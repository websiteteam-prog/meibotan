<?php /** @var array $s */ ?>
<section class="section quote-section">
  <div class="container-xl" data-reveal>
    <svg class="quote-mark ic" aria-hidden="true"><use href="#i-sparkle"></use></svg>
    <blockquote class="quote-text">
      <span>“<?= e($s['title']) ?></span>
      <?php if ($s['title_italic']): ?><span><?= e($s['title_italic']) ?>”</span><?php endif; ?>
    </blockquote>
    <div class="quote-sign"><?= e(setting('site_name')) ?></div>
  </div>
</section>
