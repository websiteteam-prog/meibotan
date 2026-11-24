<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\AdminAuth;
use App\Core\DB;
use App\Core\Http;
use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Core\Validator;
use App\Core\View;
use App\Services\PasswordReset;

final class AuthController
{
    private function render(string $view, array $data = []): void
    {
        Http::noCache();
        echo View::render('admin/auth/' . $view, $data, 'layouts/admin-auth');
    }

    public function loginForm(): void
    {
        if (AdminAuth::user()) {
            redirect('/admin');
        }
        $this->render('login', ['title' => 'Admin login', 'redirect' => safe_redirect_path((string) input('redirect', ''), '')]);
    }

    public function login(): void
    {
        $email = strtolower(trim((string) input('email', '')));
        $key = 'admin-login|' . $email . '|' . client_ip();
        $redirect = safe_redirect_path((string) input('redirect', ''), '/admin');
        if (!str_starts_with($redirect, '/admin')) {
            $redirect = '/admin';
        }
        if (RateLimiter::tooMany($key, 5, 15)) {
            flash('error', 'Too many attempts. Please wait 15 minutes and try again.');
            redirect('/admin/login');
        }
        $admin = AdminAuth::attempt($email, (string) input('password', ''));
        if (!$admin || !(int) $admin['is_active']) {
            RateLimiter::hit($key);
            log_message('admin-auth', 'Failed login for ' . $email . ' from ' . client_ip());
            with_errors(['email' => 'Invalid credentials or inactive account.'], ['email' => $email]);
            redirect('/admin/login');
        }
        RateLimiter::clear($key);
        AdminAuth::login($admin);
        log_message('admin-auth', 'Login ' . $email . ' from ' . client_ip());
        redirect($redirect);
    }

    public function logout(): void
    {
        AdminAuth::logout();
        flash('success', 'You have been signed out.');
        redirect('/admin/login');
    }

    public function forgotForm(): void
    {
        $this->render('forgot', ['title' => 'Reset admin password']);
    }

    public function forgot(): void
    {
        $email = strtolower(trim((string) input('email', '')));
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && !RateLimiter::tooMany('admin-forgot|' . client_ip(), 5, 30)) {
            RateLimiter::hit('admin-forgot|' . client_ip());
            $admin = DB::one('SELECT * FROM admins WHERE email = :e AND is_active = 1', ['e' => $email]);
            if ($admin) {
                $token = PasswordReset::create('admin', $email);
                Mailer::template($email, 'Reset your admin password', 'password-reset', [
                    'name' => $admin['name'], 'link' => url('admin/reset-password', ['token' => $token, 'email' => $email]),
                ]);
            }
        }
        flash('success', 'If that e-mail belongs to an admin account, a reset link has been sent.');
        redirect('/admin/forgot-password');
    }

    public function resetForm(): void
    {
        $email = (string) input('email', '');
        $token = (string) input('token', '');
        $this->render('reset', ['title' => 'Choose a new password', 'email' => $email, 'token' => $token, 'valid' => PasswordReset::valid('admin', $email, $token)]);
    }

    public function reset(): void
    {
        $email = strtolower((string) input('email', ''));
        $token = (string) input('token', '');
        if (!PasswordReset::valid('admin', $email, $token)) {
            flash('error', 'This link is invalid or has expired.');
            redirect('/admin/forgot-password');
        }
        $v = Validator::make($_POST, ['password' => 'required|password|confirmed']);
        if ($v->fails()) {
            with_errors($v->errors());
            redirect('/admin/reset-password?' . http_build_query(['token' => $token, 'email' => $email]));
        }
        DB::update('admins', ['password_hash' => password_hash((string) input('password'), PASSWORD_DEFAULT)], 'email = :e', ['e' => $email]);
        PasswordReset::consume('admin', $email);
        flash('success', 'Password updated. Please sign in.');
        redirect('/admin/login');
    }
}
