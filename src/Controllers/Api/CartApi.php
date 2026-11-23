<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Auth;
use App\Core\Http;
use App\Core\View;
use App\Services\CartService;
use App\Services\CouponService;
use App\Services\Razorpay;
use RuntimeException;

final class CartApi
{
    public function __construct()
    {
        Http::noCache();
    }

    /** Current mini-cart HTML + count. */
    public function show(): void
    {
        $this->respond(true, '');
    }

    public function add(): void
    {
        $productId = input_int('product_id');
        $variantId = input_int('variant_id') ?: null;
        $qty = max(1, input_int('quantity', 1));
        try {
            CartService::add($productId, $variantId, $qty);
        } catch (RuntimeException $e) {
            $this->respond(false, $e->getMessage(), 422);
        }
        $highlight = null;
        foreach (CartService::items() as $it) {
            if ($it['product_id'] === $productId && $it['variant_id'] === $variantId) {
                $highlight = $it['item_id'];
            }
        }
        $this->respond(true, 'Added to your bag.', 200, $highlight);
    }

    public function update(): void
    {
        try {
            CartService::update(input_int('item_id'), input_int('quantity'));
        } catch (RuntimeException $e) {
            $this->respond(false, $e->getMessage(), 422);
        }
        $this->respond(true, 'Bag updated.');
    }

    public function remove(): void
    {
        CartService::remove(input_int('item_id'));
        $this->respond(true, 'Removed from your bag.');
    }

    public function applyCoupon(): void
    {
        $code = strtoupper(trim((string) input('code', '')));
        $items = CartService::items();
        if (!$items) {
            $this->respond(false, 'Add something to your bag first.', 422);
        }
        $subtotal = array_sum(array_column($items, 'line_total'));
        $customer = Auth::customer();
        $result = CouponService::validate($code, $subtotal, $customer['id'] ?? null, $customer['email'] ?? (string) input('email', ''));
        if (!$result['ok']) {
            $this->respond(false, $result['message'], 422);
        }
        CartService::setCoupon($result['coupon']['code']);
        $this->respond(true, $result['message']);
    }

    public function removeCoupon(): void
    {
        if (CartService::cart()) {
            CartService::setCoupon(null);
        }
        $this->respond(true, 'Coupon removed.');
    }

    /** Order summary block for the checkout page (re-rendered on payment method change). */
    public function checkoutSummary(): void
    {
        $method = (string) input('payment_method', '');
        if (!in_array($method, ['cod', 'razorpay'], true)) {
            $method = Razorpay::enabled() ? 'razorpay' : 'cod';
        }
        $items = CartService::items();
        $totals = CartService::totals($method);
        json_response([
            'ok' => true,
            'empty' => !$items,
            'html' => View::partial('front/partials/checkout-summary', ['items' => $items, 'totals' => $totals]),
        ]);
    }

    private function respond(bool $ok, string $message, int $status = 200, ?int $highlight = null): never
    {
        $items = CartService::items();
        $totals = CartService::totals();
        $payload = [
            'ok' => $ok,
            'message' => $message,
            'count' => CartService::count(),
            'html' => View::partial('partials/mini-cart', ['items' => $items, 'totals' => $totals, 'highlight' => $highlight]),
        ];
        if (input('context') === 'page') {
            $payload['page_html'] = View::partial('front/partials/cart-body', ['items' => $items, 'totals' => $totals]);
        }
        json_response($payload, $status);
    }
}
