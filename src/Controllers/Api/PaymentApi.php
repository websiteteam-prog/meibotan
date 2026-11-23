<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Controllers\Front\CheckoutController;
use App\Core\DB;
use App\Core\Http;
use App\Core\Session;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\Razorpay;
use RuntimeException;

/**
 * Razorpay payment callbacks.
 */
final class PaymentApi
{
    public function __construct()
    {
        Http::noCache();
    }

    /** Called by Checkout.js on success — verifies the HMAC signature before marking paid. */
    public function verify(): void
    {
        $order = OrderService::findByNumber((string) input('order_number', ''));
        if (!$order || !CheckoutController::canView($order)) {
            json_response(['ok' => false, 'message' => 'Order not found.'], 404);
        }
        $gatewayOrderId = (string) input('razorpay_order_id', '');
        $paymentId = (string) input('razorpay_payment_id', '');
        $signature = (string) input('razorpay_signature', '');
        $payment = DB::one('SELECT * FROM payments WHERE order_id = :o AND gateway_order_id = :g', ['o' => $order['id'], 'g' => $gatewayOrderId]);
        if (!$payment || !Razorpay::verifySignature($gatewayOrderId, $paymentId, $signature)) {
            log_message('razorpay', 'Signature verification failed for ' . $order['order_number']);
            DB::exec("UPDATE payments SET status = 'failed', error_message = 'Signature verification failed' WHERE order_id = :o AND gateway_order_id = :g", ['o' => $order['id'], 'g' => $gatewayOrderId]);
            json_response(['ok' => false, 'message' => 'We could not verify your payment. If money was deducted it will be refunded automatically — please contact us.'], 400);
        }
        $wasPaid = $order['payment_status'] === 'paid';
        OrderService::markPaid($order, $gatewayOrderId, $paymentId, $signature, $_POST);
        if ((int) Session::get('pending_order_id', 0) === (int) $order['id']) {
            CartService::clear();
            Session::forget('pending_order_id');
        }
        Session::put('last_order', $order['order_number']);
        if (!$wasPaid) {
            OrderService::sendPlacedEmails(OrderService::find((int) $order['id']));
        }
        json_response(['ok' => true, 'redirect' => url('order/' . $order['order_number'], ['key' => $order['access_token']])]);
    }

    /** Checkout.js reported a failure or the customer closed the payment window. */
    public function failed(): void
    {
        $order = OrderService::findByNumber((string) input('order_number', ''));
        if ($order && CheckoutController::canView($order) && $order['payment_status'] !== 'paid') {
            $reason = mb_substr((string) input('reason', 'failed'), 0, 250);
            DB::exec("UPDATE payments SET status = 'failed', error_message = :r WHERE order_id = :o AND status <> 'paid' ORDER BY id DESC LIMIT 1", ['r' => $reason, 'o' => $order['id']]);
            DB::update('orders', ['payment_status' => 'failed'], 'id = :id', ['id' => $order['id']]);
        }
        json_response(['ok' => true]);
    }

    /** Start a new Razorpay attempt for an unpaid order (from the order page). */
    public function retry(): void
    {
        $order = OrderService::findByNumber((string) input('order_number', ''));
        if (!$order || !CheckoutController::canView($order)) {
            json_response(['ok' => false, 'message' => 'Order not found.'], 404);
        }
        if ($order['payment_method'] !== 'razorpay' || $order['payment_status'] === 'paid' || $order['status'] !== 'pending') {
            json_response(['ok' => false, 'message' => 'This order does not need a payment.'], 422);
        }
        if (!Razorpay::enabled()) {
            json_response(['ok' => false, 'message' => 'Online payments are currently unavailable.'], 503);
        }
        try {
            $rz = Razorpay::createOrder((float) $order['total'], $order['order_number'], ['order_number' => $order['order_number']]);
        } catch (RuntimeException $e) {
            json_response(['ok' => false, 'message' => $e->getMessage()], 502);
        }
        DB::insert('payments', ['order_id' => $order['id'], 'method' => 'razorpay', 'gateway_order_id' => $rz['id'], 'amount' => $order['total'], 'currency' => $order['currency'], 'status' => 'created', 'created_at' => now()]);
        Session::put('last_order', $order['order_number']);
        json_response(['ok' => true, 'razorpay' => CheckoutController::razorpayOptions($order, $rz['id'])]);
    }

    /**
     * Razorpay webhook (configure URL: /api/payment/razorpay/webhook, events:
     * payment.captured, payment.failed, order.paid, refund.processed).
     */
    public function webhook(): void
    {
        $body = (string) file_get_contents('php://input');
        $sig = (string) ($_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '');
        if (!Razorpay::verifyWebhook($body, $sig)) {
            json_response(['ok' => false, 'message' => 'Invalid signature'], 400);
        }
        $event = json_decode($body, true) ?: [];
        $type = (string) ($event['event'] ?? '');
        $paymentEntity = $event['payload']['payment']['entity'] ?? [];
        $gatewayOrderId = (string) ($paymentEntity['order_id'] ?? ($event['payload']['order']['entity']['id'] ?? ''));
        $payment = $gatewayOrderId !== '' ? DB::one('SELECT * FROM payments WHERE gateway_order_id = :g', ['g' => $gatewayOrderId]) : null;
        if ($payment) {
            $order = OrderService::find((int) $payment['order_id']);
            if ($order && in_array($type, ['payment.captured', 'order.paid'], true) && $order['payment_status'] !== 'paid') {
                OrderService::markPaid($order, $gatewayOrderId, (string) ($paymentEntity['id'] ?? ''), 'webhook', $event);
                OrderService::sendPlacedEmails(OrderService::find((int) $order['id']));
            } elseif ($order && $type === 'payment.failed' && $order['payment_status'] !== 'paid') {
                DB::update('orders', ['payment_status' => 'failed'], 'id = :id', ['id' => $order['id']]);
                DB::exec("UPDATE payments SET status = 'failed', error_message = :m WHERE id = :id", ['m' => mb_substr((string) ($paymentEntity['error_description'] ?? 'failed'), 0, 250), 'id' => $payment['id']]);
            }
        }
        log_message('razorpay', 'Webhook ' . $type . ' ' . $gatewayOrderId);
        json_response(['ok' => true]);
    }
}
