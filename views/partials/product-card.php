<?php
/**
 * Product card.
 * @var array $p decorated product (ProductService::decorate)
 * @var string|null $sizes
 */
$sizes = $sizes ?? '(max-width: 576px) 50vw, (max-width: 992px) 33vw, 25vw';
$onSale = $p['discount_percent'] > 0;
$needsChoice = $p['variant_count'] > 0;
$lowStock = $p['in_stock'] && $p['available_qty'] <= (int) setting('low_stock_threshold', 5);
?>
<article class="pcard<?= $p['in_stock'] ? '' : ' is-soldout' ?>" data-product-id="<?= (int) $p['id'] ?>">
  <div class="pcard-media">
    <a href="<?= e($p['url']) ?>" aria-label="<?= e($p['name']) ?>" tabindex="-1">
      <?= img_tag($p['image'], $p['name'], ['class' => 'img-main', 'sizes' => $sizes, 'width' => 600, 'height' => 750]) ?>
      <?php if ($p['hover_image']): ?><?= img_tag($p['hover_image'], '', ['class' => 'img-hover', 'sizes' => $sizes, 'width' => 600, 'height' => 750]) ?><?php endif; ?>
    </a>
    <?php if ($p['badges']): ?>
    <div class="pcard-badges">
      <?php foreach ($p['badges'] as $b): ?><span class="badge-sa type-<?= e($b['type']) ?>"><?= e($b['label']) ?></span><?php endforeach; ?>
    </div>
    <?php endif; ?>
    <button type="button" class="wish-btn<?= $p['in_wishlist'] ? ' is-active' : '' ?>" data-wishlist="<?= (int) $p['id'] ?>" aria-pressed="<?= $p['in_wishlist'] ? 'true' : 'false' ?>" aria-label="<?= $p['in_wishlist'] ? 'Remove from wishlist' : 'Add to wishlist' ?>">
      <?= icon('heart', 'ic-off') ?><?= icon('heart-fill', 'ic-on') ?>
    </button>
    <div class="pcard-actions">
      <?php if (!$p['in_stock']): ?>
        <a class="btn-sa btn-light" href="<?= e($p['url']) ?>">View details</a>
      <?php elseif ($needsChoice): ?>
        <button type="button" class="btn-sa btn-dark" data-quick-view="<?= (int) $p['id'] ?>">Choose <?= e(strtolower($p['variant_label'] ?: 'option')) ?></button>
      <?php else: ?>
        <button type="button" class="btn-sa btn-dark" data-add-to-cart="<?= (int) $p['id'] ?>"><?= icon('bag') ?> Add to bag</button>
      <?php endif; ?>
      <button type="button" class="btn-qv" data-quick-view="<?= (int) $p['id'] ?>" aria-label="Quick view <?= e($p['name']) ?>"><?= icon('eye') ?></button>
    </div>
  </div>
  <div class="pcard-body">
    <?php if (!empty($p['category_name'])): ?><span class="pcard-cat"><?= e($p['category_name']) ?></span><?php endif; ?>
    <h3 class="pcard-title"><a href="<?= e($p['url']) ?>"><?= e($p['name']) ?></a></h3>
    <div class="pcard-meta">
      <span class="price<?= $onSale ? ' on-sale' : '' ?>">
        <?php if ($p['from_price']): ?><span class="price-from">From</span> <span class="price-now"><?= money($p['from_price']) ?></span>
        <?php else: ?>
          <span class="price-now"><?= money($p['final_price']) ?></span>
          <?php if ($onSale): ?><span class="price-old"><?= money($p['regular_price']) ?></span><span class="price-off">-<?= (int) $p['discount_percent'] ?>%</span><?php endif; ?>
        <?php endif; ?>
      </span>
      <?php if ($p['swatches']): ?>
        <span class="swatches" aria-label="<?= (int) $p['variant_count'] ?> shades"><?php foreach ($p['swatches'] as $sw): ?><i style="background:<?= e($sw) ?>"></i><?php endforeach; ?><?php if ($p['variant_count'] > count($p['swatches'])): ?><small>+<?= $p['variant_count'] - count($p['swatches']) ?></small><?php endif; ?></span>
      <?php endif; ?>
    </div>
    <?php if ((int) $p['rating_count'] > 0): ?>
      <span class="rating-line"><?= stars((float) $p['rating_avg']) ?> (<?= (int) $p['rating_count'] ?>)</span>
    <?php elseif ($lowStock && !$needsChoice): ?>
      <span class="stock-low">Only <?= (int) $p['available_qty'] ?> left</span>
    <?php endif; ?>
  </div>
</article>
