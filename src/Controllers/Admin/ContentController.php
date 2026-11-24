<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\DB;
use App\Core\HtmlSanitizer;
use App\Core\Settings;
use App\Core\Uploader;
use App\Core\Validator;
use RuntimeException;

final class ContentController extends Controller
{
    // ------------------------------------------------------------------ banners
    public function banners(): void
    {
        $this->admin('content/banners', [
            'title' => 'Banners', 'active' => 'banners',
            'banners' => DB::all("SELECT * FROM banners ORDER BY FIELD(type,'hero','promo'), sort_order, id"),
        ]);
    }

    public function saveBanner(): void
    {
        $id = input_int('id');
        $v = Validator::make($_POST, [
            'type' => 'required|in:hero,promo', 'title' => 'required|max:190', 'title_italic' => 'nullable|max:120', 'eyebrow' => 'nullable|max:80',
            'subtitle' => 'nullable|max:300', 'button_text' => 'nullable|max:60', 'button_link' => 'nullable|max:255', 'button2_text' => 'nullable|max:60',
            'button2_link' => 'nullable|max:255', 'theme' => 'required|in:noir,cotton,cherry', 'sort_order' => 'nullable|integer',
            'starts_at' => 'nullable|date', 'ends_at' => 'nullable|date',
        ]);
        if ($v->fails()) {
            with_errors($v->errors(), $_POST);
            redirect('/admin/banners');
        }
        try {
            $image = Uploader::image('image', 'banners', 1600);
        } catch (RuntimeException $e) {
            with_errors(['image' => $e->getMessage()], $_POST);
            redirect('/admin/banners');
        }
        $n = static fn($k) => trim((string) input($k, '')) === '' ? null : trim((string) input($k));
        $row = [
            'type' => input('type'), 'eyebrow' => $n('eyebrow'), 'title' => (string) input('title'), 'title_italic' => $n('title_italic'), 'subtitle' => $n('subtitle'),
            'button_text' => $n('button_text'), 'button_link' => $n('button_link'), 'button2_text' => $n('button2_text'), 'button2_link' => $n('button2_link'),
            'theme' => input('theme'), 'sort_order' => input_int('sort_order'), 'is_active' => (int) (input('is_active') === '1'),
            'starts_at' => $n('starts_at') ? date('Y-m-d H:i:s', strtotime((string) input('starts_at'))) : null,
            'ends_at' => $n('ends_at') ? date('Y-m-d H:i:s', strtotime((string) input('ends_at'))) : null,
        ];
        if ($image) {
            $row['image'] = $image;
        }
        if ($id) {
            DB::update('banners', $row, 'id = :id', ['id' => $id]);
        } else {
            $row['created_at'] = now();
            DB::insert('banners', $row);
        }
        flash('success', 'Banner saved.');
        redirect('/admin/banners');
    }

    public function deleteBanner(string $id): void
    {
        DB::delete('banners', 'id = :id', ['id' => (int) $id]);
        flash('success', 'Banner deleted.');
        redirect('/admin/banners');
    }

    // ------------------------------------------------------------------ testimonials
    public function testimonials(): void
    {
        $this->admin('content/testimonials', ['title' => 'Testimonials', 'active' => 'testimonials', 'items' => DB::all('SELECT * FROM testimonials ORDER BY sort_order, id DESC')]);
    }

