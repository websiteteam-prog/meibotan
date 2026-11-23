<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Auth;
use App\Core\DB;
use App\Core\Http;
use RuntimeException;

/**
 * Database-backed shopping cart.
 * Guests are identified by a random cookie token; logged-in customers by
 * customer_id so their cart follows them across devices. The guest cart is
 * merged into the customer cart on login.
 */
final class CartService
{
    private const COOKIE = 'savie_cart';
    private static ?array $cart = null;
    private static ?array $itemsCache = null;

    public static function currentGuestToken(): ?string
    {
        $t = $_COOKIE[self::COOKIE] ?? null;
        return (is_string($t) && preg_match('/^[a-f0-9]{48}$/', $t)) ? $t : null;
    }

    /** Current cart row (creates one when $create is true). */
    public static function cart(bool $create = false): ?array
    {
        if (self::$cart !== null) {
            return self::$cart;
        }
        $cid = Auth::id();
        if ($cid) {
            $cart = DB::one('SELECT * FROM carts WHERE customer_id = :c', ['c' => $cid]);
            if (!$cart && $create) {
                $id = DB::insert('carts', ['customer_id' => $cid, 'created_at' => now()]);
                $cart = DB::one('SELECT * FROM carts WHERE id = :id', ['id' => $id]);
            }
        } else {
            $token = self::currentGuestToken();
            $cart = $token ? DB::one('SELECT * FROM carts WHERE token = :t AND customer_id IS NULL', ['t' => $token]) : null;
            if (!$cart && $create) {
                $token = bin2hex(random_bytes(24));
                $id = DB::insert('carts', ['token' => $token, 'created_at' => now()]);
                self::setCookie($token);
                $cart = DB::one('SELECT * FROM carts WHERE id = :id', ['id' => $id]);
            }
        }
        return self::$cart = $cart ?: null;
    }

