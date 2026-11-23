<?php /** @var array $order @var array $items */ ?>
<h1 style="font-family:Georgia,serif;font-weight:normal;font-size:26px;margin:0 0 12px">New order #<?= e($order['order_number']) ?></h1>
<p><strong><?= e($order['customer_name']) ?></strong> (<?= e($order['customer_email']) ?>, <?= e($order['customer_phone']) ?>) placed an order of <strong><?= money($order['total']) ?></strong> — <?= $order['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Online payment' ?> (<?= e($order['payment_status']) ?>).</p>
<?= App\Core\View::partial('emails/order-table', ['order' => $order, 'items' => $items]) ?>
<?= App\Core\View::partial('emails/button', ['href' => url('admin/orders/' . $order['id']), 'label' => 'Open in admin']) ?>