    public function saveTestimonial(): void
    {
        $id = input_int('id');
        $v = Validator::make($_POST, ['name' => 'required|max:120', 'location' => 'nullable|max:120', 'rating' => 'required|integer|between:1,5', 'content' => 'required|max:1000', 'product_name' => 'nullable|max:190']);
        if ($v->fails()) {
            with_errors($v->errors(), $_POST);
            redirect('/admin/testimonials');
        }
        try {
            $avatar = Uploader::image('avatar', 'testimonials', 300);
        } catch (RuntimeException $e) {
            with_errors(['avatar' => $e->getMessage()], $_POST);
            redirect('/admin/testimonials');
        }
        $row = ['name' => input('name'), 'location' => input('location') ?: null, 'rating' => input_int('rating', 5), 'content' => input('content'),
            'product_name' => input('product_name') ?: null, 'sort_order' => input_int('sort_order'), 'is_active' => (int) (input('is_active') === '1')];
        if ($avatar) {
            $row['avatar'] = $avatar;
        }
        if ($id) {
            DB::update('testimonials', $row, 'id = :id', ['id' => $id]);
        } else {
            $row['created_at'] = now();
            DB::insert('testimonials', $row);
        }
        flash('success', 'Testimonial saved.');
        redirect('/admin/testimonials');
    }

    public function deleteTestimonial(string $id): void
    {
        DB::delete('testimonials', 'id = :id', ['id' => (int) $id]);
        flash('success', 'Testimonial deleted.');
        redirect('/admin/testimonials');
    }

    // ------------------------------------------------------------------ instagram / social gallery
    public function social(): void
    {
        $this->admin('content/social', ['title' => 'Instagram gallery', 'active' => 'social', 'items' => DB::all('SELECT * FROM social_posts ORDER BY sort_order, id DESC')]);
    }

    public function saveSocial(): void
    {
        $id = input_int('id');
        $link = trim((string) input('link', ''));
        if ($link !== '' && !filter_var($link, FILTER_VALIDATE_URL)) {
            with_errors(['link' => 'Please enter a full URL (https://…).'], $_POST);
            redirect('/admin/social');
        }
        try {
            $image = Uploader::image('image', 'social', 900);
        } catch (RuntimeException $e) {
            with_errors(['image' => $e->getMessage()], $_POST);
            redirect('/admin/social');
        }
        if (!$id && !$image) {
            with_errors(['image' => 'Please choose an image.'], $_POST);
            redirect('/admin/social');
        }
        $row = ['link' => $link ?: null, 'caption' => mb_substr((string) input('caption', ''), 0, 190) ?: null, 'sort_order' => input_int('sort_order'), 'is_active' => (int) (input('is_active') === '1')];
        if ($image) {
            $row['image'] = $image;
        }
        if ($id) {
            DB::update('social_posts', $row, 'id = :id', ['id' => $id]);
        } else {
            $row['created_at'] = now();
            DB::insert('social_posts', $row);
        }
        flash('success', 'Gallery post saved.');
        redirect('/admin/social');
    }

    public function deleteSocial(string $id): void
    {
        DB::delete('social_posts', 'id = :id', ['id' => (int) $id]);
        flash('success', 'Gallery post deleted.');
        redirect('/admin/social');
    }

    // ------------------------------------------------------------------ homepage sections
    public function homepage(): void
    {
        $sections = DB::all('SELECT * FROM home_sections ORDER BY sort_order');
        foreach ($sections as &$s) {
            $s['settings'] = json_decode((string) $s['settings'], true) ?: [];
        }
        $this->admin('content/homepage', [
            'title' => 'Homepage', 'active' => 'homepage', 'sections' => $sections, 'benefits' => Settings::json('benefits'),
        ]);
    }

