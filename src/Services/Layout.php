<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\DB;

/**
 * Data shared by the storefront layout (navigation, footer), cached per request.
 */
final class Layout
{
    private static array $cache = [];

    /** Active categories with their active subcategories and product counts. */
    public static function categories(): array
    {
        if (!isset(self::$cache['cats'])) {
            $cats = DB::all(
                'SELECT c.*, (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id AND p.is_active = 1) AS product_count
                 FROM categories c WHERE c.is_active = 1 ORDER BY c.sort_order, c.name'
            );
            $subs = DB::all('SELECT * FROM subcategories WHERE is_active = 1 ORDER BY sort_order, name');
            foreach ($cats as &$c) {
                $c['subs'] = array_values(array_filter($subs, static fn($s) => (int) $s['category_id'] === (int) $c['id']));
                $c['url'] = url('category/' . $c['slug']);
            }
            self::$cache['cats'] = $cats;
        }
        return self::$cache['cats'];
    }

    public static function collections(): array
    {
        return self::$cache['cols'] ??= DB::all('SELECT * FROM collections WHERE is_active = 1 ORDER BY sort_order, name');
    }

    public static function footerPages(): array
    {
        return self::$cache['pages'] ??= DB::all("SELECT title, slug FROM pages WHERE is_active = 1 AND show_in_footer = 1 AND slug <> 'about-us' ORDER BY id");
    }

    public static function announcements(): array
    {
        $raw = (string) setting('announcement_messages', '');
        return array_values(array_filter(array_map('trim', preg_split('/\R/', $raw))));
    }

    public static function logo(string $variant = 'maroon'): string
    {
        $custom = $variant === 'cotton' ? setting('logo_light') : setting('logo');
        if ($custom) {
            return upload_url($custom);
        }
        return asset('img/logo-' . $variant . '.webp');
    }

    public static function socials(): array
    {
        $out = [];
        foreach (['instagram' => 'instagram_url', 'facebook' => 'facebook_url', 'youtube' => 'youtube_url', 'pinterest' => 'pinterest_url', 'x' => 'x_url'] as $icon => $key) {
            $v = trim((string) setting($key, ''));
            if ($v !== '') {
                $out[$icon] = $v;
            }
        }
        return $out;
    }

    public static function pagePath(string $slug): string
    {
        return $slug === 'about-us' ? 'about-us' : 'page/' . $slug;
    }
}
