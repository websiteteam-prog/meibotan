<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\AdminAuth;
use App\Core\Mailer;
use App\Core\Settings;
use App\Core\Uploader;
use RuntimeException;

final class SettingsController extends Controller
{
    /** tab => [key => type]. Types: text, textarea, email, url, number, bool, secret, image, select:<a,b> */
    public const SCHEMA = [
        'general' => [
            'site_name' => 'text', 'site_tagline' => 'text', 'site_email' => 'email', 'site_phone' => 'text', 'whatsapp_number' => 'text',
            'site_address' => 'textarea', 'business_hours' => 'text', 'announcement_messages' => 'textarea', 'footer_about' => 'textarea', 'copyright_text' => 'text',
        ],
        'branding' => ['logo' => 'image', 'logo_light' => 'image', 'favicon' => 'image', 'og_image' => 'image'],
        'social' => ['instagram_url' => 'url', 'instagram_handle' => 'text', 'facebook_url' => 'url', 'youtube_url' => 'url', 'pinterest_url' => 'url', 'x_url' => 'url'],
        'store' => ['currency_code' => 'text', 'currency_symbol' => 'text', 'products_per_page' => 'number', 'low_stock_threshold' => 'number', 'order_prefix' => 'text', 'guest_checkout' => 'bool', 'review_auto_approve' => 'bool'],
        'shipping' => ['shipping_enabled' => 'bool', 'shipping_flat_rate' => 'number', 'free_shipping_threshold' => 'number', 'cod_enabled' => 'bool', 'cod_fee' => 'number', 'delivery_estimate' => 'text', 'shipping_countries' => 'text'],
        'tax' => ['tax_enabled' => 'bool', 'tax_label' => 'text', 'tax_rate' => 'number', 'prices_include_tax' => 'bool', 'gstin' => 'text'],
        'payment' => ['razorpay_enabled' => 'bool', 'razorpay_key_id' => 'text', 'razorpay_key_secret' => 'secret', 'razorpay_webhook_secret' => 'secret'],
        'email' => [
            'mail_driver' => 'select:log,mail,smtp', 'mail_from_name' => 'text', 'mail_from_address' => 'email', 'admin_notification_email' => 'email',
            'notify_admin_new_order' => 'bool', 'notify_customer_order_status' => 'bool',
            'smtp_host' => 'text', 'smtp_port' => 'number', 'smtp_encryption' => 'select:tls,ssl,none', 'smtp_username' => 'text', 'smtp_password' => 'secret',
        ],
        'seo' => ['meta_title' => 'text', 'meta_description' => 'textarea', 'meta_keywords' => 'text', 'google_analytics_id' => 'text', 'robots_extra' => 'textarea'],
    ];

    public const TABS = [
        'general' => 'General', 'branding' => 'Logo & favicon', 'social' => 'Social links', 'store' => 'Store', 'shipping' => 'Shipping & COD',
        'tax' => 'Tax / GST', 'payment' => 'Payments', 'email' => 'E-mail', 'seo' => 'SEO',
    ];

    public function index(): void
    {
        $tab = (string) input('tab', 'general');
        if (!isset(self::TABS[$tab])) {
            $tab = 'general';
        }
        $this->admin('settings', ['title' => 'Settings', 'active' => 'settings', 'tab' => $tab]);
    }

    public function save(): void
    {
        $tab = (string) input('tab', '');
        if (!isset(self::SCHEMA[$tab])) {
            abort(404);
        }
        $errors = [];
        foreach (self::SCHEMA[$tab] as $key => $type) {
            $raw = $_POST[$key] ?? null;
            $value = is_string($raw) ? trim($raw) : $raw;
            switch (true) {
                case $type === 'bool':
                    $value = !empty($value) && $value !== '0' ? '1' : '0';
                    break;
                case $type === 'secret':
                    if ($value === '' || $value === null) {
                        continue 2; // keep the stored secret
                    }
                    break;
                case $type === 'image':
                    try {
                        $path = Uploader::image($key, 'settings', $key === 'favicon' ? 512 : 1400);
                    } catch (RuntimeException $e) {
                        $errors[$key] = $e->getMessage();
                        continue 2;
                    }
                    if ($path) {
                        $value = $path;
                    } elseif (!empty($_POST['remove_' . $key])) {
                        $value = '';
                    } else {
                        continue 2;
                    }
                    break;
                case $type === 'email':
                    if ($value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$key] = 'Please enter a valid e-mail address.';
                        continue 2;
                    }
                    break;
                case $type === 'url':
                    if ($value !== '' && !filter_var($value, FILTER_VALIDATE_URL)) {
                        $errors[$key] = 'Please enter a full URL starting with https://';
                        continue 2;
                    }
                    break;
                case $type === 'number':
                    if ($value !== '' && !is_numeric($value)) {
                        $errors[$key] = 'Please enter a number.';
                        continue 2;
                    }
                    $value = $value === '' ? '0' : (string) max(0, (float) $value);
                    break;
                case str_starts_with($type, 'select:'):
                    if (!in_array($value, explode(',', substr($type, 7)), true)) {
                        continue 2;
                    }
                    break;
                default:
                    $value = (string) $value;
            }
            Settings::set($key, $value, $tab);
        }
        if ($tab === 'payment' && Settings::bool('razorpay_enabled') && (Settings::get('razorpay_key_id', '') === '' || Settings::get('razorpay_key_secret', '') === '')) {
            $errors['razorpay_key_id'] = 'Razorpay is enabled but the Key ID or Key Secret is missing, so online payment stays hidden at checkout.';
        }
        if ($tab === 'shipping' && !Settings::bool('cod_enabled') && !\App\Services\Razorpay::enabled()) {
            $errors['cod_enabled'] = 'Warning: no payment method is active, customers cannot check out.';
        }
        if ($errors) {
            with_errors($errors);
            flash('error', 'Some settings need attention.');
        } else {
            flash('success', self::TABS[$tab] . ' settings saved.');
        }
        log_message('admin-settings', AdminAuth::user()['email'] . ' updated ' . $tab);
        redirect('/admin/settings?tab=' . $tab);
    }

    public function testEmail(): void
    {
        $to = (string) input('to', AdminAuth::user()['email']);
        $ok = Mailer::send($to, 'Test e-mail from ' . setting('site_name'), \App\Core\View::render('emails/welcome', ['customer' => ['name' => AdminAuth::user()['name']], 'subject' => 'Test'], 'emails/layout'));
        flash($ok ? 'success' : 'error', $ok
            ? (setting('mail_driver') === 'log' ? 'Mail driver is “log”: the test e-mail was written to storage/logs/mail instead of being sent.' : 'Test e-mail sent to ' . $to . '.')
            : 'The e-mail could not be sent — check storage/logs/mail-error.log for details.');
        redirect('/admin/settings?tab=email');
    }
}
