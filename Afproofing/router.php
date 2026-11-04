<?php
/**
 * Local development only. Mirrors the .htaccess rules for PHP's built-in server:
 *
 *   php -S localhost:8000 router.php
 *
 * Not used (and blocked) on the live Apache server.
 */
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/');

if (preg_match('#^/(includes|storage)(/|$)#', $path) || preg_match('#\.(log|md|json)$#', $path)) {
    http_response_code(403);
    exit('Forbidden');
}
if ($path !== '/' && is_file(__DIR__ . $path)) {
    return false; // Serve static files and .php files as normal.
}
if (preg_match('#^/services/([a-z0-9-]+)$#', $path, $m)) {
    $_GET['slug'] = $m[1];
    require __DIR__ . '/service.php';
    return true;
}
if ($path === '/sitemap.xml') {
    require __DIR__ . '/sitemap.php';
    return true;
}
$name = trim($path, '/');
if ($name === '') {
    require __DIR__ . '/index.php';
    return true;
}
if (preg_match('/^[a-z0-9-]+$/', $name) && is_file(__DIR__ . "/$name.php")) {
    require __DIR__ . "/$name.php";
    return true;
}
require __DIR__ . '/404.php';
return true;
