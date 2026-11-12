<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
  'title' => 'Roof Restoration Adelaide | AF Prestige Roofing',
  'description' => 'Locally owned roof restoration in Adelaide and regional SA within ' . config('service_radius_km') . 'km. Roof cleaning, tile replacement, ridge capping, repairs and roof painting. Free quotes.',
  'path' => '',
  'body_class' => 'page-home',
  'preload_image' => 'assets/img/hero.jpg',
  'schema' => [faq_schema($faqs)],
];
include ROOT_PATH . '/includes/header.php';
?>

<section class="hero">
  <div class="hero__bg"><img src="<?= e(asset('assets/img/services/banner-roof-restoration.png')) ?>" alt=""
      <?= img_size('assets/img/services/banner-roof-restoration.png') ?> fetchpriority="high"></div>
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

<section class="section" id="about">
  <div class="container about about--intro">
    <div class="about__media" data-reveal>
      <img src="<?= e(asset('assets/img/about-roof restoration.png')) ?>"
        alt="Tiled roof half cleaned and restored, showing the difference a roof restoration makes"
        <?= img_size('assets/img/about-roof restoration.png') ?> loading="lazy" decoding="async">
      <div class="about__badge">
        <span class="about__badge-icon"><?= icon('shield') ?></span>
        <div><strong>Locally Owned &amp; Operated</strong><span>Free, no-obligation quotes</span></div>
      </div>
    </div>
    <div class="about__content" data-reveal>
      <p class="eyebrow">About us</p>
      <h2 class="about__title">Welcome to <span class="hl-mark">AF Prestige Roofing</span></h2>
      <p class="about__tagline">Quality Roofing. Reliable Service. Lasting Protection.</p>
      <p>AF Prestige Roofing is a locally owned and operated roofing company proudly servicing Adelaide and
        surrounding areas across South Australia.</p>
      <p>We specialise in professional roof restoration and maintenance, helping homeowners protect, restore and
        enhance the appearance of their properties. From pressure cleaning and tile replacement to ridge capping,
        re-bedding, pointing and roof painting, we provide complete roofing solutions tailored to your roof&rsquo;s
        needs.</p>
    
      <p class="about__cta-text">Contact AF Prestige Roofing today for your <strong>FREE, no-obligation quote.</strong>
      </p>
      <div class="about__actions">
        <a class="btn btn--dark" href="<?= e(url('free-quote')) ?>">Get a Free Quote
          <?= icon('arrow-right', 'icon-shift') ?></a>
        <a class="btn btn--outline-dark" href="<?= e(phone_href()) ?>"><?= icon('phone') ?>
          <?= e(config('phone')) ?></a>
      </div>

    </div>
  </div>
</section>

