<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Service Areas | Roofing Across Adelaide & Regional SA',
    'description' => 'AF Prestige Roofing services all of Adelaide and regional areas within ' . config('service_radius_km') . 'km: the Adelaide Hills, Barossa, Fleurieu Peninsula, Murray Bridge and Adelaide Plains. Free quotes.',
    'path'        => 'service-areas',
    'schema'      => [breadcrumb_schema([['Service Areas', 'service-areas']])],
];
include ROOT_PATH . '/includes/header.php';

partial('page-hero', [
    'title'   => 'Roofing Across Adelaide & Regional SA',
    'lead'    => 'We restore, repair and paint tiled roofs throughout metropolitan Adelaide and regional areas up to ' . config('service_radius_km') . 'km from the city. Find your area below, or call us to check.',
    'eyebrow' => 'Service areas',
    'crumbs'  => [['Service Areas', 'service-areas']],
    'image'   => 'assets/img/services/roof-repairs.jpg',
]);
?>

<section class="section section--dark">
  <div class="container">
    <div class="section-head section-head--split">
      <div>
        <p class="eyebrow">Where we work</p>
        <h2>Adelaide &amp; <span class="hl">100km around it</span></h2>
        <p>We service every suburb of metropolitan Adelaide, plus regional towns up to <?= e(config('service_radius_km')) ?>km from the CBD. These are just some of the places we work in regularly. If yours isn't listed, get in touch. Chances are we cover it.</p>
      </div>
      <p class="radius-badge"><span class="radius-badge__num"><?= e(config('service_radius_km')) ?><small>km</small></span>
        <span>service radius from the Adelaide CBD</span></p>
    </div>
    <?php
    $areaGroups = [
      'metro'    => ['Metropolitan Adelaide', 'All suburbs, north, south, east and west'],
      'regional' => ['Regional areas', 'Country towns within ' . config('service_radius_km') . 'km of Adelaide'],
    ];
    foreach ($areaGroups as $groupKey => [$groupTitle, $groupNote]):
      $groupAreas = array_filter($areas, fn($region) => ($region['group'] ?? 'metro') === $groupKey);
      if (!$groupAreas) continue; ?>
      <div class="areas-group">
        <h3 class="areas-group__title"><?= e($groupTitle) ?> <span><?= e($groupNote) ?></span></h3>
        <div class="areas-grid">
          <?php foreach ($groupAreas as $region): ?>
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
    <?php endforeach; ?>
  </div>
</section>

<section class="section">
  <div class="container split">
    <div class="split__content" data-reveal>
      <p class="eyebrow">Local knowledge</p>
      <h2>Roofing built for <span class="hl-mark">Adelaide conditions</span></h2>
      <p>Adelaide roofs face long, hot summers, strong UV and winter storms. Homes in the Hills deal with extra rain, leaf litter and moss, while coastal and river towns cop salt air and wind. We tailor every restoration to your home's conditions, from the cleaning method to the coating and pointing we recommend.</p>
      <p>Whether you're in the suburbs, up in the Hills, on the Fleurieu coast or out in the Barossa, you'll get the same free inspection, honest advice and quality finish.</p>
      <a class="btn btn--dark" href="<?= e(url('free-quote')) ?>">Get a free quote in your area <?= icon('arrow-right', 'icon-shift') ?></a>
    </div>
    <div class="map-embed" data-reveal>
      <iframe src="https://www.google.com/maps?q=Adelaide%20SA&amp;z=8&amp;output=embed" title="Map of our service area: Adelaide and regional areas within <?= e(config('service_radius_km')) ?>km" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
