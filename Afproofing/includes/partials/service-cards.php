<?php
/**
 * Homepage services showcase: a large featured service, a photo card for each
 * other service (a swipeable row on phones) and a free-inspection strip.
 * Each card uses the service's 'image' from includes/data/services.php.
 * Vars: $exclude (slug to skip).
 */
defined('ROOT_PATH') || exit;
$exclude = $exclude ?? '';
$svcList = array_filter($GLOBALS['services'], fn($slug) => $slug !== $exclude, ARRAY_FILTER_USE_KEY);
$featuredSlug = array_key_first($svcList);
$featured = $svcList[$featuredSlug];
$others = array_slice($svcList, 1, null, true);
$n = 1;
?>
<div class="svc">
  <article class="svc-card svc-card--featured" data-reveal>
    <a class="svc-card__media" href="<?= e(service_url($featuredSlug)) ?>" tabindex="-1" aria-hidden="true">
      <img src="<?= e(asset($featured['image'])) ?>" alt="" <?= img_size($featured['image']) ?> loading="lazy" decoding="async">
      <span class="svc-card__num">01</span>
      <span class="svc-card__tag"><?= icon('award') ?>Complete package</span>
    </a>
    <div class="svc-card__body">
      <span class="svc-card__icon"><?= icon($featured['icon']) ?></span>
      <h3><a href="<?= e(service_url($featuredSlug)) ?>"><?= e($featured['name']) ?></a></h3>
      <p><?= e($featured['excerpt']) ?></p>
      <ul class="checklist">
        <?php foreach (array_slice($featured['includes'] ?? [], 0, 3) as $item): ?>
          <li><?= icon('check') ?><?= e($item) ?></li>
        <?php endforeach; ?>
      </ul>
      <div class="svc-card__actions">
        <a class="btn btn--dark" href="<?= e(service_url($featuredSlug)) ?>">Learn more<span class="visually-hidden"> about <?= e($featured['name']) ?></span> <?= icon('arrow-right', 'icon-shift') ?></a>
        <a class="link-arrow" href="<?= e(url('free-quote')) ?>">Free quote <?= icon('arrow-right') ?></a>
      </div>
    </div>
  </article>

  <p class="svc-hint" aria-hidden="true">Swipe to see all services <?= icon('arrow-right') ?></p>

  <div class="svc-list">
    <?php foreach ($others as $slug => $service): $n++; ?>
      <a class="svc-card" href="<?= e(service_url($slug)) ?>" data-reveal>
        <span class="svc-card__media">
          <img src="<?= e(asset($service['image'])) ?>" alt="" <?= img_size($service['image']) ?> loading="lazy" decoding="async">
          <span class="svc-card__num"><?= sprintf('%02d', $n) ?></span>
        </span>
        <span class="svc-card__icon"><?= icon($service['icon']) ?></span>
        <span class="svc-card__body">
          <h3><?= e($service['name']) ?></h3>
          <p><?= e($service['excerpt']) ?></p>
          <span class="svc-card__more">Learn more <?= icon('arrow-right') ?></span>
        </span>
      </a>
    <?php endforeach; ?>
  </div>

  <div class="svc-cta" data-reveal>
    <span class="svc-cta__icon"><?= icon('clipboard') ?></span>
    <div>
      <h3>Not sure what your roof needs?</h3>
      <p>Book a free, no-obligation inspection. We'll check your roof and give you honest advice and a clear quote.</p>
    </div>
    <div class="svc-cta__actions">
      <a class="btn btn--dark" href="<?= e(url('free-quote')) ?>">Book a free inspection <?= icon('arrow-right', 'icon-shift') ?></a>
      <a class="btn btn--outline-dark" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> <?= e(config('phone')) ?></a>
    </div>
  </div>
</div>
