<?php
/** @var array $order @var array $items @var ?string $note */
$messages = [
    'processing' => 'We’re preparing your order with care.',
    'confirmed' => 'Your order is confirmed and will be packed shortly.',
    'shipped' => 'Good news — your order is on its way!',
    'delivered' => 'Your order has been delivered. We hope you love it.',
    'cancelled' => 'Your order has been cancelled.',
    'refunded' => 'Your refund has been processed to the original payment method.',
    'pending' => 'Your order is awaiting confirmation.',
];
?>
<h1 style="font-family:Georgia,serif;font-weight:normal;font-size:28px;margin:0 0 12px">Order #<?= e($order['order_number']) ?>: <?= e(status_label($order['status'])) ?></h1>
<p><?= e($messages[$order['status']] ?? 'Your order status was updated.') ?></p>
<?php if ($note): ?><p style="background:#EDEBDD;padding:12px 16px;border-radius:10px"><?= e($note) ?></p><?php endif; ?>
<?php if ($order['status'] === 'shipped' && $order['tracking_number']): ?><p>Courier: <strong><?= e($order['courier_name'] ?: '—') ?></strong><br>Tracking number: <strong><?= e($order['tracking_number']) ?></strong></p><?php endif; ?>
<?= App\Core\View::partial('emails/button', ['href' => url('order/' . $order['order_number'], ['key' => $order['access_token']]), 'label' => 'Track your order']) ?>