    public function saveHomepage(): void
    {
        foreach ((array) ($_POST['sections'] ?? []) as $id => $s) {
            $current = DB::one('SELECT * FROM home_sections WHERE id = :id', ['id' => (int) $id]);
            if (!$current) {
                continue;
            }
            $settings = json_decode((string) $current['settings'], true) ?: [];
            if (isset($s['limit'])) {
                $settings['limit'] = max(1, min(24, (int) $s['limit']));
            }
            if (isset($s['items'])) {
                $settings['items'] = array_values(array_filter(array_map('trim', preg_split('/\R/', (string) $s['items']))));
            }
            DB::update('home_sections', [
                'eyebrow' => mb_substr(trim((string) ($s['eyebrow'] ?? '')), 0, 80) ?: null,
                'title' => mb_substr(trim((string) ($s['title'] ?? '')), 0, 190) ?: null,
                'title_italic' => mb_substr(trim((string) ($s['title_italic'] ?? '')), 0, 120) ?: null,
                'subtitle' => mb_substr(trim((string) ($s['subtitle'] ?? '')), 0, 300) ?: null,
                'is_visible' => (int) !empty($s['is_visible']),
                'sort_order' => (int) ($s['sort_order'] ?? 0),
                'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
            ], 'id = :id', ['id' => (int) $id]);
        }
        $benefits = [];
        foreach ((array) ($_POST['benefits'] ?? []) as $b) {
            if (trim((string) ($b['title'] ?? '')) === '') {
                continue;
            }
            $benefits[] = ['icon' => preg_replace('/[^a-z-]/', '', (string) ($b['icon'] ?? 'sparkle')), 'title' => mb_substr(trim((string) $b['title']), 0, 80), 'text' => mb_substr(trim((string) ($b['text'] ?? '')), 0, 200)];
        }
        Settings::set('benefits', $benefits, 'home');
        flash('success', 'Homepage updated — changes are live.');
        redirect('/admin/homepage');
    }

    // ------------------------------------------------------------------ pages
    public function pages(): void
    {
        $this->admin('content/pages', ['title' => 'Pages', 'active' => 'pages', 'pages' => DB::all('SELECT * FROM pages ORDER BY id')]);
    }

    public function createPage(): void
    {
        $this->admin('content/page-form', ['title' => 'New page', 'active' => 'pages', 'page' => null]);
    }

    public function editPage(string $id): void
    {
        $page = DB::one('SELECT * FROM pages WHERE id = :id', ['id' => (int) $id]);
        if (!$page) {
            abort(404);
        }
        $this->admin('content/page-form', ['title' => 'Edit page', 'active' => 'pages', 'page' => $page]);
    }

    public function savePage(): void
    {
        $id = input_int('id');
        $data = $_POST;
        $data['slug'] = slugify((string) (($data['slug'] ?? '') !== '' ? $data['slug'] : ($data['title'] ?? '')));
        $v = Validator::make($data, ['title' => 'required|max:190', 'slug' => 'required|slug|unique:pages,slug,' . $id, 'meta_title' => 'nullable|max:190', 'meta_description' => 'nullable|max:300']);
        $back = $id ? "/admin/pages/{$id}/edit" : '/admin/pages/create';
        if ($v->fails()) {
            with_errors($v->errors(), $_POST);
            redirect($back);
        }
        $row = ['title' => trim((string) $data['title']), 'slug' => $data['slug'], 'content' => HtmlSanitizer::clean((string) ($data['content'] ?? '')),
            'meta_title' => ($data['meta_title'] ?? '') ?: null, 'meta_description' => ($data['meta_description'] ?? '') ?: null,
            'show_in_footer' => (int) !empty($data['show_in_footer']), 'is_active' => (int) !empty($data['is_active'])];
        if ($id) {
            DB::update('pages', $row, 'id = :id', ['id' => $id]);
        } else {
            $row['created_at'] = now();
            $id = DB::insert('pages', $row);
        }
        flash('success', 'Page “' . $row['title'] . '” saved.');
        redirect("/admin/pages/{$id}/edit");
    }

    public function deletePage(string $id): void
    {
        $p = DB::one('SELECT slug FROM pages WHERE id = :id', ['id' => (int) $id]);
        if ($p && $p['slug'] === 'about-us') {
            flash('error', 'The About Us page is used by the “Our story” page — edit it instead of deleting it.');
            redirect('/admin/pages');
        }
        DB::delete('pages', 'id = :id', ['id' => (int) $id]);
        flash('success', 'Page deleted.');
        redirect('/admin/pages');
    }
}
