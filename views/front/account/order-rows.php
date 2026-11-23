<?php /** @var array $orders */ ?>
<div class="order-rows">
  <?php foreach ($orders as $o): ?>
  <a class="order-row" href="<?= e(url('account/orders/' . $o['order_number'])) ?>">
    <span class="or-id"><strong>#<?= e($o['order_number']) ?></strong><small><?= format_date($o['created_at'], 'd M Y, h:i A') ?></small></span>
    <span class="status-badge s-<?= e($o['status']) ?>"><?= e(status_label($o['status'])) ?></span>
    <span class="or-pay"><?= $o['payment_method'] === 'cod' ? 'COD' : 'Online' ?> · <?= e(status_label($o['payment_status'])) ?></span>
    <span class="or-total"><?= money($o['total']) ?></span>
    <?= icon('chevron-right') ?>
  </a>
  <?php endforeach; ?>
</div>
