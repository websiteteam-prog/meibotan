<?php /** @var string $redirect */ ?>
<h1>Welcome back</h1>
<p class="lead-a">Sign in to manage your store.</p>
<form method="post" action="<?= e(url('admin/login')) ?>" novalidate>
  <?= csrf_field() ?>
  <input type="hidden" name="redirect" value="<?= e($redirect) ?>">
  <?= adm_input('email', 'Email', '', ['type' => 'email', 'attrs' => ['required' => true, 'autocomplete' => 'username', 'autofocus' => true]]) ?>
  <?= adm_input('password', 'Password', '', ['type' => 'password', 'attrs' => ['required' => true, 'autocomplete' => 'current-password']]) ?>
  <button class="btn-a w-100 mt-2" type="submit"><?= icon('lock', 'ic-sm') ?> Sign in</button>
  <p class="text-center mt-3 mb-0"><a href="<?= e(url('admin/forgot-password')) ?>">Forgot your password?</a></p>
</form>
