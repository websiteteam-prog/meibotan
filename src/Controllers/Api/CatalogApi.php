<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\DB;
use App\Core\View;
use App\Services\ProductService;

final class CatalogApi
{
    /** Live search suggestions for the header search panel. */
    public function search(): void
    {
        $q = mb_substr(trim((string) input('q', '')), 0, 80);
        if (mb_strlen($q) < 2) {
            json_response(['ok' => true, 'products' => [], 'categories' => [], 'total' => 0]);
        }
        $result = ProductService::query(['q' => $q], 'bestselling', 8);
        $like = '%' . addcslashes($q, '%_\\') . '%';
        $cats = DB::all('SELECT name, slug FROM categories WHERE is_active = 1 AND name LIKE :q ORDER BY sort_order LIMIT 4', ['q' => $like]);
        header('Cache-Control: private, max-age=60');
        json_response([
            'ok' => true,
            'total' => $result['total'],
            'categories' => array_map(static fn($c) => ['name' => $c['name'], 'url' => url('category/' . $c['slug'])], $cats),
            'products' => array_map(static fn($p) => [
                'name' => $p['name'],
                'url' => $p['url'],
                'image' => upload_url($p['image'], '300'),
                'category' => $p['category_name'],
                'price' => ($p['from_price'] ? 'From ' . money($p['from_price']) : money($p['final_price'])),
                'regular' => $p['discount_percent'] && !$p['from_price'] ? money($p['regular_price']) : null,
            ], $result['items']),
        ]);
    }

    public function quickView(string $id): void
    {
        $p = ProductService::findById((int) $id);
        if (!$p) {
            json_response(['ok' => false, 'message' => 'This product is no longer available.'], 404);
        }
        json_response(['ok' => true, 'html' => View::partial('front/partials/quick-view', ['p' => $p])]);
    }

    /** Home page best-seller tabs (filter by category). */
    public function homeTab(): void
    {
        $cat = input_int('category');
        $limit = max(1, min(16, input_int('limit', 8)));
        $filters = $cat ? ['category_id' => $cat] : [];
        $items = ProductService::list($filters, 'bestselling', $limit);
        $html = '';
        foreach ($items as $p) {
            $html .= View::partial('partials/product-card', ['p' => $p]);
        }
        if ($html === '') {
            $html = '<p class="text-muted-sa">No products in this category yet.</p>';
        }
        $slug = $cat ? DB::value('SELECT slug FROM categories WHERE id = :id', ['id' => $cat]) : null;
        json_response(['ok' => true, 'html' => $html, 'link' => $slug ? url('category/' . $slug, ['sort' => 'bestselling']) : url('shop', ['sort' => 'bestselling'])]);
    }
}
