<section class="auth-wrap">
  <div class="auth-card">
    <?= App\Core\View::partial('front/auth/aside', ['heading' => 'A fresh', 'italic' => 'start.', 'text' => 'Enter your email and we’ll send you a secure link to set a new password.']) ?>
    <div class="auth-form">
      <span class="eyebrow">Account help</span>
      <h1 class="display-title">Forgot <em>password?</em></h1>
      <p class="text-muted-sa mb-4">Remembered it? <a href="<?= e(url('login')) ?>">Back to log in</a></p>
      <form method="post" action="<?= e(url('forgot-password')) ?>" class="form-sa" novalidate>
        <?= csrf_field() ?>
        <div class="mb-4"><label class="form-label" for="email">Email address</label><input class="form-control<?= invalid('email') ?>" type="email" id="email" name="email" required autocomplete="email" value="<?= e(old('email')) ?>" autofocus><?= error_for('email') ?></div>
        <button type="submit" class="btn-sa btn-block">Send reset link <?= icon('mail') ?></button>
      </form>
    </div>
  </div>
</section>
