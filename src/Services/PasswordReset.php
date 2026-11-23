<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\DB;

/**
 * Single-use, expiring password reset tokens. Only a SHA-256 hash of the
 * token is stored, so a database leak cannot be used to reset passwords.
 */
final class PasswordReset
{
    private const TTL_MINUTES = 60;

    public static function create(string $type, string $email): string
    {
        $email = strtolower($email);
        DB::delete('password_resets', 'user_type = :t AND email = :e', ['t' => $type, 'e' => $email]);
        $token = bin2hex(random_bytes(32));
        DB::insert('password_resets', [
            'user_type' => $type, 'email' => $email, 'token_hash' => hash('sha256', $token),
            'expires_at' => date('Y-m-d H:i:s', time() + self::TTL_MINUTES * 60), 'created_at' => now(),
        ]);
        return $token;
    }

    public static function valid(string $type, string $email, string $token): bool
    {
        if ($token === '' || $email === '') {
            return false;
        }
        $row = DB::one(
            'SELECT * FROM password_resets WHERE user_type = :t AND email = :e AND expires_at > NOW() ORDER BY id DESC LIMIT 1',
            ['t' => $type, 'e' => strtolower($email)]
        );
        return $row !== null && hash_equals($row['token_hash'], hash('sha256', $token));
    }

    public static function consume(string $type, string $email): void
    {
        DB::delete('password_resets', 'user_type = :t AND email = :e', ['t' => $type, 'e' => strtolower($email)]);
    }
}
