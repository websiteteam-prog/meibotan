<?php
declare(strict_types=1);

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\DB;
use App\Core\Paginator;
use App\Core\View;
use App\Services\Layout;
use App\Services\ProductService;

final class ShopController extends Controller
{
    public function index(): void
    {
        $this->listing(['type' => 'shop', 'title' => 'Shop all', 'italic' => 'products', 'path' => 'shop']);
    }

    public function search(): void
    {
        $q = trim((string) input('q', ''));
        $this->listing([
            'type' => 'search', 'path' => 'search',
            'title' => $q !== '' ? 'Results for' : 'Search', 'italic' => $q !== '' ? '“' . $q . '”' : 'our products',
            'robots' => 'noindex, follow',
        ]);
    }

    public function category(string $slug): void
    {
        $cat = DB::one('SELECT * FROM categories WHERE slug = :s AND is_active = 1', ['s' => $slug]);
        if (!$cat) {
            abort(404);
        }
        $this->listing([
            'type' => 'category', 'category' => $cat, 'path' => 'category/' . $cat['slug'],
            'title' => $cat['name'], 'description' => $cat['description'], 'image' => $cat['image'],
            'meta_title' => $cat['meta_title'] ?: $cat['name'], 'meta_description' => $cat['meta_description'] ?: $cat['description'],
        ]);
    }

    public function subcategory(string $slug, string $sub): void
    {
        $cat = DB::one('SELECT * FROM categories WHERE slug = :s AND is_active = 1', ['s' => $slug]);
        $subcat = $cat ? DB::one('SELECT * FROM subcategories WHERE category_id = :c AND slug = :s AND is_active = 1', ['c' => $cat['id'], 's' => $sub]) : null;
        if (!$subcat) {
            abort(404);
        }
        $this->listing([
            'type' => 'subcategory', 'category' => $cat, 'subcategory' => $subcat, 'path' => 'category/' . $cat['slug'] . '/' . $subcat['slug'],
            'title' => $subcat['name'], 'description' => $subcat['description'] ?: $cat['description'], 'image' => $subcat['image'] ?: $cat['image'],
            'meta_title' => $subcat['name'] . ' — ' . $cat['name'],
        ]);
    }

    public function collection(string $slug): void
    {
        $col = DB::one('SELECT * FROM collections WHERE slug = :s AND is_active = 1', ['s' => $slug]);
        if (!$col) {
            abort(404);
        }
        $this->listing([
            'type' => 'collection', 'collection' => $col, 'path' => 'collection/' . $col['slug'],
            'title' => $col['name'], 'description' => $col['description'] ?: $col['tagline'], 'image' => $col['image'],
            'eyebrow' => $col['eyebrow'] ?: 'Collection',
        ]);
    }

