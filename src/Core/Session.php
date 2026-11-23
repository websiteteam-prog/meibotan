<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Hardened session handling + flash data.
 */
final class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }
        $secure = config('session.secure');
        if ($secure === null) {
            $secure = Http::isHttps();
        }
        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');
        ini_set('session.cookie_httponly', '1');
        ini_set('session.gc_maxlifetime', (string) config('session.lifetime', 7200));
        session_name((string) config('session.name', 'savie_session'));
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => base_path() === '' ? '/' : base_path() . '/',
            'secure'   => (bool) $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();

        // Idle timeout.
        $now = time();
        $last = $_SESSION['_last_activity'] ?? $now;
        if ($now - $last > (int) config('session.lifetime', 7200)) {
            $_SESSION = [];
            session_regenerate_id(true);
        }
        $_SESSION['_last_activity'] = $now;

        // Age out flash data: values set during the previous request become readable now.
        $_SESSION['_flash_old'] = $_SESSION['_flash_new'] ?? [];
        $_SESSION['_flash_new'] = [];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function pull(string $key, mixed $default = null): mixed
    {
        $v = $_SESSION[$key] ?? $default;
        unset($_SESSION[$key]);
        return $v;
    }

    /** Store a value for the next request only. */
    public static function flash(string $key, mixed $value): void
    {
        $_SESSION['_flash_new'][$key] = $value;
    }

    /** Read flash data (from the previous request, or set in this one) without consuming. */
    public static function peekFlash(string $key, mixed $default = null): mixed
    {
        return $_SESSION['_flash_new'][$key] ?? $_SESSION['_flash_old'][$key] ?? $default;
    }

    /** Read and consume flash data. */
    public static function getFlash(string $key, mixed $default = null): mixed
    {
        $v = self::peekFlash($key, $default);
        unset($_SESSION['_flash_new'][$key], $_SESSION['_flash_old'][$key]);
        return $v;
    }

    /** Keep current flash data for one more request (used for AJAX-triggered redirects). */
    public static function reflash(): void
    {
        $_SESSION['_flash_new'] = array_merge($_SESSION['_flash_old'] ?? [], $_SESSION['_flash_new'] ?? []);
    }

    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }

    public static function destroy(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires' => time() - 42000,
                'path' => $p['path'],
                'secure' => $p['secure'],
                'httponly' => $p['httponly'],
                'samesite' => 'Lax',
            ]);
        }
        session_destroy();
    }
}
