<?php
declare(strict_types=1);

namespace App\Core;

/**
 * CSRF protection: one token per session, checked on every state-changing
 * request (form field "_token" or "X-CSRF-Token" header for AJAX).
 */
final class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    public static function verify(): bool
    {
        $sent = $_POST['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        return is_string($sent) && $sent !== '' && !empty($_SESSION['_csrf'])
            && hash_equals($_SESSION['_csrf'], $sent);
    }

    public static function enforce(): void
    {
        if (!self::verify()) {
            if (is_ajax()) {
                json_response(['ok' => false, 'message' => 'Your session has expired. Please refresh the page and try again.'], 419);
            }
            flash('error', 'Your session expired. Please try again.');
            back();
        }
    }
}
