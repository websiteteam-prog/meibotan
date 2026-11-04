<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
  'title' => 'Roof Restoration Adelaide | AF Prestige Roofing',
  'description' => 'Premium roof restoration in Adelaide for terracotta and concrete tiled roofs. Roof cleaning, ridge capping, tile repairs and roof painting. Get a free quote.',
  'path' => '',
  'body_class' => 'page-home',
  'preload_image' => 'assets/img/hero.jpg',
  'schema' => [faq_schema($faqs)],
];
include ROOT_PATH . '/includes/header.php';
?>

<section class="hero">
  <div class="hero__bg"><img src="<?= e(asset('assets/img/Rooftop Restoration at Golden Hour.png')) ?>" alt=""
      <?= img_size('assets/img/hero.jpg') ?> fetchpriority="high"></div>
  <div class="container">
    <div class="hero__content">
      <p class="eyebrow">Adelaide's tiled roof specialists</p>
      <h1>
        <span class="hero__line">Premium Roof Restoration</span>
        <span class="hero__line">in <span class="hl">Adelaide</span></span>
      </h1>
      <p class="hero__lead">We clean, repair, re-point and paint terracotta and concrete tiled roofs so they look brand
        new and protect your home for years to come.</p>
      <div class="hero__actions">
        <a class="btn btn--primary btn--lg" href="<?= e(url('free-quote')) ?>">Get a Free Quote
          <?= icon('arrow-right', 'icon-shift') ?></a>
        <a class="btn btn--outline btn--lg" href="<?= e(url('gallery')) ?>">View Our Work</a>
      </div>
    </div>
  </div>
</section>

<?php partial('trust-strip'); ?>

<section class="section">
  <div class="container about">
    <div class="about__media" data-reveal>
      <img src="<?= e(asset('assets/img/about-roof restoration.jpg')) ?>"
        alt="Restored terracotta tiled roof with freshly pointed ridge capping in Adelaide"
        <?= img_size('assets/img/about-roof restoration.jpg') ?> loading="lazy" decoding="async">
      <div class="about__badge">
        <span class="about__badge-icon"><?= icon('shield') ?></span>
        <div><strong>Free Roof Inspections</strong><span>Honest advice, no pressure</span></div>
      </div>
    </div>
    <div class="about__content" data-reveal>
      <p class="eyebrow">About us</p>
      <h2 style="font-size: 3.1rem;">Bring your roof back to life and <span class="hl-mark">protect your home</span>
      </h2>
      <p>AF Prestige Roofing is a roof restoration company servicing Adelaide and surrounding suburbs. We specialise in
        tiled roofs, both terracotta and concrete, and we take pride in work that looks outstanding and lasts.</p>
      <div class="about-points">
        <div class="about-point">
          <h3>Our mission</h3>
          <p>Make every roof look great and protect your home for years.</p>
        </div>
        <div class="about-point">
          <h3>Our promise</h3>
          <p>Honest advice and a clear quote upfront.</p>
        </div>
      </div>
      <div class="about__actions">
        <a class="btn btn--dark" href="<?= e(url('free-quote')) ?>">Get a Free Quote
          <?= icon('arrow-right', 'icon-shift') ?></a>
        <a class="btn btn--outline-dark" href="<?= e(phone_href()) ?>"><?= icon('phone') ?>
          <?= e(config('phone')) ?></a>
      </div>
    </div>
  </div>
</section>

<section class="section section--dark" id="services">
  <div class="container">
    <div class="section-head section-head--split">
      <div>
        <p class="eyebrow">Our services</p>
        <h2>Roof restoration services <span class="hl">in Adelaide</span></h2>
        <p>Everything your tiled roof needs, from a high-pressure clean to a complete restoration, delivered by one
          reliable local team.</p>
      </div>
      <a class="btn btn--outline" href="<?= e(url('services')) ?>">All services
        <?= icon('arrow-right', 'icon-shift') ?></a>
    </div>
    <?php partial('service-cards'); ?>
  </div>
</section>

