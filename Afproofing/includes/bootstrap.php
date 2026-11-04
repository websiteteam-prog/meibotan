<?php
/**
 * Loaded at the top of every page: settings, helpers and site content.
 */
declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));
define('IS_DEV', PHP_SAPI === 'cli-server');

error_reporting(E_ALL);
ini_set('display_errors', IS_DEV ? '1' : '0');
date_default_timezone_set('Australia/Adelaide');

$config = require ROOT_PATH . '/includes/config.php';

require ROOT_PATH . '/includes/functions.php';

$services = [];
foreach (require ROOT_PATH . '/includes/data/services.php' as $slug => $service) {
    $services[$slug] = $service + ['slug' => $slug];
}
$gallery = require ROOT_PATH . '/includes/data/gallery.php';
$reviews = require ROOT_PATH . '/includes/data/reviews.php';
$areas   = require ROOT_PATH . '/includes/data/areas.php';
$faqs    = require ROOT_PATH . '/includes/data/faqs.php';

// Path the site is served from ('' at the domain root, '/afproofing' in a sub-folder).
$docRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '';
$rootReal = realpath(ROOT_PATH) ?: ROOT_PATH;
$basePath = ($docRoot !== '' && str_starts_with($rootReal, $docRoot))
    ? str_replace('\\', '/', substr($rootReal, strlen($docRoot)))
    : '';
define('BASE_PATH', rtrim($basePath, '/'));

$requestPath = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
if (BASE_PATH !== '' && str_starts_with($requestPath, BASE_PATH)) {
    $requestPath = substr($requestPath, strlen(BASE_PATH));
}
define('CURRENT_PATH', trim($requestPath, '/'));

// Error messages and previous input from a non-JavaScript form submission.
$flash = flash_pull();
