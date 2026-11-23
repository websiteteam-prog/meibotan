<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Settings;
use RuntimeException;

/**
 * Razorpay integration (Orders API + Checkout.js + signature verification + refunds).
 * Keys are configured in Admin → Settings → Payments.
 */
final class Razorpay
{
    private const API = 'https://api.razorpay.com/v1/';

    public static function enabled(): bool
    {
        return Settings::bool('razorpay_enabled') && self::keyId() !== '' && self::secret() !== '';
    }

    public static function keyId(): string
    {
        return trim((string) Settings::get('razorpay_key_id', ''));
    }

    private static function secret(): string
    {
        return trim((string) Settings::get('razorpay_key_secret', ''));
    }

    /** Create a Razorpay order. Amount is in rupees; converted to paise. */
    public static function createOrder(float $amount, string $receipt, array $notes = []): array
    {
        return self::request('POST', 'orders', [
            'amount' => (int) round($amount * 100),
            'currency' => (string) Settings::get('currency_code', 'INR'),
            'receipt' => substr($receipt, 0, 40),
            'notes' => $notes,
            'payment_capture' => 1,
        ]);
    }

    /** Verify the checkout handler signature: HMAC_SHA256(order_id|payment_id, secret). */
    public static function verifySignature(string $orderId, string $paymentId, string $signature): bool
    {
        if ($orderId === '' || $paymentId === '' || $signature === '' || self::secret() === '') {
            return false;
        }
        $expected = hash_hmac('sha256', $orderId . '|' . $paymentId, self::secret());
        return hash_equals($expected, $signature);
    }

    /** Verify a webhook body with the webhook secret. */
    public static function verifyWebhook(string $body, string $signature): bool
    {
        $secret = trim((string) Settings::get('razorpay_webhook_secret', ''));
        if ($secret === '' || $signature === '') {
            return false;
        }
        return hash_equals(hash_hmac('sha256', $body, $secret), $signature);
    }

    /** Refund a captured payment (full refund when $amount is null). */
    public static function refund(string $paymentId, ?float $amount = null): array
    {
        $payload = $amount !== null ? ['amount' => (int) round($amount * 100)] : [];
        return self::request('POST', 'payments/' . rawurlencode($paymentId) . '/refund', $payload);
    }

    private static function request(string $method, string $path, array $payload = []): array
    {
        if (self::keyId() === '' || self::secret() === '') {
            throw new RuntimeException('Razorpay keys are not configured.');
        }
        $ch = curl_init(self::API . $path);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_USERPWD => self::keyId() . ':' . self::secret(),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => $payload ? json_encode($payload) : '{}',
            CURLOPT_TIMEOUT => 20,
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);
        $body = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        if ($body === false) {
            throw new RuntimeException('Could not reach the payment gateway: ' . $err);
        }
        $data = json_decode((string) $body, true) ?: [];
        if ($status >= 400) {
            $msg = $data['error']['description'] ?? 'Payment gateway error (' . $status . ')';
            log_message('razorpay', $path . ' ' . $status . ' ' . $body);
            throw new RuntimeException($msg);
        }
        return $data;
    }
}