<section class="section section--paper">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Is it time?</p>
      <h2>Signs your roof needs <span class="hl-mark">restoring</span></h2>
      <p>Spotted any of these? Small problems are much cheaper to fix early. Book a free inspection and we'll tell you
        exactly what your roof needs.</p>
    </div>
    <ul class="signs-grid">
      <li class="sign" data-reveal><span class="sign__icon"><?= icon('sun') ?></span>
        <div>
          <h3>Faded, patchy tiles</h3>
          <p>Sun-bleached or porous tiles that have lost their colour and protective surface.</p>
        </div>
      </li>
      <li class="sign" data-reveal><span class="sign__icon"><?= icon('leaf') ?></span>
        <div>
          <h3>Moss &amp; lichen growth</h3>
          <p>Growth that traps moisture against your tiles and speeds up wear.</p>
        </div>
      </li>
      <li class="sign" data-reveal><span class="sign__icon"><?= icon('ridge') ?></span>
        <div>
          <h3>Cracked ridge capping</h3>
          <p>Crumbling or missing mortar along the ridges, or caps that have come loose.</p>
        </div>
      </li>
      <li class="sign" data-reveal><span class="sign__icon"><?= icon('tile-broken') ?></span>
        <div>
          <h3>Broken or slipped tiles</h3>
          <p>Cracked, chipped or dislodged tiles that let water into your roof space.</p>
        </div>
      </li>
      <li class="sign" data-reveal><span class="sign__icon"><?= icon('drop') ?></span>
        <div>
          <h3>Leaks &amp; ceiling stains</h3>
          <p>Water marks, damp patches or drips inside after rain.</p>
        </div>
      </li>
      <li class="sign" data-reveal><span class="sign__icon"><?= icon('search') ?></span>
        <div>
          <h3>Debris in your gutters</h3>
          <p>Mortar, tile grit or growth washing off the roof and into your gutters.</p>
        </div>
      </li>
    </ul>
  </div>
</section>

<section class="section section--dark">
  <div class="container">
    <div class="section-head section-head--split">
      <div>
        <p class="eyebrow">Before &amp; after</p>
        <h2>See the <span class="hl">difference</span></h2>
        <p>Drag the slider to compare. Every restoration is finished with the same care and attention to detail.</p>
      </div>
      <a class="btn btn--outline" href="<?= e(url('gallery')) ?>">View full gallery
        <?= icon('arrow-right', 'icon-shift') ?></a>
    </div>
    <div class="ba-grid">
      <?php foreach (array_slice($gallery, 0, 2) as $project)
        partial('ba-card', ['project' => $project]); ?>
    </div>
  </div>
</section>

<section class="section section--paper">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">How it works</p>
      <h2>Our roof restoration <span class="hl-mark">process</span></h2>
      <p>A proven, step-by-step process that delivers a beautiful, long-lasting result.</p>
    </div>
    <?php partial('process'); ?>
  </div>
</section>

<section class="section section--ink">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Why choose us</p>
      <h2>The AF Prestige <span class="hl">difference</span></h2>
      <p>Premium results come from doing the basics brilliantly, every single time.</p>
    </div>
    <?php partial('features'); ?>
  </div>
</section>

<section class="section section--paper">
  <div class="container">
    <div class="section-head section-head--split">
      <div>
        <p class="eyebrow">Customer reviews</p>
        <h2>What our customers <span class="hl-mark">say?</span></h2>
        <p>Our reputation is built on happy customers and roofs we're proud of.</p>
      </div>
      <a class="btn btn--outline-dark" href="<?= e(url('reviews')) ?>">Read more reviews
        <?= icon('arrow-right', 'icon-shift') ?></a>
    </div>
    <div class="reviews-grid">
      <?php foreach (array_slice($reviews, 0, 3) as $review)
        partial('review-card', ['review' => $review]); ?>
    </div>
  </div>
</section>

<section class="section section--dark">
  <div class="container areas-split">
    <div>
      <p class="eyebrow">Service areas</p>
      <h2>Proudly servicing <span class="hl">Adelaide</span> &amp; surrounds</h2>
      <p class="areas-split__text">From the beaches to the Hills, we restore tiled roofs right across metropolitan
        Adelaide. Not sure if we cover your suburb? Just ask.</p>
      <div class="hero__actions">
        <a class="btn btn--primary" href="<?= e(url('service-areas')) ?>">View service areas
          <?= icon('arrow-right', 'icon-shift') ?></a>
        <a class="btn btn--outline" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> <?= e(config('phone')) ?></a>
      </div>
    </div>
    <ul class="region-list">
      <?php foreach ($areas as $region): ?>
        <li data-reveal>
          <strong><?= icon('pin') ?><?= e($region['name']) ?></strong><span><?= e(implode(', ', array_slice($region['suburbs'], 0, 6))) ?>
            &amp; more</span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">FAQs</p>
      <h2>Frequently asked <span class="hl-mark">questions</span></h2>
    </div>
    <?php partial('faq', ['faqs' => $faqs]); ?>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>