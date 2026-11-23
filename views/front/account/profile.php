<?php
/** @var array $customer @var string $section */
ob_start(); ?>
<div class="acc-card">
  <div class="acc-card-head"><h2>Personal information</h2></div>
  <form method="post" action="<?= e(url('account/profile')) ?>" class="form-sa" novalidate>
    <?= csrf_field() ?>
    <div class="row g-3">
      <div class="col-md-12"><label class="form-label" for="name">Full name</label><input class="form-control<?= invalid('name') ?>" id="name" name="name" required value="<?= e(old('name', $customer['name'])) ?>"><?= error_for('name') ?></div>
      <div class="col-md-6"><label class="form-label" for="email">Email</label><input class="form-control<?= invalid('email') ?>" type="email" id="email" name="email" required value="<?= e(old('email', $customer['email'])) ?>"><?= error_for('email') ?></div>
      <div class="col-md-6"><label class="form-label" for="phone">Phone</label><input class="form-control<?= invalid('phone') ?>" type="tel" id="phone" name="phone" required value="<?= e(old('phone', $customer['phone'])) ?>"><?= error_for('phone') ?></div>
      <div class="col-md-6"><label class="form-label" for="current_password">Current password <span class="text-muted-sa text-lowercase">(required to change email)</span></label><input class="form-control<?= invalid('current_password') ?>" type="password" id="current_password" name="current_password" autocomplete="current-password"><?= error_for('current_password') ?></div>
    </div>
    <label class="check-line mt-4"><input type="checkbox" name="newsletter" value="1" <?= (int) $customer['newsletter'] ? 'checked' : '' ?>> Email me new launches and offers</label>
    <p class="small text-muted-sa mt-3">Member since <?= format_date($customer['created_at'], 'F Y') ?></p>
    <button type="submit" class="btn-sa mt-2">Save changes</button>
  </form>
</div>
<?php $body = ob_get_clean();
echo App\Core\View::partial('front/account/shell', compact('body', 'section', 'customer') + ['title' => 'My', 'italic' => 'profile']);
