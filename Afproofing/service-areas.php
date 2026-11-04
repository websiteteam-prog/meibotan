<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Service Areas | Roof Restoration Across Adelaide',
    'description' => 'AF Prestige Roofing restores tiled roofs across Adelaide: northern, southern, eastern and western suburbs, inner Adelaide and the Adelaide Hills. Free quotes.',
    'path'        => 'service-areas',
    'schema'      => [breadcrumb_schema([['Service Areas', 'service-areas']])],
];
include ROOT_PATH . '/includes/header.php';

partial('page-hero', [
    'title'   => 'Roof Restoration Across Adelaide',
    'lead'    => 'We restore, repair and paint tiled roofs throughout metropolitan Adelaide and the Adelaide Hills. Find your area below, or call us to check.',
    'eyebrow' => 'Service areas',
    'crumbs'  => [['Service Areas', 'service-areas']],
    'image'   => 'assets/img/services/roof-repairs.jpg',
]);
?>

<section class="section section--dark">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow">Where we work</p>
      <h2>Suburbs we <span class="hl">service</span></h2>
      <p>These are just some of the suburbs we work in regularly. If yours isn't listed, get in touch. Chances are we cover it.</p>
    </div>
    <div class="areas-grid">
      <?php foreach ($areas as $region): ?>
        <div class="area-card" data-reveal>
          <h3><?= icon('pin') ?><?= e($region['name']) ?></h3>
          <p><?= e($region['blurb']) ?></p>
          <ul class="chips">
            <?php foreach ($region['suburbs'] as $suburb): ?><li><?= e($suburb) ?></li><?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container split">
    <div class="split__content" data-reveal>
      <p class="eyebrow">Local knowledge</p>
      <h2>Roofing built for <span class="hl-mark">Adelaide conditions</span></h2>
      <p>Adelaide roofs face long, hot summers, strong UV and winter storms, while homes in the Hills deal with extra rain, leaf litter and moss. We tailor every restoration to your home's conditions, from the cleaning method to the coating and pointing we recommend.</p>
      <p>Whether you're on the coast, in the suburbs or up in the Hills, you'll get the same free inspection, honest advice and premium finish.</p>
      <a class="btn btn--dark" href="<?= e(url('free-quote')) ?>">Get a free quote in your suburb <?= icon('arrow-right', 'icon-shift') ?></a>
    </div>
    <div class="map-embed" data-reveal>
      <iframe src="https://www.google.com/maps?q=Adelaide%20SA&amp;z=9&amp;output=embed" title="Map of our Adelaide service area" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</section>

<section class="section section--paper">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Services in your area</p>
      <h2>What we can do for <span class="hl-mark">your roof</span></h2>
    </div>
    <div class="features features--light">
      <?php foreach ($services as $slug => $service): ?>
        <a class="feature plain-link" href="<?= e(service_url($slug)) ?>" data-reveal>
          <span class="feature__icon"><?= icon($service['icon']) ?></span>
          <h3><?= e($service['name']) ?></h3>
          <p><?= e($service['excerpt']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
