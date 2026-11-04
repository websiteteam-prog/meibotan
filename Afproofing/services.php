<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
  'title' => 'Roofing Services Adelaide | Roof Restoration & Repairs',
  'description' => 'Roof restoration, roof painting, roof cleaning, ridge capping, tile replacement and tiled roof repairs across Adelaide. Terracotta & concrete specialists.',
  'path' => 'services',
  'schema' => [breadcrumb_schema([['Services', 'services']])],
];
include ROOT_PATH . '/includes/header.php';

partial('page-hero', [
  'title' => 'Our Roof Restoration Services',
  'lead' => 'Specialist services for terracotta and concrete tiled roofs across Adelaide, from a single broken tile to a complete, start-to-finish restoration.',
  'eyebrow' => 'Services',
  'image' => 'assets/img/services/roof-restoration.png',
]);
?>

<section class="section">
  <div class="container service-rows">
    <?php $n = 0;
    foreach ($services as $slug => $service):
      $n++; ?>
      <article class="split<?= $n % 2 === 0 ? ' split--reverse' : '' ?> service-row" id="<?= e($slug) ?>">
        <div class="split__media" data-reveal>
          <a class="media-frame" href="<?= e(service_url($slug)) ?>" tabindex="-1" aria-hidden="true">
            <img src="<?= e(asset($service['image'])) ?>" alt="" <?= img_size($service['image']) ?> loading="lazy"
              decoding="async">
          </a>
        </div>
        <div class="split__content" data-reveal>
          <span class="service-row__num"><?= sprintf('%02d', $n) ?></span>
          <h2><a class="plain-link" href="<?= e(service_url($slug)) ?>"><?= e($service['name']) ?></a></h2>
          <p><?= e($service['lead']) ?></p>
          <ul class="checklist">
            <?php foreach (array_slice($service['includes'], 0, 4) as $item): ?>
              <li><?= icon('check') ?><?= e($item) ?></li>
            <?php endforeach; ?>
          </ul>
          <div class="service-row__actions">
            <a class="btn btn--dark" href="<?= e(service_url($slug)) ?>">Learn more <span class="visually-hidden">about
                <?= e($service['name']) ?></span><?= icon('arrow-right', 'icon-shift') ?></a>
            <a class="btn btn--outline-dark" href="<?= e(url('free-quote')) ?>">Free quote</a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="section section--paper">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">How it works</p>
      <h2>From inspection to <span class="hl-mark">finished roof</span></h2>
    </div>
    <?php partial('process'); ?>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
