<?php
/**
 * Global helper functions used across controllers and views.
 */
declare(strict_types=1);

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Session;
use App\Core\Settings;

/** Read a value from config/config.php using dot notation. */
function config(string $key, mixed $default = null): mixed
{
    $value = $GLOBALS['__config'] ?? [];
    foreach (explode('.', $key) as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }
    return $value;
}

/** Escape a value for safe HTML output (XSS protection). */
function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Store-wide setting managed from Admin → Settings. */
function setting(string $key, mixed $default = null): mixed
{
    return Settings::get($key, $default);
}

/** Base path of the app (e.g. "" or "/shop") derived from app_url. */
function base_path(): string
{
    static $path = null;
    if ($path === null) {
        $path = rtrim((string) parse_url((string) config('app_url', ''), PHP_URL_PATH), '/');
    }
    return $path;
}

/** Absolute URL for an application path. */
function url(string $path = '', array $query = []): string
{
    $base = rtrim((string) config('app_url', ''), '/');
    $path = '/' . ltrim($path, '/');
    $out = $base . ($path === '/' ? '/' : $path);
    if ($query) {
        $query = array_filter($query, static fn($v) => $v !== null && $v !== '' && $v !== []);
        if ($query) {
            $out .= (str_contains($out, '?') ? '&' : '?') . http_build_query($query);
        }
    }
    return $out;
}

/** URL for a static asset with cache-busting version based on file mtime. */
function asset(string $path): string
{
    $file = PUBLIC_PATH . '/assets/' . ltrim($path, '/');
    $v = is_file($file) ? filemtime($file) : 1;
    return url('assets/' . ltrim($path, '/')) . '?v=' . $v;
}

/** Public URL of an uploaded file (stored relative to /public/uploads). */
function upload_url(?string $path, ?string $size = null): string
{
    if (!$path) {
        return asset('img/placeholder.svg');
    }
    if (preg_match('~^https?://~', $path)) {
        return $path;
    }
    if ($size !== null) {
        $sized = preg_replace('~\.webp$~', '-' . $size . '.webp', $path);
        if ($sized !== $path && is_file(UPLOAD_PATH . '/' . $sized)) {
            $path = $sized;
        }
    }
    return url('uploads/' . ltrim($path, '/'));
}

/**
 * Responsive <img> tag for an uploaded image with srcset (300/600/full) and lazy loading.
 */
function img_tag(?string $path, string $alt, array $attrs = []): string
{
    $src = upload_url($path, '600');
    $srcset = '';
    if ($path && str_ends_with($path, '.webp')) {
        $set = [];
        foreach (['300' => 300, '600' => 600] as $suffix => $w) {
            $candidate = preg_replace('~\.webp$~', '-' . $suffix . '.webp', $path);
            if (is_file(UPLOAD_PATH . '/' . $candidate)) {
                $set[] = url('uploads/' . $candidate) . ' ' . $w . 'w';
            }
        }
        if (is_file(UPLOAD_PATH . '/' . $path)) {
            $info = @getimagesize(UPLOAD_PATH . '/' . $path);
            $set[] = url('uploads/' . $path) . ' ' . ($info[0] ?? 1200) . 'w';
        }
        $srcset = implode(', ', $set);
    }
    $defaults = ['loading' => 'lazy', 'decoding' => 'async'];
    $attrs = array_merge($defaults, $attrs);
    $html = '<img src="' . e($src) . '" alt="' . e($alt) . '"';
    if ($srcset !== '') {
        $html .= ' srcset="' . e($srcset) . '"';
        $html .= ' sizes="' . e($attrs['sizes'] ?? '(max-width: 576px) 50vw, (max-width: 992px) 33vw, 25vw') . '"';
    }
    unset($attrs['sizes']);
    foreach ($attrs as $k => $v) {
        if ($v === false || $v === null) {
            continue;
        }
        $html .= ' ' . e($k) . ($v === true ? '' : '="' . e($v) . '"');
    }
    return $html . '>';
}

/** Inline SVG icon from the sprite. */
function icon(string $name, string $class = ''): string
{
    return '<svg class="ic ' . e($class) . '" aria-hidden="true" focusable="false"><use href="#i-' . e($name) . '"></use></svg>';
}

