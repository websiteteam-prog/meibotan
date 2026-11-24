<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\AdminAuth;
use App\Core\DB;
use App\Core\Mailer;
use App\Core\Paginator;
use App\Core\Settings;
use App\Core\View;
use App\Services\OrderService;
use App\Services\Razorpay;
use RuntimeException;

final class OrderController extends Controller
{
    /** @return array{0: string, 1: array} */
    private function filters(): array
    {
        $where = ['1=1'];
        $params = [];
        $q = trim((string) input('q', ''));
        if ($q !== '') {
            $like = '%' . addcslashes($q, '%_\\') . '%';
            $where[] = '(o.order_number LIKE :q1 OR o.customer_name LIKE :q2 OR o.customer_email LIKE :q3 OR o.customer_phone LIKE :q4)';
            $params += ['q1' => $like, 'q2' => $like, 'q3' => $like, 'q4' => $like];
        }
        $status = (string) input('status', '');
        if (in_array($status, OrderService::STATUSES, true)) {
            $where[] = 'o.status = :st';
            $params['st'] = $status;
        }
        $pay = (string) input('payment', '');
        if (in_array($pay, OrderService::PAYMENT_STATUSES, true)) {
            $where[] = 'o.payment_status = :ps';
            $params['ps'] = $pay;
        }
        $method = (string) input('method', '');
        if (in_array($method, ['cod', 'razorpay'], true)) {
            $where[] = 'o.payment_method = :pm';
            $params['pm'] = $method;
        }
        if (($from = (string) input('from', '')) !== '' && strtotime($from)) {
            $where[] = 'o.created_at >= :from';
            $params['from'] = date('Y-m-d 00:00:00', strtotime($from));
        }
        if (($to = (string) input('to', '')) !== '' && strtotime($to)) {
            $where[] = 'o.created_at <= :to';
            $params['to'] = date('Y-m-d 23:59:59', strtotime($to));
        }
        if ($cid = input_int('customer')) {
            $where[] = 'o.customer_id = :cid';
            $params['cid'] = $cid;
        }
        return [implode(' AND ', $where), $params];
    }

    public function index(): void
    {
        [$where, $params] = $this->filters();
        $total = (int) DB::value("SELECT COUNT(*) FROM orders o WHERE {$where}", $params);
        $pager = new Paginator($total, 20);
        $orders = DB::all(
            "SELECT o.*, (SELECT SUM(quantity) FROM order_items oi WHERE oi.order_id = o.id) AS qty FROM orders o WHERE {$where} ORDER BY o.created_at DESC LIMIT :l OFFSET :o",
            $params + ['l' => $pager->perPage, 'o' => $pager->offset]
        );
        $this->admin('orders/index', [
            'title' => 'Orders', 'active' => 'orders', 'orders' => $orders, 'pager' => $pager,
            'counts' => array_column(DB::all('SELECT status, COUNT(*) c FROM orders GROUP BY status'), 'c', 'status'),
            'sum' => (float) DB::value("SELECT COALESCE(SUM(total),0) FROM orders o WHERE {$where}", $params),
        ]);
    }

    public function export(): void
    {
        [$where, $params] = $this->filters();
        $rows = DB::all("SELECT * FROM orders o WHERE {$where} ORDER BY o.created_at DESC LIMIT 20000", $params);
        csv_download('orders-' . date('Ymd-His') . '.csv',
            ['Order', 'Date', 'Customer', 'Email', 'Phone', 'City', 'State', 'PIN', 'Status', 'Payment method', 'Payment status', 'Subtotal', 'Discount', 'Coupon', 'Shipping', 'Tax', 'Total'],
            array_map(static fn($o) => [$o['order_number'], $o['created_at'], $o['customer_name'], $o['customer_email'], $o['customer_phone'], $o['shipping_city'], $o['shipping_state'], $o['shipping_postal_code'],
                $o['status'], $o['payment_method'], $o['payment_status'], $o['subtotal'], $o['discount_amount'], $o['coupon_code'], $o['shipping_amount'], $o['tax_amount'], $o['total']], $rows)
        );
    }

    private function order(string $id): array
    {
        $o = OrderService::find((int) $id);
        if (!$o) {
            abort(404);
        }
        return $o;
    }

    public function show(string $id): void
    {
        $o = $this->order($id);
        $this->admin('orders/show', [
            'title' => 'Order ' . $o['order_number'], 'active' => 'orders', 'o' => $o,
            'items' => OrderService::items((int) $o['id']),
            'history' => OrderService::history((int) $o['id']),
            'payments' => DB::all('SELECT * FROM payments WHERE order_id = :id ORDER BY id DESC', ['id' => $o['id']]),
            'customer' => $o['customer_id'] ? DB::one('SELECT c.*, (SELECT COUNT(*) FROM orders WHERE customer_id = c.id) AS order_count FROM customers c WHERE c.id = :id', ['id' => $o['customer_id']]) : null,
        ]);
    }

    public function invoice(string $id): void
    {
        $o = $this->order($id);
        echo View::render('admin/orders/invoice', [
            'title' => 'Invoice ' . $o['order_number'], 'active' => 'orders', 'o' => $o, 'items' => OrderService::items((int) $o['id']),
        ], 'layouts/admin');
    }

