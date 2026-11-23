<?php
/** @var array $customer @var int $orderCount @var int $activeCount @var float $spent @var int $wishCount @var int $addressCount @var array $recent @var string $section */
ob_start(); ?>
<div class="acc-welcome">
  <p class="serif fs-3 mb-1">Hello, <em class="text-cherry"><?= e(explode(' ', $customer['name'])[0]) ?></em></p>
  <p class="text-muted-sa mb-0">From your account you can track orders, manage addresses and update your details.</p>
</div>
<div class="acc-stats">
  <a href="<?= e(url('account/orders')) ?>"><?= icon('package') ?><strong><?= $orderCount ?></strong><span>Total orders</span></a>
  <a href="<?= e(url('account/orders')) ?>"><?= icon('truck') ?><strong><?= $activeCount ?></strong><span>In progress</span></a>
  <a href="<?= e(url('wishlist')) ?>"><?= icon('heart') ?><strong><?= $wishCount ?></strong><span>Wishlist</span></a>
  <a href="<?= e(url('account/addresses')) ?>"><?= icon('pin') ?><strong><?= $addressCount ?></strong><span>Addresses</span></a>
</div>
<div class="acc-card">
  <div class="acc-card-head"><h2>Recent orders</h2><a class="link-arrow" href="<?= e(url('account/orders')) ?>">View all <?= icon('arrow-right') ?></a></div>
  <?php if (!$recent): ?>
    <div class="empty-state py-4"><p>You haven’t placed any orders yet.</p><a class="btn-sa" href="<?= e(url('shop')) ?>">Start shopping</a></div>
  <?php else: ?>
    <?= App\Core\View::partial('front/account/order-rows', ['orders' => $recent]) ?>
  <?php endif; ?>
</div>
<?php $body = ob_get_clean();
echo App\Core\View::partial('front/account/shell', compact('body', 'section', 'customer') + ['title' => 'My', 'italic' => 'account']);
