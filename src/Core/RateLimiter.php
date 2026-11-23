<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Database-backed throttle for login and other sensitive endpoints.
 */
final class RateLimiter
{
    public static function tooMany(string $key, int $maxAttempts = 5, int $minutes = 15): bool
    {
        $count = (int) DB::value(
            'SELECT COUNT(*) FROM login_attempts WHERE identifier = :k AND attempted_at > (NOW() - INTERVAL :m MINUTE)',
            ['k' => self::key($key), 'm' => $minutes]
        );
        return $count >= $maxAttempts;
    }

    public static function hit(string $key): void
    {
        DB::insert('login_attempts', ['identifier' => self::key($key), 'ip_address' => client_ip(), 'attempted_at' => now()]);
        if (random_int(1, 50) === 1) {
            DB::exec('DELETE FROM login_attempts WHERE attempted_at < (NOW() - INTERVAL 1 DAY)');
        }
    }

    public static function clear(string $key): void
    {
        DB::delete('login_attempts', 'identifier = :k', ['k' => self::key($key)]);
    }

    private static function key(string $key): string
    {
        return hash('sha256', strtolower($key));
    }
}
