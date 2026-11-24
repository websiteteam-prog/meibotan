<?php
/**
 * Order progress steps + courier details. Used on the account order page and the public tracking page.
 * @var array $order
 */
$steps = ['pending' => 'Order placed', 'confirmed' => 'Confirmed', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
$rank = ['pending' => 0, 'processing' => 1, 'confirmed' => 1, 'shipped' => 2, 'delivered' => 3];
$current = $rank[$order['status']] ?? -1;
$cancelled = in_array($order['status'], ['cancelled', 'refunded'], true);
?>
<?php if ($cancelled): ?>
  <div class="flash flash-error mt-0 mb-3"><?= icon('alert') ?> This order was <?= e($order['status']) ?><?= $order['cancel_reason'] ? ': ' . e($order['cancel_reason']) : '' ?>.</div>
<?php else: ?>
  <ol class="track-steps">
    <?php $i = 0; foreach ($steps as $label): ?>
      <li class="<?= $i <= $current ? 'done' : '' ?><?= $i === $current ? ' current' : '' ?>"><span><?= icon($i <= $current ? 'check' : ['package', 'check-circle', 'truck', 'home'][$i]) ?></span><?= e($label) ?></li>
    <?php $i++; endforeach; ?>
  </ol>
<?php endif; ?>
<?php if ($order['tracking_number'] || !empty($order['tracking_url'])): ?>
  <div class="tracking-box">
    <?= icon('truck') ?>
    <span>Shipped via <strong><?= e($order['courier_name'] ?: 'our courier partner') ?></strong><?php if ($order['tracking_number']): ?> · Tracking no. <strong><?= e($order['tracking_number']) ?></strong><?php endif; ?></span>
    <?php if (!empty($order['tracking_url'])): ?><a class="btn-sa btn-sm ms-auto" href="<?= e($order['tracking_url']) ?>" target="_blank" rel="noopener nofollow">Track shipment <?= icon('external', 'ic-sm') ?></a><?php endif; ?>
  </div>
<?php elseif (!$cancelled && $current < 2): ?>
  <p class="small text-muted-sa mb-0"><?= icon('clock', 'ic-sm') ?> Courier tracking details will appear here (and be e-mailed to you) as soon as your order ships.</p>
<?php endif; ?>