    private static function setCookie(string $token): void
    {
        $_COOKIE[self::COOKIE] = $token;
        setcookie(self::COOKIE, $token, [
            'expires' => time() + 30 * 86400,
            'path' => base_path() === '' ? '/' : base_path() . '/',
            'secure' => Http::isHttps(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    /**
     * Cart lines with live prices and stock.
     * @return array<int, array<string, mixed>>
     */
    public static function items(): array
    {
        if (self::$itemsCache !== null) {
            return self::$itemsCache;
        }
        $cart = self::cart();
        if (!$cart) {
            return self::$itemsCache = [];
        }
        $rows = DB::all(
            'SELECT ci.id AS item_id, ci.quantity, ci.variant_id, p.*,
                    v.name AS variant_name, v.price AS v_price, v.sale_price AS v_sale_price, v.stock_qty AS v_stock,
                    v.sku AS v_sku, v.image AS v_image, v.swatch AS v_swatch, v.is_active AS v_active,
                    c.name AS category_name
             FROM cart_items ci
             INNER JOIN products p ON p.id = ci.product_id
             LEFT JOIN product_variants v ON v.id = ci.variant_id
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE ci.cart_id = :cart ORDER BY ci.id',
            ['cart' => $cart['id']]
        );
        $items = [];
        foreach ($rows as $r) {
            if (!(int) $r['is_active'] || ($r['variant_id'] && !(int) $r['v_active'])) {
                // Product was disabled by the admin: drop it from the cart.
                DB::delete('cart_items', 'id = :id', ['id' => $r['item_id']]);
                continue;
            }
            $variant = $r['variant_id'] ? [
                'price' => $r['v_price'], 'sale_price' => $r['v_sale_price'], 'stock_qty' => $r['v_stock'],
            ] : null;
            [$unit, $regular] = ProductService::price($r, $variant);
            $available = ProductService::availableQty($r, $variant);
            $qty = (int) $r['quantity'];
            $items[] = [
                'item_id' => (int) $r['item_id'],
                'product_id' => (int) $r['id'],
                'variant_id' => $r['variant_id'] ? (int) $r['variant_id'] : null,
                'name' => $r['name'],
                'slug' => $r['slug'],
                'url' => url('product/' . $r['slug']),
                'category_name' => $r['category_name'],
                'variant_label' => $r['variant_label'] ?: 'Option',
                'variant_name' => $r['variant_name'],
                'swatch' => $r['v_swatch'],
                'sku' => $r['v_sku'] ?: $r['sku'],
                'image' => $r['v_image'] ?: $r['image'],
                'unit_price' => $unit,
                'regular_price' => $regular,
                'quantity' => $qty,
                'line_total' => round($unit * $qty, 2),
                'line_regular' => round($regular * $qty, 2),
                'available_qty' => $available,
                'stock_ok' => $available >= $qty,
            ];
        }
        return self::$itemsCache = $items;
    }

    public static function count(): int
    {
        $cart = self::cart();
        if (!$cart) {
            return 0;
        }
        return (int) DB::value('SELECT COALESCE(SUM(quantity),0) FROM cart_items WHERE cart_id = :c', ['c' => $cart['id']]);
    }

    public static function add(int $productId, ?int $variantId, int $qty): void
    {
        $qty = max(1, min($qty, 99));
        $product = DB::one('SELECT * FROM products WHERE id = :id AND is_active = 1', ['id' => $productId]);
        if (!$product) {
            throw new RuntimeException('This product is no longer available.');
        }
        $variant = null;
        if (ProductService::hasVariants($productId)) {
            if (!$variantId) {
                throw new RuntimeException('Please choose a ' . strtolower($product['variant_label'] ?: 'option') . ' first.');
            }
            $variant = ProductService::variant($productId, $variantId);
            if (!$variant) {
                throw new RuntimeException('The selected option is not available.');
            }
        } else {
            $variantId = null;
        }
        $available = ProductService::availableQty($product, $variant);
        if ($available <= 0) {
            throw new RuntimeException('Sorry, this item is out of stock.');
        }
        $cart = self::cart(true);
        $existing = DB::one(
            'SELECT * FROM cart_items WHERE cart_id = :c AND product_id = :p AND ' . ($variantId ? 'variant_id = :v' : 'variant_id IS NULL'),
            array_filter(['c' => $cart['id'], 'p' => $productId, 'v' => $variantId], static fn($v) => $v !== null)
        );
        $newQty = ($existing ? (int) $existing['quantity'] : 0) + $qty;
        if ($newQty > $available) {
            throw new RuntimeException($existing
                ? "You already have {$existing['quantity']} in your bag — only {$available} available."
                : "Only {$available} left in stock.");
        }
        if ($existing) {
            DB::update('cart_items', ['quantity' => $newQty], 'id = :id', ['id' => $existing['id']]);
        } else {
            DB::insert('cart_items', [
                'cart_id' => $cart['id'], 'product_id' => $productId, 'variant_id' => $variantId,
                'quantity' => $qty, 'created_at' => now(),
            ]);
        }
        DB::exec('UPDATE carts SET updated_at = NOW() WHERE id = :id', ['id' => $cart['id']]);
        self::$itemsCache = null;
    }

    public static function update(int $itemId, int $qty): void
    {
        $cart = self::cart();
        if (!$cart) {
            throw new RuntimeException('Your bag is empty.');
        }
        if ($qty <= 0) {
            self::remove($itemId);
            return;
        }
        $line = null;
        foreach (self::items() as $i) {
            if ($i['item_id'] === $itemId) {
                $line = $i;
            }
        }
        if (!$line) {
            throw new RuntimeException('Item not found in your bag.');
        }
        if ($qty > $line['available_qty']) {
            throw new RuntimeException($line['available_qty'] > 0 ? "Only {$line['available_qty']} available." : 'This item is out of stock.');
        }
        DB::update('cart_items', ['quantity' => min($qty, 99)], 'id = :id AND cart_id = :c', ['id' => $itemId, 'c' => $cart['id']]);
        self::$itemsCache = null;
    }

    public static function remove(int $itemId): void
    {
        $cart = self::cart();
        if ($cart) {
            DB::delete('cart_items', 'id = :id AND cart_id = :c', ['id' => $itemId, 'c' => $cart['id']]);
        }
        self::$itemsCache = null;
    }

    public static function clear(): void
    {
        $cart = self::cart();
        if ($cart) {
            DB::delete('cart_items', 'cart_id = :c', ['c' => $cart['id']]);
            DB::update('carts', ['coupon_code' => null], 'id = :id', ['id' => $cart['id']]);
            self::$cart['coupon_code'] = null;
        }
        self::$itemsCache = null;
    }

    public static function couponCode(): ?string
    {
        $cart = self::cart();
        return $cart['coupon_code'] ?? null;
    }

    public static function setCoupon(?string $code): void
    {
        $cart = self::cart(true);
        DB::update('carts', ['coupon_code' => $code], 'id = :id', ['id' => $cart['id']]);
        self::$cart['coupon_code'] = $code;
    }

    /** Totals for the current cart. */
    public static function totals(string $paymentMethod = 'razorpay'): array
    {
        $items = self::items();
        $coupon = null;
        $couponError = null;
        $code = self::couponCode();
        if ($code) {
            $subtotal = array_sum(array_column($items, 'line_total'));
            $customer = Auth::customer();
            $result = CouponService::validate($code, $subtotal, $customer['id'] ?? null, $customer['email'] ?? null);
            if ($result['ok']) {
                $coupon = $result['coupon'];
            } else {
                $couponError = $result['message'];
            }
        }
        $totals = PricingService::calculate($items, $coupon, $paymentMethod);
        $totals['coupon_error'] = $couponError;
        return $totals;
    }

    /** Move a guest cart's items into the customer's cart after login. */
    public static function mergeGuestCart(?string $token, int $customerId): void
    {
        self::$cart = null;
        self::$itemsCache = null;
        if (!$token) {
            return;
        }
        $guest = DB::one('SELECT * FROM carts WHERE token = :t AND customer_id IS NULL', ['t' => $token]);
        if ($guest) {
            $customerCart = DB::one('SELECT * FROM carts WHERE customer_id = :c', ['c' => $customerId]);
            if (!$customerCart) {
                // Adopt the guest cart.
                DB::update('carts', ['customer_id' => $customerId, 'token' => null], 'id = :id', ['id' => $guest['id']]);
            } else {
                foreach (DB::all('SELECT * FROM cart_items WHERE cart_id = :c', ['c' => $guest['id']]) as $gi) {
                    $match = DB::one(
                        'SELECT * FROM cart_items WHERE cart_id = :c AND product_id = :p AND ' . ($gi['variant_id'] ? 'variant_id = :v' : 'variant_id IS NULL'),
                        array_filter(['c' => $customerCart['id'], 'p' => $gi['product_id'], 'v' => $gi['variant_id']], static fn($v) => $v !== null)
                    );
                    if ($match) {
                        DB::update('cart_items', ['quantity' => min(99, (int) $match['quantity'] + (int) $gi['quantity'])], 'id = :id', ['id' => $match['id']]);
                    } else {
                        DB::update('cart_items', ['cart_id' => $customerCart['id']], 'id = :id', ['id' => $gi['id']]);
                    }
                }
                if ($guest['coupon_code'] && !$customerCart['coupon_code']) {
                    DB::update('carts', ['coupon_code' => $guest['coupon_code']], 'id = :id', ['id' => $customerCart['id']]);
                }
                DB::delete('carts', 'id = :id', ['id' => $guest['id']]);
            }
        }
        setcookie(self::COOKIE, '', ['expires' => time() - 3600, 'path' => base_path() === '' ? '/' : base_path() . '/']);
        unset($_COOKIE[self::COOKIE]);
    }

    /** Reset in-memory caches (after login/logout within one request). */
    public static function reset(): void
    {
        self::$cart = null;
        self::$itemsCache = null;
    }
}
