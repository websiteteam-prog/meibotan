<?php /** @var array $coupons */ ?>
<?= adm_head('Coupons', 'Create percentage or fixed-amount discount codes with limits and expiry dates.', '<button class="btn-a" type="button" data-bs-toggle="modal" data-bs-target="#couponModal" data-fill-form="#couponForm" data-title="New coupon" data-values=\'{"id":"0","type":"percent","is_active":"1"}\'>' . icon('plus', 'ic-sm') . ' New coupon</button>') ?>
<div class="card-a flush"><div class="table-wrap"><table class="table-a">
  <thead><tr><th>Code</th><th>Discount</th><th>Conditions</th><th>Usage</th><th>Validity</th><th>Status</th><th class="actions"></th></tr></thead>
  <tbody>
  <?php foreach ($coupons as $c):
    $expired = $c['expires_at'] && strtotime($c['expires_at']) < time();
    $values = $c; $values['starts_at'] = $c['starts_at'] ? date('Y-m-d\TH:i', strtotime($c['starts_at'])) : ''; $values['expires_at'] = $c['expires_at'] ? date('Y-m-d\TH:i', strtotime($c['expires_at'])) : ''; ?>
    <tr>
      <td><strong class="font-monospace"><?= e($c['code']) ?></strong> <button type="button" class="btn-a sm ghost" data-copy="<?= e($c['code']) ?>" title="Copy"><?= icon('copy', 'ic-sm') ?></button><span class="sub"><?= e($c['description'] ?? '') ?></span></td>
      <td><strong><?= $c['type'] === 'percent' ? rtrim(rtrim(number_format((float) $c['value'], 2), '0'), '.') . '%' : money($c['value']) ?></strong><?php if ($c['max_discount']): ?><span class="sub">max <?= money($c['max_discount']) ?></span><?php endif; ?></td>
      <td><?= (float) $c['min_order_amount'] > 0 ? 'Min. order ' . money($c['min_order_amount']) : 'No minimum' ?><?php if ($c['usage_per_customer']): ?><span class="sub"><?= (int) $c['usage_per_customer'] ?> per customer</span><?php endif; ?></td>
      <td><?= (int) $c['used_count'] ?><?= $c['usage_limit'] ? ' / ' . (int) $c['usage_limit'] : '' ?><span class="sub"><?= money($c['discount_given']) ?> given</span></td>
      <td><?= $c['starts_at'] ? 'From ' . format_date($c['starts_at']) : 'Now' ?><span class="sub"><?= $c['expires_at'] ? 'Until ' . format_date($c['expires_at']) : 'No expiry' ?></span></td>
      <td><?= $expired ? '<span class="badge-a grey">Expired</span>' : ($c['is_active'] ? '<span class="badge-a green">Active</span>' : '<span class="badge-a grey">Paused</span>') ?></td>
      <td class="actions">
        <button type="button" class="btn-a sm light" data-bs-toggle="modal" data-bs-target="#couponModal" data-fill-form="#couponForm" data-title="Edit coupon" data-values='<?= e(json_encode($values)) ?>'><?= icon('edit', 'ic-sm') ?></button>
        <?= adm_post_button('admin/coupons/' . $c['id'] . '/toggle', $c['is_active'] ? 'Pause' : 'Activate') ?>
        <?= adm_post_button('admin/coupons/' . $c['id'] . '/delete', icon('trash', 'ic-sm'), 'btn-a sm danger', 'Delete coupon ' . $c['code'] . '?', 'Delete') ?>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$coupons): ?><tr><td colspan="7"><div class="empty"><?= icon('percent') ?><p>No coupons yet.</p></div></td></tr><?php endif; ?>
  </tbody>
</table></div></div>

<div class="modal fade" id="couponModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content">
  <form id="couponForm" method="post" action="<?= e(url('admin/coupons/save')) ?>">
    <div class="modal-header"><h5 class="modal-title">Coupon</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
    <div class="modal-body">
      <?= csrf_field() ?><input type="hidden" name="id" value="0" data-reset="0">
      <div class="row">
        <?= adm_input('code', 'Code', '', ['col' => 'col-md-6 mb-3', 'attrs' => ['required' => true, 'style' => 'text-transform:uppercase', 'placeholder' => 'AMOUR15']]) ?>
        <?= adm_input('description', 'Description', '', ['col' => 'col-md-6 mb-3', 'optional' => true]) ?>
        <?= adm_select('type', 'Discount type', ['percent' => 'Percentage (%)', 'fixed' => 'Fixed amount (' . setting('currency_symbol', '₹') . ')'], 'percent', ['col' => 'col-md-4 mb-3']) ?>
        <?= adm_input('value', 'Value', '', ['type' => 'number', 'col' => 'col-md-4 mb-3', 'attrs' => ['step' => '0.01', 'min' => '0.01', 'required' => true]]) ?>
        <?= adm_input('max_discount', 'Maximum discount', '', ['type' => 'number', 'col' => 'col-md-4 mb-3', 'optional' => true, 'help' => 'Cap for % coupons', 'attrs' => ['step' => '0.01', 'min' => 0]]) ?>
        <?= adm_input('min_order_amount', 'Minimum order', '0', ['type' => 'number', 'col' => 'col-md-4 mb-3', 'attrs' => ['step' => '0.01', 'min' => 0]]) ?>
        <?= adm_input('usage_limit', 'Total usage limit', '', ['type' => 'number', 'col' => 'col-md-4 mb-3', 'optional' => true, 'attrs' => ['min' => 1]]) ?>
        <?= adm_input('usage_per_customer', 'Uses per customer', '', ['type' => 'number', 'col' => 'col-md-4 mb-3', 'optional' => true, 'attrs' => ['min' => 1]]) ?>
        <?= adm_input('starts_at', 'Starts', '', ['type' => 'datetime-local', 'col' => 'col-md-6 mb-3', 'optional' => true]) ?>
        <?= adm_input('expires_at', 'Expires', '', ['type' => 'datetime-local', 'col' => 'col-md-6 mb-3', 'optional' => true]) ?>
      </div>
      <?= adm_switch('is_active', 'Active', true) ?>
    </div>
    <div class="modal-footer"><button type="button" class="btn-a light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-a">Save coupon</button></div>
  </form>
</div></div></div>
