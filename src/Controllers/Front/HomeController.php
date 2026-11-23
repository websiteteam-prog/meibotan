<?php
declare(strict_types=1);

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\DB;
use App\Core\Settings;
use App\Services\Layout;
use App\Services\ProductService;

final class HomeController extends Controller
{
    public function index(): void
    {
        $sections = DB::all('SELECT * FROM home_sections WHERE is_visible = 1 ORDER BY sort_order');
        $data = ['sections' => []];
        foreach ($sections as $s) {
            $s['settings'] = json_decode((string) $s['settings'], true) ?: [];
            $limit = max(1, min(24, (int) ($s['settings']['limit'] ?? 8)));
            switch ($s['section_key']) {
                case 'hero':
                    $s['slides'] = self::banners('hero');
                    if (!$s['slides']) { continue 2; }
                    break;
                case 'categories':
                    $s['categories'] = array_values(array_filter(Layout::categories(), static fn($c) => (int) $c['is_featured'] === 1));
                    if (!$s['categories']) { continue 2; }
                    break;
                case 'bestsellers':
                    $s['products'] = ProductService::list([], 'bestselling', $limit);
                    $s['tabs'] = Layout::categories();
                    break;
                case 'new_arrivals':
                    $s['products'] = ProductService::list([], 'newest', $limit);
                    break;
                case 'trending':
                    // Featured picks that are not already in the best-seller block, topped up if needed.
                    $s['products'] = ProductService::list(['featured' => 1, 'not_bestseller' => 1], 'featured', $limit);
                    if (count($s['products']) < $limit) {
                        $ids = array_column($s['products'], 'id');
                        foreach (ProductService::list(['featured' => 1], 'rating', $limit * 2) as $extra) {
                            if (count($s['products']) >= $limit) { break; }
                            if (!in_array($extra['id'], $ids, true)) { $s['products'][] = $extra; }
                        }
                    }
                    break;
                case 'promos':
                    $s['banners'] = self::banners('promo');
                    if (!$s['banners']) { continue 2; }
                    break;
                case 'collection':
                    $col = DB::one('SELECT * FROM collections WHERE is_active = 1 AND show_on_home = 1 ORDER BY sort_order LIMIT 1');
                    if (!$col) { continue 2; }
                    $s['collection'] = $col;
                    $s['products'] = ProductService::query(['collection_id' => $col['id']], 'collection', 4)['items'];
                    break;
                case 'benefits':
                    $s['items'] = Settings::json('benefits');
                    if (!$s['items']) { continue 2; }
                    break;
                case 'testimonials':
                    $s['items'] = DB::all('SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order, id DESC LIMIT 12');
                    if (!$s['items']) { continue 2; }
                    break;
                case 'instagram':
                    $s['items'] = DB::all('SELECT * FROM social_posts WHERE is_active = 1 ORDER BY sort_order, id DESC LIMIT 6');
                    if (!$s['items']) { continue 2; }
                    break;
            }
            if (in_array($s['section_key'], ['bestsellers', 'new_arrivals', 'trending'], true) && empty($s['products'])) {
                continue;
            }
            $data['sections'][] = $s;
        }

        $data['meta'] = [
            'title' => (string) setting('meta_title', setting('site_name')),
            'description' => (string) setting('meta_description', ''),
            'canonical' => url('/'),
        ];
        $data['schema'] = [[
            '@context' => 'https://schema.org', '@type' => 'WebSite', 'name' => setting('site_name'), 'url' => url('/'),
            'potentialAction' => ['@type' => 'SearchAction', 'target' => url('search') . '?q={search_term_string}', 'query-input' => 'required name=search_term_string'],
        ]];
        $data['bodyClass'] = 'page-home';
        $this->view('home', $data);
    }

    private static function banners(string $type): array
    {
        return DB::all(
            "SELECT * FROM banners WHERE type = :t AND is_active = 1
             AND (starts_at IS NULL OR starts_at <= NOW()) AND (ends_at IS NULL OR ends_at >= NOW())
             ORDER BY sort_order, id",
            ['t' => $type]
        );
    }
}
