<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Controllers\Front\ProductController as FrontProduct;
use App\Core\DB;
use App\Core\Paginator;

final class ReviewController extends Controller
{
    public function index(): void
    {
        $status = (string) input('status', 'pending');
        $where = in_array($status, ['pending', 'approved', 'rejected'], true) ? 'r.status = :s' : '1=1';
        $params = $where === '1=1' ? [] : ['s' => $status];
        $total = (int) DB::value("SELECT COUNT(*) FROM reviews r WHERE {$where}", $params);
        $pager = new Paginator($total, 20);
        $this->admin('reviews', [
            'title' => 'Reviews', 'active' => 'reviews', 'status' => $status, 'pager' => $pager,
            'counts' => array_column(DB::all('SELECT status, COUNT(*) c FROM reviews GROUP BY status'), 'c', 'status'),
            'reviews' => FrontProduct::withPhotos(DB::all("SELECT r.*, p.name AS product_name, p.slug, p.image FROM reviews r INNER JOIN products p ON p.id = r.product_id WHERE {$where} ORDER BY r.created_at DESC LIMIT :l OFFSET :o", $params + ['l' => $pager->perPage, 'o' => $pager->offset])),
        ]);
    }

    public function status(string $id): void
    {
        $status = (string) input('status');
        $r = DB::one('SELECT * FROM reviews WHERE id = :id', ['id' => (int) $id]);
        if ($r && in_array($status, ['approved', 'rejected', 'pending'], true)) {
            DB::update('reviews', ['status' => $status], 'id = :id', ['id' => $r['id']]);
            FrontProduct::refreshRating((int) $r['product_id']);
            flash('success', 'Review ' . $status . '.');
        }
        back('/admin/reviews');
    }

    public function delete(string $id): void
    {
        $r = DB::one('SELECT * FROM reviews WHERE id = :id', ['id' => (int) $id]);
        if ($r) {
            foreach (DB::column('SELECT image FROM review_images WHERE review_id = :id', ['id' => $r['id']]) as $img) {
                \App\Core\Uploader::delete($img);
            }
            DB::delete('reviews', 'id = :id', ['id' => $r['id']]);
            FrontProduct::refreshRating((int) $r['product_id']);
            flash('success', 'Review deleted.');
        }
        back('/admin/reviews');
    }
}
