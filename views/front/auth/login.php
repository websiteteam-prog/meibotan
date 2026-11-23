<?php /** @var string $redirect */ ?>
<section class="auth-wrap">
  <div class="auth-card">
    <?= App\Core\View::partial('front/auth/aside', ['heading' => 'Welcome', 'italic' => 'back.', 'text' => 'Sign in to view your orders, wishlist and saved addresses.']) ?>
    <div class="auth-form">
      <span class="eyebrow">My account</span>
      <h1 class="display-title">Log <em>in</em></h1>
      <p class="text-muted-sa mb-4">New to <?= e(setting('site_name')) ?>? <a href="<?= e(url('register', ['redirect' => $redirect ?: null])) ?>">Create an account</a></p>
      <form method="post" action="<?= e(url('login')) ?>" class="form-sa" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="redirect" value="<?= e($redirect) ?>">
        <div class="mb-3">
          <label class="form-label" for="identifier">Email or phone</label>
          <input class="form-control<?= invalid('identifier') ?>" id="identifier" name="identifier" required autocomplete="username" value="<?= e(old('identifier')) ?>" autofocus>
          <?= error_for('identifier') ?>
        </div>
        <div class="mb-3">
          <label class="form-label d-flex justify-content-between" for="password">Password <a href="<?= e(url('forgot-password')) ?>" class="text-cherry text-capitalize fw-normal" style="letter-spacing:0">Forgot password?</a></label>
          <div class="input-icon">
            <input class="form-control<?= invalid('password') ?>" type="password" id="password" name="password" required autocomplete="current-password">
            <button type="button" class="btn-pass" data-password-toggle aria-label="Show password"><?= icon('eye') ?></button>
          </div>
          <?= error_for('password') ?>
        </div>
        <label class="check-line mb-4"><input type="checkbox" name="remember" value="1"> Remember me for 30 days</label>
        <button type="submit" class="btn-sa btn-block">Log in <?= icon('arrow-right') ?></button>
      </form>
    </div>
  </div>
</section>
