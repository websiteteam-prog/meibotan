<?php
declare(strict_types=1);

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\Auth;
use App\Core\DB;
use App\Core\Http;
use App\Core\Session;
use App\Core\Settings;
use App\Core\Validator;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\Razorpay;
use RuntimeException;

final class CheckoutController extends Controller
{
    public const INDIAN_STATES = ['Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chandigarh', 'Chhattisgarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka', 'Kerala', 'Ladakh', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'];

    public static function paymentMethods(): array
    {
        $methods = [];
        if (Razorpay::enabled()) {
            $methods['razorpay'] = ['label' => 'Pay online', 'desc' => 'UPI, cards, net banking & wallets — secured by Razorpay', 'icon' => 'card'];
        }
        if (Settings::bool('cod_enabled')) {
            $fee = (float) Settings::get('cod_fee', 0);
            $methods['cod'] = ['label' => 'Cash on Delivery', 'desc' => 'Pay in cash or UPI when your order arrives' . ($fee > 0 ? ' (+' . money($fee) . ' handling fee)' : ''), 'icon' => 'cash'];
        }
        return $methods;
    }

    public static function countries(): array
    {
        $list = array_values(array_filter(array_map('trim', explode(',', (string) Settings::get('shipping_countries', 'India')))));
        return $list ?: ['India'];
    }

    public function index(): void
    {
        Http::noCache();
        $items = CartService::items();
        if (!$items) {
            flash('info', 'Your bag is empty — add something beautiful first.');
            redirect('/cart');
        }
        if (!Auth::check() && !Settings::bool('guest_checkout')) {
            flash('info', 'Please log in or create an account to check out.');
            redirect('/login?redirect=' . rawurlencode('/checkout'));
        }
        $methods = self::paymentMethods();
        $method = array_key_first($methods) ?? 'cod';
        $customer = Auth::customer();
        $addresses = $customer ? DB::all('SELECT * FROM customer_addresses WHERE customer_id = :c ORDER BY is_default DESC, id DESC', ['c' => $customer['id']]) : [];
        $default = $addresses[0] ?? null;

        $this->view('checkout', [
            'items' => $items,
            'totals' => CartService::totals($method),
            'methods' => $methods,
            'method' => $method,
            'customer' => $customer,
            'addresses' => $addresses,
            'default' => $default,
            'states' => self::INDIAN_STATES,
            'countries' => self::countries(),
            'meta' => $this->meta('Checkout', null, ['robots' => 'noindex, nofollow']),
            'bodyClass' => 'page-checkout',
        ]);
    }

    public function place(): void
    {
        Http::noCache();
        if (!Auth::check() && !Settings::bool('guest_checkout')) {
            $this->fail('Please log in to place your order.', [], 401);
        }
        $methods = self::paymentMethods();
        $method = (string) input('payment_method', '');
        if (!isset($methods[$method])) {
            $this->fail('Please choose a payment method.', ['payment_method' => 'Please choose a payment method.']);
        }
        $billingSame = input('billing_same') === '1';
        $rules = [
            'name' => 'required|max:120', 'email' => 'required|email|max:190', 'phone' => 'required|phone',
            'shipping_address1' => 'required|max:190', 'shipping_address2' => 'nullable|max:190',
            'shipping_city' => 'required|max:100', 'shipping_state' => 'required|max:100',
            'shipping_country' => 'required|max:100', 'shipping_postal_code' => 'required|max:12',
            'notes' => 'nullable|max:500',
        ];
        if (!$billingSame) {
            $rules += [
                'billing_name' => 'required|max:120', 'billing_phone' => 'required|phone', 'billing_address1' => 'required|max:190',
                'billing_city' => 'required|max:100', 'billing_state' => 'required|max:100', 'billing_country' => 'required|max:100',
                'billing_postal_code' => 'required|max:12',
            ];
        }
        $labels = [
            'shipping_address1' => 'Address', 'shipping_city' => 'City', 'shipping_state' => 'State', 'shipping_country' => 'Country',
            'shipping_postal_code' => 'PIN code', 'billing_address1' => 'Billing address', 'billing_city' => 'Billing city',
            'billing_state' => 'Billing state', 'billing_postal_code' => 'Billing PIN code', 'billing_name' => 'Billing name', 'billing_phone' => 'Billing phone',
        ];
        $v = Validator::make($_POST, $rules, $labels);
        $errors = $v->errors();
        foreach (['shipping', 'billing'] as $type) {
            if ($type === 'billing' && $billingSame) {
                continue;
            }
            $country = (string) input($type . '_country', 'India');
            $pin = preg_replace('/\s+/', '', (string) input($type . '_postal_code', ''));
            if ($pin !== '' && strcasecmp($country, 'India') === 0 && !preg_match('/^[1-9]\d{5}$/', $pin)) {
                $errors[$type . '_postal_code'] = 'Please enter a valid 6-digit PIN code.';
            }
            if (!in_array($country, self::countries(), true)) {
                $errors[$type . '_country'] = 'We do not ship to this country yet.';
            }
        }
        if ($errors) {
            $this->fail('Please check the highlighted fields.', $errors);
        }

        $phone = static fn($p) => preg_replace('/[^\d+]/', '', (string) $p);
        $data = [
            'name' => (string) input('name'), 'email' => (string) input('email'), 'phone' => $phone(input('phone')),
            'shipping_name' => (string) input('name'), 'shipping_phone' => $phone(input('phone')),
            'shipping_address1' => (string) input('shipping_address1'), 'shipping_address2' => (string) input('shipping_address2', ''),
            'shipping_city' => (string) input('shipping_city'), 'shipping_state' => (string) input('shipping_state'),
            'shipping_country' => (string) input('shipping_country'), 'shipping_postal_code' => preg_replace('/\s+/', '', (string) input('shipping_postal_code')),
            'notes' => (string) input('notes', ''),
        ];
        foreach (['name', 'phone', 'address1', 'address2', 'city', 'state', 'country', 'postal_code'] as $f) {
            $data['billing_' . $f] = $billingSame ? $data['shipping_' . $f] : ($f === 'phone' ? $phone(input('billing_phone')) : (string) input('billing_' . $f, ''));
        }

        foreach (CartService::items() as $it) {
            if (!$it['stock_ok']) {
                $this->fail($it['available_qty'] > 0
                    ? "Only {$it['available_qty']} of “{$it['name']}” left. Please update your bag."
                    : "“{$it['name']}” is out of stock. Please remove it from your bag.", [], 422, true);
            }
        }

        // An earlier unpaid online attempt in this session is cancelled so its stock is released.
        $previous = (int) Session::get('pending_order_id', 0);
        if ($previous) {
            $old = OrderService::find($previous);
            if ($old && $old['status'] === 'pending' && $old['payment_method'] === 'razorpay' && $old['payment_status'] !== 'paid') {
                OrderService::updateStatus($old, 'cancelled', 'Replaced by a new checkout attempt.', 'system', false);
            }
            Session::forget('pending_order_id');
        }

        try {
            $order = OrderService::createFromCart($data, $method);
        } catch (RuntimeException $e) {
            $this->fail($e->getMessage(), [], 422, true);
        }

        $customer = Auth::customer();
        if ($customer) {
            if (input('save_address') === '1') {
                self::saveAddress((int) $customer['id'], $data);
            }
            if (!$customer['phone'] && $data['phone'] && !DB::value('SELECT id FROM customers WHERE phone = :p', ['p' => $data['phone']])) {
                DB::update('customers', ['phone' => $data['phone']], 'id = :id', ['id' => $customer['id']]);
            }
        }

        if ($method === 'cod') {
            CartService::clear();
            Session::put('last_order', $order['order_number']);
            OrderService::sendPlacedEmails($order);
            $this->done(url('order/' . $order['order_number'], ['key' => $order['access_token']]));
        }

        // Online payment: create the Razorpay order and hand options to Checkout.js.
        try {
            $rz = Razorpay::createOrder((float) $order['total'], $order['order_number'], ['order_number' => $order['order_number']]);
        } catch (RuntimeException $e) {
            OrderService::updateStatus($order, 'cancelled', 'Payment gateway error: ' . $e->getMessage(), 'system', false);
            $this->fail('We could not start the online payment: ' . $e->getMessage() . ' Please try again or choose Cash on Delivery.', [], 502);
        }
        DB::exec('UPDATE payments SET gateway_order_id = :g, status = :s WHERE order_id = :o', ['g' => $rz['id'], 's' => 'created', 'o' => $order['id']]);
        Session::put('pending_order_id', (int) $order['id']);
        Session::put('last_order', $order['order_number']);
        json_response(['ok' => true, 'razorpay' => self::razorpayOptions($order, $rz['id'])]);
    }

    public static function razorpayOptions(array $order, string $gatewayOrderId): array
    {
        return [
            'order_number' => $order['order_number'],
            'options' => [
                'key' => Razorpay::keyId(),
                'amount' => (int) round((float) $order['total'] * 100),
                'currency' => $order['currency'],
                'name' => (string) setting('site_name', 'Savié Amour'),
                'description' => 'Order ' . $order['order_number'],
                'image' => url('assets/img/favicon-512.png'),
                'order_id' => $gatewayOrderId,
                'prefill' => ['name' => $order['customer_name'], 'email' => $order['customer_email'], 'contact' => $order['customer_phone']],
                'notes' => ['order_number' => $order['order_number']],
                'theme' => ['color' => '#630000'],
            ],
        ];
    }

    public function success(string $number): void
    {
        Http::noCache();
        $order = OrderService::findByNumber($number);
        if (!$order || !self::canView($order)) {
            abort(404);
        }
        $this->view('order-success', [
            'order' => $order,
            'items' => OrderService::items((int) $order['id']),
            'history' => OrderService::history((int) $order['id']),
            'meta' => $this->meta('Order ' . $order['order_number'], null, ['robots' => 'noindex, nofollow']),
        ]);
    }

    /** Owner, holder of the secret link, or the session that just placed it. */
    public static function canView(array $order): bool
    {
        $cid = Auth::id();
        if ($cid && (int) $order['customer_id'] === $cid) {
            return true;
        }
        $key = (string) input('key', '');
        if ($key !== '' && hash_equals($order['access_token'], $key)) {
            return true;
        }
        return Session::get('last_order') === $order['order_number'];
    }

    private static function saveAddress(int $customerId, array $d): void
    {
        $exists = DB::value(
            'SELECT id FROM customer_addresses WHERE customer_id = :c AND address_line1 = :a AND postal_code = :p',
            ['c' => $customerId, 'a' => $d['shipping_address1'], 'p' => $d['shipping_postal_code']]
        );
        if ($exists) {
            return;
        }
        $hasDefault = (bool) DB::value('SELECT id FROM customer_addresses WHERE customer_id = :c AND is_default = 1', ['c' => $customerId]);
        DB::insert('customer_addresses', [
            'customer_id' => $customerId, 'label' => 'Home', 'full_name' => $d['shipping_name'], 'phone' => $d['shipping_phone'],
            'address_line1' => $d['shipping_address1'], 'address_line2' => $d['shipping_address2'] ?: null, 'city' => $d['shipping_city'],
            'state' => $d['shipping_state'], 'country' => $d['shipping_country'], 'postal_code' => $d['shipping_postal_code'],
            'is_default' => $hasDefault ? 0 : 1, 'created_at' => now(),
        ]);
    }

    private function fail(string $message, array $errors = [], int $status = 422, bool $refresh = false): never
    {
        if (is_ajax()) {
            json_response(['ok' => false, 'message' => $message, 'errors' => $errors, 'refresh' => $refresh], $status);
        }
        with_errors($errors, $_POST);
        flash('error', $message);
        redirect('/checkout');
    }

    private function done(string $redirect): never
    {
        if (is_ajax()) {
            json_response(['ok' => true, 'redirect' => $redirect]);
        }
        redirect($redirect);
    }
}
