<?php /** @var string $redirect */ ?>
<section class="auth-wrap">
  <div class="auth-card">
    <?= App\Core\View::partial('front/auth/aside', ['heading' => 'Join the', 'italic' => 'inner circle.', 'text' => 'Create your account for faster checkout, order tracking and member-only offers.']) ?>
    <div class="auth-form">
      <span class="eyebrow">New here</span>
      <h1 class="display-title">Create an <em>account</em></h1>
      <p class="text-muted-sa mb-4">Already have an account? <a href="<?= e(url('login', ['redirect' => $redirect ?: null])) ?>">Log in</a></p>
      <form method="post" action="<?= e(url('register')) ?>" class="form-sa" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="redirect" value="<?= e($redirect) ?>">
        <div class="row g-3">
          <div class="col-12"><label class="form-label" for="name">Full name</label><input class="form-control<?= invalid('name') ?>" id="name" name="name" required maxlength="120" autocomplete="name" value="<?= e(old('name')) ?>"><?= error_for('name') ?></div>
          <div class="col-md-6"><label class="form-label" for="email">Email address</label><input class="form-control<?= invalid('email') ?>" type="email" id="email" name="email" required maxlength="190" autocomplete="email" value="<?= e(old('email')) ?>"><?= error_for('email') ?></div>
          <div class="col-md-6"><label class="form-label" for="phone">Phone number</label><input class="form-control<?= invalid('phone') ?>" type="tel" id="phone" name="phone" required autocomplete="tel" placeholder="10-digit mobile" value="<?= e(old('phone')) ?>"><?= error_for('phone') ?></div>
          <div class="col-md-6"><label class="form-label" for="password">Password</label>
            <div class="input-icon"><input class="form-control<?= invalid('password') ?>" type="password" id="password" name="password" required minlength="8" autocomplete="new-password"><button type="button" class="btn-pass" data-password-toggle aria-label="Show password"><?= icon('eye') ?></button></div>
            <?= error_for('password') ?><small class="text-muted-sa">At least 8 characters with a letter and a number.</small></div>
          <div class="col-md-6"><label class="form-label" for="password_confirmation">Confirm password</label><input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"></div>
        </div>
        <label class="check-line mt-4"><input type="checkbox" name="terms" value="1" <?= old('terms') ? 'checked' : '' ?> required> <span>I agree to the <a href="<?= e(url('page/terms-and-conditions')) ?>" target="_blank">terms &amp; conditions</a> and <a href="<?= e(url('page/privacy-policy')) ?>" target="_blank">privacy policy</a></span></label>
        <?= error_for('terms') ?>
        <label class="check-line mt-2 mb-4"><input type="checkbox" name="newsletter" value="1" <?= old('newsletter') ? 'checked' : '' ?>> Send me new shades, rituals and offers</label>
        <button type="submit" class="btn-sa btn-block">Create account <?= icon('arrow-right') ?></button>
      </form>
    </div>
  </div>
</section>
