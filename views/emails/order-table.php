<?php /** @var array $order @var array $items */ ?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:18px 0;font-size:14px">
  <?php foreach ($items as $it): ?>
  <tr>
    <td style="padding:10px 0;border-bottom:1px solid #e0dccd;width:64px"><?php if ($it['image']): ?><img src="<?= e(url('uploads/' . preg_replace('~\.webp$~', '-600.jpg', $it['image']))) ?>" width="54" style="border-radius:8px;display:block" alt=""><?php endif; ?></td>
    <td style="padding:10px;border-bottom:1px solid #e0dccd"><strong><?= e($it['product_name']) ?></strong><?php if ($it['variant_name']): ?><br><span style="color:#6c6260;font-size:12px"><?= e($it['variant_name']) ?></span><?php endif; ?><br><span style="color:#6c6260;font-size:12px"><?= money($it['unit_price']) ?> × <?= (int) $it['quantity'] ?></span></td>
    <td align="right" style="padding:10px 0;border-bottom:1px solid #e0dccd;white-space:nowrap"><?= money($it['line_total']) ?></td>
  </tr>
  <?php endforeach; ?>
  <tr><td colspan="2" style="padding:6px 0;color:#6c6260">Subtotal</td><td align="right"><?= money($order['subtotal']) ?></td></tr>
  <?php if ((float) $order['discount_amount'] > 0): ?><tr><td colspan="2" style="padding:6px 0;color:#810100">Discount<?= $order['coupon_code'] ? ' (' . e($order['coupon_code']) . ')' : '' ?></td><td align="right" style="color:#810100">−<?= money($order['discount_amount']) ?></td></tr><?php endif; ?>
  <tr><td colspan="2" style="padding:6px 0;color:#6c6260">Shipping</td><td align="right"><?= (float) $order['shipping_amount'] > 0 ? money($order['shipping_amount']) : 'Free' ?></td></tr>
  <?php if ((float) $order['cod_fee'] > 0): ?><tr><td colspan="2" style="padding:6px 0;color:#6c6260">COD handling</td><td align="right"><?= money($order['cod_fee']) ?></td></tr><?php endif; ?>
  <?php if ((float) $order['tax_amount'] > 0): ?><tr><td colspan="2" style="padding:6px 0;color:#6c6260;font-size:12px"><?= e($order['tax_label']) ?><?= $order['tax_inclusive'] ? ' (included)' : '' ?></td><td align="right" style="font-size:12px;color:#6c6260"><?= money($order['tax_amount']) ?></td></tr><?php endif; ?>
  <tr><td colspan="2" style="padding:12px 0 0;font-weight:bold;font-size:16px;border-top:1px solid #1B1717">Total</td><td align="right" style="padding:12px 0 0;font-weight:bold;font-size:16px;border-top:1px solid #1B1717"><?= money($order['total']) ?></td></tr>
</table>
