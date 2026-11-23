<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\DB;

/**
 * Product queries for the storefront (listing, filtering, details) and
 * price/stock helpers shared by cart and checkout.
 */
final class ProductService
{
    /** SQL expression for the price a customer actually pays (sale price when valid). */
    public const EFFECTIVE_PRICE = 'CASE WHEN p.sale_price IS NOT NULL AND p.sale_price > 0 AND p.sale_price < p.price THEN p.sale_price ELSE p.price END';

    public const SORTS = [
        'featured'   => 'Featured',
        'newest'     => 'Newest',
        'bestselling'=> 'Best selling',
        'price_asc'  => 'Price: low to high',
        'price_desc' => 'Price: high to low',
        'rating'     => 'Top rated',
    ];

    /**
     * Filtered, sorted, paginated product listing.
     * @return array{items: array, total: int}
     */
    public static function query(array $f, string $sort = 'featured', int $limit = 12, int $offset = 0): array
    {
        $where = ['p.is_active = 1', '(c.id IS NULL OR c.is_active = 1)'];
        $params = [];
        $join = '';

        if (!empty($f['category_id'])) {
            $where[] = 'p.category_id = :cat';
            $params['cat'] = (int) $f['category_id'];
        }
        if (!empty($f['category_ids'])) {
            $where[] = 'p.category_id IN ' . DB::in(array_map('intval', $f['category_ids']), $params, 'cats');
        }
        if (!empty($f['subcategory_ids'])) {
            $where[] = 'p.subcategory_id IN ' . DB::in(array_map('intval', $f['subcategory_ids']), $params, 'subs');
        }
        if (!empty($f['collection_id'])) {
            $join .= ' INNER JOIN collection_products cp ON cp.product_id = p.id AND cp.collection_id = :col';
            $params['col'] = (int) $f['collection_id'];
        }
        if (!empty($f['ids'])) {
            $where[] = 'p.id IN ' . DB::in(array_map('intval', $f['ids']), $params, 'ids');
        }
        if (!empty($f['exclude_id'])) {
            $where[] = 'p.id <> :exclude';
            $params['exclude'] = (int) $f['exclude_id'];
        }
        if (isset($f['q']) && $f['q'] !== '') {
            $where[] = '(p.name LIKE :q1 OR p.sku LIKE :q2 OR p.short_description LIKE :q3 OR c.name LIKE :q4)';
            $like = '%' . addcslashes((string) $f['q'], '%_\\') . '%';
            $params += ['q1' => $like, 'q2' => $like, 'q3' => $like, 'q4' => $like];
        }
        if (isset($f['min_price']) && $f['min_price'] !== '' && is_numeric($f['min_price'])) {
            $where[] = '(' . self::EFFECTIVE_PRICE . ') >= :minp';
            $params['minp'] = (float) $f['min_price'];
        }
        if (isset($f['max_price']) && $f['max_price'] !== '' && is_numeric($f['max_price'])) {
            $where[] = '(' . self::EFFECTIVE_PRICE . ') <= :maxp';
            $params['maxp'] = (float) $f['max_price'];
        }
        if (!empty($f['in_stock'])) {
            $where[] = "p.stock_status = 'in_stock' AND (p.stock_qty > 0 OR EXISTS (SELECT 1 FROM product_variants v WHERE v.product_id = p.id AND v.is_active = 1 AND v.stock_qty > 0))";
        }
        foreach (['featured' => 'is_featured', 'bestseller' => 'is_bestseller', 'new' => 'is_new'] as $flag => $col) {
            if (!empty($f[$flag])) {
                $where[] = "p.{$col} = 1";
            }
        }
        if (!empty($f['on_sale'])) {
            $where[] = 'p.sale_price IS NOT NULL AND p.sale_price > 0 AND p.sale_price < p.price';
        }

        $order = match ($sort) {
            'newest' => 'p.created_at DESC, p.id DESC',
            'bestselling' => 'p.is_bestseller DESC, p.sold_count DESC, p.id DESC',
            'price_asc' => 'effective_price ASC, p.id DESC',
            'price_desc' => 'effective_price DESC, p.id DESC',
            'rating' => 'p.rating_avg DESC, p.rating_count DESC',
            'random' => 'RAND()',
            'collection' => 'cp.sort_order ASC, p.id DESC',
            default => 'p.is_featured DESC, p.is_bestseller DESC, p.created_at DESC, p.id DESC',
        };

        $whereSql = implode(' AND ', $where);
        $from = "FROM products p LEFT JOIN categories c ON c.id = p.category_id {$join} WHERE {$whereSql}";
        $total = (int) DB::value("SELECT COUNT(*) {$from}", $params);
        $items = DB::all(
            'SELECT p.*, ' . self::EFFECTIVE_PRICE . " AS effective_price, c.name AS category_name, c.slug AS category_slug
             {$from} ORDER BY {$order} LIMIT :lim OFFSET :off",
            $params + ['lim' => $limit, 'off' => $offset]
        );
        return ['items' => self::decorate($items), 'total' => $total];
    }

