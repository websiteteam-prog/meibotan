<?php /** @var array $order @var array $items */ ?>
<div class="co-items">
  <?php foreach ($items as $it): ?>
  <div class="co-item">
    <span class="co-img"><?= img_tag($it['image'], $it['product_name'], ['sizes' => '64px', 'width' => 64, 'height' => 80]) ?><b><?= (int) $it['quantity'] ?></b></span>
    <span class="co-name"><?php if ($it['slug']): ?><a href="<?= e(url('product/' . $it['slug'])) ?>"><?= e($it['product_name']) ?></a><?php else: ?><?= e($it['product_name']) ?><?php endif; ?><?php if ($it['variant_name']): ?><small><?= e($it['variant_name']) ?></small><?php endif; ?><small><?= money($it['unit_price']) ?> × <?= (int) $it['quantity'] ?></small></span>
    <span class="co-price"><?= money($it['line_total']) ?></span>
  </div>
  <?php endforeach; ?>
</div>
<dl class="totals">
  <div><dt>Subtotal</dt><dd><?= money($order['subtotal']) ?></dd></div>
  <?php if ((float) $order['discount_amount'] > 0): ?><div class="is-saving"><dt>Discount<?= $order['coupon_code'] ? ' (' . e($order['coupon_code']) . ')' : '' ?></dt><dd>−<?= money($order['discount_amount']) ?></dd></div><?php endif; ?>
  <div><dt>Shipping</dt><dd><?= (float) $order['shipping_amount'] > 0 ? money($order['shipping_amount']) : 'Free' ?></dd></div>
  <?php if ((float) $order['cod_fee'] > 0): ?><div><dt>COD handling</dt><dd><?= money($order['cod_fee']) ?></dd></div><?php endif; ?>
  <?php if ((float) $order['tax_amount'] > 0): ?><div class="is-muted"><dt><?= e($order['tax_label'] ?: 'Tax') ?> (<?= rtrim(rtrim(number_format((float) $order['tax_rate'], 2), '0'), '.') ?>%)<?= $order['tax_inclusive'] ? ' — included' : '' ?></dt><dd><?= money($order['tax_amount']) ?></dd></div><?php endif; ?>
  <div class="grand"><dt>Total</dt><dd><?= money($order['total']) ?></dd></div>
</dl>
