<?php /** @var ?array $order @var array $items @var array $history */ ?>
<section class="page-hero slim">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/breadcrumbs', ['crumbs' => [['Home', url('/')], ['Track order', null]]]) ?>
    <h1 class="display-title">Track your <em>order</em></h1>
    <p class="page-hero-sub">Enter your order number and the e-mail or phone number used at checkout.</p>
  </div>
</section>
<section class="section-tight" style="padding-top:34px">
  <div class="container-xl">
    <div class="track-layout">
      <form method="post" action="<?= e(url('track-order')) ?>" class="summary-card form-sa" novalidate style="position:static">
        <?= csrf_field() ?>
        <h2 class="serif">Find my order</h2>
        <div class="mb-3"><label class="form-label" for="order_number">Order number</label><input class="form-control<?= invalid('order_number') ?>" id="order_number" name="order_number" required placeholder="e.g. SA2611241234" value="<?= e(old('order_number', $order['order_number'] ?? '')) ?>"><?= error_for('order_number') ?></div>
        <div class="mb-4"><label class="form-label" for="contact">E-mail or phone</label><input class="form-control<?= invalid('contact') ?>" id="contact" name="contact" required value="<?= e(old('contact')) ?>"><?= error_for('contact') ?></div>
        <button type="submit" class="btn-sa btn-block"><?= icon('search', 'ic-sm') ?> Track order</button>
        <p class="small text-muted-sa mt-3 mb-0">Your order number is in your confirmation e-mail. <?php if (!customer()): ?><a href="<?= e(url('login', ['redirect' => '/account/orders'])) ?>">Log in</a> to see all your orders.<?php endif; ?></p>
      </form>

      <?php if ($order): ?>
      <div>
        <div class="acc-card mb-4">
          <div class="acc-card-head flex-wrap gap-2">
            <div><h2>Order #<?= e($order['order_number']) ?></h2><small class="text-muted-sa">Placed on <?= format_date($order['created_at'], 'd M Y, h:i A') ?> · <?= e(plural((int) array_sum(array_column($items, 'quantity')), 'item')) ?> · <?= money($order['total']) ?></small></div>
            <span class="status-badge s-<?= e($order['status']) ?>"><?= e(status_label($order['status'])) ?></span>
          </div>
          <?= App\Core\View::partial('front/partials/track-status', ['order' => $order]) ?>
        </div>
        <div class="summary-card" style="position:static">
          <h2 class="serif">Updates</h2>
          <ul class="timeline">
            <?php foreach (array_reverse($history) as $h): ?>
              <li><strong><?= e(status_label(str_replace('payment_', 'payment ', $h['status']))) ?></strong><small><?= format_date($h['created_at'], 'd M Y, h:i A') ?></small><?php if ($h['note']): ?><span><?= e($h['note']) ?></span><?php endif; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <?php else: ?>
      <div class="track-help">
        <div class="contact-tile"><span class="po-icon"><?= icon('package') ?></span><span><small>Step 1</small><strong>We confirm and pack your order</strong></span></div>
        <div class="contact-tile"><span class="po-icon"><?= icon('truck') ?></span><span><small>Step 2</small><strong>It ships — you get the courier name, tracking number and link by e-mail</strong></span></div>
        <div class="contact-tile"><span class="po-icon"><?= icon('home') ?></span><span><small>Step 3</small><strong>Delivered to your door, usually in 3–7 business days</strong></span></div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
