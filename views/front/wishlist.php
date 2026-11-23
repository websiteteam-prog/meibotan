<?php /** @var array $items */ ?>
<section class="page-hero slim">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/breadcrumbs', ['crumbs' => [['Home', url('/')], ['My account', url('account')], ['Wishlist', null]]]) ?>
    <h1 class="display-title">My <em>wishlist</em></h1>
    <?php if ($items): ?><p class="page-hero-sub"><?= e(plural(count($items), 'piece')) ?> saved for later.</p><?php endif; ?>
  </div>
</section>
<section class="section-tight" style="padding-top:30px">
  <div class="container-xl">
    <?php if (!$items): ?>
      <div class="empty-state py-5">
        <div class="empty-icon"><?= icon('heart') ?></div>
        <h3>No products in your wishlist yet.</h3>
        <p>Tap the heart on any product to save it here for later.</p>
        <a href="<?= e(url('shop')) ?>" class="btn-sa">Explore Products <?= icon('arrow-right') ?></a>
      </div>
    <?php else: ?>
      <div class="wish-list">
        <?php foreach ($items as $p): ?>
        <div class="wish-row" data-wishlist-row>
          <a href="<?= e($p['url']) ?>" class="wr-img"><?= img_tag($p['image'], $p['name'], ['sizes' => '120px', 'width' => 120, 'height' => 150]) ?></a>
          <div class="wr-info">
            <span class="pcard-cat"><?= e($p['category_name'] ?? '') ?></span>
            <a class="cl-name" href="<?= e($p['url']) ?>"><?= e($p['name']) ?></a>
            <span class="price<?= $p['discount_percent'] ? ' on-sale' : '' ?>"><span class="price-now"><?= money($p['from_price'] ?? $p['final_price']) ?></span><?php if ($p['discount_percent'] && !$p['from_price']): ?><span class="price-old"><?= money($p['regular_price']) ?></span><span class="price-off">-<?= (int) $p['discount_percent'] ?>%</span><?php endif; ?></span>
          </div>
          <div class="wr-stock"><span class="stock-pill <?= $p['in_stock'] ? 'in' : 'out' ?>"><?= $p['in_stock'] ? 'In stock' : 'Out of stock' ?></span></div>
          <div class="wr-actions">
            <?php if (!$p['in_stock']): ?>
              <a class="btn-sa btn-outline btn-sm" href="<?= e($p['url']) ?>">View</a>
            <?php elseif ($p['variant_count'] > 0): ?>
              <button type="button" class="btn-sa btn-dark btn-sm" data-quick-view="<?= (int) $p['id'] ?>">Choose <?= e(strtolower($p['variant_label'] ?: 'option')) ?></button>
            <?php else: ?>
              <button type="button" class="btn-sa btn-dark btn-sm" data-add-to-cart="<?= (int) $p['id'] ?>"><?= icon('bag') ?> Add to bag</button>
            <?php endif; ?>
            <form method="post" action="<?= e(url('wishlist/' . (int) $p['id'] . '/remove')) ?>" class="d-inline">
              <?= csrf_field() ?>
              <button type="submit" class="btn-icon" data-wishlist="<?= (int) $p['id'] ?>" aria-label="Remove <?= e($p['name']) ?> from wishlist"><?= icon('trash') ?></button>
            </form>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