<section class="section section--dark section--tiles" id="services">
  <div class="container">
    <div class="section-head section-head--split">
      <div>
        <p class="eyebrow">Our services</p>
        <h2>Roof restoration services <span class="hl">in Adelaide</span></h2>
        <p>Everything your tiled roof needs, from a high-pressure clean to a complete restoration, delivered by one
          reliable local team.</p>
      </div>

    </div>
    <?php

    $svcFeaturedSlug = array_key_first($services);
    $svcFeatured = $services[$svcFeaturedSlug];
    $svcOthers = array_slice($services, 1, null, true);
    $svcNum = 1;
    ?>
    <div class="svc">
      <article class="svc-card svc-card--featured" data-reveal>
        <a class="svc-card__media" href="<?= e(service_url($svcFeaturedSlug)) ?>" tabindex="-1" aria-hidden="true">
          <img src="<?= e(asset($svcFeatured['image'])) ?>" alt="" <?= img_size($svcFeatured['image']) ?> loading="lazy"
            decoding="async">

          <span class="svc-card__tag"><?= icon('award') ?>Complete package</span>
        </a>
        <div class="svc-card__body">
          <span class="svc-card__icon"><?= icon($svcFeatured['icon']) ?></span>
          <h3><a href="<?= e(service_url($svcFeaturedSlug)) ?>"><?= e($svcFeatured['name']) ?></a></h3>
          <p><?= e($svcFeatured['excerpt']) ?></p>
          <ul class="checklist">
            <?php foreach (array_slice($svcFeatured['includes'] ?? [], 0, 3) as $svcInclude): ?>
              <li><?= icon('check') ?><?= e($svcInclude) ?></li>
            <?php endforeach; ?>
          </ul>
          <div class="svc-card__actions">
            <a class="btn btn--dark" href="<?= e(service_url($svcFeaturedSlug)) ?>">Learn more<span
                class="visually-hidden"> about <?= e($svcFeatured['name']) ?></span>
              <?= icon('arrow-right', 'icon-shift') ?></a>
            <a class="link-arrow" href="<?= e(url('free-quote')) ?>">Free quote <?= icon('arrow-right') ?></a>
          </div>
        </div>
      </article>

      <p class="svc-hint" aria-hidden="true">Swipe to see all services <?= icon('arrow-right') ?></p>

      <div class="svc-list">
        <?php foreach ($svcOthers as $svcSlug => $svcItem):
          $svcNum++; ?>
          <a class="svc-card" href="<?= e(service_url($svcSlug)) ?>" data-reveal>
            <span class="svc-card__media">
              <img src="<?= e(asset($svcItem['image'])) ?>" alt="" <?= img_size($svcItem['image']) ?> loading="lazy"
                decoding="async">

            </span>
            <span class="svc-card__icon"><?= icon($svcItem['icon']) ?></span>
            <span class="svc-card__body">
              <h3><?= e($svcItem['name']) ?></h3>
              <p><?= e($svcItem['excerpt']) ?></p>
              <span class="svc-card__more">Learn more <?= icon('arrow-right') ?></span>
            </span>
          </a>
        <?php endforeach; ?>
      </div>

      <div class="svc-cta" data-reveal>
        <span class="svc-cta__icon"><?= icon('clipboard') ?></span>
        <div>
          <h3>Not sure what your roof needs?</h3>
          <p>Book a free, no-obligation inspection. We'll check your roof and give you honest advice and a clear quote.
          </p>
        </div>
        <div class="svc-cta__actions">
          <a class="btn btn--dark" href="<?= e(url('free-quote')) ?>">Book a free inspection
            <?= icon('arrow-right', 'icon-shift') ?></a>
          <a class="btn btn--outline-dark" href="<?= e(phone_href()) ?>"><?= icon('phone') ?>
            <?= e(config('phone')) ?></a>
        </div>
      </div>
    </div>
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
      <p class="eyebrow">How it works?</p>
      <h2>Our roof restoration <span class="hl-mark">process</span></h2>
      <p>A proven, step-by-step process that delivers a beautiful, long-lasting result.</p>
    </div>
    <?php partial('process'); ?>
  </div>
</section>

<section class="section section--ink section--photo"
  style="--section-photo: url('<?= e(asset('assets/img/services/Concrete Tile Restoration.jpg')) ?>')">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Why choose us?</p>
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
    <div class="reviews-carousel" data-carousel>
      <div class="reviews-carousel__track" role="region" aria-label="Customer reviews" tabindex="0">
        <?php foreach ($reviews as $review)
          partial('review-card', ['review' => $review]); ?>
      </div>
      <div class="reviews-carousel__controls">
        <button class="reviews-carousel__btn reviews-carousel__btn--prev" type="button" data-carousel-prev
          aria-label="Previous review"><?= icon('arrow-right') ?></button>
        
        <button class="reviews-carousel__btn" type="button" data-carousel-next aria-label="Next review"><?= icon('arrow-right') ?></button>
      </div>
    </div>
  </div>
</section>

