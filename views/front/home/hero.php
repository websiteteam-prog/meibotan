<?php
/** @var array $s */
$slides = $s['slides'];
$first = $slides[0]['theme'] ?? 'noir';
?>
<section class="hero<?= $first === 'cotton' ? ' on-cotton' : '' ?>" data-hero aria-roledescription="carousel" aria-label="Featured">
  <div class="hero-slides">
    <?php foreach ($slides as $i => $b): ?>
    <div class="hero-slide theme-<?= e($b['theme']) ?><?= $i === 0 ? ' is-active' : '' ?>" data-theme="<?= e($b['theme']) ?>" role="group" aria-roledescription="slide" aria-label="<?= $i + 1 ?> of <?= count($slides) ?>">
      <div class="hero-bg"></div>
      <div class="container-xl">
        <div class="hero-grid">
          <div class="hero-copy">
            <?php if ($b['eyebrow']): ?><span class="eyebrow"><?= icon('sparkle') ?> <?= e($b['eyebrow']) ?></span><?php endif; ?>
            <<?= $i === 0 ? 'h1' : 'h2' ?> class="hero-title"><?= e($b['title']) ?><?php if ($b['title_italic']): ?> <em><?= e($b['title_italic']) ?></em><?php endif; ?></<?= $i === 0 ? 'h1' : 'h2' ?>>
            <?php if ($b['subtitle']): ?><p class="hero-sub"><?= e($b['subtitle']) ?></p><?php endif; ?>
            <div class="hero-ctas">
              <?php if ($b['button_text']): ?><a class="btn-sa <?= $b['theme'] === 'cotton' ? '' : 'btn-light' ?>" href="<?= e(link_url($b['button_link'])) ?>"><?= e($b['button_text']) ?> <?= icon('arrow-right') ?></a><?php endif; ?>
              <?php if ($b['button2_text']): ?><a class="btn-sa <?= $b['theme'] === 'cotton' ? 'btn-outline' : 'btn-outline-light' ?>" href="<?= e(link_url($b['button2_link'])) ?>"><?= e($b['button2_text']) ?></a><?php endif; ?>
            </div>
          </div>
          <?php if ($b['image']): ?>
          <div class="hero-visual d-none d-md-block">
            <div class="hero-arch"><?= img_tag($b['image'], $b['title'] . ' ' . $b['title_italic'], ['sizes' => '(max-width: 992px) 45vw, 460px', 'loading' => $i === 0 ? 'eager' : 'lazy', 'fetchpriority' => $i === 0 ? 'high' : null, 'width' => 900, 'height' => 1100]) ?></div>
            <?php if ($i === 0): ?>
            <div class="hero-badge" aria-hidden="true">
              <svg viewBox="0 0 100 100"><defs><path id="circ" d="M50,50 m-40,0 a40,40 0 1,1 80,0 a40,40 0 1,1 -80,0"/></defs><text><textPath href="#circ">Savié Amour · the art of beauty · </textPath></text></svg>
              <span>Est.<br>2026</span>
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php if (count($slides) > 1): ?>
  <div class="hero-controls">
    <div class="container-xl">
      <div class="hero-dots">
        <span class="hero-count" data-hero-count>01 / <?= str_pad((string) count($slides), 2, '0', STR_PAD_LEFT) ?></span>
        <?php foreach ($slides as $i => $b): ?><button type="button" class="hero-dot<?= $i === 0 ? ' is-active' : '' ?>" data-hero-dot="<?= $i ?>" aria-label="Go to slide <?= $i + 1 ?>"></button><?php endforeach; ?>
      </div>
      <div class="hero-arrows">
        <button type="button" class="btn-icon" data-hero-prev aria-label="Previous slide"><?= icon('arrow-left') ?></button>
        <button type="button" class="btn-icon" data-hero-next aria-label="Next slide"><?= icon('arrow-right') ?></button>
      </div>
    </div>
  </div>
  <?php endif; ?>
</section>
