<?php
declare(strict_types=1);

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\Auth;
use App\Core\DB;
use App\Core\RateLimiter;
use App\Core\Settings;
use App\Core\Validator;
use App\Services\ProductService;

final class ProductController extends Controller
{
    public function show(string $slug): void
    {
        $p = ProductService::findBySlug($slug);
        if (!$p) {
            abort(404, 'This product is no longer available.');
        }
        DB::exec('UPDATE products SET view_count = view_count + 1 WHERE id = :id', ['id' => $p['id']]);

        $recentIds = array_values(array_diff(ProductService::recentlyViewed(), [(int) $p['id']]));
        ProductService::trackRecentlyViewed((int) $p['id']);

        $reviews = DB::all("SELECT * FROM reviews WHERE product_id = :id AND status = 'approved' ORDER BY created_at DESC LIMIT 50", ['id' => $p['id']]);
        $reviews = self::withPhotos($reviews);
        $dist = array_fill(1, 5, 0);
        foreach ($reviews as $r) {
            $dist[(int) $r['rating']]++;
        }
        $customer = Auth::customer();
        $myReview = $customer ? DB::one('SELECT * FROM reviews WHERE product_id = :p AND customer_id = :c', ['p' => $p['id'], 'c' => $customer['id']]) : null;
        $hasPurchased = $customer ? self::hasPurchased((int) $customer['id'], (int) $p['id']) : false;

        $related = ProductService::query(['category_id' => $p['category_id'], 'exclude_id' => $p['id']], 'bestselling', 4)['items'];
        if (count($related) < 4) {
            $ids = array_column($related, 'id');
            foreach (ProductService::list(['exclude_id' => $p['id']], 'bestselling', 8) as $extra) {
                if (count($related) >= 4) { break; }
                if (!in_array($extra['id'], $ids, true)) { $related[] = $extra; }
            }
        }
        $recent = ProductService::byIds($recentIds, 4);

        $crumbs = [['Home', url('/')], ['Shop', url('shop')]];
        if ($p['category_name']) {
            $crumbs[] = [$p['category_name'], url('category/' . $p['category_slug'])];
        }
        $crumbs[] = [$p['name'], null];

        $image = $p['image'] ? url('uploads/' . preg_replace('~\.webp$~', '-600.jpg', $p['image'])) : null;
        $offers = [];
        if ($p['variants']) {
            foreach ($p['variants'] as $v) {
                $offers[] = ['@type' => 'Offer', 'sku' => $v['sku'] ?: $p['sku'], 'name' => $v['name'], 'price' => number_format($v['final_price'], 2, '.', ''), 'priceCurrency' => Settings::get('currency_code', 'INR'),
                    'availability' => $v['available_qty'] > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock', 'url' => $p['url']];
            }
        } else {
            $offers[] = ['@type' => 'Offer', 'sku' => $p['sku'], 'price' => number_format($p['final_price'], 2, '.', ''), 'priceCurrency' => Settings::get('currency_code', 'INR'),
                'availability' => $p['in_stock'] ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock', 'url' => $p['url']];
        }
        $productSchema = [
            '@context' => 'https://schema.org', '@type' => 'Product', 'name' => $p['name'], 'sku' => $p['sku'],
            'description' => strip_tags((string) ($p['short_description'] ?: $p['description'])),
            'image' => array_map(static fn($g) => url('uploads/' . preg_replace('~\.webp$~', '-600.jpg', $g)), $p['gallery']),
            'brand' => ['@type' => 'Brand', 'name' => setting('site_name')],
            'category' => $p['category_name'],
            'offers' => count($offers) === 1 ? $offers[0] : ['@type' => 'AggregateOffer', 'lowPrice' => min(array_column($offers, 'price')), 'highPrice' => max(array_column($offers, 'price')), 'priceCurrency' => Settings::get('currency_code', 'INR'), 'offerCount' => count($offers), 'offers' => $offers],
        ];
        if ((int) $p['rating_count'] > 0) {
            $productSchema['aggregateRating'] = ['@type' => 'AggregateRating', 'ratingValue' => (float) $p['rating_avg'], 'reviewCount' => (int) $p['rating_count']];
        }

        $this->view('product', [
            'p' => $p,
            'reviews' => $reviews,
            'dist' => $dist,
            'myReview' => $myReview,
            'hasPurchased' => $hasPurchased,
            'related' => $related,
            'recent' => $recent,
            'crumbs' => $crumbs,
            'meta' => $this->meta($p['meta_title'] ?: $p['name'], $p['meta_description'] ?: str_limit($p['short_description'] ?: $p['description'], 160), [
                'canonical' => $p['url'], 'image' => $image, 'type' => 'product',
            ]),
            'schema' => [$productSchema, ShopController::breadcrumbSchema($crumbs)],
            'bodyClass' => 'page-product',
        ]);
    }

    /** Submit a review (logged-in customers, one per product). */
    public function review(string $slug): void
    {
        $p = DB::one('SELECT * FROM products WHERE slug = :s AND is_active = 1', ['s' => $slug]);
        if (!$p) {
            abort(404);
        }
        $customer = Auth::customer();
        $back = 'product/' . $p['slug'] . '#reviews';
        if (RateLimiter::tooMany('review|' . $customer['id'], 5, 60)) {
            flash('error', 'Too many reviews in a short time. Please try again later.');
            redirect($back);
        }
        $v = Validator::make($_POST, [
            'rating' => 'required|integer|between:1,5',
            'title' => 'nullable|max:120',
            'comment' => 'required|min:10|max:2000',
        ], ['comment' => 'Review']);
        if ($v->fails()) {
            with_errors($v->errors(), $_POST);
            flash('error', 'Please check your review and try again.');
            redirect($back);
        }
        if (DB::value('SELECT id FROM reviews WHERE product_id = :p AND customer_id = :c', ['p' => $p['id'], 'c' => $customer['id']])) {
            flash('info', 'You have already reviewed this product — thank you!');
            redirect($back);
        }
        // Up to 3 photos per review.
        $files = array_slice(\App\Core\Uploader::files('photos'), 0, 3);
        $photos = [];
        try {
            foreach ($files as $f) {
                $photos[] = \App\Core\Uploader::store($f, 'reviews', 1400);
            }
        } catch (\RuntimeException $e) {
            foreach ($photos as $ph) {
                \App\Core\Uploader::delete($ph);
            }
            with_errors(['photos' => $e->getMessage()], $_POST);
            flash('error', 'Photo upload failed: ' . $e->getMessage());
            redirect($back);
        }
        RateLimiter::hit('review|' . $customer['id']);
        $status = Settings::bool('review_auto_approve') ? 'approved' : 'pending';
        $reviewId = DB::insert('reviews', [
            'product_id' => $p['id'], 'customer_id' => $customer['id'], 'name' => $customer['name'],
            'rating' => (int) input('rating'), 'title' => input('title') ?: null, 'comment' => (string) input('comment'),
            'is_verified' => self::hasPurchased((int) $customer['id'], (int) $p['id']) ? 1 : 0,
            'status' => $status, 'created_at' => now(),
        ]);
        foreach ($photos as $i => $ph) {
            DB::insert('review_images', ['review_id' => $reviewId, 'image' => $ph, 'sort_order' => $i, 'created_at' => now()]);
        }
        self::refreshRating((int) $p['id']);
        flash('success', $status === 'approved' ? 'Thank you! Your review is now live.' : 'Thank you! Your review will appear once it has been approved.');
        redirect($back);
    }

    /** Attach photo paths to review rows (single query). */
    public static function withPhotos(array $reviews): array
    {
        if (!$reviews) {
            return [];
        }
        $params = [];
        $in = DB::in(array_column($reviews, 'id'), $params, 'r');
        $by = [];
        foreach (DB::all("SELECT review_id, image FROM review_images WHERE review_id IN {$in} ORDER BY sort_order, id", $params) as $row) {
            $by[(int) $row['review_id']][] = $row['image'];
        }
        foreach ($reviews as &$r) {
            $r['photos'] = $by[(int) $r['id']] ?? [];
        }
        return $reviews;
    }

    public static function refreshRating(int $productId): void
    {
        $row = DB::one("SELECT COUNT(*) AS c, COALESCE(AVG(rating),0) AS a FROM reviews WHERE product_id = :id AND status = 'approved'", ['id' => $productId]);
        DB::update('products', ['rating_count' => (int) $row['c'], 'rating_avg' => round((float) $row['a'], 2)], 'id = :id', ['id' => $productId]);
    }

    private static function hasPurchased(int $customerId, int $productId): bool
    {
        return (bool) DB::value(
            "SELECT 1 FROM order_items oi INNER JOIN orders o ON o.id = oi.order_id
             WHERE o.customer_id = :c AND oi.product_id = :p AND o.status NOT IN ('cancelled','refunded') LIMIT 1",
            ['c' => $customerId, 'p' => $productId]
        );
    }
}
