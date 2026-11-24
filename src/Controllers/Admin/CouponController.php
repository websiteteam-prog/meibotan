<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\DB;
use App\Core\Validator;

final class CouponController extends Controller
{
    public function index(): void
    {
        $this->admin('coupons', [
            'title' => 'Coupons', 'active' => 'coupons',
            'coupons' => DB::all('SELECT c.*, (SELECT COALESCE(SUM(discount_amount),0) FROM coupon_usages u WHERE u.coupon_id = c.id) AS discount_given FROM coupons c ORDER BY c.created_at DESC'),
        ]);
    }

    public function save(): void
    {
        $id = input_int('id');
        $data = $_POST;
        $data['code'] = strtoupper(preg_replace('/\s+/', '', (string) ($data['code'] ?? '')));
        $v = Validator::make($data, [
            'code' => 'required|max:40|unique:coupons,code,' . $id, 'type' => 'required|in:percent,fixed', 'value' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0', 'max_discount' => 'nullable|numeric|min:0', 'usage_limit' => 'nullable|integer|min:1',
            'usage_per_customer' => 'nullable|integer|min:1', 'starts_at' => 'nullable|date', 'expires_at' => 'nullable|date', 'description' => 'nullable|max:190',
        ]);
        $errors = $v->errors();
        if (!preg_match('/^[A-Z0-9_-]+$/', $data['code'])) {
            $errors['code'] = 'Use only letters, numbers, dashes and underscores.';
        }
        if (($data['type'] ?? '') === 'percent' && (float) ($data['value'] ?? 0) > 100) {
            $errors['value'] = 'A percentage discount cannot exceed 100%.';
        }
        if (!empty($data['starts_at']) && !empty($data['expires_at']) && strtotime($data['expires_at']) < strtotime($data['starts_at'])) {
            $errors['expires_at'] = 'Expiry must be after the start date.';
        }
        if ($errors) {
            with_errors($errors, $_POST);
            redirect('/admin/coupons');
        }
        $n = static fn($k) => ($data[$k] ?? '') === '' ? null : $data[$k];
        $row = [
            'code' => $data['code'], 'description' => $n('description'), 'type' => $data['type'], 'value' => (float) $data['value'],
            'min_order_amount' => (float) ($data['min_order_amount'] ?: 0), 'max_discount' => $n('max_discount'),
            'usage_limit' => $n('usage_limit'), 'usage_per_customer' => $n('usage_per_customer'),
            'starts_at' => $n('starts_at') ? date('Y-m-d H:i:s', strtotime($data['starts_at'])) : null,
            'expires_at' => $n('expires_at') ? date('Y-m-d H:i:s', strtotime($data['expires_at'])) : null,
            'is_active' => (int) !empty($data['is_active']),
        ];
        if ($id) {
            DB::update('coupons', $row, 'id = :id', ['id' => $id]);
        } else {
            $row['created_at'] = now();
            DB::insert('coupons', $row);
        }
        flash('success', 'Coupon ' . $row['code'] . ' saved.');
        redirect('/admin/coupons');
    }

    public function delete(string $id): void
    {
        DB::delete('coupons', 'id = :id', ['id' => (int) $id]);
        flash('success', 'Coupon deleted.');
        redirect('/admin/coupons');
    }

    public function toggle(string $id): void
    {
        DB::exec('UPDATE coupons SET is_active = 1 - is_active WHERE id = :id', ['id' => (int) $id]);
        redirect('/admin/coupons');
    }
}
