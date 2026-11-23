<?php
/** @var array $customer @var string $section @var array $orders @var App\Core\Paginator $pager @var string $status */
ob_start(); ?>
<div class="acc-card">
  <div class="acc-card-head flex-wrap gap-2"><h2>Order history</h2>
    <div class="pill-tabs">
      <a class="pill-tab<?= $status === '' ? ' active' : '' ?>" href="<?= e(url('account/orders')) ?>">All</a>
      <?php foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $s): ?><a class="pill-tab<?= $status === $s ? ' active' : '' ?>" href="<?= e(url('account/orders', ['status' => $s])) ?>"><?= e(status_label($s)) ?></a><?php endforeach; ?>
    </div>
  </div>
  <?php if (!$orders): ?>
    <div class="empty-state py-4"><div class="empty-icon"><?= icon('package') ?></div><p>No orders found.</p><a class="btn-sa" href="<?= e(url('shop')) ?>">Start shopping</a></div>
  <?php else: ?>
    <?= App\Core\View::partial('front/account/order-rows', ['orders' => $orders]) ?>
    <div class="mt-4"><?= App\Core\View::partial('front/partials/pager', ['pager' => $pager, 'path' => 'account/orders']) ?></div>
  <?php endif; ?>
</div>
<?php $body = ob_get_clean();
echo App\Core\View::partial('front/account/shell', compact('body', 'section', 'customer') + ['title' => 'My', 'italic' => 'orders']);
