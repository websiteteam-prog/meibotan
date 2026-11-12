<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
  'title' => 'Roof Restoration Adelaide | AF Prestige Roofing',
  'description' => 'Locally owned roof restoration across Adelaide and regional South Australia. Roof cleaning, tile replacement, ridge capping, repairs and roof painting. Free quotes.',
  'path' => '',
  'body_class' => 'page-home',
  'preload_image' => 'assets/img/services/banner-roof-restoration.png',
  'schema' => [faq_schema($faqs)],
];
include ROOT_PATH . '/includes/header.php';
?>


<section class="hero hero--split">
  <div class="hero__bg"><img src="<?= e(asset('assets/img/services/banner-roof-restoration.png')) ?>" alt=""
      <?= img_size('assets/img/services/banner-roof-restoration.png') ?> fetchpriority="high"></div>
  <div class="container hero__grid">
    <div class="hero__content">
      <p class="hero__rating"><span class="hero__stars" aria-hidden="true"><?= str_repeat(icon('star'), 5) ?></span>Rated 5/5 on Google</p>
      <h1>Affordable <span class="hl">Roof Restorations &amp; Repairs</span> in Adelaide</h1>
      <ul class="hero__points">
        <li>
          <span class="hero__point-icon"><?= icon('award') ?></span>
          <div><strong>Satisfaction Guaranteed</strong><span>Licensed &amp; insured roofing specialists</span></div>
        </li>
        <li>
          <span class="hero__point-icon"><?= icon('tag') ?></span>
          <div><strong>20% Off Your Quote</strong><span>Get a free roof repair &amp; restoration quote today. Free call-out &amp;
              roof assessments available.</span></div>
        </li>
      </ul>
      <div class="hero__actions">
        <a class="btn btn--primary btn--lg" href="#hero-form"><?= icon('tag') ?> Get 20% Off Today</a>
        <a class="btn btn--outline btn--lg" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> Call: <?= e(config('phone')) ?></a>
      </div>
    </div>

    <div class="hero-quote">
      <p class="hero-quote__title">20% Off Your Quote Today!</p>
      <p class="hero-quote__sub">Fill out the form and we'll start arranging your free quote as soon as possible.</p>
      <?php partial('quote-form', ['id' => 'hero', 'variant' => 'hero', 'button' => 'Get My Free Quote']); ?>
    </div>
  </div>
</section>

<?php partial('trust-strip'); ?>

<section class="section section--dark section--tiles" id="services">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Our services</p>
      <h2>We repair &amp; restore <span class="hl">your roof &amp; protect it for years</span></h2>
      <p>Doesn't matter if your roof is ageing, faded or damaged. Our team delivers reliable roofing solutions that
        restore protection, improve appearance and stand the test of time. Every job is backed by our workmanship
        guarantee and 20+ years of experience.</p>
    </div>
    <?php
    // Services shown on the homepage (title, text and the service page each card opens).
    // The photo comes from that service in includes/data/services.php. Remove a row to show fewer.
    $homeServices = [
      ['roof-repairs-adelaide', 'Roof Repair & Roof Leaks', 'Fast and reliable roof repairs, roof leaks, cracked tile replacement and preventative roofing maintenance to protect your home from water damage.'],
      ['roof-restoration-adelaide', 'Roof Restorations', "Complete roof restoration services including repairs, rebedding, cleaning and painting to improve your roof's appearance and lifespan."],
      ['roof-painting-adelaide', 'Roof Painting & Cleaning', 'Professional roof cleaning and painting services that remove dirt, moss and faded coatings while restoring a fresh, modern finish.'],
      ['ridge-capping-adelaide', 'Roof Rebedding & Repointing', 'Restore loose ridge caps and damaged mortar with expert rebedding and repointing services designed for long-term roof protection.'],
    ];
    ?>
    <div class="home-svc">
      <?php foreach ($homeServices as [$svcSlug, $svcTitle, $svcText]):
        if (empty($services[$svcSlug])) continue;
        $svcImage = $services[$svcSlug]['image']; ?>
        <a class="home-svc__card" href="<?= e(service_url($svcSlug)) ?>" data-reveal>
          <span class="home-svc__media">
            <img src="<?= e(asset($svcImage)) ?>" alt="<?= e($svcTitle) ?> in Adelaide" <?= img_size($svcImage) ?>
              loading="lazy" decoding="async">
          </span>
          <h3><?= e($svcTitle) ?></h3>
          <p><?= e($svcText) ?></p>
          <span class="home-svc__more">Learn more <?= icon('arrow-right') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
    <p class="home-svc__all">
      <a class="btn btn--primary btn--lg" href="<?= e(url('services')) ?>">Explore more services
        <?= icon('arrow-right', 'icon-shift') ?></a>
    </p>
  </div>
</section>

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

