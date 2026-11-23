<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Auth;
use App\Core\DB;
use App\Core\Mailer;
use App\Core\Settings;
use RuntimeException;

final class OrderService
{
    public const STATUSES = ['pending', 'processing', 'confirmed', 'shipped', 'delivered', 'cancelled', 'refunded'];
    public const PAYMENT_STATUSES = ['pending', 'paid', 'failed', 'refunded'];
    public const CANCELLABLE = ['pending', 'processing', 'confirmed'];

    /**
     * Create an order from the current cart inside a transaction.
     * Stock is locked (SELECT … FOR UPDATE) and decremented atomically, so two
     * customers can never buy the last unit at the same time.
     */
    public static function createFromCart(array $data, string $paymentMethod): array
    {
        $items = CartService::items();
        if (!$items) {
            throw new RuntimeException('Your bag is empty.');
        }
        $totals = CartService::totals($paymentMethod);
        if ($totals['coupon_error']) {
            CartService::setCoupon(null);
            throw new RuntimeException('Your coupon was removed: ' . $totals['coupon_error'] . ' Please review your total and place the order again.');
        }
        $customer = Auth::customer();

        return DB::transaction(static function () use ($items, $totals, $data, $paymentMethod, $customer) {
            // 1. Lock & verify stock.
            foreach ($items as $item) {
                if ($item['variant_id']) {
                    $row = DB::one('SELECT v.stock_qty, p.stock_status, p.is_active FROM product_variants v INNER JOIN products p ON p.id = v.product_id WHERE v.id = :id FOR UPDATE', ['id' => $item['variant_id']]);
                } else {
                    $row = DB::one('SELECT stock_qty, stock_status, is_active FROM products WHERE id = :id FOR UPDATE', ['id' => $item['product_id']]);
                }
                $available = ($row && (int) $row['is_active'] && $row['stock_status'] === 'in_stock') ? (int) $row['stock_qty'] : 0;
                if ($available < $item['quantity']) {
                    $label = $item['name'] . ($item['variant_name'] ? ' (' . $item['variant_name'] . ')' : '');
                    throw new RuntimeException($available > 0
                        ? "Only {$available} of “{$label}” left in stock. Please update your bag."
                        : "“{$label}” just sold out. Please remove it from your bag.");
                }
            }

            // 2. Order row.
            $orderNumber = self::generateNumber();
            $orderId = DB::insert('orders', [
                'order_number' => $orderNumber,
                'access_token' => bin2hex(random_bytes(20)),
                'customer_id' => $customer['id'] ?? null,
                'customer_name' => $data['name'],
                'customer_email' => strtolower($data['email']),
                'customer_phone' => $data['phone'],
                'shipping_name' => $data['shipping_name'],
                'shipping_phone' => $data['shipping_phone'],
                'shipping_address1' => $data['shipping_address1'],
                'shipping_address2' => $data['shipping_address2'] ?: null,
                'shipping_city' => $data['shipping_city'],
                'shipping_state' => $data['shipping_state'],
                'shipping_country' => $data['shipping_country'],
                'shipping_postal_code' => $data['shipping_postal_code'],
                'billing_name' => $data['billing_name'],
                'billing_phone' => $data['billing_phone'],
                'billing_address1' => $data['billing_address1'],
                'billing_address2' => $data['billing_address2'] ?: null,
                'billing_city' => $data['billing_city'],
                'billing_state' => $data['billing_state'],
                'billing_country' => $data['billing_country'],
                'billing_postal_code' => $data['billing_postal_code'],
                'subtotal' => $totals['subtotal'],
                'discount_amount' => $totals['discount'],
                'coupon_code' => $totals['coupon_code'],
                'shipping_amount' => $totals['shipping'],
                'cod_fee' => $totals['cod_fee'],
                'tax_amount' => $totals['tax'],
                'tax_label' => $totals['tax_label'],
                'tax_rate' => $totals['tax_rate'],
                'tax_inclusive' => $totals['tax_inclusive'] ? 1 : 0,
                'total' => $totals['total'],
                'currency' => (string) Settings::get('currency_code', 'INR'),
                'payment_method' => $paymentMethod,
                'payment_status' => 'pending',
                'status' => 'pending',
                'notes' => $data['notes'] ?: null,
                'ip_address' => client_ip(),
                'created_at' => now(),
            ]);

            // 3. Items + stock.
            foreach ($items as $item) {
                DB::insert('order_items', [
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'product_name' => $item['name'],
                    'variant_name' => $item['variant_name'] ? $item['variant_label'] . ': ' . $item['variant_name'] : null,
                    'sku' => $item['sku'],
                    'image' => $item['image'],
                    'unit_price' => $item['unit_price'],
                    'regular_price' => $item['regular_price'],
                    'quantity' => $item['quantity'],
                    'line_total' => $item['line_total'],
                ]);
                if ($item['variant_id']) {
                    DB::exec('UPDATE product_variants SET stock_qty = stock_qty - :q WHERE id = :id', ['q' => $item['quantity'], 'id' => $item['variant_id']]);
                } else {
                    DB::exec('UPDATE products SET stock_qty = stock_qty - :q WHERE id = :id', ['q' => $item['quantity'], 'id' => $item['product_id']]);
                }
                DB::exec('UPDATE products SET sold_count = sold_count + :q WHERE id = :id', ['q' => $item['quantity'], 'id' => $item['product_id']]);
            }

            // 4. Coupon usage.
            if ($totals['coupon']) {
                DB::exec('UPDATE coupons SET used_count = used_count + 1 WHERE id = :id', ['id' => $totals['coupon']['id']]);
                DB::insert('coupon_usages', [
                    'coupon_id' => $totals['coupon']['id'], 'order_id' => $orderId, 'customer_id' => $customer['id'] ?? null,
                    'email' => strtolower($data['email']), 'discount_amount' => $totals['discount'], 'created_at' => now(),
                ]);
            }

            // 5. Payment + history.
            DB::insert('payments', [
                'order_id' => $orderId, 'method' => $paymentMethod, 'amount' => $totals['total'],
                'currency' => (string) Settings::get('currency_code', 'INR'),
                'status' => $paymentMethod === 'cod' ? 'pending' : 'created', 'created_at' => now(),
            ]);
            self::addHistory($orderId, 'pending', $paymentMethod === 'cod' ? 'Order placed — Cash on Delivery' : 'Order placed — awaiting online payment', 'customer');

            return self::find($orderId);
        });
    }

