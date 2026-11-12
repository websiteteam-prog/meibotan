<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
  'title' => 'Service Areas | Roofing Across Adelaide & Regional SA',
  'description' => 'AF Prestige Roofing services all of Adelaide and regional South Australia, including the Adelaide Hills, Barossa, Fleurieu Peninsula, Murray Bridge and Adelaide Plains. Free quotes.',
  'path' => 'service-areas',
  'body_class' => 'page-areas',
  'schema' => [breadcrumb_schema([['Service Areas', 'service-areas']])],
];
include ROOT_PATH . '/includes/header.php';

partial('page-hero', [
  'title' => 'Roofing Across Adelaide & Regional SA',
  'lead' => 'We restore, repair and paint tiled roofs throughout metropolitan Adelaide and regional South Australia. Find your area below, or call us to check.',
  'eyebrow' => 'Service areas',
  'crumbs' => [['Service Areas', 'service-areas']],
  'image' => 'assets/img/services/service-area-hero-banner.png',
]);

// ---------------------------------------------------------------------------
// Page data (regions and suburbs come from includes/data/areas.php)
// ---------------------------------------------------------------------------
// Approximate driving distance of each region from the Adelaide CBD.
$regionDistance = [
  'Inner Adelaide' => '0–6 km',
  'Northern Suburbs' => '10–35 km',
  'Southern Suburbs' => '10–35 km',
  'Eastern Suburbs' => '4–12 km',
  'Western Suburbs' => '8–16 km',
  'Adelaide Hills' => '15–55 km',
  'Gawler & Barossa' => '40–80 km',
  'Fleurieu Peninsula' => '40–85 km',
  'Murray Bridge & Murraylands' => '55–85 km',
  'Adelaide Plains' => '30–60 km',
];
$areaId = fn(string $name): string => 'area-' . trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($name)), '-');

$placeCount = 0;
$finderList = [];
foreach ($areas as $region) {
  $placeCount += count($region['suburbs']);
  foreach ($region['suburbs'] as $suburb) {
    $finderList[] = ['n' => $suburb, 'r' => $region['name'], 'id' => $areaId($region['name'])];
  }
}

// Coverage diagram: where each regional area sits from the CBD (km and compass bearing).
// A schematic only: 2.2px per km from the centre of a 520px square. It isn't a limit,
// the business also travels further across South Australia.
$mapScale = 2.2;
$mapPoints = [
  ['name' => 'Gawler & Barossa', 'label' => 'Gawler & Barossa', 'km' => 60, 'deg' => 20, 'dx' => 12, 'dy' => -10, 'anchor' => 'start'],
  ['name' => 'Adelaide Plains', 'label' => 'Adelaide Plains', 'km' => 45, 'deg' => 335, 'dx' => -12, 'dy' => -10, 'anchor' => 'end'],
  ['name' => 'Adelaide Hills', 'label' => 'Adelaide Hills', 'km' => 32, 'deg' => 120, 'dx' => 12, 'dy' => 18, 'anchor' => 'start'],
  ['name' => 'Murray Bridge & Murraylands', 'label' => 'Murray Bridge', 'km' => 75, 'deg' => 100, 'dx' => 0, 'dy' => -16, 'anchor' => 'middle'],
  ['name' => 'Fleurieu Peninsula', 'label' => 'Fleurieu', 'km' => 70, 'deg' => 200, 'dx' => 12, 'dy' => 20, 'anchor' => 'start'],
];
$mapXY = function (float $km, float $deg) use ($mapScale): array {
  $rad = deg2rad($deg);
  return [round(260 + sin($rad) * $km * $mapScale, 1), round(260 - cos($rad) * $km * $mapScale, 1)];
};

$conditions = [
  ['icon' => 'drop', 'title' => 'Coast & river towns', 'text' => 'Salt air and strong winds are hard on mortar and coatings, from Glenelg and Semaphore to Victor Harbor and Murray Bridge.'],
  ['icon' => 'leaf', 'title' => 'Hills & valleys', 'text' => 'More rain, leaf litter, moss and lichen in the Adelaide Hills and the Barossa, so cleaning and gutters matter.'],
  ['icon' => 'sun', 'title' => 'Suburbs & plains', 'text' => 'Long, hot summers and strong UV fade tiles and dry out pointing right across the city and the Adelaide Plains.'],
];
?>

