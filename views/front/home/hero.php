<?php
/**
 * Hero slider — three panels per slide: left image · text · right image.
 * @var array $s
 */
$slides = $s['slides'];
$petals = [asset('img/petal-a.webp'), asset('img/petal-b.webp'), asset('img/petal-c.webp')];
?>
<section class="hero3" data-hero aria-roledescription="carousel" aria-label="Featured">
  <div class="hero3-slides">
    <?php foreach ($slides as $i => $b): $tag = $i === 0 ? 'h1' : 'h2'; ?>
    <div class="hero-slide hero3-slide theme-<?= e($b['theme']) ?><?= $i === 0 ? ' is-active' : '' ?>" data-theme="<?= e($b['theme']) ?>" role="group" aria-roledescription="slide" aria-label="<?= $i + 1 ?> of <?= count($slides) ?>">
      <div class="hero3-media hero3-left">
        <?php if ($b['image']): ?><?= img_tag($b['image'], $b['title'] . ' ' . $b['title_italic'], ['sizes' => '(max-width: 767px) 50vw, 34vw', 'loading' => $i === 0 ? 'eager' : 'lazy', 'fetchpriority' => $i === 0 ? 'high' : null, 'width' => 960, 'height' => 1080]) ?><?php endif; ?>
      </div>
      <div class="hero3-center">
        <img class="h3-petal p1" src="<?= e($petals[($i) % 3]) ?>" alt="" aria-hidden="true" width="150" height="150">
        <img class="h3-petal p2" src="<?= e($petals[($i + 1) % 3]) ?>" alt="" aria-hidden="true" width="110" height="110">
        <img class="h3-petal p3" src="<?= e($petals[($i + 2) % 3]) ?>" alt="" aria-hidden="true" width="120" height="120">
        <div class="hero3-copy">
          <?php if ($b['eyebrow']): ?><span class="h3-eyebrow"><?= e($b['eyebrow']) ?></span><?php endif; ?>
          <<?= $tag ?> class="h3-title"><?= e($b['title']) ?><?php if ($b['title_italic']): ?> <em><?= e($b['title_italic']) ?></em><?php endif; ?></<?= $tag ?>>
          <?php if ($b['subtitle']): ?><p class="h3-sub"><?= e($b['subtitle']) ?></p><?php endif; ?>
          <div class="h3-ctas">
            <?php if ($b['button_text']): ?><a class="h3-btn" href="<?= e(link_url($b['button_link'])) ?>"><span>—</span> <?= e($b['button_text']) ?> <span>—</span></a><?php endif; ?>
            <?php if ($b['button2_text']): ?><a class="h3-link" href="<?= e(link_url($b['button2_link'])) ?>"><?= e($b['button2_text']) ?></a><?php endif; ?>
          </div>
        </div>
      </div>
      <div class="hero3-media hero3-right">
        <?php $right = !empty($b['image2']) ? $b['image2'] : $b['image']; ?>
        <?php if ($right): ?><?= img_tag($right, '', ['sizes' => '(max-width: 767px) 50vw, 34vw', 'loading' => $i === 0 ? 'eager' : 'lazy', 'width' => 960, 'height' => 1080]) ?><?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php if (count($slides) > 1): ?>
  <div class="hero3-dots" role="tablist" aria-label="Slides">
    <?php foreach ($slides as $i => $b): ?><button type="button" class="h3-dot<?= $i === 0 ? ' is-active' : '' ?>" data-hero-dot="<?= $i ?>" aria-label="Go to slide <?= $i + 1 ?>"><span></span></button><?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>
