<?php
/** Grid of service cards plus a "free inspection" card. Vars: $exclude (slug to skip). */
defined('ROOT_PATH') || exit;
$exclude = $exclude ?? '';
$n = 0;
?>
<div class="service-grid">
  <?php foreach ($GLOBALS['services'] as $slug => $service): if ($slug === $exclude) continue; $n++; ?>
    <a class="service-card" href="<?= e(service_url($slug)) ?>" data-reveal>
      <span class="service-card__num" aria-hidden="true"><?= sprintf('%02d', $n) ?></span>
      <span class="service-card__icon"><?= icon($service['icon']) ?></span>
      <h3><?= e($service['name']) ?></h3>
      <p><?= e($service['excerpt']) ?></p>
      <span class="service-card__more">Learn more <?= icon('arrow-right') ?></span>
    </a>
  <?php endforeach; ?>
  <a class="service-card service-card--cta" href="<?= e(url('free-quote')) ?>" data-reveal>
    <span class="service-card__icon"><?= icon('clipboard') ?></span>
    <h3>Not sure what your roof needs?</h3>
    <p>Book a free, no-obligation inspection. We'll check your roof and give you honest advice and a clear quote.</p>
    <span class="service-card__more">Book a free inspection <?= icon('arrow-right') ?></span>
  </a>
</div>
