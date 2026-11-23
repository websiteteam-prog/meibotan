<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\DB;

final class CouponService
{
    /**
     * Validate a coupon for a subtotal (and optionally a customer).
     * @return array{ok: bool, message: string, coupon?: array, discount?: float}
     */
    public static function validate(string $code, float $subtotal, ?int $customerId = null, ?string $email = null): array
    {
        $code = strtoupper(trim($code));
        if ($code === '') {
            return ['ok' => false, 'message' => 'Please enter a coupon code.'];
        }
        $c = DB::one('SELECT * FROM coupons WHERE code = :c', ['c' => $code]);
        if (!$c || !(int) $c['is_active']) {
            return ['ok' => false, 'message' => 'This coupon code is not valid.'];
        }
        $now = time();
        if ($c['starts_at'] && strtotime($c['starts_at']) > $now) {
            return ['ok' => false, 'message' => 'This coupon is not active yet.'];
        }
        if ($c['expires_at'] && strtotime($c['expires_at']) < $now) {
            return ['ok' => false, 'message' => 'This coupon has expired.'];
        }
        if ($c['usage_limit'] !== null && (int) $c['used_count'] >= (int) $c['usage_limit']) {
            return ['ok' => false, 'message' => 'This coupon has reached its usage limit.'];
        }
        if ((float) $c['min_order_amount'] > 0 && $subtotal < (float) $c['min_order_amount']) {
            return ['ok' => false, 'message' => 'Add ' . money((float) $c['min_order_amount'] - $subtotal) . ' more to use this coupon (minimum order ' . money($c['min_order_amount']) . ').'];
        }
        if ($c['usage_per_customer'] !== null && ($customerId || $email)) {
            $used = (int) DB::value(
                'SELECT COUNT(*) FROM coupon_usages cu INNER JOIN orders o ON o.id = cu.order_id
                 WHERE cu.coupon_id = :id AND o.status NOT IN (\'cancelled\') AND (cu.customer_id = :cid OR cu.email = :email)',
                ['id' => $c['id'], 'cid' => $customerId ?? 0, 'email' => strtolower((string) $email)]
            );
            if ($used >= (int) $c['usage_per_customer']) {
                return ['ok' => false, 'message' => 'You have already used this coupon.'];
            }
        }
        $discount = self::discount($c, $subtotal);
        return ['ok' => true, 'message' => 'Coupon applied — you save ' . money($discount) . '.', 'coupon' => $c, 'discount' => $discount];
    }

    public static function discount(array $c, float $subtotal): float
    {
        if ($c['type'] === 'percent') {
            $d = $subtotal * ((float) $c['value'] / 100);
            if ($c['max_discount'] !== null && (float) $c['max_discount'] > 0) {
                $d = min($d, (float) $c['max_discount']);
            }
        } else {
            $d = (float) $c['value'];
        }
        return round(min($d, $subtotal), 2);
    }
}
