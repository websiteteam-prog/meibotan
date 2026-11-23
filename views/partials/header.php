<?php
/** @var ?array $customer @var int $cartCount @var int $wishCount */
use App\Services\Layout;

$cats = Layout::categories();
$collections = Layout::collections();
$messages = Layout::announcements();
$phone = (string) setting('site_phone', '');
$featuredCollection = null;
foreach ($collections as $c) {
    if ($c['show_on_home']) { $featuredCollection = $c; break; }
}
$featuredCollection = $featuredCollection ?? ($collections[0] ?? null);
?>
<div class="announce">
  <div class="container-xl">
    <div class="announce-left d-none d-lg-flex">
      <?php if ($phone): ?><a href="tel:<?= e(preg_replace('/[^\d+]/', '', $phone)) ?>"><?= icon('phone') ?> <span>Orders: <?= e($phone) ?></span></a><?php endif; ?>
    </div>
    <div class="announce-rotator" data-rotator aria-live="polite">
      <?php foreach ($messages ?: [setting('site_tagline', 'the art of beauty')] as $i => $m): ?>
        <span class="<?= $i === 0 ? 'is-active' : '' ?>"><?= e($m) ?></span>
      <?php endforeach; ?>
    </div>
    <div class="announce-right d-none d-lg-flex">
      <a href="<?= e(url('account/orders')) ?>">Track order</a>
      <?php if ($customer): ?>
        <a href="<?= e(url('account')) ?>"><?= icon('user') ?> Hi, <?= e(explode(' ', $customer['name'])[0]) ?></a>
      <?php else: ?>
        <a href="<?= e(url('login')) ?>"><?= icon('user') ?> Log in</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<header class="site-header" id="siteHeader">
  <div class="container-xl">
    <div class="header-main">
      <div class="header-left">
        <button class="hdr-btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav" aria-label="Open menu"><?= icon('menu') ?></button>
        <button class="hdr-btn d-lg-none" type="button" data-search-open aria-label="Search"><?= icon('search') ?></button>
        <button class="hdr-search-inline d-none d-lg-inline-flex" type="button" data-search-open><?= icon('search') ?> <span>Search sindoor, tints, kohl…</span></button>
      </div>
      <a href="<?= e(url('/')) ?>" class="brand-logo" aria-label="<?= e(setting('site_name')) ?> — home">
        <img src="<?= e(Layout::logo('maroon')) ?>" alt="<?= e(setting('site_name')) ?>" width="647" height="365">
      </a>
      <div class="header-actions">
        <a class="hdr-btn d-none d-sm-inline-flex" href="<?= e(url($customer ? 'account' : 'login')) ?>" aria-label="My account"><?= icon('user') ?></a>
        <a class="hdr-btn" href="<?= e(url('wishlist')) ?>" aria-label="Wishlist" <?= $customer ? '' : 'data-auth-required="wishlist"' ?>>
          <?= icon('heart') ?><span class="hdr-count" data-wish-count data-count="<?= $wishCount ?>"><?= $wishCount ?></span>
        </a>
        <button class="hdr-btn" type="button" data-cart-open aria-label="Shopping bag">
          <?= icon('bag') ?><span class="hdr-count" data-cart-count data-count="<?= $cartCount ?>"><?= $cartCount ?></span>
        </button>
      </div>
    </div>
  </div>
  <nav class="main-nav d-none d-lg-block" aria-label="Main">
    <ul>
      <li>
        <a href="<?= e(url('shop')) ?>" class="<?= active_path('/shop') ?>">Shop <?= icon('chevron-down') ?></a>
        <div class="mega">
          <div class="container-xl">
            <div class="mega-inner">
              <?php foreach (array_slice($cats, 0, 4) as $c): ?>
              <div class="mega-col">
                <a href="<?= e($c['url']) ?>" class="mega-thumb"><?= img_tag($c['image'], $c['name'], ['sizes' => '260px']) ?></a>
                <h4><a href="<?= e($c['url']) ?>"><?= e($c['name']) ?></a></h4>
                <ul>
                  <?php foreach ($c['subs'] as $s): ?>
                    <li><a href="<?= e(url('category/' . $c['slug'] . '/' . $s['slug'])) ?>"><?= e($s['name']) ?></a></li>
                  <?php endforeach; ?>
                  <li><a href="<?= e($c['url']) ?>"><strong>Shop all <?= e($c['name']) ?></strong></a></li>
                </ul>
              </div>
              <?php endforeach; ?>
              <?php if ($featuredCollection): ?>
              <a class="mega-feature" href="<?= e(url('collection/' . $featuredCollection['slug'])) ?>">
                <?= img_tag($featuredCollection['image'], $featuredCollection['name'], ['sizes' => '360px']) ?>
                <div>
                  <span class="eyebrow eyebrow-light"><?= e($featuredCollection['eyebrow'] ?: 'Collection') ?></span>
                  <h4><?= e($featuredCollection['name']) ?></h4>
                  <span class="btn-sa btn-light btn-sm">Discover <?= icon('arrow-right') ?></span>
                </div>
              </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </li>
      <?php foreach ($cats as $c): ?>
        <li class="<?= $c['subs'] ? 'has-dropdown' : '' ?>">
          <a href="<?= e($c['url']) ?>" class="<?= active_path('/category/' . $c['slug']) ?>"><?= e($c['name']) ?></a>
          <?php if ($c['subs']): ?>
          <ul class="dropdown-simple">
            <?php foreach ($c['subs'] as $s): ?>
              <li><a href="<?= e(url('category/' . $c['slug'] . '/' . $s['slug'])) ?>"><?= e($s['name']) ?></a></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
      <?php if ($collections): ?>
      <li class="has-dropdown">
        <a href="<?= e(url('collection/' . $collections[0]['slug'])) ?>" class="<?= active_path('/collection') ?>">Collections <?= icon('chevron-down') ?></a>
        <ul class="dropdown-simple">
          <?php foreach ($collections as $col): ?>
            <li><a href="<?= e(url('collection/' . $col['slug'])) ?>"><?= e($col['name']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </li>
      <?php endif; ?>
      <li><a href="<?= e(url('about-us')) ?>" class="<?= active_path('/about-us') ?>">Our Story</a></li>
      <li><a href="<?= e(url('contact')) ?>" class="<?= active_path('/contact') ?>">Contact</a></li>
    </ul>
  </nav>
</header>