<section class="section section--dark">
  <div class="container areas-split">
    <div>
      <p class="eyebrow">Service areas</p>
      <h2>Proudly servicing <span class="hl">Adelaide</span> &amp; regional SA</h2>
      <p class="areas-split__text">We work right across metropolitan Adelaide and regional areas up to
        <?= e(config('service_radius_km')) ?>km from the city, including the Adelaide Hills, Barossa, Fleurieu
        Peninsula and Murraylands. Not sure if we cover your area? Just ask.
      </p>
      <p class="radius-badge"><span
          class="radius-badge__num"><?= e(config('service_radius_km')) ?><small>km</small></span>
        <span>service radius from the Adelaide CBD</span>
      </p>
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

<script>
  // Reviews carousel: swipe or drag on touch screens, arrows and dots everywhere,
  // and a gentle auto-advance that pauses while the visitor is interacting.
  (function () {
    document.querySelectorAll('[data-carousel]').forEach(function (root) {
      var track = root.querySelector('.reviews-carousel__track');
      var prev = root.querySelector('[data-carousel-prev]');
      var next = root.querySelector('[data-carousel-next]');
      var dotsWrap = root.querySelector('[data-carousel-dots]');
      var cards = Array.prototype.slice.call(track.children);
      if (!cards.length) return;
      var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      var timer = null, paused = false;

      function step() { return cards.length > 1 ? cards[1].offsetLeft - cards[0].offsetLeft : track.clientWidth; }
      function maxScroll() { return track.scrollWidth - track.clientWidth; }
      function positions() { return Math.max(1, Math.round(maxScroll() / step()) + 1); }
      function current() { return Math.min(positions() - 1, Math.round(track.scrollLeft / step())); }
      function go(i) {
        var last = positions() - 1;
        if (i < 0) i = 0;
        if (i > last) i = last;
        track.scrollTo({ left: Math.min(i * step(), maxScroll()), behavior: reduceMotion ? 'auto' : 'smooth' });
      }
      function update() {
        var c = current(), n = positions();
        Array.prototype.forEach.call(dotsWrap.children, function (d, i) {
          d.classList.toggle('is-active', i === c);
          d.setAttribute('aria-current', i === c ? 'true' : 'false');
        });
        prev.disabled = c <= 0;
        next.disabled = c >= n - 1;
        root.classList.toggle('is-static', n <= 1);
      }
      function buildDots() {
        dotsWrap.innerHTML = '';
        for (var i = 0; i < positions(); i++) {
          var dot = document.createElement('button');
          dot.type = 'button';
          dot.className = 'reviews-carousel__dot';
          dot.setAttribute('aria-label', 'Show review ' + (i + 1));
          dot.addEventListener('click', go.bind(null, i));
          dotsWrap.appendChild(dot);
        }
        update();
      }
      function autoplay() {
        clearInterval(timer);
        if (reduceMotion) return;
        timer = setInterval(function () {
          if (paused || document.hidden) return;
          var c = current();
          go(c >= positions() - 1 ? 0 : c + 1);
        }, 5000);
      }

      prev.addEventListener('click', function () { go(current() - 1); });
      next.addEventListener('click', function () { go(current() + 1); });
      var ticking = false;
      track.addEventListener('scroll', function () {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(function () { update(); ticking = false; });
      }, { passive: true });
      ['mouseenter', 'focusin', 'touchstart'].forEach(function (ev) { root.addEventListener(ev, function () { paused = true; }, { passive: true }); });
      ['mouseleave', 'focusout'].forEach(function (ev) { root.addEventListener(ev, function () { paused = false; }); });
      track.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowRight') { e.preventDefault(); go(current() + 1); }
        if (e.key === 'ArrowLeft') { e.preventDefault(); go(current() - 1); }
      });
      var resizeTimer;
      window.addEventListener('resize', function () { clearTimeout(resizeTimer); resizeTimer = setTimeout(buildDots, 150); });
      buildDots();
      autoplay();
    });
  })();
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>