<!-- Area finder + quick facts -------------------------------------------------->
<section class="areas-finder-wrap">
  <div class="container">
    <div class="areas-finder" data-reveal>
      <div class="areas-finder__main">
        <p class="eyebrow">Check your area</p>
        <h2>Do we service <span class="hl-mark">your suburb?</span></h2>
        <form class="areas-finder__form" id="area-finder" action="#areas-list" role="search" autocomplete="off">
          <label class="visually-hidden" for="area-finder-input">Your suburb or town</label>
          <span class="areas-finder__field">
            <?= icon('search') ?>
            <input id="area-finder-input" type="text" list="area-finder-list"
              placeholder="Type your suburb, e.g. Glenelg" maxlength="60">
          </span>
          <button class="btn btn--primary" type="submit">Check</button>
          <datalist id="area-finder-list">
            <?php foreach ($finderList as $place): ?>
              <option value="<?= e($place['n']) ?>"><?php endforeach; ?>
          </datalist>
        </form>
        <p class="areas-finder__try"><span>Try:</span>
          <?php foreach (['Glenelg', 'Mount Barker', 'Tanunda', 'Victor Harbor', 'Murray Bridge'] as $example): ?>
            <button type="button" data-try="<?= e($example) ?>"><?= e($example) ?></button>
          <?php endforeach; ?>
        </p>
        <div class="areas-finder__result" id="area-finder-result" aria-live="polite" hidden></div>
        <noscript>
          <p class="areas-finder__hint">See the full list of suburbs and towns below, or call us on
            <?= e(config('phone')) ?>.</p>
        </noscript>
      </div>
      <ul class="areas-stats">
        <li><strong>20+</strong><span>Years of roofing experience</span></li>
        <li><strong><?= count($areas) ?></strong><span>Regions, metro &amp; regional</span></li>
        <li><strong><?= e($placeCount) ?>+</strong><span>Suburbs &amp; towns we visit regularly</span></li>
        <li><strong>Free</strong><span>On-site roof inspections &amp; quotes</span></li>
      </ul>
    </div>
  </div>
</section>

<!-- Coverage diagram ------------------------------------------------------------>
<section class="section section--dark section--tiles areas-coverage">
  <div class="container areas-coverage__grid">
    <div class="areas-coverage__text" data-reveal>
      <p class="eyebrow">Where we travel</p>
      <h2>Adelaide &amp; <span class="hl">regional South Australia</span></h2>
      <p>We service every suburb of metropolitan Adelaide and travel right across regional South Australia.
        Whether you're in the city, up in the Hills, on the Fleurieu coast or out in the Barossa, you get the same free
        inspection, honest advice and quality finish.</p>
      <ul class="coverage-legend">
        <?php foreach ($areas as $region):
          if (($region['group'] ?? 'metro') !== 'regional')
            continue; ?>
          <li><a href="#<?= e($areaId($region['name'])) ?>"><span
                class="coverage-legend__dot"></span><?= e($region['name']) ?><small><?= e($regionDistance[$region['name']] ?? '') ?></small></a>
          </li>
        <?php endforeach; ?>
        <li><a href="#area-group-metro"><span
              class="coverage-legend__dot coverage-legend__dot--metro"></span>Metropolitan Adelaide<small>All
              suburbs</small></a></li>
        <li><a href="<?= e(phone_href()) ?>"><span
              class="coverage-legend__dot coverage-legend__dot--more"></span>Further across SA<small>Just
              ask</small></a></li>
      </ul>
    </div>

    <figure class="coverage-map" data-reveal>
      <svg viewBox="0 0 520 520" role="img" aria-labelledby="coverage-map-title">
        <title id="coverage-map-title">Diagram of our service area: metropolitan Adelaide and regional South Australia</title>
        <defs>
          <radialGradient id="coverage-glow" cx="50%" cy="50%" r="50%">
            <stop offset="0%" stop-color="#ffc20e" stop-opacity=".22" />
            <stop offset="100%" stop-color="#ffc20e" stop-opacity="0" />
          </radialGradient>
        </defs>
        <circle cx="260" cy="260" r="220" class="coverage-map__area" />
        <?php foreach ([55, 110, 165, 220] as $r): ?>
          <circle cx="260" cy="260" r="<?= $r ?>" class="coverage-map__ring" />
        <?php endforeach; ?>
        <text x="260" y="504" class="coverage-map__beyond">&hellip; and further across South Australia</text>
        <line x1="260" y1="30" x2="260" y2="490" class="coverage-map__axis" />
        <line x1="30" y1="260" x2="490" y2="260" class="coverage-map__axis" />
        <g class="coverage-map__north" transform="translate(492 40)" aria-hidden="true">
          <path d="M0 -16 L8 6 L0 1 L-8 6 Z" /><text y="24">N</text>
        </g>

        <circle cx="260" cy="260" r="<?= round(24 * $mapScale, 1) ?>" fill="url(#coverage-glow)" />
        <a href="#area-group-metro">
          <circle cx="260" cy="260" r="<?= round(18 * $mapScale, 1) ?>" class="coverage-map__metro" />
          <text x="260" y="256" class="coverage-map__metro-label">Metro</text>
          <text x="260" y="272" class="coverage-map__metro-label">Adelaide</text>
        </a>

        <?php foreach ($mapPoints as $point):
          [$x, $y] = $mapXY($point['km'], $point['deg']); ?>
          <a href="#<?= e($areaId($point['name'])) ?>" class="coverage-map__point">
            <circle cx="<?= $x ?>" cy="<?= $y ?>" r="16" class="coverage-map__pulse" />
            <circle cx="<?= $x ?>" cy="<?= $y ?>" r="8" class="coverage-map__dot" />
            <text x="<?= $x + $point['dx'] ?>" y="<?= $y + $point['dy'] ?>" text-anchor="<?= $point['anchor'] ?>"
              class="coverage-map__label"><?= e($point['label']) ?></text>
          </a>
        <?php endforeach; ?>
      </svg>
      <figcaption>Not to scale. Distances are approximate driving distances from the Adelaide CBD.</figcaption>
    </figure>
  </div>
