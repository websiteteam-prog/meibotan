<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\DB;
use App\Core\HtmlSanitizer;
use App\Core\Paginator;
use App\Core\Settings;
use App\Core\Uploader;
use App\Core\Validator;
use RuntimeException;

final class ProductController extends Controller
{
    public function index(): void
    {
        $where = ['1=1'];
        $params = [];
        $q = trim((string) input('q', ''));
        if ($q !== '') {
            $where[] = '(p.name LIKE :q1 OR p.sku LIKE :q2 OR EXISTS (SELECT 1 FROM product_variants v WHERE v.product_id = p.id AND v.sku LIKE :q3))';
            $like = '%' . addcslashes($q, '%_\\') . '%';
            $params += ['q1' => $like, 'q2' => $like, 'q3' => $like];
        }
        if ($cat = input_int('category')) {
            $where[] = 'p.category_id = :cat';
            $params['cat'] = $cat;
        }
        $status = (string) input('status', '');
        if ($status === 'active' || $status === 'inactive') {
            $where[] = 'p.is_active = ' . ($status === 'active' ? 1 : 0);
        }
        $threshold = (int) Settings::get('low_stock_threshold', 5);
        $stockExpr = '(CASE WHEN EXISTS (SELECT 1 FROM product_variants v WHERE v.product_id = p.id AND v.is_active = 1) THEN (SELECT COALESCE(SUM(v.stock_qty),0) FROM product_variants v WHERE v.product_id = p.id AND v.is_active = 1) ELSE p.stock_qty END)';
        $stock = (string) input('stock', '');
        if ($stock === 'low') {
            $where[] = "{$stockExpr} <= :th";
            $params['th'] = $threshold;
        } elseif ($stock === 'out') {
            $where[] = "({$stockExpr} <= 0 OR p.stock_status = 'out_of_stock')";
        }
        $flag = (string) input('flag', '');
        if (in_array($flag, ['featured', 'bestseller', 'new'], true)) {
            $where[] = 'p.is_' . $flag . ' = 1';
        }
        $sort = match ((string) input('sort', '')) {
            'name' => 'p.name ASC', 'price' => 'p.price ASC', 'stock' => 'stock ASC', 'sold' => 'p.sold_count DESC', default => 'p.created_at DESC',
        };
        $whereSql = implode(' AND ', $where);
        $total = (int) DB::value("SELECT COUNT(*) FROM products p WHERE {$whereSql}", $params);
        $pager = new Paginator($total, 20);
        $products = DB::all(
            "SELECT p.*, c.name AS category_name, s.name AS subcategory_name, {$stockExpr} AS stock,
                    (SELECT COUNT(*) FROM product_variants v WHERE v.product_id = p.id) AS variant_count
             FROM products p LEFT JOIN categories c ON c.id = p.category_id LEFT JOIN subcategories s ON s.id = p.subcategory_id
             WHERE {$whereSql} ORDER BY {$sort} LIMIT :lim OFFSET :off",
            $params + ['lim' => $pager->perPage, 'off' => $pager->offset]
        );
        $this->admin('products/index', [
            'title' => 'Products', 'active' => 'products', 'products' => $products, 'pager' => $pager,
            'categories' => DB::all('SELECT id, name FROM categories ORDER BY sort_order, name'), 'threshold' => $threshold,
        ]);
    }

    public function create(): void
    {
        $this->form(null);
    }

    public function edit(string $id): void
    {
        $p = DB::one('SELECT * FROM products WHERE id = :id', ['id' => (int) $id]);
        if (!$p) {
            abort(404);
        }
        $this->form($p);
    }