<section class="section section--paper">
  <div class="container results">
    <div class="results__media" data-reveal>
      <img src="<?= e(asset('assets/img/services/why-choose-section2.jpeg')) ?>"
        alt="AF Prestige Roofing roofer repairing a tiled roof in Adelaide"
        <?= img_size('assets/img/services/why-choose-section2.jpeg') ?> loading="lazy" decoding="async">
      <div class="results__badge"><strong>20+</strong><span>Years of combined roofing experience</span></div>
    </div>
    <div class="results__content" data-reveal>
      <p class="eyebrow">Why homeowners choose us</p>
      <h2>Our roofing results <span class="hl-mark">can't be matched</span> by anyone</h2>
      <ul class="results__list">
        <li><?= icon('check') ?><div><strong>10-Year Workmanship Warranty:</strong> Every roof repair and restoration is
            backed by a 10-year written workmanship guarantee, so you're covered long after the job is done.</div></li>
        <li><?= icon('check') ?><div><strong>Flexible and Competitive Pricing:</strong> Transparent, competitive pricing on
            every quote. Whether it's a quick repair or a full restoration, there's an option to suit your budget.</div></li>
        <li><?= icon('check') ?><div><strong>Licensed &amp; Insured Roofers:</strong> Fully qualified and insured, giving you
            total peace of mind that your home, roof and property are protected from the moment we step on site.</div></li>
        <li><?= icon('check') ?><div><strong>Prioritising Safety:</strong> Safety is central to everything we do. Every job
            is carried out to strict Australian standards with proper roof safety systems in place.</div></li>
        <li><?= icon('check') ?><div><strong>Roofing Specialists:</strong> With over 20 years of combined experience, we
            specialise in tile roof repairs and restorations.</div></li>
        <li><?= icon('check') ?><div><strong>Free Same-Day Quotes, No Obligation:</strong> Get a free quote the same day you
            call. No pressure, no hidden costs, just a straight answer on what your roof needs and what it will cost.</div></li>
      </ul>
      <div class="cta-pair">
        <a class="btn btn--primary" href="#hero-form"><?= icon('tag') ?> Get 20% Off Today</a>
        <a class="btn btn--outline-dark" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> Call: <?= e(config('phone')) ?></a>
      </div>
    </div>
  </div>
</section>

<section class="section section--dark section--tiles">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">How it works</p>
      <h2>How our <span class="hl">roof transformations</span> work</h2>
      <p>Three simple steps from your first call to a finished roof you'll love.</p>
    </div>
    <ol class="steps">
      <li class="step" data-reveal>
        <span class="step__icon"><?= icon('calendar') ?></span>
        <h3 class="step__num">Step 1</h3>
        <p>Simply call or book online and our experienced roofing specialists will arrange a convenient time to inspect
          your roof and understand your needs.</p>
        <span class="step__label">Book a Free Quote</span>
      </li>
      <li class="step" data-reveal>
        <span class="step__icon"><?= icon('search') ?></span>
        <h3 class="step__num">Step 2</h3>
        <p>We assess your roof in detail, explain the scope of work clearly and provide a transparent fixed price, so
          there are no surprises later.</p>
        <span class="step__label">Site Inspection &amp; Fixed Quote</span>
      </li>
      <li class="step" data-reveal>
        <span class="step__icon"><?= icon('clipboard') ?></span>
        <h3 class="step__num">Step 3</h3>
        <p>Our skilled team completes the restoration, repair or cleaning, then walks you through the results to make sure
          everything meets your expectations.</p>
        <span class="step__label">Work Completed &amp; Final Check</span>
      </li>
    </ol>
      <div class="cta-pair cta-pair--center">
        <a class="btn btn--primary" href="#hero-form"><?= icon('tag') ?> Get 20% Off Today</a>
        <a class="btn btn--outline" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> Call: <?= e(config('phone')) ?></a>
      </div>
  </div>
</section>

<section class="section" id="reviews">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Customer reviews</p>
      <h2>What our <span class="hl-mark">clients</span> say</h2>
      <?php $googleUrl = (string) config('social.google'); ?>
      <<?= $googleUrl ? 'a href="' . e($googleUrl) . '" target="_blank" rel="noopener"' : 'p' ?> class="google-badge">
        <strong>Excellent</strong>
        <span class="google-badge__stars" aria-hidden="true"><?= str_repeat(icon('star'), 5) ?></span>
        <span>reviews on</span> <?= google_logo_svg(20) ?><span class="google-badge__word">Google</span>
      </<?= $googleUrl ? 'a' : 'p' ?>>
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
    <p class="center mt-md"><a class="link-arrow" href="<?= e(url('reviews')) ?>">Read more reviews <?= icon('arrow-right') ?></a></p>
  </div>
</section>

