<?php /** @var array $s */ ?>
<section class="section newsletter" id="newsletter">
  <div class="container-xl">
    <div class="newsletter-box" data-reveal>
      <?php if ($s['eyebrow']): ?><span class="eyebrow"><?= e($s['eyebrow']) ?></span><?php endif; ?>
      <h2 class="section-title"><?= e($s['title']) ?> <em><?= e($s['title_italic']) ?></em></h2>
      <?php if ($s['subtitle']): ?><p class="mt-3"><?= e($s['subtitle']) ?></p><?php endif; ?>
      <form class="nl-form" data-newsletter action="<?= e(url('api/newsletter')) ?>" method="post" novalidate>
        <?= csrf_field() ?>
        <label class="visually-hidden" for="nl-email">E-mail address</label>
        <input type="email" id="nl-email" name="email" placeholder="Your e-mail address" required autocomplete="email">
        <button type="submit" class="btn-sa btn-light">Subscribe</button>
      </form>
      <div class="nl-msg" data-newsletter-msg role="status"></div>
      <p class="nl-note">By subscribing you agree to our privacy policy. Unsubscribe anytime.</p>
    </div>
  </div>
</section>
