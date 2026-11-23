<?php
/**
 * Mini cart (drawer body). Rendered on demand via /api/cart.
 * @var array $items @var array $totals @var int|null $highlight item id just added
 */
$highlight = $highlight ?? null;
?>
<?php if (!$items): ?>
  <div class="empty-state" style="margin:auto">
    <div class="empty-icon"><?= icon('bag') ?></div>
    <h3>Your bag is <em class="text-cherry">empty</em></h3>
    <p>Discover sacred vermilion, velvet tints and kohl as deep as noir.</p>
    <a href="<?= e(url('shop')) ?>" class="btn-sa">Explore products <?= icon('arrow-right') ?></a>
  </div>
<?php else: ?>
  <?php if ($totals['free_shipping_threshold'] > 0): ?>
  <div class="ship-progress">
    <?php if ($totals['shipping'] > 0 && $totals['free_shipping_remaining'] > 0): ?>
      You’re <strong><?= money($totals['free_shipping_remaining']) ?></strong> away from complimentary shipping.
    <?php else: ?>
      <?= icon('check-circle', 'ic-sm text-cherry') ?> You’ve unlocked <strong>complimentary shipping</strong>.
    <?php endif; ?>
    <div class="bar"><span style="width:<?= min(100, round(($totals['subtotal'] - $totals['discount']) / $totals['free_shipping_threshold'] * 100)) ?>%"></span></div>
  </div>
  <?php endif; ?>
  <div class="mini-items">
    <?php foreach ($items as $it): ?>
      <div class="mini-item<?= $highlight === $it['item_id'] ? ' is-new' : '' ?>" data-item="<?= (int) $it['item_id'] ?>">
        <a href="<?= e($it['url']) ?>"><?= img_tag($it['image'], $it['name'], ['sizes' => '84px', 'width' => 84, 'height' => 105]) ?></a>
        <div>
          <a class="mi-title" href="<?= e($it['url']) ?>"><?= e($it['name']) ?></a>
          <?php if ($it['variant_name']): ?>
            <span class="mi-variant"><?php if ($it['swatch']): ?><i style="background:<?= e($it['swatch']) ?>"></i><?php endif; ?><?= e($it['variant_label']) ?>: <?= e($it['variant_name']) ?></span>
          <?php endif; ?>
          <?php if (!$it['stock_ok']): ?><span class="stock-low d-block mt-1"><?= $it['available_qty'] > 0 ? 'Only ' . (int) $it['available_qty'] . ' available' : 'Out of stock' ?></span><?php endif; ?>
          <div class="mi-row">
            <div class="qty" data-qty>
              <button type="button" data-qty-minus aria-label="Decrease quantity"><?= icon('minus') ?></button>
              <input type="number" value="<?= (int) $it['quantity'] ?>" min="1" max="<?= max(1, (int) $it['available_qty']) ?>" aria-label="Quantity" data-cart-qty="<?= (int) $it['item_id'] ?>">
              <button type="button" data-qty-plus aria-label="Increase quantity" <?= $it['quantity'] >= $it['available_qty'] ? 'disabled' : '' ?>><?= icon('plus') ?></button>
            </div>
            <div class="text-end">
              <div class="price<?= $it['unit_price'] < $it['regular_price'] ? ' on-sale' : '' ?>"><span class="price-now"><?= money($it['line_total']) ?></span></div>
              <button type="button" class="mi-remove" data-cart-remove="<?= (int) $it['item_id'] ?>">Remove</button>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="mini-foot">
    <div class="row-line"><span>Subtotal</span><span><?= money($totals['subtotal']) ?></span></div>
    <?php if ($totals['savings'] > 0): ?><div class="row-line text-cherry"><span>You save</span><span><?= money($totals['savings']) ?></span></div><?php endif; ?>
    <?php if ($totals['discount'] > 0): ?><div class="row-line text-cherry"><span>Coupon (<?= e($totals['coupon_code']) ?>)</span><span>−<?= money($totals['discount']) ?></span></div><?php endif; ?>
    <div class="row-line row-total"><span>Total</span><span><?= money($totals['subtotal'] - $totals['discount']) ?></span></div>
    <p class="note">Shipping<?= $totals['tax_rate'] > 0 && !$totals['tax_inclusive'] ? ', taxes' : '' ?> and coupons are calculated at checkout.<?= $totals['tax_rate'] > 0 && $totals['tax_inclusive'] ? ' Prices include ' . e($totals['tax_label']) . '.' : '' ?></p>
    <div class="btns">
      <a href="<?= e(url('cart')) ?>" class="btn-sa btn-outline">View bag</a>
      <a href="<?= e(url('checkout')) ?>" class="btn-sa">Checkout</a>
    </div>
    <button type="button" class="continue" data-bs-dismiss="offcanvas">Continue shopping</button>
  </div>
<?php endif; ?>