</section>

<!-- Regions and suburbs ---------------------------------------------------------->
<section class="section section--paper" id="areas-list">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Where we work</p>
      <h2>Suburbs &amp; towns <span class="hl-mark">we service</span></h2>
      <p>These are just some of the places we work in regularly. If yours isn't listed, get in touch. Chances are we
        cover it.</p>
    </div>
    <?php
    $areaGroups = [
      'metro' => ['Metropolitan Adelaide', 'All suburbs, north, south, east and west', 'map'],
      'regional' => ['Regional areas', 'Country towns across South Australia', 'pin'],
    ];
    foreach ($areaGroups as $groupKey => [$groupTitle, $groupNote, $groupIcon]):
      $groupAreas = array_filter($areas, fn($region) => ($region['group'] ?? 'metro') === $groupKey);
      if (!$groupAreas)
        continue; ?>
      <div class="areas-group areas-group--<?= e($groupKey) ?>" id="area-group-<?= e($groupKey) ?>">
        <div class="areas-group__head">
          <span class="areas-group__icon"><?= icon($groupIcon) ?></span>
          <div>
            <h3 class="areas-group__title"><?= e($groupTitle) ?></h3>
            <p><?= e($groupNote) ?></p>
          </div>
        </div>
        <div class="region-cards">
          <?php foreach ($groupAreas as $region): ?>
            <article class="region-card" id="<?= e($areaId($region['name'])) ?>" data-reveal>
              <div class="region-card__head">
                <h4><?= e($region['name']) ?></h4>
                <?php if (!empty($regionDistance[$region['name']])): ?>
                  <span class="region-card__km"
                    title="Approximate driving distance from the Adelaide CBD"><?= icon('pin') ?><?= e($regionDistance[$region['name']]) ?></span>
                <?php endif; ?>
              </div>
              <p><?= e($region['blurb']) ?></p>
              <ul class="chips chips--light">
                <?php foreach ($region['suburbs'] as $suburb): ?>
                  <li data-place="<?= e(mb_strtolower($suburb)) ?>"><?= e($suburb) ?></li><?php endforeach; ?>
              </ul>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="areas-note" data-reveal>
      <span class="areas-note__icon"><?= icon('phone') ?></span>
      <p><strong>Can't see your suburb?</strong> We regularly travel further for larger jobs. Give us a call and we'll
        let you know straight away.</p>
      <a class="btn btn--outline-dark" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> <?= e(config('phone')) ?></a>
    </div>
  </div>
</section>

