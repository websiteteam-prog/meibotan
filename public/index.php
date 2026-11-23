<?php
/**
 * Front controller — every request that is not a static file is routed here.
 */
declare(strict_types=1);

// Let PHP's built-in dev server serve static files directly.
if (PHP_SAPI === 'cli-server') {
    $file = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($file !== __DIR__ . '/' && is_file($file) && !str_ends_with($file, '.php')) {
        return false;
    }
}

require dirname(__DIR__) . '/src/bootstrap.php';

$router = new App\Core\Router();
require SRC_PATH . '/routes.php';

$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', request_path());
