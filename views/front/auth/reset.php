<?php /** @var string $email @var string $token @var bool $valid @var string $action */ ?>
<section class="auth-wrap">
  <div class="auth-card">
    <?= App\Core\View::partial('front/auth/aside', ['heading' => 'Choose a new', 'italic' => 'password.', 'text' => 'Pick something memorable and secure — at least 8 characters with a letter and a number.']) ?>
    <div class="auth-form">
      <span class="eyebrow">Account help</span>
      <h1 class="display-title">Reset <em>password</em></h1>
      <?php if (!$valid): ?>
        <p class="text-muted-sa">This reset link is invalid or has expired.</p>
        <a class="btn-sa mt-3" href="<?= e(url(str_contains($action, '/admin/') ? 'admin/forgot-password' : 'forgot-password')) ?>">Request a new link</a>
      <?php else: ?>
        <form method="post" action="<?= e($action) ?>" class="form-sa mt-3" novalidate>
          <?= csrf_field() ?>
          <input type="hidden" name="token" value="<?= e($token) ?>"><input type="hidden" name="email" value="<?= e($email) ?>">
          <div class="mb-3"><label class="form-label" for="password">New password</label><div class="input-icon"><input class="form-control<?= invalid('password') ?>" type="password" id="password" name="password" required minlength="8" autocomplete="new-password"><button type="button" class="btn-pass" data-password-toggle aria-label="Show password"><?= icon('eye') ?></button></div><?= error_for('password') ?></div>
          <div class="mb-4"><label class="form-label" for="password_confirmation">Confirm new password</label><input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"></div>
          <button type="submit" class="btn-sa btn-block">Update password</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</section>
