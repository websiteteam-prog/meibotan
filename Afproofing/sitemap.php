<?php
/**
 * XML sitemap for Google, served at /sitemap.xml. New service pages are added automatically.
 */
require_once __DIR__ . '/includes/bootstrap.php';

$dataFile = ROOT_PATH . '/includes/data/services.php';
$pages = [
    ['', 'index.php', '1.0'],
    ['services', 'services.php', '0.9'],
    ['free-quote', 'free-quote.php', '0.9'],
    ['gallery', 'gallery.php', '0.8'],
    ['why-choose-us', 'why-choose-us.php', '0.7'],
    ['reviews', 'reviews.php', '0.7'],
    ['service-areas', 'service-areas.php', '0.8'],
    ['contact', 'contact.php', '0.8'],
    ['privacy-policy', 'privacy-policy.php', '0.2'],
];

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

$entry = function (string $path, int $modified, string $priority): void {
    echo "  <url>\n    <loc>" . e(absolute_url($path)) . "</loc>\n"
        . '    <lastmod>' . date('Y-m-d', $modified) . "</lastmod>\n"
        . "    <priority>$priority</priority>\n  </url>\n";
};

foreach ($pages as [$path, $file, $priority]) {
    $entry($path, max(filemtime(ROOT_PATH . '/' . $file), filemtime($dataFile)), $priority);
}
foreach ($services as $slug => $service) {
    $entry('services/' . $slug, max(filemtime(ROOT_PATH . '/service.php'), filemtime($dataFile)), '0.9');
}

echo '</urlset>' . "\n";
