<?php /** @var array $order @var array $items */ ?>
<h1 style="font-family:Georgia,serif;font-weight:normal;font-size:28px;margin:0 0 12px">Thank you, <?= e(explode(' ', $order['customer_name'])[0]) ?>.</h1>
<p>We’ve received your order <strong>#<?= e($order['order_number']) ?></strong><?= $order['payment_status'] === 'paid' ? ' and your payment was successful' : ($order['payment_method'] === 'cod' ? ' — you’ll pay on delivery' : '') ?>. We’ll e-mail you again when it ships.</p>
<?= App\Core\View::partial('emails/order-table', ['order' => $order, 'items' => $items]) ?>
<p style="margin:0"><strong>Delivering to</strong><br><?= e($order['shipping_name']) ?>, <?= e($order['shipping_address1']) ?><?= $order['shipping_address2'] ? ', ' . e($order['shipping_address2']) : '' ?>, <?= e($order['shipping_city']) ?>, <?= e($order['shipping_state']) ?> <?= e($order['shipping_postal_code']) ?></p>
<?= App\Core\View::partial('emails/button', ['href' => url('order/' . $order['order_number'], ['key' => $order['access_token']]), 'label' => 'View your order']) ?>