<section class="section section--tight offer-wrap">
  <div class="container">
    <div class="offer" data-reveal>
      <div class="offer__media">
        <img src="<?= e(asset('assets/img/services/why-choose-section1.jpeg')) ?>"
          alt="Freshly restored terracotta tiled roof in Adelaide" <?= img_size('assets/img/services/why-choose-section1.jpeg') ?>
          loading="lazy" decoding="async">
      </div>
      <span class="offer__badge" aria-hidden="true"><strong>20%</strong><span>off</span></span>
      <div class="offer__body">
        <p class="offer__tag"><?= icon('tag') ?> Special offer</p>
        <h2>Get a free roof repair &amp; restoration quote today</h2>
        <p class="offer__text">Available 24/7. Fast, reliable and affordable roofing services across Adelaide and
          regional South Australia, with <strong>20% off your quote</strong> when you book today.</p>
        <ul class="offer__perks">
          <li><?= icon('check') ?>Free call-out &amp; roof assessment</li>
          <li><?= icon('check') ?>Fixed-price quote, no surprises</li>
          <li><?= icon('check') ?>10-year workmanship warranty</li>
        </ul>
        <div class="offer__actions">
          <a class="btn btn--dark-solid btn--lg" href="#hero-form"><?= icon('tag') ?> Claim 20% Off</a>
          <a class="offer__call" href="<?= e(phone_href()) ?>"><span class="offer__call-icon"><?= icon('phone') ?></span>
            <span><small>Call us 24/7</small><strong><?= e(config('phone')) ?></strong></span></a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section--paper">
  <div class="container">
    <div class="section-head section-head--split">
      <div>
        <p class="eyebrow">Before &amp; after</p>
        <h2>See the <span class="hl-mark">difference</span></h2>
        <p>Drag the slider to compare. Every restoration is finished with the same care and attention to detail.</p>
      </div>
      <a class="btn btn--outline-dark" href="<?= e(url('gallery')) ?>">View full gallery
        <?= icon('arrow-right', 'icon-shift') ?></a>
    </div>
    <div class="ba-grid">
      <?php foreach (array_slice($gallery, 0, 2) as $project)
        partial('ba-card', ['project' => $project]); ?>
    </div>
  </div>
</section>

<section class="section section--ink section--photo"
  style="--section-photo: url('<?= e(asset('assets/img/services/Concrete Tile Restoration.jpg')) ?>')">
  <div class="container">
    <div class="section-head section-head--center">
      <p class="eyebrow">Why choose us?</p>
      <h2>Why <span class="hl">choose</span> us</h2>
      <p>Reliable roofing solutions delivered by experienced professionals who focus on quality, honesty and
        long-lasting results.</p>
    </div>
    <?php partial('features', ['center' => true]); ?>
      <div class="cta-pair cta-pair--center">
        <a class="btn btn--primary" href="#hero-form"><?= icon('tag') ?> Get 20% Off Today</a>
        <a class="btn btn--outline" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> Call: <?= e(config('phone')) ?></a>
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
  <div class="container areas-split">
    <div>
      <p class="eyebrow">Service areas</p>
      <h2>Proudly servicing <span class="hl">Adelaide</span> &amp; regional SA</h2>
      <p class="areas-split__text">We work right across metropolitan Adelaide and regional South Australia, including
        the Adelaide Hills, Barossa, Fleurieu Peninsula and Murraylands. Not sure if we cover your area? Just ask.
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
  // Reviews carousel: swipe on touch screens, arrows (and dots, if present), gentle
  // auto-advance that pauses while the visitor is interacting.
  (function () {
    document.querySelectorAll('[data-carousel]').forEach(function (root) {
      var track = root.querySelector('.reviews-carousel__track');
      var prev = root.querySelector('[data-carousel-prev]');
      var next = root.querySelector('[data-carousel-next]');
      var dotsWrap = root.querySelector('[data-carousel-dots]'); // optional
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
        i = Math.max(0, Math.min(i, last));
        track.scrollTo({ left: Math.min(i * step(), maxScroll()), behavior: reduceMotion ? 'auto' : 'smooth' });
      }
      function update() {
        var c = current(), n = positions();
        if (dotsWrap) {
          Array.prototype.forEach.call(dotsWrap.children, function (d, i) {
            d.classList.toggle('is-active', i === c);
            d.setAttribute('aria-current', i === c ? 'true' : 'false');
          });
        }
        if (prev) prev.disabled = c <= 0;
        if (next) next.disabled = c >= n - 1;
        root.classList.toggle('is-static', n <= 1);
      }
      function build() {
        if (dotsWrap) {
          dotsWrap.innerHTML = '';
          for (var i = 0; i < positions(); i++) {
            var dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'reviews-carousel__dot';
            dot.setAttribute('aria-label', 'Show review ' + (i + 1));
            dot.addEventListener('click', go.bind(null, i));
            dotsWrap.appendChild(dot);
          }
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

      if (prev) prev.addEventListener('click', function () { go(current() - 1); });
      if (next) next.addEventListener('click', function () { go(current() + 1); });
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
      window.addEventListener('resize', function () { clearTimeout(resizeTimer); resizeTimer = setTimeout(build, 150); });
      build();
      autoplay();
    });
  })();
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