/** Current request path relative to the app base (always starts with "/"). */
function request_path(): string
{
    $uri = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $base = base_path();
    if ($base !== '' && str_starts_with($uri, $base)) {
        $uri = substr($uri, strlen($base));
    }
    $uri = '/' . trim(rawurldecode($uri), '/');
    return $uri;
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function is_ajax(): bool
{
    return strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest'
        || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
}

/** Read request input (POST first, then GET), trimmed when string. */
function input(string $key, mixed $default = null): mixed
{
    $value = $_POST[$key] ?? $_GET[$key] ?? $default;
    return is_string($value) ? trim($value) : $value;
}

function input_int(string $key, int $default = 0): int
{
    $v = input($key);
    return is_numeric($v) ? (int) $v : $default;
}

function redirect(string $to, int $status = 302): never
{
    if (!preg_match('~^https?://~', $to)) {
        $to = url($to);
    }
    header('Location: ' . $to, true, $status);
    exit;
}

function back(string $fallback = '/'): never
{
    $ref = $_SERVER['HTTP_REFERER'] ?? '';
    $app = rtrim((string) config('app_url'), '/');
    if ($ref !== '' && str_starts_with($ref, $app)) {
        header('Location: ' . $ref, true, 302);
        exit;
    }
    redirect($fallback);
}

/** Only allow redirects to paths on this site (prevents open redirects). */
function safe_redirect_path(?string $path, string $fallback = '/'): string
{
    $path = (string) $path;
    if ($path === '' || !str_starts_with($path, '/') || str_starts_with($path, '//') || str_contains($path, '\\')) {
        return $fallback;
    }
    return $path;
}

function json_response(array $data, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function abort(int $code = 404, string $message = ''): never
{
    http_response_code($code);
    if (is_ajax()) {
        json_response(['ok' => false, 'message' => $message ?: 'Not found'], $code);
    }
    $titles = [403 => 'Access denied', 404 => 'Page not found', 419 => 'Session expired', 429 => 'Too many requests'];
    echo App\Core\View::render('front/error', [
        'code' => $code,
        'title' => $titles[$code] ?? 'Error',
        'message' => $message ?: ($code === 404 ? 'The page you are looking for has moved or no longer exists.' : 'Please try again.'),
        'meta' => ['title' => ($titles[$code] ?? 'Error') . ' | ' . setting('site_name', 'Savié Amour'), 'robots' => 'noindex'],
    ], 'layouts/front');
    exit;
}

// ---------------------------------------------------------------------------
// Flash / old input / validation errors
// ---------------------------------------------------------------------------
function flash(string $type, string $message): void
{
    Session::flash('messages', array_merge(Session::peekFlash('messages', []), [['type' => $type, 'text' => $message]]));
}

function flash_messages(): array
{
    return Session::getFlash('messages', []);
}

function old(string $key, mixed $default = ''): mixed
{
    $old = Session::peekFlash('old', []);
    return $old[$key] ?? $default;
}

function errors(): array
{
    return Session::peekFlash('errors', []);
}

function error_for(string $field): string
{
    $errors = errors();
    return isset($errors[$field]) ? '<div class="invalid-feedback d-block">' . e($errors[$field]) . '</div>' : '';
}

function invalid(string $field): string
{
    return isset(errors()[$field]) ? ' is-invalid' : '';
}

function with_errors(array $errors, array $old = []): void
{
    unset($old['password'], $old['password_confirmation'], $old['current_password'], $old['_token']);
    Session::flash('errors', $errors);
    Session::flash('old', $old);
}

function csrf_token(): string
{
    return Csrf::token();
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(Csrf::token()) . '">';
}

// ---------------------------------------------------------------------------
// Formatting
// ---------------------------------------------------------------------------
function money(float|int|string|null $amount, ?bool $decimals = null): string
{
    $amount = (float) $amount;
    $symbol = (string) setting('currency_symbol', '₹');
    $showDecimals = $decimals ?? (fmod($amount, 1.0) !== 0.0);
    if (setting('currency_code', 'INR') === 'INR') {
        $formatted = indian_number_format($amount, $showDecimals ? 2 : 0);
    } else {
        $formatted = number_format($amount, $showDecimals ? 2 : 0);
    }
    return $symbol . $formatted;
}

/** 1234567.5 => 12,34,567.50 */
function indian_number_format(float $n, int $decimals = 0): string
{
    $neg = $n < 0;
    $n = abs($n);
    $fixed = number_format($n, $decimals, '.', '');
    [$int, $dec] = array_pad(explode('.', $fixed), 2, '');
    if (strlen($int) > 3) {
        $last3 = substr($int, -3);
        $rest = substr($int, 0, -3);
        $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
        $int = $rest . ',' . $last3;
    }
    return ($neg ? '-' : '') . $int . ($decimals ? '.' . $dec : '');
}

function format_date(?string $date, string $format = 'd M Y'): string
{
    if (!$date) {
        return '—';
    }
    return date($format, strtotime($date));
}

function str_limit(?string $text, int $limit = 120): string
{
    $text = trim(strip_tags((string) $text));
    return mb_strlen($text) > $limit ? rtrim(mb_substr($text, 0, $limit)) . '…' : $text;
}

function slugify(string $text): string
{
    $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text) ?: $text;
    $text = strtolower((string) preg_replace('~[^A-Za-z0-9]+~', '-', $text));
    return trim($text, '-') ?: 'item';
}

function status_label(string $status): string
{
    return ucwords(str_replace('_', ' ', $status));
}

function active_path(string $prefix, string $class = 'active'): string
{
    $path = request_path();
    if ($prefix === '/') {
        return $path === '/' ? $class : '';
    }
    return ($path === $prefix || str_starts_with($path, rtrim($prefix, '/') . '/')) ? $class : '';
}

/** The logged-in customer row or null. */
function customer(): ?array
{
    return Auth::customer();
}

function admin_user(): ?array
{
    return App\Core\AdminAuth::user();
}

/** Plural helper: 1 item / 3 items */
function plural(int $n, string $singular, ?string $pluralForm = null): string
{
    return $n . ' ' . ($n === 1 ? $singular : ($pluralForm ?? $singular . 's'));
}

/** Build the current URL with modified query parameters. */
function query_url(array $changes, ?string $path = null): string
{
    $q = array_merge($_GET, $changes);
    foreach ($q as $k => $v) {
        if ($v === null || $v === '') {
            unset($q[$k]);
        }
    }
    return url($path ?? request_path(), $q);
}

function client_ip(): string
{
    return substr((string) ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'), 0, 45);
}

function now(): string
{
    return date('Y-m-d H:i:s');
}

/** Render a star rating as icons. */
function stars(float $rating, string $class = ''): string
{
    $html = '<span class="stars ' . e($class) . '" aria-label="' . e(number_format($rating, 1)) . ' out of 5">';
    for ($i = 1; $i <= 5; $i++) {
        $html .= icon($rating >= $i - 0.25 ? 'star-fill' : 'star');
    }
    return $html . '</span>';
}

function log_message(string $file, string $message): void
{
    @file_put_contents(STORAGE_PATH . '/logs/' . $file . '.log', '[' . date('c') . '] ' . $message . PHP_EOL, FILE_APPEND | LOCK_EX);
}