    private static function generateNumber(): string
    {
        $prefix = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', (string) Settings::get('order_prefix', 'SA'))) ?: 'SA';
        for ($i = 0; $i < 5; $i++) {
            $n = $prefix . date('ymd') . random_int(1000, 9999);
            if (!DB::value('SELECT id FROM orders WHERE order_number = :n', ['n' => $n])) {
                return $n;
            }
        }
        return $prefix . date('ymdHis') . random_int(10, 99);
    }

    public static function find(int $id): ?array
    {
        return DB::one('SELECT * FROM orders WHERE id = :id', ['id' => $id]);
    }

    public static function findByNumber(string $number): ?array
    {
        return DB::one('SELECT * FROM orders WHERE order_number = :n', ['n' => $number]);
    }

    public static function items(int $orderId): array
    {
        return DB::all('SELECT oi.*, p.slug FROM order_items oi LEFT JOIN products p ON p.id = oi.product_id WHERE oi.order_id = :id ORDER BY oi.id', ['id' => $orderId]);
    }

    public static function history(int $orderId): array
    {
        return DB::all('SELECT * FROM order_status_history WHERE order_id = :id ORDER BY created_at ASC, id ASC', ['id' => $orderId]);
    }

    public static function addHistory(int $orderId, string $status, ?string $note, string $actor = 'system'): void
    {
        DB::insert('order_status_history', [
            'order_id' => $orderId, 'status' => $status, 'note' => $note, 'actor' => $actor, 'created_at' => now(),
        ]);
    }

    /** Change status, restock on cancellation and notify the customer. */
    public static function updateStatus(array $order, string $status, ?string $note = null, string $actor = 'admin', bool $notify = true): void
    {
        if (!in_array($status, self::STATUSES, true) || $order['status'] === $status) {
            return;
        }
        DB::transaction(static function () use ($order, $status, $note, $actor) {
            $data = ['status' => $status];
            if ($status === 'cancelled') {
                $data['cancelled_at'] = now();
                $data['cancel_reason'] = $note;
                if (!in_array($order['status'], ['cancelled', 'refunded'], true)) {
                    self::restock((int) $order['id']);
                }
            }
            if ($status === 'refunded') {
                $data['payment_status'] = 'refunded';
                if (!in_array($order['status'], ['cancelled', 'refunded'], true)) {
                    self::restock((int) $order['id']);
                }
            }
            if ($status === 'delivered' && $order['payment_method'] === 'cod' && $order['payment_status'] === 'pending') {
                $data['payment_status'] = 'paid';
                DB::exec("UPDATE payments SET status = 'paid' WHERE order_id = :id AND method = 'cod'", ['id' => $order['id']]);
            }
            DB::update('orders', $data, 'id = :id', ['id' => $order['id']]);
            self::addHistory((int) $order['id'], $status, $note, $actor);
        });
        if ($notify && Settings::bool('notify_customer_order_status')) {
            $fresh = self::find((int) $order['id']);
            Mailer::template($fresh['customer_email'], 'Your order ' . $fresh['order_number'] . ' is ' . status_label($status), 'order-status', [
                'order' => $fresh, 'items' => self::items((int) $fresh['id']), 'note' => $note,
            ]);
        }
    }

