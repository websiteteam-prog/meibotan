<?php
/**
 * Application bootstrap: configuration, autoloading, error handling and session.
 */
declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));
define('SRC_PATH', BASE_PATH . '/src');
define('VIEW_PATH', BASE_PATH . '/views');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');
define('STORAGE_PATH', BASE_PATH . '/storage');

// ---------------------------------------------------------------------------
// Autoloader (PSR-4 style: App\Core\Router => src/Core/Router.php)
// ---------------------------------------------------------------------------
spl_autoload_register(static function (string $class): void {
    if (strncmp($class, 'App\\', 4) !== 0) {
        return;
    }
    $file = SRC_PATH . '/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

require SRC_PATH . '/helpers.php';
require SRC_PATH . '/admin_helpers.php';

// ---------------------------------------------------------------------------
// Configuration
// ---------------------------------------------------------------------------
$configFile = BASE_PATH . '/config/config.php';
if (!is_file($configFile)) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Missing config/config.php — run: php bin/install.php\n");
        exit(1);
    }
    http_response_code(503);
    echo '<!doctype html><meta charset="utf-8"><title>Setup required</title>'
        . '<body style="font-family:system-ui;background:#EDEBDD;color:#1B1717;padding:60px">'
        . '<h1 style="font-weight:500">Savié Amour — setup required</h1>'
        . '<p>Copy <code>config/config.sample.php</code> to <code>config/config.php</code>, '
        . 'update the database credentials and run <code>php bin/install.php</code>.</p></body>';
    exit;
}
$GLOBALS['__config'] = require $configFile;

date_default_timezone_set(config('timezone', 'Asia/Kolkata'));
mb_internal_encoding('UTF-8');

// ---------------------------------------------------------------------------
// Error handling
// ---------------------------------------------------------------------------
$isDev = config('app_env') === 'development';
error_reporting(E_ALL);
ini_set('display_errors', $isDev ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', STORAGE_PATH . '/logs/php-error.log');

set_exception_handler(static function (Throwable $e) use ($isDev): void {
    error_log((string) $e);
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, (string) $e . "\n");
        exit(1);
    }
    if (!headers_sent()) {
        http_response_code(500);
    }
    if (is_ajax()) {
        header('Content-Type: application/json');
        echo json_encode(['ok' => false, 'message' => $isDev ? $e->getMessage() : 'Something went wrong. Please try again.']);
        return;
    }
    if ($isDev) {
        echo '<pre style="padding:20px;white-space:pre-wrap">' . e((string) $e) . '</pre>';
        return;
    }
    try {
        echo App\Core\View::render('front/error', ['code' => 500, 'title' => 'Something went wrong', 'message' => 'We could not complete your request. Please try again in a moment.'], 'layouts/front');
    } catch (Throwable $inner) {
        echo 'Something went wrong. Please try again later.';
    }
});

// ---------------------------------------------------------------------------
// Session (not for CLI)
// ---------------------------------------------------------------------------
if (PHP_SAPI !== 'cli') {
    App\Core\Session::start();
    App\Core\Http::securityHeaders();
}
