<?php
/** @var array $order @var array $items @var array $history */
$unpaidOnline = $order['payment_method'] === 'razorpay' && $order['payment_status'] !== 'paid' && $order['status'] === 'pending';
$cancelled = in_array($order['status'], ['cancelled', 'refunded'], true);
?>
<section class="section-tight">
  <div class="container-xl">
    <div class="success-card">
      <div class="success-mark<?= $unpaidOnline || $cancelled ? ' is-pending' : '' ?>">
        <?php if ($unpaidOnline || $cancelled): ?><?= icon('alert') ?><?php else: ?>
        <svg viewBox="0 0 52 52" aria-hidden="true"><circle cx="26" cy="26" r="24" fill="none"/><path fill="none" d="M15 27l7 7 15-16"/></svg><?php endif; ?>
      </div>
      <?php if ($cancelled): ?>
        <span class="eyebrow">Order <?= e($order['order_number']) ?></span>
        <h1 class="display-title">This order was <em>cancelled</em></h1>
        <p class="lead-sub"><?= e($order['cancel_reason'] ?: 'If you have any questions, please contact us.') ?></p>
      <?php elseif ($unpaidOnline): ?>
        <span class="eyebrow">Order <?= e($order['order_number']) ?></span>
        <h1 class="display-title">Almost <em>there</em></h1>
        <p class="lead-sub">Your order is reserved, but we haven’t received the payment yet. Complete it below to confirm your order.</p>
        <button type="button" class="btn-sa mt-2" data-retry-payment="<?= e($order['order_number']) ?>" data-key="<?= e($order['access_token']) ?>"><?= icon('lock') ?> Complete payment · <?= money($order['total']) ?></button>
      <?php else: ?>
        <span class="eyebrow">Thank you, <?= e(explode(' ', $order['customer_name'])[0]) ?></span>
        <h1 class="display-title">Your order is <em>confirmed</em></h1>
        <p class="lead-sub">We’ve sent a confirmation to <strong><?= e($order['customer_email']) ?></strong>. We’ll let you know as soon as it ships.</p>
      <?php endif; ?>
      <div class="success-meta">
        <div><span>Order number</span><strong><?= e($order['order_number']) ?></strong></div>
        <div><span>Date</span><strong><?= format_date($order['created_at'], 'd M Y') ?></strong></div>
        <div><span>Total</span><strong><?= money($order['total']) ?></strong></div>
        <div><span>Payment</span><strong><?= $order['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Online' ?> · <?= e(status_label($order['payment_status'])) ?></strong></div>
      </div>
    </div>

    <div class="order-detail-grid">
      <div class="summary-card">
        <h2 class="serif">Items</h2>
        <?= App\Core\View::partial('front/partials/order-items', ['order' => $order, 'items' => $items]) ?>
      </div>
      <div class="summary-card">
        <h2 class="serif">Delivery</h2>
        <address class="addr">
          <strong><?= e($order['shipping_name']) ?></strong><br>
          <?= e($order['shipping_address1']) ?><?= $order['shipping_address2'] ? ', ' . e($order['shipping_address2']) : '' ?><br>
          <?= e($order['shipping_city']) ?>, <?= e($order['shipping_state']) ?> <?= e($order['shipping_postal_code']) ?><br>
          <?= e($order['shipping_country']) ?><br><?= e($order['shipping_phone']) ?>
        </address>
        <?php if ($order['notes']): ?><p class="small text-muted-sa"><strong>Notes:</strong> <?= e($order['notes']) ?></p><?php endif; ?>
        <div class="d-grid gap-2 mt-4">
          <?php if (customer()): ?><a href="<?= e(url('account/orders/' . $order['order_number'])) ?>" class="btn-sa btn-dark">Track this order</a><?php endif; ?>
          <a href="<?= e(url('shop')) ?>" class="btn-sa btn-outline">Continue shopping</a>
        </div>
      </div>
    </div>
  </div>
</section>
