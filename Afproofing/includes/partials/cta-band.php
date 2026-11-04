<?php
defined('ROOT_PATH') || exit;
$title = $title ?? 'Ready for a roof that looks brand new?';
$text = $text ?? 'Book your free, no-obligation roof inspection and quote today. We service Adelaide and regional areas within ' . config('service_radius_km') . 'km.';
?>
<section class="cta-band" aria-labelledby="cta-band-title">
  <div class="container cta-band__inner">
    <div>
      <h2 id="cta-band-title"><?= e($title) ?></h2>
      <p><?= e($text) ?></p>
    </div>
    <div class="cta-band__actions">
      <a class="btn btn--dark btn--lg" href="<?= e(url('free-quote')) ?>">Get a Free Quote <?= icon('arrow-right', 'icon-shift') ?></a>
      <a class="btn btn--outline-dark btn--lg" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> <?= e(config('phone')) ?></a>
    </div>
  </div>
</section>
