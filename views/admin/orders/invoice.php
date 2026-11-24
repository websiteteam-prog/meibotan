<?php /** @var array $o @var array $items */ ?>
<div class="no-print d-flex gap-2 mb-3">
  <a class="btn-a light" href="<?= e(url('admin/orders/' . $o['id'])) ?>"><?= icon('arrow-left', 'ic-sm') ?> Back to order</a>
  <button class="btn-a" type="button" onclick="window.print()"><?= icon('printer', 'ic-sm') ?> Print / Save as PDF</button>
</div>
<div class="invoice">
  <div class="inv-head">
    <div>
      <img src="<?= e(asset('img/logo-maroon.webp')) ?>" alt="<?= e(setting('site_name')) ?>">
      <p class="mt-2 mb-0 small"><?= nl2br(e(setting('site_address'))) ?><br><?= e(setting('site_email')) ?> · <?= e(setting('site_phone')) ?><?php if (setting('gstin')): ?><br>GSTIN: <?= e(setting('gstin')) ?><?php endif; ?></p>
    </div>
    <div class="text-end">
      <h2>Invoice</h2>
      <p class="m-0 small"><strong>#<?= e($o['order_number']) ?></strong><br>Date: <?= format_date($o['created_at'], 'd M Y') ?><br>Payment: <?= $o['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Online' ?> (<?= e($o['payment_status']) ?>)</p>
    </div>
  </div>
  <div class="inv-cols">
    <div><h4>Billed to</h4><?= e($o['billing_name']) ?><br><?= e($o['billing_address1']) ?><?= $o['billing_address2'] ? ', ' . e($o['billing_address2']) : '' ?><br><?= e($o['billing_city']) ?>, <?= e($o['billing_state']) ?> <?= e($o['billing_postal_code']) ?><br><?= e($o['billing_phone']) ?></div>
    <div><h4>Shipped to</h4><?= e($o['shipping_name']) ?><br><?= e($o['shipping_address1']) ?><?= $o['shipping_address2'] ? ', ' . e($o['shipping_address2']) : '' ?><br><?= e($o['shipping_city']) ?>, <?= e($o['shipping_state']) ?> <?= e($o['shipping_postal_code']) ?><br><?= e($o['shipping_phone']) ?></div>
    <div><h4>Customer</h4><?= e($o['customer_name']) ?><br><?= e($o['customer_email']) ?><br><?= e($o['customer_phone']) ?></div>
  </div>
  <table class="inv-table">
    <thead><tr><th>#</th><th>Item</th><th>SKU</th><th class="r">Price</th><th class="r">Qty</th><th class="r">Amount</th></tr></thead>
    <tbody>
    <?php foreach ($items as $i => $it): ?>
      <tr><td><?= $i + 1 ?></td><td><?= e($it['product_name']) ?><?= $it['variant_name'] ? '<br><small>' . e($it['variant_name']) . '</small>' : '' ?></td><td><?= e($it['sku']) ?></td><td class="r"><?= money($it['unit_price']) ?></td><td class="r"><?= (int) $it['quantity'] ?></td><td class="r"><?= money($it['line_total']) ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <div class="inv-totals totals-a">
    <div><span>Subtotal</span><span><?= money($o['subtotal']) ?></span></div>
    <?php if ((float) $o['discount_amount'] > 0): ?><div><span>Discount<?= $o['coupon_code'] ? ' (' . e($o['coupon_code']) . ')' : '' ?></span><span>−<?= money($o['discount_amount']) ?></span></div><?php endif; ?>
    <div><span>Shipping</span><span><?= money($o['shipping_amount']) ?></span></div>
    <?php if ((float) $o['cod_fee'] > 0): ?><div><span>COD fee</span><span><?= money($o['cod_fee']) ?></span></div><?php endif; ?>
    <?php if ((float) $o['tax_amount'] > 0): ?><div><span><?= e($o['tax_label']) ?> @ <?= rtrim(rtrim(number_format((float) $o['tax_rate'], 2), '0'), '.') ?>%<?= $o['tax_inclusive'] ? ' (included)' : '' ?></span><span><?= money($o['tax_amount']) ?></span></div><?php endif; ?>
    <div class="grand"><span>Total</span><span><?= money($o['total']) ?></span></div>
  </div>
  <div class="inv-foot">Thank you for shopping with <?= e(setting('site_name')) ?> — <?= e(setting('site_tagline')) ?>. This is a computer-generated invoice.</div>
</div>
