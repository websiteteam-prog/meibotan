<?php
/**
 * Service detail page: /services/{slug}
 *
 * One page is generated for every service in includes/data/services.php
 * (name, image, intro, sections, what's included, FAQs and related services),
 * so adding or editing a service there updates its page automatically.
 */
require_once __DIR__ . '/includes/bootstrap.php';

$slug = (string) ($_GET['slug'] ?? '');
$service = $services[$slug] ?? null;

if ($service === null) {
    require __DIR__ . '/404.php';
    exit;
}

$path = 'services/' . $slug;
$GLOBALS['preselect_service'] = $slug; // pre-selects this service in the quote form

// Previous / next service (wraps around), so every service page links to the others.
$slugs = array_keys($services);
$index = array_search($slug, $slugs, true);
$prevSlug = $slugs[($index - 1 + count($slugs)) % count($slugs)];
$nextSlug = $slugs[($index + 1) % count($slugs)];

$page = [
    'title'       => $service['meta_title'],
    'description' => $service['meta_description'],
    'path'        => $path,
    'image'       => $service['image'],
    'body_class'  => 'page-service',
    'schema'      => [
        breadcrumb_schema([['Services', 'services'], [$service['name'], $path]]),
        [
            '@type'       => 'Service',
            '@id'         => absolute_url($path . '#service'),
            'name'        => $service['name'],
            'serviceType' => $service['name'],
            'description' => $service['meta_description'],
            'url'         => absolute_url($path),
            'image'       => absolute_url($service['image']),
            'provider'    => ['@id' => absolute_url('#business')],
            'areaServed'  => [['@type' => 'City', 'name' => 'Adelaide'], service_area_schema()],
        ],
        faq_schema($service['faqs']),
    ],
];
include ROOT_PATH . '/includes/header.php';

partial('page-hero', [
    'title'   => $service['h1'],
    'lead'    => $service['lead'],
    'eyebrow' => 'Adelaide roofing services',
    'crumbs'  => [['Services', 'services'], [$service['name'], $path]],
    'image'   => $service['image'],
]);

partial('trust-strip');
?>

<!-- Overview, details and what's included, with the quote form alongside ---------->
<section class="section">
  <div class="container content-layout">
    <article class="prose service-body">
      <p class="eyebrow">About this service</p>
      <?php foreach ($service['intro'] as $i => $paragraph): ?>
        <p<?= $i === 0 ? ' class="lead-text"' : '' ?>><?= e($paragraph) ?></p>
      <?php endforeach; ?>

      <figure class="service-figure">
        <img src="<?= e(asset($service['image'])) ?>" alt="<?= e($service['name']) ?> on a tiled roof in Adelaide" <?= img_size($service['image']) ?> loading="lazy" decoding="async">
        <figcaption class="service-figure__badge">
          <span class="service-figure__icon"><?= icon($service['icon']) ?></span>
          <span><strong><?= e($service['name']) ?></strong>Free inspection &amp; itemised quote</span>
        </figcaption>
      </figure>

      <?php foreach ($service['sections'] as $section): ?>
        <h2><?= e($section['title']) ?></h2>
        <?php foreach ($section['body'] ?? [] as $paragraph): ?>
          <p><?= e($paragraph) ?></p>
        <?php endforeach; ?>
        <?php if (!empty($section['list'])): ?>
          <?php $tag = !empty($section['ordered']) ? 'ol' : 'ul'; ?>
          <<?= $tag ?>>
            <?php foreach ($section['list'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
          </<?= $tag ?>>
        <?php endif; ?>
      <?php endforeach; ?>

      <div class="includes-box">
        <div class="includes-box__head">
          <span class="includes-box__icon"><?= icon($service['icon']) ?></span>
          <h2>What's included</h2>
        </div>
        <ul class="checklist checklist--2col">
          <?php foreach ($service['includes'] as $item): ?>
            <li><?= icon('check') ?><?= e($item) ?></li>
          <?php endforeach; ?>
        </ul>
        <div class="includes-box__actions">
          <a class="btn btn--primary" href="<?= e(url('free-quote')) ?>">Get a Free Quote <?= icon('arrow-right', 'icon-shift') ?></a>
          <a class="btn btn--outline" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> <?= e(config('phone')) ?></a>
        </div>
      </div>

      <nav class="service-pager" aria-label="More services">
        <?php foreach ([['Previous service', $prevSlug, 'prev'], ['Next service', $nextSlug, 'next']] as [$label, $pagerSlug, $dir]): $pager = $services[$pagerSlug]; ?>
          <a class="service-pager__link service-pager__link--<?= $dir ?>" href="<?= e(service_url($pagerSlug)) ?>">
            <img src="<?= e(asset($pager['image'])) ?>" alt="" width="72" height="72" loading="lazy" decoding="async">
            <span><small><?= e($label) ?></small><strong><?= e($pager['name']) ?></strong></span>
            <?= icon('arrow-right') ?>
          </a>
        <?php endforeach; ?>
      </nav>
    </article>

    <aside class="sidebar" aria-label="Get a quote">
      <div class="quote-card">
        <span class="quote-card__badge">Free quote</span>
        <h2 class="quote-card__title">Get a Free Quote</h2>
        <p class="quote-card__sub">No obligation. We'll arrange a free inspection at a time that suits you.</p>
        <?php partial('quote-form', ['id' => 'sidebar', 'variant' => 'compact']); ?>
      </div>
      <div class="sidebar-card sidebar-card--dark">
        <h2>Prefer to talk?</h2>
        <p>Call us for friendly advice or to book your free roof inspection.</p>
        <a class="call-number" href="<?= e(phone_href()) ?>"><?= icon('phone') ?><?= e(config('phone')) ?></a>
      </div>
      <nav class="sidebar-card" aria-label="Other services">
        <h2>Our Services</h2>
        <ul class="service-links">
          <?php foreach ($services as $otherSlug => $other): ?>
            <li><a href="<?= e(service_url($otherSlug)) ?>"<?= $otherSlug === $slug ? ' aria-current="page"' : '' ?>><?= e($other['name']) ?><?= icon('arrow-right') ?></a></li>
          <?php endforeach; ?>
        </ul>
        <a class="link-arrow service-links__all" href="<?= e(url('services')) ?>">View all services <?= icon('arrow-right') ?></a>
      </nav>
    </aside>
  </div>
</section>

<!-- Before & after ---------------------------------------------------------------->
<section class="section section--dark">
  <div class="container">
    <div class="section-head section-head--split">
      <div>
        <p class="eyebrow">Our work</p>
        <h2>Before &amp; <span class="hl">after</span></h2>
        <p>Drag the slider to see the transformation.</p>
      </div>
      <a class="btn btn--outline" href="<?= e(url('gallery')) ?>">View full gallery <?= icon('arrow-right', 'icon-shift') ?></a>
    </div>
    <div class="ba-grid">
      <?php foreach (gallery_for_service($slug) as $project) partial('ba-card', ['project' => $project]); ?>
    </div>
  </div>
</section>

<!-- FAQs ------------------------------------------------------------------------------>
<section class="section section--paper">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">FAQs</p>
      <h2><?= e($service['name']) ?> <span class="hl-mark">questions</span></h2>
    </div>
    <?php partial('faq', ['faqs' => $service['faqs']]); ?>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
