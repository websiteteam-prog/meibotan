<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Settings;

/**
 * Order total calculation: subtotal → coupon discount → shipping → COD fee → tax.
 * Tax (GST) can be configured as included in prices or added on top.
 */
final class PricingService
{
    public static function calculate(array $items, ?array $coupon = null, string $paymentMethod = 'razorpay'): array
    {
        $subtotal = round(array_sum(array_column($items, 'line_total')), 2);
        $regularTotal = round(array_sum(array_column($items, 'line_regular')), 2);
        $savings = max(0, round($regularTotal - $subtotal, 2));
        $count = (int) array_sum(array_column($items, 'quantity'));

        $discount = $coupon ? CouponService::discount($coupon, $subtotal) : 0.0;
        $afterDiscount = max(0, $subtotal - $discount);

        $shipping = 0.0;
        $freeThreshold = (float) Settings::get('free_shipping_threshold', 0);
        if ($count > 0 && Settings::bool('shipping_enabled')) {
            $shipping = ($freeThreshold > 0 && $afterDiscount >= $freeThreshold) ? 0.0 : (float) Settings::get('shipping_flat_rate', 0);
        }
        $codFee = ($paymentMethod === 'cod' && $count > 0) ? (float) Settings::get('cod_fee', 0) : 0.0;

        $tax = 0.0;
        $taxRate = Settings::bool('tax_enabled') ? (float) Settings::get('tax_rate', 0) : 0.0;
        $inclusive = Settings::bool('prices_include_tax');
        if ($taxRate > 0) {
            $tax = $inclusive
                ? round($afterDiscount - $afterDiscount / (1 + $taxRate / 100), 2)
                : round($afterDiscount * $taxRate / 100, 2);
        }
        $total = round($afterDiscount + $shipping + $codFee + ($inclusive ? 0 : $tax), 2);

        return [
            'count' => $count,
            'subtotal' => $subtotal,
            'regular_total' => $regularTotal,
            'savings' => $savings,
            'discount' => $discount,
            'coupon_code' => $coupon['code'] ?? null,
            'coupon' => $coupon,
            'shipping' => $shipping,
            'free_shipping_threshold' => $freeThreshold,
            'free_shipping_remaining' => ($freeThreshold > 0 && $shipping > 0) ? round($freeThreshold - $afterDiscount, 2) : 0.0,
            'cod_fee' => $codFee,
            'tax' => $tax,
            'tax_rate' => $taxRate,
            'tax_label' => (string) Settings::get('tax_label', 'GST'),
            'tax_inclusive' => $inclusive,
            'total' => $total,
        ];
    }
}
