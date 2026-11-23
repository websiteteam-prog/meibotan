<?php /** @var array $items @var array $totals */ ?>
<?php if (!$items): ?>
  <div class="empty-state py-5">
    <div class="empty-icon"><?= icon('bag') ?></div>
    <h3>Your bag is <em class="text-cherry">empty</em></h3>
    <p>Looks like you haven’t added anything yet. Let’s find something you’ll love.</p>
    <a href="<?= e(url('shop')) ?>" class="btn-sa">Explore products <?= icon('arrow-right') ?></a>
  </div>
<?php else: ?>
<div class="cart-layout">
  <div class="cart-lines">
    <div class="cart-head d-none d-md-grid"><span>Product</span><span>Price</span><span>Quantity</span><span class="text-end">Total</span></div>
    <?php foreach ($items as $it): ?>
    <div class="cart-line" data-item="<?= (int) $it['item_id'] ?>">
      <div class="cl-product">
        <a href="<?= e($it['url']) ?>" class="cl-img"><?= img_tag($it['image'], $it['name'], ['sizes' => '110px', 'width' => 110, 'height' => 138]) ?></a>
        <div>
          <span class="pcard-cat"><?= e($it['category_name'] ?? '') ?></span>
          <a href="<?= e($it['url']) ?>" class="cl-name"><?= e($it['name']) ?></a>
          <?php if ($it['variant_name']): ?><span class="mi-variant"><?php if ($it['swatch']): ?><i style="background:<?= e($it['swatch']) ?>"></i><?php endif; ?><?= e($it['variant_label']) ?>: <?= e($it['variant_name']) ?></span><?php endif; ?>
          <span class="cl-sku">SKU: <?= e($it['sku']) ?></span>
          <?php if (!$it['stock_ok']): ?><span class="stock-low d-block"><?= $it['available_qty'] > 0 ? 'Only ' . (int) $it['available_qty'] . ' available — please reduce the quantity' : 'This item is now out of stock — please remove it' ?></span><?php endif; ?>
          <button type="button" class="mi-remove mt-2" data-cart-remove="<?= (int) $it['item_id'] ?>"><?= icon('trash', 'ic-sm') ?> Remove</button>
        </div>
      </div>
      <div class="cl-price">
        <span class="price<?= $it['unit_price'] < $it['regular_price'] ? ' on-sale' : '' ?>"><span class="price-now"><?= money($it['unit_price']) ?></span><?php if ($it['unit_price'] < $it['regular_price']): ?><span class="price-old"><?= money($it['regular_price']) ?></span><?php endif; ?></span>
      </div>
      <div class="cl-qty">
        <div class="qty" data-qty>
          <button type="button" data-qty-minus aria-label="Decrease quantity"><?= icon('minus') ?></button>
          <input type="number" value="<?= (int) $it['quantity'] ?>" min="1" max="<?= max(1, (int) $it['available_qty']) ?>" aria-label="Quantity for <?= e($it['name']) ?>" data-cart-qty="<?= (int) $it['item_id'] ?>">
          <button type="button" data-qty-plus aria-label="Increase quantity" <?= $it['quantity'] >= $it['available_qty'] ? 'disabled' : '' ?>><?= icon('plus') ?></button>
        </div>
      </div>
      <div class="cl-total"><?= money($it['line_total']) ?></div>
    </div>
    <?php endforeach; ?>
    <a href="<?= e(url('shop')) ?>" class="link-arrow mt-4"><?= icon('arrow-left') ?> Continue shopping</a>
  </div>

  <aside class="summary-card">
    <h2 class="serif">Order summary</h2>
    <?= App\Core\View::partial('front/partials/coupon-box', ['totals' => $totals, 'context' => 'page']) ?>
    <dl class="totals">
      <div><dt>Subtotal (<?= e(plural($totals['count'], 'item')) ?>)</dt><dd><?= money($totals['subtotal']) ?></dd></div>
      <?php if ($totals['savings'] > 0): ?><div class="is-saving"><dt>Product savings</dt><dd><?= money($totals['savings']) ?></dd></div><?php endif; ?>
      <?php if ($totals['discount'] > 0): ?><div class="is-saving"><dt>Coupon (<?= e($totals['coupon_code']) ?>)</dt><dd>−<?= money($totals['discount']) ?></dd></div><?php endif; ?>
      <div><dt>Shipping</dt><dd><?= $totals['shipping'] > 0 ? money($totals['shipping']) : 'Free' ?></dd></div>
      <?php if ($totals['tax'] > 0): ?><div class="is-muted"><dt><?= e($totals['tax_label']) ?> (<?= rtrim(rtrim(number_format($totals['tax_rate'], 2), '0'), '.') ?>%)<?= $totals['tax_inclusive'] ? ' — included' : '' ?></dt><dd><?= money($totals['tax']) ?></dd></div><?php endif; ?>
      <div class="grand"><dt>Estimated total</dt><dd><?= money($totals['total']) ?></dd></div>
    </dl>
    <?php if ($totals['free_shipping_remaining'] > 0): ?><p class="ship-note"><?= icon('truck', 'ic-sm') ?> Add <?= money($totals['free_shipping_remaining']) ?> more for free shipping.</p><?php endif; ?>
    <a href="<?= e(url('checkout')) ?>" class="btn-sa btn-block">Proceed to checkout <?= icon('lock') ?></a>
    <p class="secure-note"><?= icon('shield', 'ic-sm') ?> Secure checkout · COD available</p>
  </aside>
</div>
<?php endif; ?>
