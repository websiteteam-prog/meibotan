<?php /** @var string $email @var string $token @var bool $valid */ ?>
<h1>New password</h1>
<?php if (!$valid): ?>
  <p class="lead-a">This link is invalid or has expired.</p>
  <a class="btn-a w-100" href="<?= e(url('admin/forgot-password')) ?>">Request a new link</a>
<?php else: ?>
<form method="post" action="<?= e(url('admin/reset-password')) ?>" novalidate>
  <?= csrf_field() ?>
  <input type="hidden" name="email" value="<?= e($email) ?>"><input type="hidden" name="token" value="<?= e($token) ?>">
  <?= adm_input('password', 'New password', '', ['type' => 'password', 'help' => 'At least 8 characters with a letter and a number.', 'attrs' => ['required' => true, 'autocomplete' => 'new-password']]) ?>
  <?= adm_input('password_confirmation', 'Confirm password', '', ['type' => 'password', 'attrs' => ['required' => true]]) ?>
  <button class="btn-a w-100" type="submit">Update password</button>
</form>
<?php endif; ?>