<!-- Local conditions + map ------------------------------------------------------->
<section class="section">
  <div class="container split areas-local">
    <div class="split__content" data-reveal>
      <p class="eyebrow">Local knowledge</p>
      <h2>Roofing built for <span class="hl-mark">Adelaide conditions</span></h2>
      <p>Every part of our service area is tough on roofs in its own way. We tailor each restoration to your home, from
        the cleaning method to the coating and pointing we recommend.</p>
      <ul class="conditions">
        <?php foreach ($conditions as $condition): ?>
        <li>
          <span class="conditions__icon">
            <?= icon($condition['icon']) ?>
          </span>
          <div>
            <h3>
              <?= e($condition['title']) ?>
            </h3>
            <p>
              <?= e($condition['text']) ?>
            </p>
          </div>
        </li>
        <?php endforeach; ?>
      </ul>
      <a class="btn btn--dark areas-local__btn" href="<?= e(url('free-quote')) ?>">Get a free quote in your area
        <?= icon('arrow-right', 'icon-shift') ?>
      </a>
    </div>
    <div class="map-embed areas-local__map" data-reveal>
      <iframe src="https://www.google.com/maps?q=Adelaide%20SA&amp;z=8&amp;output=embed"
        title="Map of our service area: Adelaide and regional South Australia" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</section>

<!-- Services ----------------------------------------------------------------------->
<section class="section section--paper">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Services in your area</p>
      <h2>What we can do for <span class="hl-mark">your roof</span></h2>
    </div>
    <div class="features features--light">
      <?php foreach ($services as $slug => $service): ?>
      <a class="feature plain-link" href="<?= e(service_url($slug)) ?>" data-reveal>
        <span class="feature__icon">
          <?= icon($service['icon']) ?>
        </span>
        <h3>
          <?= e($service['name']) ?>
        </h3>
        <p>
          <?= e($service['excerpt']) ?>
        </p>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
  // "Do we service your suburb?" checker. Matches against the suburbs listed on this page.
  (function () {
    var places = <?= json_encode($finderList, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    var form = document.getElementById('area-finder');
    var input = document.getElementById('area-finder-input');
    var result = document.getElementById('area-finder-result');
    var quoteUrl = <?= json_encode(url('free-quote'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    var phoneHref = <?= json_encode(phone_href(), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    var phone = <?= json_encode((string) config('phone'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    if (!form || !input || !result) return;

    function norm(s) { return String(s).toLowerCase().replace(/\s+/g, ' ').trim(); }
    function esc(s) { return String(s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
    function clearHighlights() {
      document.querySelectorAll('.chips li.is-match').forEach(function (li) { li.classList.remove('is-match'); });
    }
    function find(q) {
      var exact = places.filter(function (p) { return norm(p.n) === q; });
      if (exact.length) return exact[0];
      var starts = places.filter(function (p) { return norm(p.n).indexOf(q) === 0; });
      return starts.length === 1 ? starts[0] : null;
    }
    function show(final) {
      var q = norm(input.value);
      clearHighlights();
      if (q.length < 2) { result.hidden = true; result.innerHTML = ''; return; }
      var match = find(q);
      if (match) {
        var chip = document.querySelector('.chips li[data-place="' + norm(match.n).replace(/"/g, '') + '"]');
        if (chip) chip.classList.add('is-match');
        result.className = 'areas-finder__result is-yes';
        result.innerHTML = '<span class="areas-finder__badge">✓</span><div><strong>Yes, we service ' + esc(match.n) + '!</strong>' +
          '<span>It’s in our <a href="#' + esc(match.id) + '">' + esc(match.r) + '</a> area. Book your free inspection and quote.</span></div>' +
          '<a class="btn btn--primary" href="' + esc(quoteUrl) + '">Get a free quote</a>';
        result.hidden = false;
      } else if (final || q.length >= 4) {
        result.className = 'areas-finder__result is-maybe';
        result.innerHTML = '<span class="areas-finder__badge">?</span><div><strong>“' + esc(input.value.trim()) + '” isn’t on our list yet</strong>' +
          '<span>We also travel across regional South Australia, so we can most likely help. Give us a call to check.</span></div>' +
          '<a class="btn btn--outline-dark" href="' + esc(phoneHref) + '">Call ' + esc(phone) + '</a>';
        result.hidden = false;
      } else {
        result.hidden = true; result.innerHTML = '';
      }
    }
    input.addEventListener('input', function () { show(false); });
    document.querySelectorAll('[data-try]').forEach(function (btn) {
      btn.addEventListener('click', function () { input.value = btn.getAttribute('data-try'); show(true); });
    });
    form.addEventListener('submit', function (e) { e.preventDefault(); show(true); });
  })();
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>