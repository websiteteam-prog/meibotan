<?php
/** @var array $customer @var string $section */
ob_start(); ?>
<div class="acc-card" style="max-width:640px">
  <div class="acc-card-head"><h2>Change password</h2></div>
  <form method="post" action="<?= e(url('account/password')) ?>" class="form-sa" novalidate>
    <?= csrf_field() ?>
    <div class="mb-3"><label class="form-label" for="current_password">Current password</label><input class="form-control<?= invalid('current_password') ?>" type="password" id="current_password" name="current_password" required autocomplete="current-password"><?= error_for('current_password') ?></div>
    <div class="mb-3"><label class="form-label" for="password">New password</label><div class="input-icon"><input class="form-control<?= invalid('password') ?>" type="password" id="password" name="password" required minlength="8" autocomplete="new-password"><button type="button" class="btn-pass" data-password-toggle aria-label="Show password"><?= icon('eye') ?></button></div><?= error_for('password') ?><small class="text-muted-sa">At least 8 characters with a letter and a number.</small></div>
    <div class="mb-4"><label class="form-label" for="password_confirmation">Confirm new password</label><input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"></div>
    <button type="submit" class="btn-sa">Update password</button>
  </form>
</div>
<?php $body = ob_get_clean();
echo App\Core\View::partial('front/account/shell', compact('body', 'section', 'customer') + ['title' => 'Change', 'italic' => 'password']);