    /** Shortcut for homepage blocks. */
    public static function list(array $filters, string $sort = 'featured', int $limit = 8): array
    {
        return self::query($filters, $sort, $limit)['items'];
    }

    /**
     * Add computed display fields to product rows: url, final/regular price,
     * discount %, stock availability, variant info and wishlist state.
     */
    public static function decorate(array $products): array
    {
        if (!$products) {
            return [];
        }
        $ids = array_map(static fn($p) => (int) $p['id'], $products);
        $params = [];
        $in = DB::in($ids, $params, 'pid');
        $variantRows = DB::all(
            "SELECT product_id, COUNT(*) AS cnt, SUM(GREATEST(stock_qty,0)) AS stock,
                    MIN(COALESCE(CASE WHEN sale_price IS NOT NULL AND sale_price > 0 AND sale_price < COALESCE(price, 999999999) THEN sale_price END, price)) AS min_price,
                    MAX(COALESCE(price, 0)) AS max_price,
                    GROUP_CONCAT(CASE WHEN swatch IS NOT NULL AND swatch <> '' THEN swatch END ORDER BY sort_order SEPARATOR ',') AS swatches
             FROM product_variants WHERE is_active = 1 AND product_id IN {$in} GROUP BY product_id",
            $params
        );
        $variants = [];
        foreach ($variantRows as $r) {
            $variants[(int) $r['product_id']] = $r;
        }
        $wish = WishlistService::ids();

        foreach ($products as &$p) {
            $id = (int) $p['id'];
            [$final, $regular] = self::price($p);
            $p['final_price'] = $final;
            $p['regular_price'] = $regular;
            $p['discount_percent'] = self::discountPercent($final, $regular);
            $v = $variants[$id] ?? null;
            $p['variant_count'] = $v ? (int) $v['cnt'] : 0;
            $p['swatches'] = $v && $v['swatches'] ? array_slice(explode(',', $v['swatches']), 0, 5) : [];
            $stock = $v ? (int) $v['stock'] : (int) $p['stock_qty'];
            $p['available_qty'] = $p['stock_status'] === 'in_stock' ? max(0, $stock) : 0;
            $p['in_stock'] = $p['available_qty'] > 0;
            $p['from_price'] = null;
            if ($v && $v['min_price'] !== null && (float) $v['min_price'] > 0 && (float) $v['min_price'] < $final) {
                $p['from_price'] = (float) $v['min_price'];
            }
            $p['url'] = url('product/' . $p['slug']);
            $p['in_wishlist'] = in_array($id, $wish, true);
            $p['badges'] = self::badges($p);
        }
        return $products;
    }

    /** @return array{0: float, 1: float} [final price, regular price] */
    public static function price(array $product, ?array $variant = null): array
    {
        if ($variant && $variant['price'] !== null && $variant['price'] !== '') {
            $regular = (float) $variant['price'];
            $sale = $variant['sale_price'] !== null ? (float) $variant['sale_price'] : 0.0;
        } else {
            $regular = (float) $product['price'];
            $sale = $product['sale_price'] !== null ? (float) $product['sale_price'] : 0.0;
        }
        $final = ($sale > 0 && $sale < $regular) ? $sale : $regular;
        return [$final, $regular];
    }

    public static function discountPercent(float $final, float $regular): int
    {
        return ($regular > 0 && $final < $regular) ? (int) round(($regular - $final) / $regular * 100) : 0;
    }

    /** Badges shown on product cards (custom badge first, then automatic ones). */
    public static function badges(array $p): array
    {
        $badges = [];
        if (!empty($p['badge'])) {
            $badges[] = ['label' => $p['badge'], 'type' => 'custom'];
        }
        if (($p['in_stock'] ?? true) === false) {
            return [['label' => 'Sold out', 'type' => 'soldout']];
        }
        if (!empty($p['is_bestseller']) && stripos((string) $p['badge'], 'best') === false) {
            $badges[] = ['label' => 'Best Seller', 'type' => 'bestseller'];
        }
        if (!empty($p['is_new']) && stripos((string) $p['badge'], 'new') === false) {
            $badges[] = ['label' => 'New', 'type' => 'new'];
        }
        if (!empty($p['discount_percent'])) {
            $badges[] = ['label' => 'Sale', 'type' => 'sale'];
        }
        return array_slice($badges, 0, 2);
    }

