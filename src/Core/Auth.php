<?php
declare(strict_types=1);

namespace App\Core;

use App\Services\CartService;
use App\Services\WishlistService;

/**
 * Customer authentication: session based, with optional "remember me"
 * tokens (selector + hashed validator, rotated on use).
 */
final class Auth
{
    private const REMEMBER_COOKIE = 'savie_remember';
    private const REMEMBER_DAYS = 30;

    private static ?array $customer = null;
    private static bool $resolved = false;

    public static function customer(): ?array
    {
        if (self::$resolved) {
            return self::$customer;
        }
        self::$resolved = true;
        $id = (int) Session::get('customer_id', 0);
        if ($id > 0) {
            $row = DB::one('SELECT * FROM customers WHERE id = :id AND is_active = 1', ['id' => $id]);
            if ($row) {
                return self::$customer = $row;
            }
            Session::forget('customer_id');
        }
        $row = self::loginFromRememberCookie();
        return self::$customer = $row;
    }

    public static function id(): ?int
    {
        $c = self::customer();
        return $c ? (int) $c['id'] : null;
    }

    public static function check(): bool
    {
        return self::customer() !== null;
    }

    /** Find a customer by email or phone and verify the password. */
    public static function attempt(string $identifier, string $password): ?array
    {
        $identifier = trim($identifier);
        if (str_contains($identifier, '@')) {
            $row = DB::one('SELECT * FROM customers WHERE email = :v LIMIT 1', ['v' => strtolower($identifier)]);
        } else {
            $phone = preg_replace('/\D+/', '', $identifier);
            $row = $phone === '' ? null : DB::one('SELECT * FROM customers WHERE phone = :v LIMIT 1', ['v' => $phone]);
        }
        if (!$row || !password_verify($password, $row['password_hash'])) {
            return null;
        }
        if (password_needs_rehash($row['password_hash'], PASSWORD_DEFAULT)) {
            DB::update('customers', ['password_hash' => password_hash($password, PASSWORD_DEFAULT)], 'id = :id', ['id' => $row['id']]);
        }
        return $row;
    }

    public static function login(array $customer, bool $remember = false): void
    {
        $guestCartToken = CartService::currentGuestToken();
        Session::regenerate();
        Session::put('customer_id', (int) $customer['id']);
        self::$customer = $customer;
        self::$resolved = true;
        DB::update('customers', ['last_login_at' => now()], 'id = :id', ['id' => $customer['id']]);

        if ($remember) {
            self::issueRememberToken((int) $customer['id']);
        }
        CartService::mergeGuestCart($guestCartToken, (int) $customer['id']);
        WishlistService::processPending((int) $customer['id']);
    }

    public static function logout(): void
    {
        $cookie = $_COOKIE[self::REMEMBER_COOKIE] ?? '';
        if ($cookie && str_contains($cookie, ':')) {
            [$selector] = explode(':', $cookie, 2);
            DB::delete('customer_remember_tokens', 'selector = :s', ['s' => $selector]);
        }
        self::forgetCookie();
        Session::forget('customer_id');
        Session::forget('pending_order_id');
        Session::regenerate();
        self::$customer = null;
        self::$resolved = true;
    }

    public static function requireCustomer(): void
    {
        if (self::check()) {
            return;
        }
        if (is_ajax()) {
            json_response(['ok' => false, 'auth' => false, 'message' => 'Please sign in to continue.'], 401);
        }
        flash('info', 'Please sign in to continue.');
        $intended = request_path() . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '');
        redirect('/login?redirect=' . rawurlencode($intended));
    }

    /** Remove every remember-me token of a customer (e.g. after a password change). */
    public static function revokeRememberTokens(int $customerId): void
    {
        DB::delete('customer_remember_tokens', 'customer_id = :id', ['id' => $customerId]);
    }

    private static function issueRememberToken(int $customerId): void
    {
        $selector = bin2hex(random_bytes(12));
        $validator = bin2hex(random_bytes(32));
        $expires = time() + self::REMEMBER_DAYS * 86400;
        DB::insert('customer_remember_tokens', [
            'customer_id' => $customerId,
            'selector' => $selector,
            'validator_hash' => hash('sha256', $validator),
            'expires_at' => date('Y-m-d H:i:s', $expires),
            'created_at' => now(),
        ]);
        setcookie(self::REMEMBER_COOKIE, $selector . ':' . $validator, [
            'expires' => $expires,
            'path' => base_path() === '' ? '/' : base_path() . '/',
            'secure' => Http::isHttps(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    private static function loginFromRememberCookie(): ?array
    {
        $cookie = $_COOKIE[self::REMEMBER_COOKIE] ?? '';
        if (!is_string($cookie) || !preg_match('/^[a-f0-9]{24}:[a-f0-9]{64}$/', $cookie)) {
            return null;
        }
        [$selector, $validator] = explode(':', $cookie, 2);
        $token = DB::one('SELECT * FROM customer_remember_tokens WHERE selector = :s AND expires_at > NOW()', ['s' => $selector]);
        if (!$token || !hash_equals($token['validator_hash'], hash('sha256', $validator))) {
            self::forgetCookie();
            return null;
        }
        $customer = DB::one('SELECT * FROM customers WHERE id = :id AND is_active = 1', ['id' => $token['customer_id']]);
        if (!$customer) {
            return null;
        }
        // Rotate token on use.
        DB::delete('customer_remember_tokens', 'id = :id', ['id' => $token['id']]);
        Session::regenerate();
        Session::put('customer_id', (int) $customer['id']);
        self::issueRememberToken((int) $customer['id']);
        return $customer;
    }

    private static function forgetCookie(): void
    {
        if (isset($_COOKIE[self::REMEMBER_COOKIE])) {
            setcookie(self::REMEMBER_COOKIE, '', [
                'expires' => time() - 3600,
                'path' => base_path() === '' ? '/' : base_path() . '/',
                'secure' => Http::isHttps(),
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            unset($_COOKIE[self::REMEMBER_COOKIE]);
        }
    }
}
