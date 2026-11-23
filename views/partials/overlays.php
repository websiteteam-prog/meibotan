<?php
/** @var ?array $customer @var int $cartCount */
use App\Services\Layout;

$cats = Layout::categories();
$collections = Layout::collections();
$redirect = request_path() . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '');
?>
<!-- Mobile navigation -->
<div class="offcanvas offcanvas-start mobile-nav" tabindex="-1" id="mobileNav" aria-label="Menu">
  <div class="offcanvas-header">
    <img src="<?= e(Layout::logo('maroon')) ?>" alt="<?= e(setting('site_name')) ?>" width="647" height="365">
    <button type="button" class="btn-icon" data-bs-dismiss="offcanvas" aria-label="Close"><?= icon('close') ?></button>
  </div>
  <div class="offcanvas-body">
    <ul class="m-menu">
      <li><a href="<?= e(url('shop')) ?>">Shop all <?= icon('arrow-right') ?></a></li>
      <?php foreach ($cats as $i => $c): ?>
      <li>
        <button type="button" data-bs-toggle="collapse" data-bs-target="#mcat<?= $i ?>" aria-expanded="false"><?= e($c['name']) ?> <?= icon('chevron-down') ?></button>
        <div class="collapse" id="mcat<?= $i ?>">
          <ul class="m-sub">
            <?php foreach ($c['subs'] as $s): ?><li><a href="<?= e(url('category/' . $c['slug'] . '/' . $s['slug'])) ?>"><?= e($s['name']) ?></a></li><?php endforeach; ?>
            <li><a href="<?= e($c['url']) ?>"><strong>Shop all <?= e($c['name']) ?></strong></a></li>
          </ul>
        </div>
      </li>
      <?php endforeach; ?>
      <?php if ($collections): ?>
      <li>
        <button type="button" data-bs-toggle="collapse" data-bs-target="#mcols" aria-expanded="false">Collections <?= icon('chevron-down') ?></button>
        <div class="collapse" id="mcols"><ul class="m-sub">
          <?php foreach ($collections as $col): ?><li><a href="<?= e(url('collection/' . $col['slug'])) ?>"><?= e($col['name']) ?></a></li><?php endforeach; ?>
        </ul></div>
      </li>
      <?php endif; ?>
      <li><a href="<?= e(url('about-us')) ?>">Our story</a></li>
      <li><a href="<?= e(url('contact')) ?>">Contact</a></li>
    </ul>
    <div class="m-account">
      <?php if ($customer): ?>
        <a class="btn-sa btn-dark" href="<?= e(url('account')) ?>"><?= icon('user') ?> My account</a>
        <a class="btn-sa btn-outline" href="<?= e(url('wishlist')) ?>"><?= icon('heart') ?> Wishlist</a>
      <?php else: ?>
        <a class="btn-sa btn-dark" href="<?= e(url('login')) ?>">Log in</a>
        <a class="btn-sa btn-outline" href="<?= e(url('register')) ?>">Create account</a>
      <?php endif; ?>
    </div>
    <div class="m-contact">
      <?php if (setting('site_phone')): ?><a href="tel:<?= e(preg_replace('/[^\d+]/', '', (string) setting('site_phone'))) ?>"><?= icon('phone') ?> <?= e(setting('site_phone')) ?></a><?php endif; ?>
      <?php if (setting('site_email')): ?><a href="mailto:<?= e(setting('site_email')) ?>"><?= icon('mail') ?> <?= e(setting('site_email')) ?></a><?php endif; ?>
    </div>
  </div>
</div>

<!-- Cart drawer -->
<div class="offcanvas offcanvas-end cart-drawer" tabindex="-1" id="cartDrawer" aria-labelledby="cartDrawerTitle">
  <div class="offcanvas-header">
    <h2 class="offcanvas-title" id="cartDrawerTitle">Your bag <small data-cart-label><?= e(plural($cartCount, 'item')) ?></small></h2>
    <button type="button" class="btn-icon" data-bs-dismiss="offcanvas" aria-label="Close"><?= icon('close') ?></button>
  </div>
  <div class="offcanvas-body" data-mini-cart>
    <div class="qv-loading"><div class="spinner"></div></div>
  </div>
</div>

<!-- Search -->
<div class="search-panel" id="searchPanel" role="dialog" aria-modal="true" aria-label="Search">
  <div class="search-backdrop" data-search-close></div>
  <div class="search-sheet">
    <div class="container-xl">
      <form class="search-form" action="<?= e(url('search')) ?>" method="get" role="search">
        <?= icon('search') ?>
        <input type="search" name="q" placeholder="What are you looking for?" autocomplete="off" aria-label="Search products" data-search-input>
        <button type="button" class="btn-icon" data-search-close aria-label="Close search"><?= icon('close') ?></button>
      </form>
      <div class="search-hints">
        <span>Popular:</span>
        <?php foreach (array_slice($cats, 0, 4) as $c): ?><a class="chip" href="<?= e($c['url']) ?>"><?= e($c['name']) ?></a><?php endforeach; ?>
        <a class="chip" href="<?= e(url('shop', ['sort' => 'bestselling'])) ?>">Best sellers</a>
      </div>
      <div class="search-results" data-search-results></div>
    </div>
  </div>
</div>

<!-- Quick view -->
<div class="modal fade qv-modal" id="quickView" tabindex="-1" aria-label="Quick view" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <button type="button" class="btn-icon modal-close" data-bs-dismiss="modal" aria-label="Close"><?= icon('close') ?></button>
      <div class="qv-body" data-qv-body><div class="qv-loading"><div class="spinner"></div></div></div>
    </div>
  </div>
</div>

<!-- Sign-in required (wishlist) -->
<div class="modal fade auth-modal" id="authRequired" tabindex="-1" aria-labelledby="authRequiredTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:460px">
    <div class="modal-content">
      <button type="button" class="btn-icon modal-close" data-bs-dismiss="modal" aria-label="Close"><?= icon('close') ?></button>
      <div class="modal-body">
        <div class="auth-icon"><?= icon('heart') ?></div>
        <h3 id="authRequiredTitle">Save your <em class="text-cherry">favourites</em></h3>
        <p data-auth-text>Please sign in or create an account to add products to your wishlist. We’ll save this piece for you as soon as you’re in.</p>
        <div class="btns">
          <a class="btn-sa" data-auth-login href="<?= e(url('login', ['redirect' => $redirect])) ?>">Log in</a>
          <a class="btn-sa btn-outline" data-auth-register href="<?= e(url('register', ['redirect' => $redirect])) ?>">Create an account</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="toast-stack" data-toasts aria-live="polite"></div>
<button class="to-top" type="button" data-to-top aria-label="Back to top"><?= icon('arrow-right') ?></button>
