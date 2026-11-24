<?php
/** @var array $customer @var string $section @var array $order @var array $items @var array $history */
use App\Services\OrderService;

$steps = ['pending' => 'Order placed', 'confirmed' => 'Confirmed', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
$rank = ['pending' => 0, 'processing' => 1, 'confirmed' => 1, 'shipped' => 2, 'delivered' => 3];
$current = $rank[$order['status']] ?? -1;
$cancelled = in_array($order['status'], ['cancelled', 'refunded'], true);
$unpaidOnline = $order['payment_method'] === 'razorpay' && $order['payment_status'] !== 'paid' && $order['status'] === 'pending';
ob_start(); ?>
<div class="acc-card">
  <div class="acc-card-head flex-wrap gap-2">
    <div><h2>Order #<?= e($order['order_number']) ?></h2><small class="text-muted-sa">Placed on <?= format_date($order['created_at'], 'd M Y, h:i A') ?></small></div>
    <span class="status-badge s-<?= e($order['status']) ?>"><?= e(status_label($order['status'])) ?></span>
  </div>
  <?= App\Core\View::partial('front/partials/track-status', ['order' => $order]) ?>
  <?php if ($unpaidOnline): ?>
    <div class="flash flash-info mb-3"><?= icon('alert') ?> Payment pending. <button type="button" class="btn-sa btn-sm ms-auto" data-retry-payment="<?= e($order['order_number']) ?>">Complete payment</button></div>
  <?php endif; ?>
</div>

<div class="order-detail-grid mt-4">
  <div class="summary-card"><h2 class="serif">Items</h2><?= App\Core\View::partial('front/partials/order-items', ['order' => $order, 'items' => $items]) ?></div>
  <div>
    <div class="summary-card mb-4">
      <h2 class="serif">Shipping to</h2>
      <address class="addr"><strong><?= e($order['shipping_name']) ?></strong><br><?= e($order['shipping_address1']) ?><?= $order['shipping_address2'] ? ', ' . e($order['shipping_address2']) : '' ?><br><?= e($order['shipping_city']) ?>, <?= e($order['shipping_state']) ?> <?= e($order['shipping_postal_code']) ?><br><?= e($order['shipping_phone']) ?></address>
      <p class="small mb-0"><strong>Payment:</strong> <?= $order['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Online (Razorpay)' ?> — <?= e(status_label($order['payment_status'])) ?></p>
    </div>
    <div class="summary-card">
      <h2 class="serif">Timeline</h2>
      <ul class="timeline">
        <?php foreach (array_reverse($history) as $h): ?>
          <li><strong><?= e(status_label(str_replace('payment_', 'payment ', $h['status']))) ?></strong><small><?= format_date($h['created_at'], 'd M Y, h:i A') ?></small><?php if ($h['note']): ?><span><?= e($h['note']) ?></span><?php endif; ?></li>
        <?php endforeach; ?>
      </ul>
      <?php if (OrderService::canCustomerCancel($order)): ?>
        <form method="post" action="<?= e(url('account/orders/' . $order['order_number'] . '/cancel')) ?>" class="mt-3 form-sa" data-confirm="Are you sure you want to cancel this order?">
          <?= csrf_field() ?>
          <label class="form-label" for="reason">Reason (optional)</label>
          <select class="form-select mb-3" id="reason" name="reason"><option>Changed my mind</option><option>Ordered by mistake</option><option>Found a better price</option><option>Delivery is taking too long</option><option>Other</option></select>
          <button type="submit" class="btn-sa btn-outline btn-block">Cancel order</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php $body = ob_get_clean();
echo App\Core\View::partial('front/account/shell', compact('body', 'section', 'customer') + ['title' => 'Order', 'italic' => 'details']);
