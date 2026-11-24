<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Admin authentication with role-based access control.
 */
final class AdminAuth
{
    /** Role => list of permissions ('*' means everything). */
    /*
     * "content" (homepage, banners, testimonials, gallery, pages) and "design"
     * (logo, website texts, SEO) are reserved for the website developer.
     */
    public const ROLES = [
        'developer' => ['*'],
        'super_admin' => ['dashboard', 'catalog', 'orders', 'customers', 'marketing', 'reviews', 'messages', 'settings', 'admins'],
        'manager' => ['dashboard', 'catalog', 'orders', 'customers', 'marketing', 'reviews', 'messages'],
        'support' => ['dashboard', 'orders', 'customers', 'reviews', 'messages'],
    ];

    public const ROLE_LABELS = [
        'developer' => 'Website Developer',
        'super_admin' => 'Store Owner',
        'manager' => 'Store Manager',
        'support' => 'Customer Support',
    ];

    private static ?array $user = null;
    private static bool $resolved = false;

    public static function user(): ?array
    {
        if (!self::$resolved) {
            self::$resolved = true;
            $id = (int) Session::get('admin_id', 0);
            if ($id > 0) {
                self::$user = DB::one('SELECT * FROM admins WHERE id = :id AND is_active = 1', ['id' => $id]);
                if (!self::$user) {
                    Session::forget('admin_id');
                }
            }
        }
        return self::$user;
    }

    public static function attempt(string $email, string $password): ?array
    {
        $row = DB::one('SELECT * FROM admins WHERE email = :e LIMIT 1', ['e' => strtolower(trim($email))]);
        if (!$row || !password_verify($password, $row['password_hash'])) {
            return null;
        }
        if (password_needs_rehash($row['password_hash'], PASSWORD_DEFAULT)) {
            DB::update('admins', ['password_hash' => password_hash($password, PASSWORD_DEFAULT)], 'id = :id', ['id' => $row['id']]);
        }
        return $row;
    }

    public static function login(array $admin): void
    {
        Session::regenerate();
        Session::put('admin_id', (int) $admin['id']);
        DB::update('admins', ['last_login_at' => now()], 'id = :id', ['id' => $admin['id']]);
        self::$user = $admin;
        self::$resolved = true;
    }

    public static function logout(): void
    {
        Session::forget('admin_id');
        Session::regenerate();
        self::$user = null;
    }

    public static function can(string $permission): bool
    {
        $u = self::user();
        if (!$u) {
            return false;
        }
        $perms = self::ROLES[$u['role']] ?? [];
        return in_array('*', $perms, true) || in_array($permission, $perms, true);
    }

    public static function require(?string $permission = null): void
    {
        Http::noCache();
        if (!self::user()) {
            if (is_ajax()) {
                json_response(['ok' => false, 'message' => 'Please sign in.'], 401);
            }
            redirect('/admin/login?redirect=' . rawurlencode(request_path()));
        }
        if ($permission !== null && !self::can($permission)) {
            if (is_ajax()) {
                json_response(['ok' => false, 'message' => 'You do not have permission for this action.'], 403);
            }
            flash('error', 'You do not have permission to access that section.');
            redirect('/admin');
        }
    }
}
