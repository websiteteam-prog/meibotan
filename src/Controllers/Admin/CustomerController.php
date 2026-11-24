<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\Auth;
use App\Core\DB;
use App\Core\Paginator;
use App\Core\Validator;

final class CustomerController extends Controller
{
    private function filters(): array
    {
        $where = ['1=1'];
        $params = [];
        if (($q = trim((string) input('q', ''))) !== '') {
            $like = '%' . addcslashes($q, '%_\\') . '%';
            $where[] = '(c.name LIKE :q1 OR c.email LIKE :q2 OR c.phone LIKE :q3)';
            $params += ['q1' => $like, 'q2' => $like, 'q3' => $like];
        }
        $status = (string) input('status', '');
        if ($status === 'active' || $status === 'inactive') {
            $where[] = 'c.is_active = ' . ($status === 'active' ? 1 : 0);
        }
        if (input('newsletter') === '1') {
            $where[] = 'c.newsletter = 1';
        }
        return [implode(' AND ', $where), $params];
    }

    public function index(): void
    {
        [$where, $params] = $this->filters();
        $total = (int) DB::value("SELECT COUNT(*) FROM customers c WHERE {$where}", $params);
        $pager = new Paginator($total, 20);
        $sort = match ((string) input('sort', '')) { 'spent' => 'spent DESC', 'orders' => 'order_count DESC', 'name' => 'c.name ASC', default => 'c.created_at DESC' };
        $customers = DB::all(
            "SELECT c.*, (SELECT COUNT(*) FROM orders o WHERE o.customer_id = c.id) AS order_count,
                    (SELECT COALESCE(SUM(total),0) FROM orders o WHERE o.customer_id = c.id AND o.status NOT IN ('cancelled','refunded')) AS spent,
                    (SELECT MAX(created_at) FROM orders o WHERE o.customer_id = c.id) AS last_order
             FROM customers c WHERE {$where} ORDER BY {$sort} LIMIT :l OFFSET :o",
            $params + ['l' => $pager->perPage, 'o' => $pager->offset]
        );
        $this->admin('customers/index', ['title' => 'Customers', 'active' => 'customers', 'customers' => $customers, 'pager' => $pager]);
    }

    public function export(): void
    {
        [$where, $params] = $this->filters();
        $rows = DB::all("SELECT c.*, (SELECT COUNT(*) FROM orders o WHERE o.customer_id = c.id) AS order_count, (SELECT COALESCE(SUM(total),0) FROM orders o WHERE o.customer_id = c.id AND o.status NOT IN ('cancelled','refunded')) AS spent FROM customers c WHERE {$where} ORDER BY c.created_at DESC", $params);
        csv_download('customers-' . date('Ymd') . '.csv', ['Name', 'Email', 'Phone', 'Active', 'Newsletter', 'Orders', 'Total spent', 'Registered'],
            array_map(static fn($c) => [$c['name'], $c['email'], $c['phone'], $c['is_active'] ? 'yes' : 'no', $c['newsletter'] ? 'yes' : 'no', $c['order_count'], $c['spent'], $c['created_at']], $rows));
    }

    public function show(string $id): void
    {
        $c = DB::one('SELECT * FROM customers WHERE id = :id', ['id' => (int) $id]);
        if (!$c) {
            abort(404);
        }
        $this->admin('customers/show', [
            'title' => $c['name'], 'active' => 'customers', 'c' => $c,
            'orders' => DB::all('SELECT * FROM orders WHERE customer_id = :id ORDER BY created_at DESC LIMIT 50', ['id' => $c['id']]),
            'addresses' => DB::all('SELECT * FROM customer_addresses WHERE customer_id = :id ORDER BY is_default DESC', ['id' => $c['id']]),
            'wishlist' => (int) DB::value('SELECT COUNT(*) FROM wishlist WHERE customer_id = :id', ['id' => $c['id']]),
            'spent' => (float) DB::value("SELECT COALESCE(SUM(total),0) FROM orders WHERE customer_id = :id AND status NOT IN ('cancelled','refunded')", ['id' => $c['id']]),
        ]);
    }

    public function update(string $id): void
    {
        $c = DB::one('SELECT * FROM customers WHERE id = :id', ['id' => (int) $id]);
        if (!$c) {
            abort(404);
        }
        $data = $_POST;
        $data['email'] = strtolower(trim((string) ($data['email'] ?? '')));
        $data['phone'] = preg_replace('/[^\d+]/', '', (string) ($data['phone'] ?? ''));
        $v = Validator::make($data, [
            'name' => 'required|max:120', 'email' => 'required|email|unique:customers,email,' . $c['id'],
            'phone' => 'nullable|phone|unique:customers,phone,' . $c['id'], 'new_password' => 'nullable|password',
        ]);
        if ($v->fails()) {
            with_errors($v->errors(), $_POST);
            redirect('/admin/customers/' . $c['id']);
        }
        $row = ['name' => trim((string) $data['name']), 'email' => $data['email'], 'phone' => $data['phone'] ?: null,
            'is_active' => (int) !empty($data['is_active']), 'newsletter' => (int) !empty($data['newsletter'])];
        if (!empty($data['new_password'])) {
            $row['password_hash'] = password_hash((string) $data['new_password'], PASSWORD_DEFAULT);
            Auth::revokeRememberTokens((int) $c['id']);
        }
        DB::update('customers', $row, 'id = :id', ['id' => $c['id']]);
        flash('success', 'Customer details updated.');
        redirect('/admin/customers/' . $c['id']);
    }

    public function toggle(string $id): void
    {
        DB::exec('UPDATE customers SET is_active = 1 - is_active WHERE id = :id', ['id' => (int) $id]);
        Auth::revokeRememberTokens((int) $id);
        flash('success', 'Customer account status updated.');
        back('/admin/customers');
    }
}
