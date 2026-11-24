<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\DB;
use App\Core\Uploader;
use App\Core\Validator;
use RuntimeException;

final class CollectionController extends Controller
{
    public function index(): void
    {
        $this->admin('collections/index', [
            'title' => 'Collections', 'active' => 'collections',
            'collections' => DB::all('SELECT c.*, (SELECT COUNT(*) FROM collection_products cp WHERE cp.collection_id = c.id) AS product_count FROM collections c ORDER BY c.sort_order, c.name'),
        ]);
    }

    public function create(): void
    {
        $this->form(null);
    }

    public function edit(string $id): void
    {
        $c = DB::one('SELECT * FROM collections WHERE id = :id', ['id' => (int) $id]);
        if (!$c) {
            abort(404);
        }
        $this->form($c);
    }

    private function form(?array $c): void
    {
        $selected = $c ? DB::all('SELECT product_id, sort_order FROM collection_products WHERE collection_id = :id', ['id' => $c['id']]) : [];
        $this->admin('collections/form', [
            'title' => $c ? 'Edit collection' : 'New collection', 'active' => 'collections', 'c' => $c,
            'products' => DB::all('SELECT p.id, p.name, p.sku, p.image, p.is_active, c.name AS category FROM products p LEFT JOIN categories c ON c.id = p.category_id ORDER BY c.sort_order, p.name'),
            'selected' => array_column($selected, 'sort_order', 'product_id'),
        ]);
    }

    public function save(): void
    {
        $id = input_int('id');
        $data = $_POST;
        $data['slug'] = slugify((string) (($data['slug'] ?? '') !== '' ? $data['slug'] : ($data['name'] ?? '')));
        $v = Validator::make($data, ['name' => 'required|max:120', 'slug' => 'required|slug|unique:collections,slug,' . $id, 'eyebrow' => 'nullable|max:80', 'tagline' => 'nullable|max:190', 'description' => 'nullable|max:3000']);
        $back = $id ? "/admin/collections/{$id}/edit" : '/admin/collections/create';
        if ($v->fails()) {
            with_errors($v->errors(), $_POST);
            redirect($back);
        }
        try {
            $image = Uploader::image('image', 'collections', 1400);
        } catch (RuntimeException $e) {
            with_errors(['image' => $e->getMessage()], $_POST);
            redirect($back);
        }
        $row = [
            'name' => trim((string) $data['name']), 'slug' => $data['slug'], 'eyebrow' => ($data['eyebrow'] ?? '') ?: null, 'tagline' => ($data['tagline'] ?? '') ?: null,
            'description' => ($data['description'] ?? '') ?: null, 'show_on_home' => (int) !empty($data['show_on_home']), 'is_active' => (int) !empty($data['is_active']),
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ];
        if ($image) {
            $row['image'] = $image;
        }
        $id = DB::transaction(static function () use ($id, $row) {
            if ($id) {
                DB::update('collections', $row, 'id = :id', ['id' => $id]);
            } else {
                $row['created_at'] = now();
                $id = DB::insert('collections', $row);
            }
            if ($row['show_on_home']) {
                DB::exec('UPDATE collections SET show_on_home = 0 WHERE id <> :id', ['id' => $id]);
            }
            DB::delete('collection_products', 'collection_id = :id', ['id' => $id]);
            $sorts = (array) ($_POST['product_sort'] ?? []);
            foreach (array_unique(array_map('intval', (array) ($_POST['products'] ?? []))) as $pid) {
                DB::insert('collection_products', ['collection_id' => $id, 'product_id' => $pid, 'sort_order' => (int) ($sorts[$pid] ?? 0)]);
            }
            return $id;
        });
        flash('success', 'Collection saved.');
        redirect("/admin/collections/{$id}/edit");
    }

    public function delete(string $id): void
    {
        DB::delete('collections', 'id = :id', ['id' => (int) $id]);
        flash('success', 'Collection deleted. Its products were not affected.');
        redirect('/admin/collections');
    }
}
