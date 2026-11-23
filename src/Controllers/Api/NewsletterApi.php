<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\DB;
use App\Core\RateLimiter;

final class NewsletterApi
{
    public function subscribe(): void
    {
        $email = strtolower(trim((string) input('email', '')));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) {
            json_response(['ok' => false, 'message' => 'Please enter a valid e-mail address.'], 422);
        }
        if (RateLimiter::tooMany('newsletter|' . client_ip(), 10, 60)) {
            json_response(['ok' => false, 'message' => 'Too many attempts. Please try again later.'], 429);
        }
        RateLimiter::hit('newsletter|' . client_ip());
        $existing = DB::one('SELECT * FROM newsletter_subscribers WHERE email = :e', ['e' => $email]);
        if ($existing && $existing['status'] === 'subscribed') {
            json_response(['ok' => true, 'message' => 'You’re already part of the inner circle — thank you!']);
        }
        if ($existing) {
            DB::update('newsletter_subscribers', ['status' => 'subscribed'], 'id = :id', ['id' => $existing['id']]);
        } else {
            DB::insert('newsletter_subscribers', ['email' => $email, 'status' => 'subscribed', 'ip_address' => client_ip(), 'created_at' => now()]);
        }
        json_response(['ok' => true, 'message' => 'Welcome to the inner circle. Watch your inbox for something beautiful.']);
    }
}
