<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\DB;
use App\Core\Uploader;
use App\Core\Validator;
use RuntimeException;

final class CategoryController extends Controller
{
    public function index(): void
    {
        $cats = DB::all('SELECT c.*, (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) AS product_count FROM categories c ORDER BY c.sort_order, c.name');
        $subs = DB::all('SELECT s.*, (SELECT COUNT(*) FROM products p WHERE p.subcategory_id = s.id) AS product_count FROM subcategories s ORDER BY s.sort_order, s.name');
        foreach ($cats as &$c) {
            $c['subs'] = array_values(array_filter($subs, static fn($s) => (int) $s['category_id'] === (int) $c['id']));
        }
        $this->admin('categories', ['title' => 'Categories', 'active' => 'categories', 'categories' => $cats]);
    }

    public function save(): void
    {
        $id = input_int('id');
        $data = $_POST;
        $data['slug'] = slugify((string) (($data['slug'] ?? '') !== '' ? $data['slug'] : ($data['name'] ?? '')));
        $v = Validator::make($data, [
            'name' => 'required|max:120', 'slug' => 'required|slug|max:140|unique:categories,slug,' . $id,
            'tagline' => 'nullable|max:190', 'description' => 'nullable|max:2000', 'sort_order' => 'nullable|integer',
            'meta_title' => 'nullable|max:190', 'meta_description' => 'nullable|max:300',
        ]);
        if ($v->fails()) {
            with_errors($v->errors(), $_POST);
            redirect('/admin/categories');
        }
        try {
            $image = Uploader::image('image', 'categories', 1200);
        } catch (RuntimeException $e) {
            with_errors(['image' => $e->getMessage()], $_POST);
            redirect('/admin/categories');
        }
        $row = [
            'name' => trim((string) $data['name']), 'slug' => $data['slug'], 'tagline' => trim((string) ($data['tagline'] ?? '')) ?: null,
            'description' => trim((string) ($data['description'] ?? '')) ?: null, 'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (int) !empty($data['is_active']), 'is_featured' => (int) !empty($data['is_featured']),
            'meta_title' => trim((string) ($data['meta_title'] ?? '')) ?: null, 'meta_description' => trim((string) ($data['meta_description'] ?? '')) ?: null,
        ];
        if ($image) {
            $row['image'] = $image;
        }
        if ($id) {
            DB::update('categories', $row, 'id = :id', ['id' => $id]);
        } else {
            $row['created_at'] = now();
            DB::insert('categories', $row);
        }
        flash('success', 'Category “' . $row['name'] . '” saved.');
        redirect('/admin/categories');
    }

    public function delete(string $id): void
    {
        $c = DB::one('SELECT * FROM categories WHERE id = :id', ['id' => (int) $id]);
        if ($c) {
            $count = (int) DB::value('SELECT COUNT(*) FROM products WHERE category_id = :id', ['id' => $c['id']]);
            if ($count > 0) {
                flash('error', "“{$c['name']}” still has {$count} product(s). Move or delete them first, or hide the category instead.");
                redirect('/admin/categories');
            }
            DB::delete('categories', 'id = :id', ['id' => $c['id']]);
            flash('success', 'Category deleted.');
        }
        redirect('/admin/categories');
    }

    public function toggle(string $id): void
    {
        DB::exec('UPDATE categories SET is_active = 1 - is_active WHERE id = :id', ['id' => (int) $id]);
        flash('success', 'Category visibility updated.');
        redirect('/admin/categories');
    }

    public function reorder(): void
    {
        foreach ((array) ($_POST['order'] ?? []) as $id => $sort) {
            DB::update('categories', ['sort_order' => (int) $sort], 'id = :id', ['id' => (int) $id]);
        }
        foreach ((array) ($_POST['sub_order'] ?? []) as $id => $sort) {
            DB::update('subcategories', ['sort_order' => (int) $sort], 'id = :id', ['id' => (int) $id]);
        }
        flash('success', 'Display order saved.');
        redirect('/admin/categories');
    }

    public function saveSub(): void
    {
        $id = input_int('id');
        $catId = input_int('category_id');
        $slug = slugify((string) (input('slug') ?: input('name', '')));
        $v = Validator::make($_POST, ['name' => 'required|max:120', 'category_id' => 'required|integer', 'description' => 'nullable|max:2000']);
        $errors = $v->errors();
        if (!DB::value('SELECT id FROM categories WHERE id = :id', ['id' => $catId])) {
            $errors['category_id'] = 'Choose a parent category.';
        }
        if (DB::value('SELECT id FROM subcategories WHERE category_id = :c AND slug = :s AND id <> :id', ['c' => $catId, 's' => $slug, 'id' => $id])) {
            $errors['slug'] = 'Another subcategory in this category already uses that slug.';
        }
        if ($errors) {
            with_errors($errors, $_POST);
            redirect('/admin/categories');
        }
        $row = ['category_id' => $catId, 'name' => trim((string) input('name')), 'slug' => $slug, 'description' => input('description') ?: null,
            'sort_order' => input_int('sort_order'), 'is_active' => (int) (input('is_active') === '1')];
        if ($id) {
            DB::update('subcategories', $row, 'id = :id', ['id' => $id]);
        } else {
            $row['created_at'] = now();
            DB::insert('subcategories', $row);
        }
        flash('success', 'Subcategory “' . $row['name'] . '” saved.');
        redirect('/admin/categories');
    }

    public function deleteSub(string $id): void
    {
        DB::delete('subcategories', 'id = :id', ['id' => (int) $id]);
        flash('success', 'Subcategory deleted. Its products remain in the parent category.');
        redirect('/admin/categories');
    }

    public function toggleSub(string $id): void
    {
        DB::exec('UPDATE subcategories SET is_active = 1 - is_active WHERE id = :id', ['id' => (int) $id]);
        redirect('/admin/categories');
    }
}
