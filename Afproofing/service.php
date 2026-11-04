<?php
/**
 * Individual service page: /services/{slug}. Content comes from includes/data/services.php.
 */
require_once __DIR__ . '/includes/bootstrap.php';

$slug = (string) ($_GET['slug'] ?? '');
$service = $services[$slug] ?? null;

if ($service === null) {
    require __DIR__ . '/404.php';
    exit;
}

$path = 'services/' . $slug;
$GLOBALS['preselect_service'] = $slug;

$page = [
    'title'       => $service['meta_title'],
    'description' => $service['meta_description'],
    'path'        => $path,
    'image'       => $service['image'],
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
            'areaServed'  => ['@type' => 'City', 'name' => 'Adelaide'],
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
?>

<section class="section">
  <div class="container content-layout">
    <article class="prose">
      <?php foreach ($service['intro'] as $i => $paragraph): ?>
        <p<?= $i === 0 ? ' class="lead-text"' : '' ?>><?= e($paragraph) ?></p>
      <?php endforeach; ?>

      <figure>
        <img src="<?= e(asset($service['image'])) ?>" alt="<?= e($service['name']) ?> on a tiled roof in Adelaide" <?= img_size($service['image']) ?> loading="lazy" decoding="async">
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
        <h2>What's included</h2>
        <ul class="checklist checklist--2col">
          <?php foreach ($service['includes'] as $item): ?>
            <li><?= icon('check') ?><?= e($item) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
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
      </nav>
    </aside>
  </div>
</section>

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

<section class="section section--paper">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">FAQs</p>
      <h2><?= e($service['name']) ?> <span class="hl-mark">questions</span></h2>
    </div>
    <?php partial('faq', ['faqs' => $service['faqs']]); ?>
  </div>
</section>

<section class="section section--dark">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow">Related services</p>
      <h2>You might also <span class="hl">need</span></h2>
    </div>
    <div class="service-grid service-grid--3">
      <?php foreach ($service['related'] as $n => $relatedSlug): $related = $services[$relatedSlug]; ?>
        <a class="service-card" href="<?= e(service_url($relatedSlug)) ?>" data-reveal>
          <span class="service-card__icon"><?= icon($related['icon']) ?></span>
          <h3><?= e($related['name']) ?></h3>
          <p><?= e($related['excerpt']) ?></p>
          <span class="service-card__more">Learn more <?= icon('arrow-right') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