    public function status(string $id): void
    {
        $o = $this->order($id);
        $status = (string) input('status', '');
        if (!in_array($status, OrderService::STATUSES, true)) {
            flash('error', 'Choose a valid status.');
            redirect('/admin/orders/' . $o['id']);
        }
        if ($status === $o['status']) {
            flash('info', 'The order is already ' . status_label($status) . '.');
            redirect('/admin/orders/' . $o['id']);
        }
        $note = mb_substr(trim((string) input('note', '')), 0, 250) ?: null;
        $admin = AdminAuth::user();
        OrderService::updateStatus($o, $status, $note, 'admin:' . $admin['name'], input('notify') === '1');
        flash('success', 'Order status changed to ' . status_label($status) . (input('notify') === '1' ? ' and the customer was notified.' : '.'));
        redirect('/admin/orders/' . $o['id']);
    }

    public function payment(string $id): void
    {
        $o = $this->order($id);
        $ps = (string) input('payment_status', '');
        if (!in_array($ps, OrderService::PAYMENT_STATUSES, true)) {
            flash('error', 'Choose a valid payment status.');
            redirect('/admin/orders/' . $o['id']);
        }
        OrderService::setPaymentStatus($o, $ps, 'Payment status set to ' . $ps . ' by ' . AdminAuth::user()['name'], 'admin');
        flash('success', 'Payment status updated.');
        redirect('/admin/orders/' . $o['id']);
    }

    public function shipping(string $id): void
    {
        $o = $this->order($id);
        $trackUrl = trim((string) input('tracking_url', ''));
        if ($trackUrl !== '' && !preg_match('~^https?://~i', $trackUrl)) {
            $trackUrl = 'https://' . $trackUrl;
        }
        if ($trackUrl !== '' && !filter_var($trackUrl, FILTER_VALIDATE_URL)) {
            flash('error', 'The tracking link is not a valid URL.');
            redirect('/admin/orders/' . $o['id']);
        }
        DB::update('orders', [
            'tracking_url' => $trackUrl !== '' ? mb_substr($trackUrl, 0, 500) : null,
            'courier_name' => mb_substr(trim((string) input('courier_name', '')), 0, 100) ?: null,
            'tracking_number' => mb_substr(trim((string) input('tracking_number', '')), 0, 100) ?: null,
            'admin_notes' => mb_substr(trim((string) input('admin_notes', '')), 0, 2000) ?: null,
        ], 'id = :id', ['id' => $o['id']]);
        if (input('mark_shipped') === '1' && in_array($o['status'], ['pending', 'processing', 'confirmed'], true)) {
            OrderService::updateStatus(OrderService::find((int) $o['id']), 'shipped', 'Shipped via ' . (input('courier_name') ?: 'courier') . (input('tracking_number') ? ' · AWB ' . input('tracking_number') : ''), 'admin:' . AdminAuth::user()['name'], true);
        }
        flash('success', 'Shipping details saved.');
        redirect('/admin/orders/' . $o['id']);
    }

    /** Refund: through Razorpay when the order was paid online, otherwise recorded manually. */
    public function refund(string $id): void
    {
        $o = $this->order($id);
        if ($o['payment_status'] !== 'paid') {
            flash('error', 'Only paid orders can be refunded.');
            redirect('/admin/orders/' . $o['id']);
        }
        $amount = (float) input('amount', $o['total']);
        if ($amount <= 0 || $amount > (float) $o['total']) {
            flash('error', 'Refund amount must be between 0 and the order total.');
            redirect('/admin/orders/' . $o['id']);
        }
        $payment = DB::one("SELECT * FROM payments WHERE order_id = :id AND status = 'paid' ORDER BY id DESC LIMIT 1", ['id' => $o['id']]);
        $note = 'Refund of ' . money($amount);
        if ($o['payment_method'] === 'razorpay' && $payment && $payment['gateway_payment_id'] && input('manual') !== '1') {
            try {
                $res = Razorpay::refund($payment['gateway_payment_id'], $amount);
            } catch (RuntimeException $e) {
                flash('error', 'Razorpay refund failed: ' . $e->getMessage());
                redirect('/admin/orders/' . $o['id']);
            }
            DB::update('payments', ['refund_id' => $res['id'] ?? null, 'refunded_amount' => $amount, 'status' => 'refunded'], 'id = :id', ['id' => $payment['id']]);
            $note .= ' via Razorpay (' . ($res['id'] ?? 'pending') . ')';
        } else {
            if ($payment) {
                DB::update('payments', ['refunded_amount' => $amount, 'status' => 'refunded'], 'id = :id', ['id' => $payment['id']]);
            }
            $note .= ' recorded manually';
        }
        OrderService::updateStatus($o, 'refunded', $note, 'admin:' . AdminAuth::user()['name'], true);
        DB::update('orders', ['payment_status' => 'refunded'], 'id = :id', ['id' => $o['id']]);
        flash('success', $note . '.');
        redirect('/admin/orders/' . $o['id']);
    }
}
