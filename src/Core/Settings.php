<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Key/value store settings (Admin → Settings), loaded once per request.
 */
final class Settings
{
    private static ?array $cache = null;

    /** Defaults used when a key has not been saved yet. */
    public const DEFAULTS = [
        'site_name' => 'Savié Amour',
        'site_tagline' => 'the art of beauty',
        'currency_code' => 'INR',
        'currency_symbol' => '₹',
        'products_per_page' => '12',
        'low_stock_threshold' => '5',
        'guest_checkout' => '1',
        'review_auto_approve' => '0',
        'order_prefix' => 'SA',
        'shipping_enabled' => '1',
        'shipping_flat_rate' => '79',
        'free_shipping_threshold' => '999',
        'cod_enabled' => '1',
        'cod_fee' => '0',
        'tax_enabled' => '1',
        'tax_label' => 'GST',
        'tax_rate' => '18',
        'prices_include_tax' => '1',
        'razorpay_enabled' => '0',
        'mail_driver' => 'log',
        'notify_admin_new_order' => '1',
        'notify_customer_order_status' => '1',
        'default_country' => 'India',
    ];

    public static function all(): array
    {
        if (self::$cache === null) {
            try {
                $rows = DB::all('SELECT `key`, `value` FROM settings');
                self::$cache = array_column($rows, 'value', 'key');
            } catch (\Throwable $e) {
                self::$cache = [];
            }
        }
        return self::$cache;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = self::all();
        if (array_key_exists($key, $all) && $all[$key] !== null) {
            return $all[$key];
        }
        return $default ?? (self::DEFAULTS[$key] ?? null);
    }

    public static function bool(string $key): bool
    {
        return (string) self::get($key, '0') === '1';
    }

    public static function json(string $key, array $default = []): array
    {
        $v = self::get($key);
        if (!$v) {
            return $default;
        }
        $decoded = json_decode((string) $v, true);
        return is_array($decoded) ? $decoded : $default;
    }

    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        if (is_array($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        DB::exec(
            'INSERT INTO settings (`key`, `value`, `group`, updated_at) VALUES (:k, :v, :g, NOW())
             ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `group` = VALUES(`group`), updated_at = NOW()',
            ['k' => $key, 'v' => $value === null ? null : (string) $value, 'g' => $group]
        );
        if (self::$cache !== null) {
            self::$cache[$key] = $value;
        }
    }

    public static function flush(): void
    {
        self::$cache = null;
    }
}
