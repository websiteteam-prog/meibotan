<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\AdminAuth;
use App\Core\DB;
use App\Core\Validator;

final class AdminUserController extends Controller
{
    public function index(): void
    {
        $this->admin('admins', ['title' => 'Admin users', 'active' => 'admins', 'admins' => DB::all('SELECT * FROM admins ORDER BY created_at')]);
    }

    public function save(): void
    {
        $id = input_int('id');
        $data = $_POST;
        $data['email'] = strtolower(trim((string) ($data['email'] ?? '')));
        $rules = ['name' => 'required|max:120', 'email' => 'required|email|unique:admins,email,' . $id, 'role' => 'required|in:' . implode(',', array_keys(AdminAuth::ROLES))];
        $rules['password'] = $id ? 'nullable|password' : 'required|password';
        $v = Validator::make($data, $rules);
        $errors = $v->errors();
        $me = AdminAuth::user();
        $isDev = AdminAuth::can('design');
        $target = $id ? DB::one('SELECT * FROM admins WHERE id = :id', ['id' => $id]) : null;
        if (!$isDev && (($data['role'] ?? '') === 'developer' || ($target && $target['role'] === 'developer'))) {
            $errors['role'] = 'Developer accounts can only be managed by the website developer.';
        }
        if ($id === (int) $me['id'] && (($data['role'] ?? '') !== $me['role'] || empty($data['is_active']))) {
            $errors['role'] = 'You cannot change the role of, or deactivate, your own account.';
        }
        if ($errors) {
            with_errors($errors, $_POST);
            redirect('/admin/admins');
        }
        $row = ['name' => trim((string) $data['name']), 'email' => $data['email'], 'role' => $data['role'], 'phone' => ($data['phone'] ?? '') ?: null, 'is_active' => (int) !empty($data['is_active'])];
        if (!empty($data['password'])) {
            $row['password_hash'] = password_hash((string) $data['password'], PASSWORD_DEFAULT);
        }
        if ($id) {
            DB::update('admins', $row, 'id = :id', ['id' => $id]);
        } else {
            $row['created_at'] = now();
            DB::insert('admins', $row);
        }
        flash('success', 'Admin user saved.');
        redirect('/admin/admins');
    }

    public function delete(string $id): void
    {
        if ((int) $id === (int) AdminAuth::user()['id']) {
            flash('error', 'You cannot delete your own account.');
            redirect('/admin/admins');
        }
        $target = DB::one('SELECT * FROM admins WHERE id = :id', ['id' => (int) $id]);
        if ($target && $target['role'] === 'developer' && !AdminAuth::can('design')) {
            flash('error', 'Developer accounts can only be managed by the website developer.');
            redirect('/admin/admins');
        }
        if ((int) DB::value("SELECT COUNT(*) FROM admins WHERE role IN ('developer','super_admin') AND is_active = 1 AND id <> :id", ['id' => (int) $id]) === 0) {
            flash('error', 'At least one active owner or developer account is required.');
            redirect('/admin/admins');
        }
        DB::delete('admins', 'id = :id', ['id' => (int) $id]);
        flash('success', 'Admin user deleted.');
        redirect('/admin/admins');
    }

    public function profile(): void
    {
        $this->admin('profile', ['title' => 'My profile', 'active' => '', 'me' => AdminAuth::user()]);
    }

    public function updateProfile(): void
    {
        $me = AdminAuth::user();
        $data = $_POST;
        $data['email'] = strtolower(trim((string) ($data['email'] ?? '')));
        $v = Validator::make($data, ['name' => 'required|max:120', 'email' => 'required|email|unique:admins,email,' . $me['id'], 'phone' => 'nullable|phone']);
        if ($v->fails()) {
            with_errors($v->errors(), $_POST);
            redirect('/admin/profile');
        }
        DB::update('admins', ['name' => trim((string) $data['name']), 'email' => $data['email'], 'phone' => ($data['phone'] ?? '') ?: null], 'id = :id', ['id' => $me['id']]);
        flash('success', 'Profile updated.');
        redirect('/admin/profile');
    }

    public function updatePassword(): void
    {
        $me = AdminAuth::user();
        $v = Validator::make($_POST, ['current_password' => 'required', 'password' => 'required|password|confirmed']);
        $errors = $v->errors();
        if (!isset($errors['current_password']) && !password_verify((string) input('current_password'), $me['password_hash'])) {
            $errors['current_password'] = 'Current password is incorrect.';
        }
        if ($errors) {
            with_errors($errors);
            redirect('/admin/profile');
        }
        DB::update('admins', ['password_hash' => password_hash((string) input('password'), PASSWORD_DEFAULT)], 'id = :id', ['id' => $me['id']]);
        flash('success', 'Password changed.');
        redirect('/admin/profile');
    }
}
