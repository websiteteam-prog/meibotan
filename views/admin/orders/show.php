<?php
/** @var array $o @var array $items @var array $history @var array $payments @var ?array $customer */
use App\Services\OrderService;
$addr = static fn(string $p) => e($o[$p . '_name']) . '<br>' . e($o[$p . '_address1']) . ($o[$p . '_address2'] ? ', ' . e($o[$p . '_address2']) : '') . '<br>' . e($o[$p . '_city']) . ', ' . e($o[$p . '_state']) . ' ' . e($o[$p . '_postal_code']) . '<br>' . e($o[$p . '_country']) . '<br>' . icon('phone', 'ic-sm') . ' ' . e($o[$p . '_phone']);
?>
<?= adm_head('Order <em>#' . e($o['order_number']) . '</em>', 'Placed ' . format_date($o['created_at'], 'd M Y, h:i A') . ' · ' . ($o['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Razorpay'),
  '<a class="btn-a light" href="' . e(url('admin/orders/' . $o['id'] . '/invoice')) . '">' . icon('printer', 'ic-sm') . ' Invoice</a>', ['Orders', 'admin/orders']) ?>
<div class="d-flex gap-2 mb-4 flex-wrap"><?= adm_badge($o['status']) ?> <?= adm_badge($o['payment_status']) ?><?php if ($o['coupon_code']): ?> <span class="badge-a"><?= icon('tag', 'ic-sm') ?> <?= e($o['coupon_code']) ?></span><?php endif; ?></div>

<div class="form-grid">
  <div>
    <div class="card-a">
      <h2>Items</h2>
      <div class="line-items">
        <?php foreach ($items as $it): ?>
          <div class="li">
            <img src="<?= e(upload_url($it['image'], '300')) ?>" alt="">
            <div><?php if ($it['product_id']): ?><a class="fw-semibold text-dark" href="<?= e(url('admin/products/' . $it['product_id'] . '/edit')) ?>"><?= e($it['product_name']) ?></a><?php else: ?><strong><?= e($it['product_name']) ?></strong><?php endif; ?>
              <div class="form-text m-0"><?= $it['variant_name'] ? e($it['variant_name']) . ' · ' : '' ?>SKU <?= e($it['sku']) ?></div></div>
            <div class="text-end"><?= money($it['unit_price']) ?> × <?= (int) $it['quantity'] ?><?php if ((float) $it['regular_price'] > (float) $it['unit_price']): ?><div class="form-text m-0"><s><?= money($it['regular_price']) ?></s></div><?php endif; ?></div>
            <strong class="text-end"><?= money($it['line_total']) ?></strong>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="totals-a mt-3 ms-auto" style="max-width:340px">
        <div><span>Subtotal</span><span><?= money($o['subtotal']) ?></span></div>
        <?php if ((float) $o['discount_amount'] > 0): ?><div class="text-danger"><span>Discount <?= $o['coupon_code'] ? '(' . e($o['coupon_code']) . ')' : '' ?></span><span>−<?= money($o['discount_amount']) ?></span></div><?php endif; ?>
        <div><span>Shipping</span><span><?= (float) $o['shipping_amount'] > 0 ? money($o['shipping_amount']) : 'Free' ?></span></div>
        <?php if ((float) $o['cod_fee'] > 0): ?><div><span>COD fee</span><span><?= money($o['cod_fee']) ?></span></div><?php endif; ?>
        <?php if ((float) $o['tax_amount'] > 0): ?><div class="form-text"><span><?= e($o['tax_label']) ?> <?= rtrim(rtrim(number_format((float) $o['tax_rate'], 2), '0'), '.') ?>%<?= $o['tax_inclusive'] ? ' (incl.)' : '' ?></span><span><?= money($o['tax_amount']) ?></span></div><?php endif; ?>
        <div class="grand"><span>Total</span><span><?= money($o['total']) ?></span></div>
      </div>
    </div>

    <div class="grid-2-eq">
      <div class="card-a"><h2>Shipping address</h2><address class="m-0"><?= $addr('shipping') ?></address></div>
      <div class="card-a"><h2>Billing address</h2><address class="m-0"><?= $addr('billing') ?></address></div>
    </div>
    <?php if ($o['notes']): ?><div class="card-a"><h2>Customer note</h2><p class="m-0"><?= nl2br(e($o['notes'])) ?></p></div><?php endif; ?>

    <div class="card-a">
      <h2>Payments</h2>
      <div class="table-wrap"><table class="table-a">
        <thead><tr><th>Method</th><th>Gateway order / payment</th><th>Status</th><th class="num">Amount</th><th>Date</th></tr></thead>
        <tbody>
        <?php foreach ($payments as $p): ?>
          <tr><td><?= $p['method'] === 'cod' ? 'Cash on Delivery' : 'Razorpay' ?></td><td><span class="sub"><?= e($p['gateway_order_id'] ?: '—') ?></span><span class="sub"><?= e($p['gateway_payment_id'] ?: '') ?></span><?php if ($p['refund_id']): ?><span class="sub">Refund <?= e($p['refund_id']) ?></span><?php endif; ?><?php if ($p['error_message']): ?><span class="sub text-danger"><?= e($p['error_message']) ?></span><?php endif; ?></td><td><?= adm_badge($p['status'] === 'created' ? 'pending' : $p['status']) ?></td><td class="num"><?= money($p['amount']) ?><?php if ((float) $p['refunded_amount'] > 0): ?><span class="sub">−<?= money($p['refunded_amount']) ?> refunded</span><?php endif; ?></td><td><?= format_date($p['created_at'], 'd M, h:i A') ?></td></tr>
        <?php endforeach; ?>
        </tbody>
      </table></div>
    </div>

    <div class="card-a">
      <h2>History</h2>
      <ul class="history">
        <?php foreach (array_reverse($history) as $h): ?>
          <li><strong><?= e(status_label(str_replace('payment_', 'payment ', $h['status']))) ?></strong> <span class="form-text">by <?= e($h['actor']) ?></span><small><?= format_date($h['created_at'], 'd M Y, h:i A') ?></small><?= $h['note'] ? e($h['note']) : '' ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <div class="sticky-col">
    <div class="card-a">
      <h2>Update status</h2>
      <form method="post" action="<?= e(url('admin/orders/' . $o['id'] . '/status')) ?>">
        <?= csrf_field() ?>
        <select class="form-select mb-2" name="status" aria-label="Order status"><?php foreach (OrderService::STATUSES as $s): ?><option value="<?= $s ?>" <?= $o['status'] === $s ? 'selected' : '' ?>><?= e(status_label($s)) ?></option><?php endforeach; ?></select>
        <input class="form-control mb-2" name="note" placeholder="Note for the customer (optional)" maxlength="250">
        <label class="form-check mb-3"><input class="form-check-input" type="checkbox" name="notify" value="1" checked> <span class="form-check-label">E-mail the customer</span></label>
        <button class="btn-a w-100" type="submit">Update status</button>
        <p class="form-text mt-2 mb-0">Cancelling or refunding returns items to stock automatically.</p>
      </form>
    </div>
    <div class="card-a">
      <h2>Payment status</h2>
      <form method="post" action="<?= e(url('admin/orders/' . $o['id'] . '/payment')) ?>" class="d-flex gap-2">
        <?= csrf_field() ?>
        <select class="form-select" name="payment_status" aria-label="Payment status"><?php foreach (OrderService::PAYMENT_STATUSES as $s): ?><option value="<?= $s ?>" <?= $o['payment_status'] === $s ? 'selected' : '' ?>><?= e(status_label($s)) ?></option><?php endforeach; ?></select>
        <button class="btn-a dark" type="submit">Save</button>
      </form>
    </div>
    <div class="card-a">
      <h2>Shipping &amp; tracking</h2>
      <form method="post" action="<?= e(url('admin/orders/' . $o['id'] . '/shipping')) ?>">
        <?= csrf_field() ?>
        <?= adm_input('courier_name', 'Courier', $o['courier_name'], ['attrs' => ['placeholder' => 'e.g. Delhivery, Blue Dart']]) ?>
        <?= adm_input('tracking_number', 'Tracking / AWB number', $o['tracking_number']) ?>
        <?= adm_textarea('admin_notes', 'Internal notes', $o['admin_notes'], ['rows' => 2, 'help' => 'Only visible to admins.']) ?>
        <?php if (in_array($o['status'], ['pending', 'processing', 'confirmed'], true)): ?><label class="form-check mb-3"><input class="form-check-input" type="checkbox" name="mark_shipped" value="1"> <span class="form-check-label">Mark as shipped &amp; notify customer</span></label><?php endif; ?>
        <button class="btn-a light w-100" type="submit">Save shipping details</button>
      </form>
    </div>
    <?php if ($o['payment_status'] === 'paid'): ?>
    <div class="card-a">
      <h2>Refund</h2>
      <form method="post" action="<?= e(url('admin/orders/' . $o['id'] . '/refund')) ?>" data-confirm="Process this refund? This cannot be undone.">
        <?= csrf_field() ?>
        <?= adm_input('amount', 'Amount', $o['total'], ['type' => 'number', 'prefix' => setting('currency_symbol', '₹'), 'attrs' => ['step' => '0.01', 'min' => '1', 'max' => $o['total']]]) ?>
        <?php if ($o['payment_method'] === 'razorpay'): ?><label class="form-check mb-3"><input class="form-check-input" type="checkbox" name="manual" value="1"> <span class="form-check-label">Record only (already refunded outside Razorpay)</span></label><?php endif; ?>
        <button class="btn-a danger w-100" type="submit"><?= icon('refresh', 'ic-sm') ?> <?= $o['payment_method'] === 'razorpay' ? 'Refund via Razorpay' : 'Record refund' ?></button>
      </form>
    </div>
    <?php endif; ?>
    <div class="card-a">
      <h2>Customer</h2>
      <dl class="kv">
        <dt>Name</dt><dd><?= e($o['customer_name']) ?></dd>
        <dt>Email</dt><dd><a href="mailto:<?= e($o['customer_email']) ?>"><?= e($o['customer_email']) ?></a></dd>
        <dt>Phone</dt><dd><a href="tel:<?= e($o['customer_phone']) ?>"><?= e($o['customer_phone']) ?></a></dd>
        <dt>Account</dt><dd><?= $customer ? '<a href="' . e(url('admin/customers/' . $customer['id'])) . '">View profile</a> · ' . (int) $customer['order_count'] . ' orders' : 'Guest checkout' ?></dd>
      </dl>
    </div>
  </div>
</div>
