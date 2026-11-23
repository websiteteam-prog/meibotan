<?php
/** @var string $body @var string $section @var array $customer @var string $title @var string $italic */
$nav = [
    'dashboard' => ['account', 'home', 'Overview'],
    'orders' => ['account/orders', 'package', 'Orders'],
    'wishlist' => ['wishlist', 'heart', 'Wishlist'],
    'addresses' => ['account/addresses', 'pin', 'Addresses'],
    'profile' => ['account/profile', 'user', 'Profile'],
    'password' => ['account/password', 'lock', 'Password'],
];
$active = $section === 'order' ? 'orders' : $section;
?>
<section class="page-hero slim">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/breadcrumbs', ['crumbs' => array_values(array_filter([['Home', url('/')], ['My account', $section === 'dashboard' ? null : url('account')], $section === 'dashboard' ? null : [$title . ' ' . $italic, null]]))]) ?>
    <h1 class="display-title"><?= e($title) ?> <em><?= e($italic) ?></em></h1>
  </div>
</section>
<section class="section-tight" style="padding-top:34px">
  <div class="container-xl">
    <div class="account-layout">
      <aside class="account-nav">
        <div class="acc-user">
          <span class="t-avatar"><?= e(mb_strtoupper(mb_substr($customer['name'], 0, 1))) ?></span>
          <div><strong><?= e($customer['name']) ?></strong><small><?= e($customer['email']) ?></small></div>
        </div>
        <nav aria-label="Account">
          <?php foreach ($nav as $key => [$path, $ic, $label]): ?>
            <a href="<?= e(url($path)) ?>" class="<?= $active === $key ? 'active' : '' ?>"><?= icon($ic) ?> <?= e($label) ?></a>
          <?php endforeach; ?>
          <form method="post" action="<?= e(url('logout')) ?>"><?= csrf_field() ?><button type="submit"><?= icon('logout') ?> Log out</button></form>
        </nav>
      </aside>
      <div class="account-main"><?= $body ?></div>
    </div>
  </div>
</section>
