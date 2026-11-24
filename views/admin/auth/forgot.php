<h1>Reset password</h1>
<p class="lead-a">Enter your admin e-mail and we’ll send a reset link.</p>
<form method="post" action="<?= e(url('admin/forgot-password')) ?>" novalidate>
  <?= csrf_field() ?>
  <?= adm_input('email', 'Email', '', ['type' => 'email', 'attrs' => ['required' => true]]) ?>
  <button class="btn-a w-100" type="submit">Send reset link</button>
  <p class="text-center mt-3 mb-0"><a href="<?= e(url('admin/login')) ?>">Back to sign in</a></p>
</form>
