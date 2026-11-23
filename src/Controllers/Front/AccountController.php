<?php
declare(strict_types=1);

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\Auth;
use App\Core\DB;
use App\Core\Http;
use App\Core\Paginator;
use App\Core\Validator;
use App\Services\OrderService;
use App\Services\WishlistService;

final class AccountController extends Controller
{
    public function __construct()
    {
        Http::noCache();
    }

    private function page(string $view, string $title, array $data = []): void
    {
        $this->view('account/' . $view, array_merge($data, [
            'customer' => Auth::customer(),
            'section' => $view,
            'meta' => $this->meta($title, null, ['robots' => 'noindex, nofollow']),
            'bodyClass' => 'page-account',
        ]));
    }

    public function dashboard(): void
    {
        $cid = (int) Auth::id();
        $this->page('dashboard', 'My account', [
            'orderCount' => (int) DB::value('SELECT COUNT(*) FROM orders WHERE customer_id = :c', ['c' => $cid]),
            'activeCount' => (int) DB::value("SELECT COUNT(*) FROM orders WHERE customer_id = :c AND status IN ('pending','processing','confirmed','shipped')", ['c' => $cid]),
            'spent' => (float) DB::value("SELECT COALESCE(SUM(total),0) FROM orders WHERE customer_id = :c AND status NOT IN ('cancelled','refunded')", ['c' => $cid]),
            'wishCount' => WishlistService::count(),
            'addressCount' => (int) DB::value('SELECT COUNT(*) FROM customer_addresses WHERE customer_id = :c', ['c' => $cid]),
            'recent' => DB::all('SELECT * FROM orders WHERE customer_id = :c ORDER BY created_at DESC LIMIT 3', ['c' => $cid]),
        ]);
    }

    public function profile(): void
    {
        $this->page('profile', 'My profile');
    }

    public function updateProfile(): void
    {
        $c = Auth::customer();
        $data = $_POST;
        $data['email'] = strtolower(trim((string) ($data['email'] ?? '')));
        $data['phone'] = preg_replace('/[^\d+]/', '', (string) ($data['phone'] ?? ''));
        $v = Validator::make($data, [
            'name' => 'required|min:2|max:120',
            'email' => 'required|email|max:190|unique:customers,email,' . $c['id'],
            'phone' => 'required|phone|unique:customers,phone,' . $c['id'],
        ]);
        $errors = $v->errors();
        if ($data['email'] !== $c['email'] && !password_verify((string) input('current_password', ''), $c['password_hash'])) {
            $errors['current_password'] = 'Enter your current password to change your email address.';
        }
        if ($errors) {
            with_errors($errors, $_POST);
            redirect('/account/profile');
        }
        DB::update('customers', [
            'name' => trim((string) $data['name']), 'email' => $data['email'], 'phone' => $data['phone'],
            'newsletter' => input('newsletter') === '1' ? 1 : 0,
        ], 'id = :id', ['id' => $c['id']]);
        flash('success', 'Your profile has been updated.');
        redirect('/account/profile');
    }

    public function password(): void
    {
        $this->page('password', 'Change password');
    }

    public function updatePassword(): void
    {
        $c = Auth::customer();
        $v = Validator::make($_POST, ['current_password' => 'required', 'password' => 'required|password|confirmed'], ['password' => 'New password']);
        $errors = $v->errors();
        if (!isset($errors['current_password']) && !password_verify((string) input('current_password'), $c['password_hash'])) {
            $errors['current_password'] = 'Your current password is incorrect.';
        }
        if ($errors) {
            with_errors($errors);
            redirect('/account/password');
        }
        DB::update('customers', ['password_hash' => password_hash((string) input('password'), PASSWORD_DEFAULT)], 'id = :id', ['id' => $c['id']]);
        Auth::revokeRememberTokens((int) $c['id']);
        flash('success', 'Your password has been changed.');
        redirect('/account/password');
    }

    public function addresses(): void
    {
        $cid = (int) Auth::id();
        $edit = input_int('edit') ? DB::one('SELECT * FROM customer_addresses WHERE id = :id AND customer_id = :c', ['id' => input_int('edit'), 'c' => $cid]) : null;
        $this->page('addresses', 'My addresses', [
            'addresses' => DB::all('SELECT * FROM customer_addresses WHERE customer_id = :c ORDER BY is_default DESC, id DESC', ['c' => $cid]),
            'edit' => $edit,
            'states' => CheckoutController::INDIAN_STATES,
            'countries' => CheckoutController::countries(),
        ]);
    }