    /**
     * Shared listing for shop, search, category, subcategory and collection pages.
     */
    private function listing(array $ctx): void
    {
        $categories = Layout::categories();
        $filters = [];
        $chips = [];

        // Context filters fixed by the URL.
        if (isset($ctx['category'])) {
            $filters['category_id'] = (int) $ctx['category']['id'];
        }
        if (isset($ctx['subcategory'])) {
            $filters['subcategory_ids'] = [(int) $ctx['subcategory']['id']];
        }
        if (isset($ctx['collection'])) {
            $filters['collection_id'] = (int) $ctx['collection']['id'];
        }

        // Category radio (shop / search / collection only).
        $selectedCat = null;
        if (!isset($ctx['category'])) {
            $catSlug = (string) input('category', '');
            foreach ($categories as $c) {
                if ($c['slug'] === $catSlug) {
                    $selectedCat = $c;
                    $filters['category_id'] = (int) $c['id'];
                    $chips[] = ['name' => 'category', 'label' => $c['name']];
                }
            }
        }

        // Subcategory checkboxes.
        $subs = array_values(array_filter(array_map('intval', (array) ($_GET['sub'] ?? []))));
        if ($subs && !isset($ctx['subcategory'])) {
            $filters['subcategory_ids'] = $subs;
            foreach ($categories as $c) {
                foreach ($c['subs'] as $s) {
                    if (in_array((int) $s['id'], $subs, true)) {
                        $chips[] = ['name' => 'sub', 'value' => $s['id'], 'label' => $s['name']];
                    }
                }
            }
        }

        $q = mb_substr(trim((string) input('q', '')), 0, 80);
        if ($q !== '') {
            $filters['q'] = $q;
            if ($ctx['type'] !== 'search') {
                $chips[] = ['name' => 'q', 'label' => '“' . $q . '”'];
            }
        }

        [$minBound, $maxBound] = ProductService::priceBounds();
        $min = input('min_price');
        $max = input('max_price');
        if (is_numeric($min) && (float) $min > $minBound) {
            $filters['min_price'] = (float) $min;
        }
        if (is_numeric($max) && (float) $max < $maxBound) {
            $filters['max_price'] = (float) $max;
        }
        if (isset($filters['min_price']) || isset($filters['max_price'])) {
            $chips[] = ['name' => 'price', 'label' => money($filters['min_price'] ?? $minBound) . ' – ' . money($filters['max_price'] ?? $maxBound)];
        }
        foreach (['in_stock' => 'In stock', 'on_sale' => 'On sale', 'new' => 'New', 'bestseller' => 'Best sellers', 'featured' => 'Featured'] as $flag => $label) {
            if (input($flag)) {
                $filters[$flag] = 1;
                $chips[] = ['name' => $flag, 'label' => $label];
            }
        }

        $sort = (string) input('sort', $ctx['type'] === 'collection' ? 'collection' : 'featured');
        if (!isset(ProductService::SORTS[$sort]) && $sort !== 'collection') {
            $sort = 'featured';
        }
        $perPage = max(4, min(48, (int) setting('products_per_page', 12)));
        $countOnly = ProductService::query($filters, $sort, 1, 0);
        $pager = new Paginator($countOnly['total'], $perPage);
        $result = ProductService::query($filters, $sort, $perPage, $pager->offset);
        $products = $result['items'];

        $basePath = $ctx['path'];
        $countLabel = $pager->total === 0 ? 'No products found' : 'Showing ' . $pager->from() . '–' . $pager->to() . ' of ' . plural($pager->total, 'product');

        if (is_ajax()) {
            $html = '';
            foreach ($products as $p) {
                $html .= View::partial('partials/product-card', ['p' => $p, 'sizes' => '(max-width: 576px) 50vw, (max-width: 1200px) 33vw, 22vw']);
            }
            if ($html === '' && $pager->page === 1) {
                $html = View::partial('front/partials/shop-empty', ['q' => $q]);
            }
            json_response([
                'ok' => true,
                'html' => $html,
                'count_label' => $countLabel,
                'has_more' => $pager->hasMore(),
                'next_page' => $pager->page + 1,
                'pager' => View::partial('front/partials/pager', ['pager' => $pager, 'path' => $basePath]),
                'chips' => View::partial('front/partials/filter-chips', ['chips' => $chips]),
            ]);
        }

        $crumbs = [['Home', url('/')], ['Shop', url('shop')]];
        if (isset($ctx['category'])) {
            $crumbs[] = [$ctx['category']['name'], url('category/' . $ctx['category']['slug'])];
        }
        if (isset($ctx['subcategory'])) {
            $crumbs[] = [$ctx['subcategory']['name'], null];
        }
        if (isset($ctx['collection'])) {
            $crumbs[] = [$ctx['collection']['name'], null];
        }
        if ($ctx['type'] === 'search') {
            $crumbs[] = ['Search', null];
        }

        $pageSuffix = $pager->page > 1 ? ' — Page ' . $pager->page : '';
        $canonicalQuery = $pager->page > 1 ? ['page' => $pager->page] : [];
        $this->view('shop', [
            'ctx' => $ctx,
            'products' => $products,
            'pager' => $pager,
            'categories' => $categories,
            'selectedCat' => $selectedCat,
            'selectedSubs' => $subs,
            'chips' => $chips,
            'q' => $q,
            'sort' => $sort,
            'minBound' => $minBound,
            'maxBound' => $maxBound,
            'minPrice' => (int) ($filters['min_price'] ?? $minBound),
            'maxPrice' => (int) ($filters['max_price'] ?? $maxBound),
            'countLabel' => $countLabel,
            'basePath' => $basePath,
            'crumbs' => $crumbs,
            'meta' => $this->meta(
                ($ctx['meta_title'] ?? ($ctx['title'] . (isset($ctx['italic']) ? ' ' . $ctx['italic'] : ''))) . $pageSuffix,
                $ctx['meta_description'] ?? ($ctx['description'] ?? null),
                ['canonical' => url($basePath, $canonicalQuery), 'robots' => ($ctx['robots'] ?? (($chips || $sort !== 'featured') ? 'noindex, follow' : 'index, follow'))]
            ),
            'schema' => [self::breadcrumbSchema($crumbs)],
            'bodyClass' => 'page-shop',
        ]);
    }

    public static function breadcrumbSchema(array $crumbs): array
    {
        $items = [];
        foreach ($crumbs as $i => [$name, $link]) {
            $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $name] + ($link ? ['item' => $link] : []);
        }
        return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
    }
}
