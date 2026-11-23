<?php
declare(strict_types=1);

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\Auth;
use App\Core\DB;
use App\Core\Http;
use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Core\Validator;
use App\Services\CartService;
use App\Services\PasswordReset;

final class AuthController extends Controller
{
    public function loginForm(): void
    {
        Http::noCache();
        $this->view('auth/login', [
            'redirect' => safe_redirect_path((string) input('redirect', ''), ''),
            'meta' => $this->meta('Log in', 'Log in to your Savié Amour account.', ['robots' => 'noindex, follow']),
            'bodyClass' => 'page-auth',
        ]);
    }

    public function login(): void
    {
        $identifier = trim((string) input('identifier', ''));
        $password = (string) input('password', '');
        $redirect = safe_redirect_path((string) input('redirect', ''), '/account');
        $back = '/login' . ($redirect !== '/account' ? '?redirect=' . rawurlencode($redirect) : '');
        $throttleKey = 'login|' . strtolower($identifier) . '|' . client_ip();

        if ($identifier === '' || $password === '') {
            with_errors(['identifier' => $identifier === '' ? 'Please enter your email or phone number.' : null, 'password' => $password === '' ? 'Please enter your password.' : null], $_POST);
            redirect($back);
        }
        if (RateLimiter::tooMany($throttleKey, 5, 15)) {
            with_errors([], $_POST);
            flash('error', 'Too many sign-in attempts. Please wait 15 minutes or reset your password.');
            redirect($back);
        }
        $customer = Auth::attempt($identifier, $password);
        if (!$customer) {
            RateLimiter::hit($throttleKey);
            with_errors(['password' => 'The email/phone or password you entered is incorrect.'], $_POST);
            redirect($back);
        }
        if (!(int) $customer['is_active']) {
            with_errors([], $_POST);
            flash('error', 'Your account has been deactivated. Please contact us for help.');
            redirect($back);
        }
        RateLimiter::clear($throttleKey);
        Auth::login($customer, input('remember') === '1');
        flash('success', 'Welcome back, ' . explode(' ', $customer['name'])[0] . '.');
        redirect($redirect);
    }

    public function registerForm(): void
    {
        Http::noCache();
        $this->view('auth/register', [
            'redirect' => safe_redirect_path((string) input('redirect', ''), ''),
            'meta' => $this->meta('Create an account', 'Join Savié Amour to save favourites, check out faster and track orders.', ['robots' => 'noindex, follow']),
            'bodyClass' => 'page-auth',
        ]);
    }

    public function register(): void
    {
        $redirect = safe_redirect_path((string) input('redirect', ''), '/account');
        if (RateLimiter::tooMany('register|' . client_ip(), 10, 60)) {
            flash('error', 'Too many sign-ups from your network. Please try again later.');
            redirect('/register');
        }
        $data = $_POST;
        $data['email'] = strtolower(trim((string) ($data['email'] ?? '')));
        $data['phone'] = preg_replace('/[^\d+]/', '', (string) ($data['phone'] ?? ''));
        $v = Validator::make($data, [
            'name' => 'required|min:2|max:120',
            'email' => 'required|email|max:190|unique:customers,email',
            'phone' => 'required|phone|unique:customers,phone',
            'password' => 'required|password|confirmed',
            'terms' => 'accepted',
        ], ['terms' => 'terms and conditions', 'phone' => 'phone number']);
        if ($v->fails()) {
            with_errors($v->errors(), $_POST);
            redirect('/register' . ($redirect !== '/account' ? '?redirect=' . rawurlencode($redirect) : ''));
        }
        RateLimiter::hit('register|' . client_ip());
        $id = DB::insert('customers', [
            'name' => trim((string) $data['name']),
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password_hash' => password_hash((string) $data['password'], PASSWORD_DEFAULT),
            'newsletter' => input('newsletter') === '1' ? 1 : 0,
            'is_active' => 1,
            'created_at' => now(),
        ]);
        if (input('newsletter') === '1') {
            DB::exec("INSERT INTO newsletter_subscribers (email, status, ip_address, created_at) VALUES (:e, 'subscribed', :ip, NOW()) ON DUPLICATE KEY UPDATE status = 'subscribed'", ['e' => $data['email'], 'ip' => client_ip()]);
        }
        $customer = DB::one('SELECT * FROM customers WHERE id = :id', ['id' => $id]);
        Auth::login($customer);
        Mailer::template($customer['email'], 'Welcome to ' . setting('site_name'), 'welcome', ['customer' => $customer]);
        flash('success', 'Welcome to ' . setting('site_name') . ', ' . explode(' ', $customer['name'])[0] . '! Your account is ready.');
        redirect($redirect);
    }

    public function logout(): void
    {
        Auth::logout();
        CartService::reset();
        flash('success', 'You have been signed out.');
        redirect('/');
    }

    public function forgotForm(): void
    {
        $this->view('auth/forgot', [
            'meta' => $this->meta('Forgot password', null, ['robots' => 'noindex, follow']),
            'bodyClass' => 'page-auth',
        ]);
    }

    public function forgot(): void
    {
        $email = strtolower(trim((string) input('email', '')));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            with_errors(['email' => 'Please enter a valid email address.'], $_POST);
            redirect('/forgot-password');
        }
        if (!RateLimiter::tooMany('forgot|' . client_ip(), 5, 30)) {
            RateLimiter::hit('forgot|' . client_ip());
            $customer = DB::one('SELECT * FROM customers WHERE email = :e AND is_active = 1', ['e' => $email]);
            if ($customer) {
                $token = PasswordReset::create('customer', $email);
                Mailer::template($email, 'Reset your ' . setting('site_name') . ' password', 'password-reset', [
                    'name' => $customer['name'],
                    'link' => url('reset-password', ['token' => $token, 'email' => $email]),
                ]);
            }
        }
        // Same response whether or not the account exists (prevents account enumeration).
        flash('success', 'If an account exists for ' . $email . ', you will receive a password reset link shortly. The link is valid for 60 minutes.');
        redirect('/forgot-password');
    }

    public function resetForm(): void
    {
        $email = (string) input('email', '');
        $token = (string) input('token', '');
        $valid = PasswordReset::valid('customer', $email, $token);
        $this->view('auth/reset', [
            'email' => $email, 'token' => $token, 'valid' => $valid, 'action' => url('reset-password'),
            'meta' => $this->meta('Reset password', null, ['robots' => 'noindex, nofollow']),
            'bodyClass' => 'page-auth',
        ]);
    }

    public function reset(): void
    {
        $email = strtolower((string) input('email', ''));
        $token = (string) input('token', '');
        $back = '/reset-password?' . http_build_query(['token' => $token, 'email' => $email]);
        if (!PasswordReset::valid('customer', $email, $token)) {
            flash('error', 'This reset link is invalid or has expired. Please request a new one.');
            redirect('/forgot-password');
        }
        $v = Validator::make($_POST, ['password' => 'required|password|confirmed']);
        if ($v->fails()) {
            with_errors($v->errors());
            redirect($back);
        }
        $customer = DB::one('SELECT * FROM customers WHERE email = :e', ['e' => $email]);
        if ($customer) {
            DB::update('customers', ['password_hash' => password_hash((string) input('password'), PASSWORD_DEFAULT)], 'id = :id', ['id' => $customer['id']]);
            Auth::revokeRememberTokens((int) $customer['id']);
        }
        PasswordReset::consume('customer', $email);
        flash('success', 'Your password has been updated. Please log in with your new password.');
        redirect('/login');
    }
}