    public function saveAddress(): void
    {
        $cid = (int) Auth::id();
        $id = input_int('id');
        $v = Validator::make($_POST, [
            'label' => 'required|max:40', 'full_name' => 'required|max:120', 'phone' => 'required|phone',
            'address_line1' => 'required|max:190', 'address_line2' => 'nullable|max:190', 'city' => 'required|max:100',
            'state' => 'required|max:100', 'country' => 'required|max:100', 'postal_code' => 'required|max:12',
        ], ['address_line1' => 'Address', 'postal_code' => 'PIN code', 'full_name' => 'Full name']);
        $errors = $v->errors();
        if (!isset($errors['postal_code']) && strcasecmp((string) input('country'), 'India') === 0 && !preg_match('/^[1-9]\d{5}$/', (string) input('postal_code'))) {
            $errors['postal_code'] = 'Please enter a valid 6-digit PIN code.';
        }
        if ($errors) {
            with_errors($errors, $_POST);
            redirect('/account/addresses' . ($id ? '?edit=' . $id : '') . '#address-form');
        }
        $data = [
            'label' => (string) input('label'), 'full_name' => (string) input('full_name'), 'phone' => preg_replace('/[^\d+]/', '', (string) input('phone')),
            'address_line1' => (string) input('address_line1'), 'address_line2' => input('address_line2') ?: null, 'city' => (string) input('city'),
            'state' => (string) input('state'), 'country' => (string) input('country'), 'postal_code' => (string) input('postal_code'),
        ];
        $makeDefault = input('is_default') === '1' || !DB::value('SELECT id FROM customer_addresses WHERE customer_id = :c', ['c' => $cid]);
        if ($id) {
            if (!DB::value('SELECT id FROM customer_addresses WHERE id = :id AND customer_id = :c', ['id' => $id, 'c' => $cid])) {
                abort(404);
            }
            DB::update('customer_addresses', $data, 'id = :id AND customer_id = :c', ['id' => $id, 'c' => $cid]);
        } else {
            $id = DB::insert('customer_addresses', $data + ['customer_id' => $cid, 'created_at' => now()]);
        }
        if ($makeDefault) {
            $this->setDefault($cid, $id);
        }
        flash('success', 'Address saved.');
        redirect('/account/addresses');
    }

    public function deleteAddress(string $id): void
    {
        $cid = (int) Auth::id();
        $row = DB::one('SELECT * FROM customer_addresses WHERE id = :id AND customer_id = :c', ['id' => (int) $id, 'c' => $cid]);
        if ($row) {
            DB::delete('customer_addresses', 'id = :id', ['id' => $row['id']]);
            if ((int) $row['is_default'] === 1) {
                $next = DB::value('SELECT id FROM customer_addresses WHERE customer_id = :c ORDER BY id DESC LIMIT 1', ['c' => $cid]);
                if ($next) {
                    $this->setDefault($cid, (int) $next);
                }
            }
            flash('success', 'Address removed.');
        }
        redirect('/account/addresses');
    }

    public function defaultAddress(string $id): void
    {
        $cid = (int) Auth::id();
        if (DB::value('SELECT id FROM customer_addresses WHERE id = :id AND customer_id = :c', ['id' => (int) $id, 'c' => $cid])) {
            $this->setDefault($cid, (int) $id);
            flash('success', 'Default address updated.');
        }
        redirect('/account/addresses');
    }

    private function setDefault(int $cid, int $id): void
    {
        DB::exec('UPDATE customer_addresses SET is_default = (id = :id) WHERE customer_id = :c', ['id' => $id, 'c' => $cid]);
    }

    public function orders(): void
    {
        $cid = (int) Auth::id();
        $status = (string) input('status', '');
        $where = 'customer_id = :c';
        $params = ['c' => $cid];
        if (in_array($status, OrderService::STATUSES, true)) {
            $where .= ' AND status = :s';
            $params['s'] = $status;
        }
        $total = (int) DB::value("SELECT COUNT(*) FROM orders WHERE {$where}", $params);
        $pager = new Paginator($total, 10);
        $orders = DB::all(
            "SELECT o.*, (SELECT COUNT(*) FROM order_items oi WHERE oi.order_id = o.id) AS item_count,
                    (SELECT image FROM order_items oi WHERE oi.order_id = o.id ORDER BY oi.id LIMIT 1) AS thumb
             FROM orders o WHERE {$where} ORDER BY created_at DESC LIMIT :lim OFFSET :off",
            $params + ['lim' => $pager->perPage, 'off' => $pager->offset]
        );
        $this->page('orders', 'My orders', ['orders' => $orders, 'pager' => $pager, 'status' => $status]);
    }

    public function order(string $number): void
    {
        $order = $this->ownedOrder($number);
        $this->page('order', 'Order ' . $order['order_number'], [
            'order' => $order,
            'items' => OrderService::items((int) $order['id']),
            'history' => OrderService::history((int) $order['id']),
        ]);
    }

    public function cancelOrder(string $number): void
    {
        $order = $this->ownedOrder($number);
        if (!OrderService::canCustomerCancel($order)) {
            flash('error', 'This order can no longer be cancelled. Please contact us for help.');
            redirect('/account/orders/' . $order['order_number']);
        }
        $reason = mb_substr(trim((string) input('reason', '')), 0, 200) ?: 'Cancelled by customer';
        OrderService::updateStatus($order, 'cancelled', $reason, 'customer');
        $msg = 'Your order has been cancelled.';
        if ($order['payment_status'] === 'paid') {
            $msg .= ' Your refund will be processed to the original payment method within 5–7 business days.';
        }
        flash('success', $msg);
        redirect('/account/orders/' . $order['order_number']);
    }

    private function ownedOrder(string $number): array
    {
        $order = DB::one('SELECT * FROM orders WHERE order_number = :n AND customer_id = :c', ['n' => $number, 'c' => Auth::id()]);
        if (!$order) {
            abort(404, 'We could not find that order in your account.');
        }
        return $order;
    }
}
