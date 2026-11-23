<?php
/** @var array $customer @var string $section @var array $addresses @var ?array $edit @var array $states @var array $countries */
$a = $edit ?? [];
$f = static fn(string $k, string $d = '') => old($k, $a[$k] ?? $d);
ob_start(); ?>
<div class="address-grid">
  <?php foreach ($addresses as $ad): ?>
  <div class="address-card<?= (int) $ad['is_default'] ? ' is-default' : '' ?>">
    <div class="d-flex justify-content-between align-items-start mb-2"><span class="badge-sa"><?= e($ad['label']) ?></span><?php if ((int) $ad['is_default']): ?><span class="small text-cherry fw-semibold"><?= icon('check-circle', 'ic-sm') ?> Default</span><?php endif; ?></div>
    <address class="addr mb-3"><strong><?= e($ad['full_name']) ?></strong><br><?= e($ad['address_line1']) ?><?= $ad['address_line2'] ? ', ' . e($ad['address_line2']) : '' ?><br><?= e($ad['city']) ?>, <?= e($ad['state']) ?> <?= e($ad['postal_code']) ?><br><?= e($ad['country']) ?> · <?= e($ad['phone']) ?></address>
    <div class="address-actions">
      <a href="<?= e(url('account/addresses', ['edit' => $ad['id']])) ?>#address-form"><?= icon('edit', 'ic-sm') ?> Edit</a>
      <?php if (!(int) $ad['is_default']): ?><form method="post" action="<?= e(url('account/addresses/' . $ad['id'] . '/default')) ?>"><?= csrf_field() ?><button type="submit">Set default</button></form><?php endif; ?>
      <form method="post" action="<?= e(url('account/addresses/' . $ad['id'] . '/delete')) ?>" data-confirm="Delete this address?"><?= csrf_field() ?><button type="submit" class="text-cherry"><?= icon('trash', 'ic-sm') ?> Delete</button></form>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<div class="acc-card mt-4" id="address-form">
  <div class="acc-card-head"><h2><?= $edit ? 'Edit address' : 'Add a new address' ?></h2><?php if ($edit): ?><a class="link-arrow" href="<?= e(url('account/addresses')) ?>">Cancel</a><?php endif; ?></div>
  <form method="post" action="<?= e(url('account/addresses')) ?>" class="form-sa" novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) ($a['id'] ?? 0) ?>">
    <div class="row g-3">
      <div class="col-md-4"><label class="form-label" for="label">Label</label><input class="form-control<?= invalid('label') ?>" id="label" name="label" list="labels" required value="<?= e($f('label', 'Home')) ?>"><datalist id="labels"><option>Home</option><option>Work</option><option>Other</option></datalist><?= error_for('label') ?></div>
      <div class="col-md-4"><label class="form-label" for="full_name">Full name</label><input class="form-control<?= invalid('full_name') ?>" id="full_name" name="full_name" required value="<?= e($f('full_name', $customer['name'])) ?>"><?= error_for('full_name') ?></div>
      <div class="col-md-4"><label class="form-label" for="aphone">Phone</label><input class="form-control<?= invalid('phone') ?>" id="aphone" name="phone" type="tel" required value="<?= e($f('phone', (string) $customer['phone'])) ?>"><?= error_for('phone') ?></div>
      <div class="col-12"><label class="form-label" for="address_line1">Address</label><input class="form-control<?= invalid('address_line1') ?>" id="address_line1" name="address_line1" required value="<?= e($f('address_line1')) ?>"><?= error_for('address_line1') ?></div>
      <div class="col-12"><label class="form-label" for="address_line2">Apartment, landmark (optional)</label><input class="form-control" id="address_line2" name="address_line2" value="<?= e($f('address_line2')) ?>"></div>
      <div class="col-md-6"><label class="form-label" for="city">City</label><input class="form-control<?= invalid('city') ?>" id="city" name="city" required value="<?= e($f('city')) ?>"><?= error_for('city') ?></div>
      <div class="col-md-6"><label class="form-label" for="state">State</label><select class="form-select<?= invalid('state') ?>" id="state" name="state" required><option value="">Select state</option><?php foreach ($states as $s): ?><option <?= $f('state') === $s ? 'selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?></select><?= error_for('state') ?></div>
      <div class="col-md-6"><label class="form-label" for="country">Country</label><select class="form-select" id="country" name="country"><?php foreach ($countries as $c): ?><option <?= $f('country') === $c ? 'selected' : '' ?>><?= e($c) ?></option><?php endforeach; ?></select></div>
      <div class="col-md-6"><label class="form-label" for="postal_code">PIN code</label><input class="form-control<?= invalid('postal_code') ?>" id="postal_code" name="postal_code" required inputmode="numeric" value="<?= e($f('postal_code')) ?>"><?= error_for('postal_code') ?></div>
    </div>
    <label class="check-line mt-3"><input type="checkbox" name="is_default" value="1" <?= !empty($a['is_default']) ? 'checked' : '' ?>> Make this my default address</label>
    <button type="submit" class="btn-sa mt-4"><?= $edit ? 'Save address' : 'Add address' ?></button>
  </form>
</div>
<?php $body = ob_get_clean();
echo App\Core\View::partial('front/account/shell', compact('body', 'section', 'customer') + ['title' => 'My', 'italic' => 'addresses']);
