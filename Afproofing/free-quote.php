<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
  'title' => 'Free Roof Restoration Quote Adelaide | AF Prestige Roofing',
  'description' => 'Get a free, no-obligation roof restoration quote in Adelaide. Free roof inspection and clear, itemised pricing for terracotta and concrete tiled roofs.',
  'path' => 'free-quote',
  'hide_cta' => true,
  'body_class' => 'page-quote',
  'schema' => [breadcrumb_schema([['Free Quote', 'free-quote']])],
];
include ROOT_PATH . '/includes/header.php';

partial('page-hero', [
  'title' => 'Get a Free Roof Restoration Quote',
  'lead' => 'Free inspection. Honest advice. A clear, itemised quote with no obligation and no hidden extras.',
  'eyebrow' => '100% free & no obligation',
  'crumbs' => [['Free Quote', 'free-quote']],
  'image' => 'assets/img/services/free-quote-hero-banner.png',
  'actions' => false,
]);
?>

<section class="section section--paper">
  <div class="container quote-layout">
    <div>
      <h2>What happens <span class="hl-mark">next?</span></h2>
      <ol class="steps-mini">
        <li>
          <div><strong>Send your details</strong><span>Fill in the form or call us on <a
                href="<?= e(phone_href()) ?>"><?= e(config('phone')) ?></a>.</span></div>
        </li>
        <li>
          <div><strong>We contact you</strong><span>We'll get in touch to understand your roof and book a time to
              inspect it.</span></div>
        </li>
        <li>
          <div><strong>Free roof inspection</strong><span>We check your tiles, ridge capping, valleys and pointing, and
              show you what we find.</span></div>
        </li>
        <li>
          <div><strong>Your itemised quote</strong><span>A clear quote with exactly what's included. No pressure, no
              obligation.</span></div>
        </li>
      </ol>

      <ul class="checklist mt-lg">
        <li><?= icon('check') ?>Terracotta &amp; concrete tile specialists</li>
        <li><?= icon('check') ?>Quality workmanship and attention to detail</li>
        <li><?= icon('check') ?>Servicing Adelaide &amp; regional areas within <?= e(config('service_radius_km')) ?>km
        </li>
        <li><?= icon('check') ?>Honest recommendations, with only the work your roof needs</li>
      </ul>

      <div class="sidebar-card sidebar-card--dark mt-lg">
        <h3>Prefer to talk?</h3>
        <p>Call us for friendly advice or to book your free inspection over the phone.</p>
        <a class="call-number" href="<?= e(phone_href()) ?>"><?= icon('phone') ?><?= e(config('phone')) ?></a>
      </div>
    </div>

    <div class="form-panel">
      <h2>Request your free quote</h2>
      <p>Takes less than a minute. Fields marked * are required.</p>
      <?php partial('quote-form', ['id' => 'quote', 'variant' => 'full']); ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Reviews</p>
      <h2>Trusted by Adelaide <span class="hl-mark">homeowners</span></h2>
    </div>
    <div class="reviews-grid">
      <?php foreach (array_slice($reviews, 0, 3) as $review)
        partial('review-card', ['review' => $review]); ?>
    </div>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>