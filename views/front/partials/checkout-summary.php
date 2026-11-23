<?php /** @var array $items @var array $totals */ ?>
<h2 class="serif">Order summary</h2>
<div class="co-items">
  <?php foreach ($items as $it): ?>
  <div class="co-item">
    <span class="co-img"><?= img_tag($it['image'], $it['name'], ['sizes' => '64px', 'width' => 64, 'height' => 80]) ?><b><?= (int) $it['quantity'] ?></b></span>
    <span class="co-name"><?= e($it['name']) ?><?php if ($it['variant_name']): ?><small><?= e($it['variant_label']) ?>: <?= e($it['variant_name']) ?></small><?php endif; ?><?php if (!$it['stock_ok']): ?><small class="stock-low">Only <?= (int) $it['available_qty'] ?> available</small><?php endif; ?></span>
    <span class="co-price"><?= money($it['line_total']) ?></span>
  </div>
  <?php endforeach; ?>
</div>
<?= App\Core\View::partial('front/partials/coupon-box', ['totals' => $totals, 'context' => 'checkout']) ?>
<dl class="totals">
  <div><dt>Subtotal</dt><dd><?= money($totals['subtotal']) ?></dd></div>
  <?php if ($totals['discount'] > 0): ?><div class="is-saving"><dt>Discount (<?= e($totals['coupon_code']) ?>)</dt><dd>−<?= money($totals['discount']) ?></dd></div><?php endif; ?>
  <div><dt>Shipping</dt><dd><?= $totals['shipping'] > 0 ? money($totals['shipping']) : 'Free' ?></dd></div>
  <?php if ($totals['cod_fee'] > 0): ?><div><dt>COD handling</dt><dd><?= money($totals['cod_fee']) ?></dd></div><?php endif; ?>
  <?php if ($totals['tax'] > 0): ?><div class="is-muted"><dt><?= e($totals['tax_label']) ?> (<?= rtrim(rtrim(number_format($totals['tax_rate'], 2), '0'), '.') ?>%)<?= $totals['tax_inclusive'] ? ' — included in prices' : '' ?></dt><dd><?= money($totals['tax']) ?></dd></div><?php endif; ?>
  <div class="grand"><dt>Total payable</dt><dd><?= money($totals['total']) ?></dd></div>
</dl>
<?php if ($totals['savings'] + $totals['discount'] > 0): ?><p class="saving-note"><?= icon('sparkle', 'ic-sm') ?> You’re saving <?= money($totals['savings'] + $totals['discount']) ?> on this order.</p><?php endif; ?>
<button type="submit" form="checkoutForm" class="btn-sa btn-block" data-place-order><?= icon('lock') ?> Place order · <?= money($totals['total']) ?></button>
<p class="secure-note"><?= icon('shield', 'ic-sm') ?> Your details are encrypted and secure.</p>
