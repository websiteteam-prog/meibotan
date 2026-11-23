<?php
declare(strict_types=1);

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\DB;
use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Core\Settings;
use App\Core\Validator;
use App\Services\ProductService;

final class PageController extends Controller
{
    public function about(): void
    {
        $page = DB::one("SELECT * FROM pages WHERE slug = 'about-us' AND is_active = 1");
        $this->view('about', [
            'page' => $page,
            'benefits' => Settings::json('benefits'),
            'categories' => array_slice(\App\Services\Layout::categories(), 0, 4),
            'featured' => ProductService::list([], 'bestselling', 4),
            'meta' => $this->meta($page['meta_title'] ?? 'Our story', $page['meta_description'] ?? null, ['canonical' => url('about-us')]),
        ]);
    }

    public function show(string $slug): void
    {
        if ($slug === 'about-us') {
            redirect('/about-us', 301);
        }
        $page = DB::one('SELECT * FROM pages WHERE slug = :s AND is_active = 1', ['s' => $slug]);
        if (!$page) {
            abort(404);
        }
        $this->view('page', [
            'page' => $page,
            'meta' => $this->meta($page['meta_title'] ?: $page['title'], $page['meta_description'] ?: str_limit($page['content'], 160), ['canonical' => url('page/' . $page['slug'])]),
        ]);
    }

    public function contact(): void
    {
        $this->view('contact', [
            'meta' => $this->meta('Contact us', 'Questions about an order, a shade or a ritual? Get in touch with the Savié Amour team.', ['canonical' => url('contact')]),
        ]);
    }

    public function contactSubmit(): void
    {
        // Honeypot field: bots fill it, people never see it.
        if (trim((string) input('website', '')) !== '') {
            flash('success', 'Thank you — your message has been sent.');
            redirect('/contact');
        }
        $v = Validator::make($_POST, [
            'name' => 'required|max:120', 'email' => 'required|email|max:190', 'phone' => 'nullable|phone',
            'subject' => 'nullable|max:190', 'message' => 'required|min:10|max:3000',
        ]);
        if ($v->fails()) {
            with_errors($v->errors(), $_POST);
            redirect('/contact#contact-form');
        }
        if (RateLimiter::tooMany('contact|' . client_ip(), 5, 60)) {
            with_errors([], $_POST);
            flash('error', 'You have sent several messages recently. Please try again later or e-mail us directly.');
            redirect('/contact');
        }
        RateLimiter::hit('contact|' . client_ip());
        $data = [
            'name' => (string) input('name'), 'email' => strtolower((string) input('email')), 'phone' => input('phone') ?: null,
            'subject' => input('subject') ?: null, 'message' => (string) input('message'), 'ip_address' => client_ip(), 'created_at' => now(),
        ];
        DB::insert('contact_messages', $data);
        $to = (string) Settings::get('admin_notification_email', Settings::get('site_email', ''));
        if ($to) {
            $html = \App\Core\View::render('emails/contact-message', ['m' => $data, 'subject' => 'New message'], 'emails/layout');
            Mailer::send($to, 'New contact message from ' . $data['name'], $html, $data['email']);
        }
        flash('success', 'Thank you, ' . explode(' ', $data['name'])[0] . ' — your message has been sent. We usually reply within one business day.');
        redirect('/contact');
    }
}
