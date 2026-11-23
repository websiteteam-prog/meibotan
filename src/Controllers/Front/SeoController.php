<?php
declare(strict_types=1);

namespace App\Controllers\Front;

use App\Core\DB;

final class SeoController
{
    public function sitemap(): void
    {
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0', 'freq' => 'daily'],
            ['loc' => url('shop'), 'priority' => '0.9', 'freq' => 'daily'],
            ['loc' => url('about-us'), 'priority' => '0.5', 'freq' => 'monthly'],
            ['loc' => url('contact'), 'priority' => '0.4', 'freq' => 'yearly'],
        ];
        foreach (DB::all('SELECT slug, updated_at, created_at FROM categories WHERE is_active = 1') as $c) {
            $urls[] = ['loc' => url('category/' . $c['slug']), 'lastmod' => $c['updated_at'] ?: $c['created_at'], 'priority' => '0.8', 'freq' => 'weekly'];
        }
        foreach (DB::all('SELECT s.slug, c.slug AS cslug FROM subcategories s INNER JOIN categories c ON c.id = s.category_id WHERE s.is_active = 1 AND c.is_active = 1') as $s) {
            $urls[] = ['loc' => url('category/' . $s['cslug'] . '/' . $s['slug']), 'priority' => '0.6', 'freq' => 'weekly'];
        }
        foreach (DB::all('SELECT slug FROM collections WHERE is_active = 1') as $c) {
            $urls[] = ['loc' => url('collection/' . $c['slug']), 'priority' => '0.6', 'freq' => 'weekly'];
        }
        foreach (DB::all('SELECT p.slug, p.image, p.name, p.updated_at, p.created_at FROM products p LEFT JOIN categories c ON c.id = p.category_id WHERE p.is_active = 1 AND (c.id IS NULL OR c.is_active = 1)') as $p) {
            $urls[] = ['loc' => url('product/' . $p['slug']), 'lastmod' => $p['updated_at'] ?: $p['created_at'], 'priority' => '0.8', 'freq' => 'weekly',
                'image' => $p['image'] ? url('uploads/' . preg_replace('~\.webp$~', '-600.jpg', $p['image'])) : null, 'title' => $p['name']];
        }
        foreach (DB::all("SELECT slug, updated_at, created_at FROM pages WHERE is_active = 1 AND slug <> 'about-us'") as $p) {
            $urls[] = ['loc' => url('page/' . $p['slug']), 'lastmod' => $p['updated_at'] ?: $p['created_at'], 'priority' => '0.3', 'freq' => 'yearly'];
        }
        header('Content-Type: application/xml; charset=utf-8');
        header('Cache-Control: public, max-age=3600');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
        foreach ($urls as $u) {
            echo '  <url><loc>' . e($u['loc']) . '</loc>';
            if (!empty($u['lastmod'])) {
                echo '<lastmod>' . date('Y-m-d', strtotime($u['lastmod'])) . '</lastmod>';
            }
            echo '<changefreq>' . $u['freq'] . '</changefreq><priority>' . $u['priority'] . '</priority>';
            if (!empty($u['image'])) {
                echo '<image:image><image:loc>' . e($u['image']) . '</image:loc><image:title>' . e($u['title']) . '</image:title></image:image>';
            }
            echo "</url>\n";
        }
        echo '</urlset>';
    }

    public function robots(): void
    {
        header('Content-Type: text/plain; charset=utf-8');
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: ' . base_path() . '/admin',
            'Disallow: ' . base_path() . '/account',
            'Disallow: ' . base_path() . '/cart',
            'Disallow: ' . base_path() . '/checkout',
            'Disallow: ' . base_path() . '/wishlist',
            'Disallow: ' . base_path() . '/api/',
            'Disallow: ' . base_path() . '/order/',
            'Disallow: ' . base_path() . '/search',
            'Disallow: /*?*sort=',
            '',
        ];
        $extra = trim((string) setting('robots_extra', ''));
        if ($extra !== '') {
            $lines[] = $extra;
            $lines[] = '';
        }
        $lines[] = 'Sitemap: ' . url('sitemap.xml');
        echo implode("\n", $lines) . "\n";
    }
}