    public static function setPaymentStatus(array $order, string $paymentStatus, ?string $note = null, string $actor = 'admin'): void
    {
        if (!in_array($paymentStatus, self::PAYMENT_STATUSES, true)) {
            return;
        }
        DB::update('orders', ['payment_status' => $paymentStatus], 'id = :id', ['id' => $order['id']]);
        DB::exec('UPDATE payments SET status = :s WHERE order_id = :id ORDER BY id DESC LIMIT 1', ['s' => $paymentStatus, 'id' => $order['id']]);
        self::addHistory((int) $order['id'], 'payment_' . $paymentStatus, $note ?? 'Payment marked as ' . $paymentStatus, $actor);
    }

    /** Return reserved stock and coupon usage of an order. */
    private static function restock(int $orderId): void
    {
        foreach (self::items($orderId) as $item) {
            if ($item['variant_id']) {
                DB::exec('UPDATE product_variants SET stock_qty = stock_qty + :q WHERE id = :id', ['q' => $item['quantity'], 'id' => $item['variant_id']]);
            } elseif ($item['product_id']) {
                DB::exec('UPDATE products SET stock_qty = stock_qty + :q WHERE id = :id', ['q' => $item['quantity'], 'id' => $item['product_id']]);
            }
            if ($item['product_id']) {
                DB::exec('UPDATE products SET sold_count = GREATEST(0, CAST(sold_count AS SIGNED) - :q) WHERE id = :id', ['q' => $item['quantity'], 'id' => $item['product_id']]);
            }
        }
        $usage = DB::one('SELECT * FROM coupon_usages WHERE order_id = :id', ['id' => $orderId]);
        if ($usage) {
            DB::exec('UPDATE coupons SET used_count = GREATEST(0, CAST(used_count AS SIGNED) - 1) WHERE id = :id', ['id' => $usage['coupon_id']]);
        }
    }

    public static function canCustomerCancel(array $order): bool
    {
        return in_array($order['status'], self::CANCELLABLE, true);
    }

    /** Mark an online payment as successful. */
    public static function markPaid(array $order, string $gatewayOrderId, string $paymentId, string $signature, array $payload = []): void
    {
        if ($order['payment_status'] === 'paid') {
            return;
        }
        DB::transaction(static function () use ($order, $gatewayOrderId, $paymentId, $signature, $payload) {
            DB::exec(
                "UPDATE payments SET status = 'paid', gateway_payment_id = :pid, gateway_signature = :sig, payload = :payload
                 WHERE order_id = :oid AND gateway_order_id = :goid",
                ['pid' => $paymentId, 'sig' => $signature, 'payload' => json_encode($payload), 'oid' => $order['id'], 'goid' => $gatewayOrderId]
            );
            DB::update('orders', ['payment_status' => 'paid', 'status' => $order['status'] === 'pending' ? 'processing' : $order['status']], 'id = :id', ['id' => $order['id']]);
            self::addHistory((int) $order['id'], 'processing', 'Payment received via Razorpay (' . $paymentId . ')', 'system');
        });
    }

    /** Send order confirmation to the customer and notification to the store. */
    public static function sendPlacedEmails(array $order): void
    {
        $items = self::items((int) $order['id']);
        Mailer::template($order['customer_email'], 'Thank you for your order ' . $order['order_number'], 'order-placed', ['order' => $order, 'items' => $items]);
        $adminEmail = (string) Settings::get('admin_notification_email', Settings::get('site_email', ''));
        if ($adminEmail && Settings::bool('notify_admin_new_order')) {
            Mailer::template($adminEmail, 'New order ' . $order['order_number'] . ' — ' . money($order['total']), 'admin-new-order', ['order' => $order, 'items' => $items]);
        }
    }

    /** Cancel stale unpaid online orders (called from bin/cron.php). */
    public static function cancelStaleUnpaid(int $hours = 2): int
    {
        $rows = DB::all(
            "SELECT * FROM orders WHERE payment_method = 'razorpay' AND payment_status IN ('pending','failed') AND status = 'pending'
             AND created_at < (NOW() - INTERVAL :h HOUR)",
            ['h' => $hours]
        );
        foreach ($rows as $o) {
            self::updateStatus($o, 'cancelled', 'Automatically cancelled — online payment was not completed.', 'system', false);
        }
        return count($rows);
    }
}
