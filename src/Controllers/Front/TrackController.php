<?php
declare(strict_types=1);

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\DB;
use App\Core\Http;
use App\Core\RateLimiter;
use App\Services\OrderService;

/**
 * Public order tracking: order number + e-mail or phone (works for guest orders too).
 */
final class TrackController extends Controller
{
    public function form(): void
    {
        Http::noCache();
        $this->view('track', [
            'order' => null,
            'meta' => $this->meta('Track your order', 'Check the status of your Savié Amour order.', ['robots' => 'noindex, follow']),
        ]);
    }

    public function lookup(): void
    {
        Http::noCache();
        $number = strtoupper(trim((string) input('order_number', '')));
        $contact = strtolower(trim((string) input('contact', '')));
        $key = 'track|' . client_ip();
        if ($number === '' || $contact === '') {
            with_errors(['order_number' => $number === '' ? 'Enter your order number.' : null, 'contact' => $contact === '' ? 'Enter the e-mail or phone used for the order.' : null], $_POST);
            redirect('/track-order');
        }
        if (RateLimiter::tooMany($key, 15, 30)) {
            flash('error', 'Too many attempts. Please try again in a few minutes.');
            redirect('/track-order');
        }
        RateLimiter::hit($key);
        $order = DB::one('SELECT * FROM orders WHERE order_number = :n', ['n' => ltrim($number, '#')]);
        $phone = preg_replace('/\D+/', '', $contact);
        $match = $order && (
            $contact === strtolower($order['customer_email'])
            || ($phone !== '' && strlen($phone) >= 10 && substr(preg_replace('/\D+/', '', $order['customer_phone']), -10) === substr($phone, -10))
        );
        if (!$match) {
            with_errors(['order_number' => 'We could not find an order with these details. Please check the order number and the e-mail/phone used at checkout.'], $_POST);
            redirect('/track-order');
        }
        $this->view('track', [
            'order' => $order,
            'items' => OrderService::items((int) $order['id']),
            'history' => OrderService::history((int) $order['id']),
            'meta' => $this->meta('Order ' . $order['order_number'] . ' status', null, ['robots' => 'noindex, nofollow']),
        ]);
    }
}
