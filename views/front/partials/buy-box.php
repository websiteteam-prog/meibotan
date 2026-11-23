<?php
/**
 * Price, variant selector, quantity and actions — shared by the product page and quick view.
 * @var array $p hydrated product  @var bool $compact
 */
$compact = $compact ?? false;
$variantsJson = array_map(static fn($v) => [
    'id' => (int) $v['id'], 'name' => $v['name'], 'price' => (float) $v['final_price'], 'regular' => (float) $v['regular_price'],
    'off' => (int) $v['discount_percent'], 'qty' => (int) $v['available_qty'], 'sku' => $v['sku'] ?: $p['sku'],
    'image' => $v['image'] ? upload_url($v['image'], '600') : null,
], $p['variants']);
$first = null;
foreach ($p['variants'] as $v) { if ($v['available_qty'] > 0) { $first = $v; break; } }
$first = $first ?? ($p['variants'][0] ?? null);
$showPrice = $first ? (float) $first['final_price'] : (float) $p['final_price'];
$showRegular = $first ? (float) $first['regular_price'] : (float) $p['regular_price'];
$off = $first ? (int) $first['discount_percent'] : (int) $p['discount_percent'];
$label = $p['variant_label'] ?: 'Option';
?>
<div class="buy-price">
  <span class="price price-lg<?= $showRegular > $showPrice ? ' on-sale' : '' ?>" data-price>
    <span class="price-now" data-price-now><?= money($showPrice) ?></span>
    <span class="price-old" data-price-old <?= $showRegular > $showPrice ? '' : 'hidden' ?>><?= $showRegular > $showPrice ? money($showRegular) : '' ?></span>
    <span class="price-off" data-price-off <?= $off ? '' : 'hidden' ?>><?= $off ? '-' . $off . '%' : '' ?></span>
  </span>
  <?php if (setting('tax_enabled') === '1' && setting('prices_include_tax') === '1'): ?><small class="tax-note">Inclusive of all taxes</small><?php endif; ?>
</div>

<form class="buy-form" data-product-form data-product-id="<?= (int) $p['id'] ?>" data-base-stock="<?= (int) $p['available_qty'] ?>" data-low="<?= (int) setting('low_stock_threshold', 5) ?>"
      data-variant-label="<?= e($label) ?>" data-variants='<?= e(json_encode($variantsJson, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?>' novalidate>
  <input type="hidden" name="variant_id" value="">
  <?php if ($p['variants']): ?>
  <div class="variant-block">
    <div class="variant-head"><span><?= e($label) ?>:</span> <strong data-variant-name><?= e($first['name'] ?? '') ?></strong></div>
    <div class="variant-list" role="radiogroup" aria-label="<?= e($label) ?>">
      <?php foreach ($p['variants'] as $v): $out = $v['available_qty'] <= 0; ?>
        <button type="button" class="variant<?= $v['swatch'] ? ' has-swatch' : '' ?><?= $out ? ' is-out' : '' ?><?= $first && $first['id'] === $v['id'] ? ' active' : '' ?>" data-variant="<?= (int) $v['id'] ?>" role="radio" aria-checked="false" title="<?= e($v['name'] . ($out ? ' — out of stock' : '')) ?>">
          <?php if ($v['swatch']): ?><i style="background:<?= e($v['swatch']) ?>"></i><?php endif; ?>
          <span><?= e($v['name']) ?></span>
        </button>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

  <div class="stock-line"><span class="stock-pill in" data-stock>In stock</span><?php if (!$compact): ?><span class="sku">SKU: <span data-sku><?= e($first['sku'] ?? $p['sku']) ?></span></span><?php endif; ?></div>

  <div class="buy-actions">
    <div class="qty qty-lg" data-qty>
      <button type="button" data-qty-minus aria-label="Decrease quantity"><?= icon('minus') ?></button>
      <input type="number" name="quantity" value="1" min="1" max="<?= max(1, (int) $p['available_qty']) ?>" aria-label="Quantity">
      <button type="button" data-qty-plus aria-label="Increase quantity"><?= icon('plus') ?></button>
    </div>
    <button type="submit" class="btn-sa btn-dark buy-add" data-requires-stock><?= icon('bag') ?> Add to bag</button>
    <?php if (!$compact): ?>
    <button type="button" class="btn-icon wish-lg<?= $p['in_wishlist'] ? ' is-active' : '' ?>" data-wishlist="<?= (int) $p['id'] ?>" aria-pressed="<?= $p['in_wishlist'] ? 'true' : 'false' ?>" aria-label="Add to wishlist"><?= icon('heart', 'ic-off') ?><?= icon('heart-fill', 'ic-on') ?></button>
    <?php endif; ?>
  </div>
  <button type="submit" class="btn-sa btn-block buy-now" data-buy-now data-requires-stock>Buy it now</button>
</form>
