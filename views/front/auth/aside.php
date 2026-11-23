<?php /** @var string $heading @var string $italic @var string $text */ ?>
<aside class="auth-aside" aria-hidden="true">
  <img src="<?= e(App\Services\Layout::logo('cotton')) ?>" alt="" class="auth-logo" width="647" height="365">
  <div>
    <span class="eyebrow eyebrow-light"><?= e(setting('site_tagline', 'the art of beauty')) ?></span>
    <p class="auth-quote"><?= e($heading) ?> <em><?= e($italic) ?></em></p>
    <p class="auth-text"><?= e($text) ?></p>
  </div>
  <ul class="auth-perks">
    <li><?= icon('heart') ?> Save favourites to your wishlist</li>
    <li><?= icon('package') ?> Track orders &amp; reorder in a tap</li>
    <li><?= icon('gift') ?> Early access to new shades &amp; offers</li>
  </ul>
</aside>