    private function form(?array $p): void
    {
        $this->admin('products/form', [
            'title' => $p ? 'Edit ' . $p['name'] : 'Add product',
            'active' => 'products',
            'p' => $p,
            'categories' => DB::all('SELECT id, name FROM categories ORDER BY sort_order, name'),
            'subcategories' => DB::all('SELECT id, category_id, name FROM subcategories ORDER BY sort_order, name'),
            'collections' => DB::all('SELECT id, name FROM collections ORDER BY sort_order, name'),
            'selectedCollections' => $p ? array_map('intval', DB::column('SELECT collection_id FROM collection_products WHERE product_id = :id', ['id' => $p['id']])) : [],
            'images' => $p ? DB::all('SELECT * FROM product_images WHERE product_id = :id ORDER BY sort_order, id', ['id' => $p['id']]) : [],
            'variants' => $p ? DB::all('SELECT * FROM product_variants WHERE product_id = :id ORDER BY sort_order, id', ['id' => $p['id']]) : [],
            'specs' => $p ? (json_decode((string) $p['specifications'], true) ?: []) : [],
        ]);
    }

    public function save(): void
    {
        $id = input_int('id');
        $existing = $id ? DB::one('SELECT * FROM products WHERE id = :id', ['id' => $id]) : null;
        if ($id && !$existing) {
            abort(404);
        }
        $back = $id ? "/admin/products/{$id}/edit" : '/admin/products/create';
        $data = $_POST;
        $data['slug'] = slugify((string) (($data['slug'] ?? '') !== '' ? $data['slug'] : ($data['name'] ?? '')));
        $data['sku'] = strtoupper(trim((string) ($data['sku'] ?? '')));

        $v = Validator::make($data, [
            'name' => 'required|max:190',
            'slug' => 'required|slug|max:210|unique:products,slug,' . $id,
            'sku' => 'required|max:64|unique:products,sku,' . $id,
            'category_id' => 'required|integer',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_qty' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock',
            'badge' => 'nullable|max:40',
            'variant_label' => 'nullable|max:40',
            'meta_title' => 'nullable|max:190',
            'meta_description' => 'nullable|max:300',
            'short_description' => 'nullable|max:600',
        ], ['category_id' => 'Category', 'stock_qty' => 'Stock quantity', 'sku' => 'SKU']);
        $errors = $v->errors();
        if (($data['sale_price'] ?? '') !== '' && is_numeric($data['sale_price']) && (float) $data['sale_price'] >= (float) ($data['price'] ?? 0)) {
            $errors['sale_price'] = 'Sale price must be lower than the regular price.';
        }
        $catId = (int) ($data['category_id'] ?? 0);
        if ($catId && !DB::value('SELECT id FROM categories WHERE id = :id', ['id' => $catId])) {
            $errors['category_id'] = 'Please choose a valid category.';
        }
        $subId = (int) ($data['subcategory_id'] ?? 0) ?: null;
        if ($subId && !DB::value('SELECT id FROM subcategories WHERE id = :id AND category_id = :c', ['id' => $subId, 'c' => $catId])) {
            $errors['subcategory_id'] = 'The subcategory does not belong to the selected category.';
        }
        // Variant validation
        $variants = [];
        foreach ((array) ($_POST['variants'] ?? []) as $key => $row) {
            if (!is_array($row) || trim((string) ($row['name'] ?? '')) === '') {
                continue;
            }
            $vPrice = ($row['price'] ?? '') === '' ? null : (float) $row['price'];
            $vSale = ($row['sale_price'] ?? '') === '' ? null : (float) $row['sale_price'];
            if ($vSale !== null && $vSale >= ($vPrice ?? (float) ($data['price'] ?? 0))) {
                $errors['variants'] = 'Variant “' . $row['name'] . '”: sale price must be lower than its price.';
            }
            $variants[$key] = [
                'id' => (int) ($row['id'] ?? 0), 'name' => mb_substr(trim((string) $row['name']), 0, 100),
                'swatch' => preg_match('/^#[0-9a-fA-F]{6}$/', (string) ($row['swatch'] ?? '')) && !empty($row['use_swatch']) ? $row['swatch'] : null,
                'sku' => ($row['sku'] ?? '') !== '' ? strtoupper(mb_substr(trim((string) $row['sku']), 0, 64)) : null,
                'price' => $vPrice, 'sale_price' => $vSale, 'stock_qty' => max(0, (int) ($row['stock_qty'] ?? 0)),
                'is_active' => !empty($row['is_active']) ? 1 : 0, 'sort_order' => (int) ($row['sort_order'] ?? 0),
                'remove_image' => !empty($row['remove_image']),
            ];
        }
        if ($errors) {
            with_errors($errors, $_POST);
            redirect($back);
        }

        // Uploads first (outside the transaction).
        try {
            $image = Uploader::image('image', 'products');
            $hover = Uploader::image('hover_image', 'products');
            $gallery = Uploader::images('gallery', 'products');
            $variantImages = [];
            if (!empty($_FILES['variant_images']['name']) && is_array($_FILES['variant_images']['name'])) {
                foreach ($_FILES['variant_images']['name'] as $key => $n) {
                    if (($_FILES['variant_images']['error'][$key] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                        continue;
                    }
                    $variantImages[$key] = Uploader::store([
                        'name' => $n, 'type' => $_FILES['variant_images']['type'][$key], 'tmp_name' => $_FILES['variant_images']['tmp_name'][$key],
                        'error' => $_FILES['variant_images']['error'][$key], 'size' => $_FILES['variant_images']['size'][$key],
                    ], 'variants', 1200);
                }
            }
        } catch (RuntimeException $e) {
            with_errors(['image' => $e->getMessage()], $_POST);
            redirect($back);
        }

        $specs = [];
        foreach ((array) ($_POST['specs'] ?? []) as $row) {
            $label = trim((string) ($row['label'] ?? ''));
            $value = trim((string) ($row['value'] ?? ''));
            if ($label !== '' && $value !== '') {
                $specs[] = ['label' => mb_substr($label, 0, 80), 'value' => mb_substr($value, 0, 300)];
            }
        }

        $row = [
            'category_id' => $catId, 'subcategory_id' => $subId, 'name' => trim((string) $data['name']), 'slug' => $data['slug'], 'sku' => $data['sku'],
            'short_description' => trim((string) ($data['short_description'] ?? '')) ?: null,
            'description' => HtmlSanitizer::clean((string) ($data['description'] ?? '')) ?: null,
            'specifications' => json_encode($specs, JSON_UNESCAPED_UNICODE),
            'additional_info' => HtmlSanitizer::clean((string) ($data['additional_info'] ?? '')) ?: null,
            'price' => round((float) $data['price'], 2),
            'sale_price' => ($data['sale_price'] ?? '') === '' ? null : round((float) $data['sale_price'], 2),
            'stock_qty' => (int) $data['stock_qty'], 'stock_status' => $data['stock_status'],
            'variant_label' => trim((string) ($data['variant_label'] ?? '')) ?: ($variants ? 'Shade' : null),
            'badge' => trim((string) ($data['badge'] ?? '')) ?: null,
            'is_featured' => (int) !empty($data['is_featured']), 'is_bestseller' => (int) !empty($data['is_bestseller']),
            'is_new' => (int) !empty($data['is_new']), 'is_active' => (int) !empty($data['is_active']),
            'meta_title' => trim((string) ($data['meta_title'] ?? '')) ?: null,
            'meta_description' => trim((string) ($data['meta_description'] ?? '')) ?: null,
        ];
        if ($image) {
            $row['image'] = $image;
        }
        if ($hover) {
            $row['hover_image'] = $hover;
        } elseif (!empty($data['remove_hover_image'])) {
            $row['hover_image'] = null;
        }

        $id = DB::transaction(function () use ($id, $existing, $row, $gallery, $variants, $variantImages) {
            if ($existing) {
                DB::update('products', $row, 'id = :id', ['id' => $id]);
                if (isset($row['image']) && $existing['image'] !== $row['image']) {
                    self::discard($existing['image']);
                }
                if (array_key_exists('hover_image', $row) && $existing['hover_image'] !== $row['hover_image']) {
                    self::discard($existing['hover_image']);
                }
            } else {
                $row['created_at'] = now();
                $id = DB::insert('products', $row);
            }
            // Gallery: sort order, deletions, new uploads.
            foreach ((array) ($_POST['gallery_sort'] ?? []) as $imgId => $sort) {
                DB::update('product_images', ['sort_order' => (int) $sort], 'id = :i AND product_id = :p', ['i' => (int) $imgId, 'p' => $id]);
            }
            foreach ((array) ($_POST['gallery_delete'] ?? []) as $imgId => $on) {
                $img = DB::one('SELECT * FROM product_images WHERE id = :i AND product_id = :p', ['i' => (int) $imgId, 'p' => $id]);
                if ($img) {
                    DB::delete('product_images', 'id = :i', ['i' => $img['id']]);
                    self::discard($img['image']);
                }
            }
            $next = (int) DB::value('SELECT COALESCE(MAX(sort_order),0) FROM product_images WHERE product_id = :p', ['p' => $id]);
            foreach ($gallery as $path) {
                DB::insert('product_images', ['product_id' => $id, 'image' => $path, 'alt' => $row['name'], 'sort_order' => ++$next, 'created_at' => now()]);
            }
            // Variants: upsert submitted rows, delete the rest.
            $keep = [];
            foreach ($variants as $key => $v) {
                $vRow = $v;
                unset($vRow['id'], $vRow['remove_image']);
                if (isset($variantImages[$key])) {
                    $vRow['image'] = $variantImages[$key];
                } elseif ($v['remove_image']) {
                    $vRow['image'] = null;
                }
                if ($v['id'] && DB::value('SELECT id FROM product_variants WHERE id = :v AND product_id = :p', ['v' => $v['id'], 'p' => $id])) {
                    DB::update('product_variants', $vRow, 'id = :v', ['v' => $v['id']]);
                    $keep[] = $v['id'];
                } else {
                    $vRow['product_id'] = $id;
                    $vRow['created_at'] = now();
                    $keep[] = DB::insert('product_variants', $vRow);
                }
            }
            $params = ['p' => $id];
            DB::exec('DELETE FROM product_variants WHERE product_id = :p' . ($keep ? ' AND id NOT IN ' . DB::in($keep, $params, 'k') : ''), $params);
            // Collections
            $cols = array_map('intval', (array) ($_POST['collections'] ?? []));
            DB::delete('collection_products', 'product_id = :p', ['p' => $id]);
            foreach (array_unique($cols) as $c) {
                if (DB::value('SELECT id FROM collections WHERE id = :c', ['c' => $c])) {
                    DB::insert('collection_products', ['collection_id' => $c, 'product_id' => $id, 'sort_order' => 99]);
                }
            }
            return $id;
        });

        flash('success', 'Product “' . $row['name'] . '” saved.');
        redirect(input('save_and') === 'new' ? '/admin/products/create' : "/admin/products/{$id}/edit");
    }

    public function delete(string $id): void
    {
        $p = DB::one('SELECT * FROM products WHERE id = :id', ['id' => (int) $id]);
        if ($p) {
            $images = DB::column('SELECT image FROM product_images WHERE product_id = :id', ['id' => $p['id']]);
            DB::delete('products', 'id = :id', ['id' => $p['id']]);
            foreach (array_merge([$p['image'], $p['hover_image']], $images) as $img) {
                self::discard($img);
            }
            flash('success', 'Product “' . $p['name'] . '” deleted. Past orders keep their item details.');
        }
        redirect('/admin/products');
    }

    public function toggle(string $id): void
    {
        DB::exec('UPDATE products SET is_active = 1 - is_active WHERE id = :id', ['id' => (int) $id]);
        flash('success', 'Product visibility updated.');
        back('/admin/products');
    }

    public function duplicate(string $id): void
    {
        $p = DB::one('SELECT * FROM products WHERE id = :id', ['id' => (int) $id]);
        if (!$p) {
            abort(404);
        }
        $newId = DB::transaction(static function () use ($p) {
            $copy = $p;
            unset($copy['id'], $copy['updated_at']);
            $suffix = '-copy-' . substr(bin2hex(random_bytes(2)), 0, 4);
            $copy['name'] .= ' (copy)';
            $copy['slug'] .= $suffix;
            $copy['sku'] .= strtoupper($suffix);
            $copy['is_active'] = 0;
            $copy['sold_count'] = 0;
            $copy['view_count'] = 0;
            $copy['rating_avg'] = 0;
            $copy['rating_count'] = 0;
            $copy['created_at'] = now();
            $newId = DB::insert('products', $copy);
            DB::exec('INSERT INTO product_images (product_id, image, alt, sort_order, created_at) SELECT :n, image, alt, sort_order, NOW() FROM product_images WHERE product_id = :o', ['n' => $newId, 'o' => $p['id']]);
            DB::exec('INSERT INTO product_variants (product_id, name, swatch, sku, price, sale_price, stock_qty, image, sort_order, is_active, created_at) SELECT :n, name, swatch, NULL, price, sale_price, stock_qty, image, sort_order, is_active, NOW() FROM product_variants WHERE product_id = :o', ['n' => $newId, 'o' => $p['id']]);
            DB::exec('INSERT INTO collection_products (collection_id, product_id, sort_order) SELECT collection_id, :n, sort_order FROM collection_products WHERE product_id = :o', ['n' => $newId, 'o' => $p['id']]);
            return $newId;
        });
        flash('success', 'Product duplicated as a hidden draft — review and activate it when ready.');
        redirect("/admin/products/{$newId}/edit");
    }

    public function bulk(): void
    {
        $ids = array_values(array_filter(array_map('intval', (array) ($_POST['ids'] ?? []))));
        $action = (string) input('action', '');
        if (!$ids) {
            flash('error', 'Select at least one product.');
            back('/admin/products');
        }
        $params = [];
        $in = DB::in($ids, $params, 'id');
        $sql = match ($action) {
            'activate' => "UPDATE products SET is_active = 1 WHERE id IN {$in}",
            'deactivate' => "UPDATE products SET is_active = 0 WHERE id IN {$in}",
            'feature' => "UPDATE products SET is_featured = 1 WHERE id IN {$in}",
            'unfeature' => "UPDATE products SET is_featured = 0 WHERE id IN {$in}",
            'bestseller' => "UPDATE products SET is_bestseller = 1 WHERE id IN {$in}",
            'out_of_stock' => "UPDATE products SET stock_status = 'out_of_stock' WHERE id IN {$in}",
            'in_stock' => "UPDATE products SET stock_status = 'in_stock' WHERE id IN {$in}",
            'delete' => "DELETE FROM products WHERE id IN {$in}",
            default => null,
        };
        if (!$sql) {
            flash('error', 'Choose a bulk action.');
            back('/admin/products');
        }
        $n = DB::exec($sql, $params);
        flash('success', plural($n, 'product') . ' updated.');
        back('/admin/products');
    }

    /** Remove an uploaded file unless it is bundled demo content or still referenced. */
    public static function discard(?string $path): void
    {
        if (!$path || str_contains($path, '/demo-')) {
            return;
        }
        $refs = (int) DB::value(
            'SELECT (SELECT COUNT(*) FROM products WHERE image = :a OR hover_image = :b) + (SELECT COUNT(*) FROM product_images WHERE image = :c) + (SELECT COUNT(*) FROM product_variants WHERE image = :d)',
            ['a' => $path, 'b' => $path, 'c' => $path, 'd' => $path]
        );
        if ($refs === 0) {
            Uploader::delete($path);
        }
    }
}
