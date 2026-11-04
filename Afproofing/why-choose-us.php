<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
  'title' => 'Why Choose AF Prestige Roofing | Adelaide Roof Restorers',
  'description' => 'Quality workmanship, attention to detail, reliable service and a commitment to customer satisfaction. See why Adelaide homeowners choose AF Prestige Roofing.',
  'path' => 'why-choose-us',
  'schema' => [breadcrumb_schema([['Why Choose Us', 'why-choose-us']])],
];
include ROOT_PATH . '/includes/header.php';

partial('page-hero', [
  'title' => 'Why Choose AF Prestige Roofing?',
  'lead' => 'We built our business on doing roofs properly: quality workmanship, attention to detail, reliable service and customers who are genuinely happy with the result.',
  'eyebrow' => 'About us',
  'crumbs' => [['Why Choose Us', 'why-choose-us']],
  'image' => 'assets/img/services/Full Roof Restoration.jpg',
]);
?>

<section class="section">
  <div class="container split">
    <div class="split__media" data-reveal>
      <div class="media-frame">
        <img src="<?= e(asset('assets/img/services/why-choose-section1.jpg')) ?>"
          alt="Ridge capping before and after re-bedding and repointing"
          <?= img_size('assets/img/services/ridge-capping.jpg') ?> loading="lazy" decoding="async">
        <div class="media-badge">
          <span class="media-badge__icon"><?= icon('award') ?></span>
          <div><strong>Pride in every roof</strong><span>Local Adelaide roof restorers</span></div>
        </div>
      </div>
    </div>
    <div class="split__content" data-reveal>
     
      <h2>Quality Roof Restoration You Can Trust</h2>
      <p>AF Prestige Roofing is a locally owned and operated roofing company servicing Adelaide and regional areas
        within <?= e(config('service_radius_km')) ?>km. We specialise in tiled roofs, terracotta and concrete, and focus
        on one thing: restoring roofs to a standard we're proud to put our name to.</p>
      <p>Your roof protects everything underneath it, so we never cut corners. Every job starts with an honest
        inspection and a clear quote, and finishes with a walk-through to make sure you're completely satisfied.</p>
      <a class="btn btn--dark" href="<?= e(url('free-quote')) ?>">Book a free inspection
        <?= icon('arrow-right', 'icon-shift') ?></a>
    </div>
  </div>
</section>

<section class="section section--ink">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Our promise</p>
      <h2>What you can <span class="hl">expect</span></h2>
    </div>
    <?php partial('features'); ?>
  </div>
</section>

<section class="section section--paper">
  <div class="container split split--reverse">
    <div class="split__media" data-reveal>
      <div class="media-frame">
        <img src="<?= e(asset('assets/img/services/roof-painting.jpg')) ?>"
          alt="Concrete tile roof part-way through sealing and painting"
          <?= img_size('assets/img/services/roof-painting.jpg') ?> loading="lazy" decoding="async">
      </div>
    </div>
    <div class="split__content" data-reveal>
      <p class="eyebrow">Attention to detail</p>
      <h2>The details make the <span class="hl-mark">difference</span></h2>
      <p>Anyone can make a roof look good from the street on day one. A premium restoration is about the details you
        don't always see: thorough preparation, properly bedded ridge caps, neat pointing and even coats that bond to
        every tile.</p>
      <ul class="checklist">
        <li><?= icon('check') ?>Thorough preparation before any coating goes on</li>
        <li><?= icon('check') ?>Straight, even ridge lines and neat flexible pointing</li>
        <li><?= icon('check') ?>Gardens, paving and windows protected while we work</li>
        <li><?= icon('check') ?>A clean, tidy site at the end of every day</li>
        <li><?= icon('check') ?>Clear communication from quote to completion</li>
      </ul>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Our process</p>
      <h2>Simple, transparent, <span class="hl-mark">stress-free</span></h2>
    </div>
    <?php partial('process'); ?>
  </div>
</section>

<section class="section section--paper">
  <div class="container">
    <div class="section-head section-head--split">
      <div>
        <p class="eyebrow">Reviews</p>
        <h2>Don't just take our <span class="hl-mark">word for it</span></h2>
      </div>
      <a class="btn btn--outline-dark" href="<?= e(url('reviews')) ?>">All reviews
        <?= icon('arrow-right', 'icon-shift') ?></a>
    </div>
    <div class="reviews-grid">
      <?php foreach (array_slice($reviews, 0, 3) as $review)
        partial('review-card', ['review' => $review]); ?>
    </div>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>