    /** Full product with category, subcategory, images, variants and specs. */
    public static function findBySlug(string $slug): ?array
    {
        $p = DB::one(
            'SELECT p.*, ' . self::EFFECTIVE_PRICE . ' AS effective_price, c.name AS category_name, c.slug AS category_slug,
                    s.name AS subcategory_name, s.slug AS subcategory_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             LEFT JOIN subcategories s ON s.id = p.subcategory_id
             WHERE p.slug = :slug AND p.is_active = 1 AND (c.id IS NULL OR c.is_active = 1)',
            ['slug' => $slug]
        );
        return $p ? self::hydrate($p) : null;
    }

    public static function findById(int $id): ?array
    {
        $p = DB::one(
            'SELECT p.*, ' . self::EFFECTIVE_PRICE . ' AS effective_price, c.name AS category_name, c.slug AS category_slug,
                    s.name AS subcategory_name, s.slug AS subcategory_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             LEFT JOIN subcategories s ON s.id = p.subcategory_id
             WHERE p.id = :id AND p.is_active = 1',
            ['id' => $id]
        );
        return $p ? self::hydrate($p) : null;
    }

    private static function hydrate(array $p): array
    {
        $p = self::decorate([$p])[0];
        $p['images'] = DB::all('SELECT * FROM product_images WHERE product_id = :id ORDER BY sort_order, id', ['id' => $p['id']]);
        $p['variants'] = array_map(static function ($v) use ($p) {
            [$final, $regular] = self::price($p, $v);
            $v['final_price'] = $final;
            $v['regular_price'] = $regular;
            $v['discount_percent'] = self::discountPercent($final, $regular);
            $v['available_qty'] = $p['stock_status'] === 'in_stock' ? max(0, (int) $v['stock_qty']) : 0;
            return $v;
        }, DB::all('SELECT * FROM product_variants WHERE product_id = :id AND is_active = 1 ORDER BY sort_order, id', ['id' => $p['id']]));
        $specs = json_decode((string) $p['specifications'], true);
        $p['specs'] = is_array($specs) ? $specs : [];
        $p['gallery'] = array_values(array_filter(array_merge(
            [$p['image']],
            array_column($p['images'], 'image')
        )));
        return $p;
    }

    /** Variant row belonging to a product (active only). */
    public static function variant(int $productId, int $variantId): ?array
    {
        return DB::one('SELECT * FROM product_variants WHERE id = :v AND product_id = :p AND is_active = 1', ['v' => $variantId, 'p' => $productId]);
    }

    public static function hasVariants(int $productId): bool
    {
        return (int) DB::value('SELECT COUNT(*) FROM product_variants WHERE product_id = :p AND is_active = 1', ['p' => $productId]) > 0;
    }

    /** Units available to buy for a product/variant. */
    public static function availableQty(array $product, ?array $variant): int
    {
        if (($product['stock_status'] ?? 'in_stock') !== 'in_stock' || empty($product['is_active'])) {
            return 0;
        }
        return max(0, (int) ($variant ? $variant['stock_qty'] : $product['stock_qty']));
    }

    /** Products ordered/viewed recently, in the given id order. */
    public static function byIds(array $ids, int $limit = 8): array
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
        if (!$ids) {
            return [];
        }
        $items = self::query(['ids' => $ids], 'featured', $limit)['items'];
        $pos = array_flip($ids);
        usort($items, static fn($a, $b) => ($pos[(int) $a['id']] ?? 99) <=> ($pos[(int) $b['id']] ?? 99));
        return $items;
    }

    public static function priceBounds(array $filters = []): array
    {
        $row = DB::one('SELECT MIN(' . self::EFFECTIVE_PRICE . ') AS min_p, MAX(' . self::EFFECTIVE_PRICE . ') AS max_p FROM products p WHERE p.is_active = 1');
        return [floor((float) ($row['min_p'] ?? 0)), ceil((float) ($row['max_p'] ?? 0))];
    }

    /** Recently viewed product ids from cookie. */
    public static function recentlyViewed(): array
    {
        $raw = $_COOKIE['savie_recent'] ?? '';
        if (!is_string($raw) || !preg_match('/^[\d,]{0,200}$/', $raw)) {
            return [];
        }
        return array_values(array_filter(array_map('intval', explode(',', $raw))));
    }

    public static function trackRecentlyViewed(int $productId): void
    {
        $ids = array_values(array_diff(self::recentlyViewed(), [$productId]));
        array_unshift($ids, $productId);
        $ids = array_slice($ids, 0, 12);
        setcookie('savie_recent', implode(',', $ids), [
            'expires' => time() + 60 * 86400,
            'path' => base_path() === '' ? '/' : base_path() . '/',
            'secure' => \App\Core\Http::isHttps(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
}
