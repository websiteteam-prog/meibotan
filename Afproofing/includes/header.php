<?php
/**
 * Page header. Each page sets $page before including this file:
 *   title, description, path (URL without leading slash), image (share image),
 *   noindex, body_class, schema (extra schema.org nodes), preload_image.
 */
defined('ROOT_PATH') || exit;

$page = array_merge([
  'title' => config('site_name') . ' | ' . config('tagline'),
  'description' => '',
  'path' => CURRENT_PATH,
  'image' => 'assets/img/og-image.jpg',
  'noindex' => false,
  'body_class' => '',
  'schema' => [],
  'preload_image' => '',
], $page ?? []);

$canonical = absolute_url($page['path']);
$schema = [
  '@context' => 'https://schema.org',
  '@graph' => array_merge([business_schema(), website_schema()], $page['schema']),
];
?>
<!doctype html>
<html lang="en-AU">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($page['title']) ?></title>
  <meta name="description" content="<?= e($page['description']) ?>">
  <meta name="robots" content="<?= $page['noindex'] ? 'noindex, follow' : 'index, follow, max-image-preview:large' ?>">
  <link rel="canonical" href="<?= e($canonical) ?>">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_AU">
  <meta property="og:site_name" content="<?= e(config('site_name')) ?>">
  <meta property="og:title" content="<?= e($page['title']) ?>">
  <meta property="og:description" content="<?= e($page['description']) ?>">
  <meta property="og:url" content="<?= e($canonical) ?>">
  <meta property="og:image" content="<?= e(absolute_url($page['image'])) ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="geo.region" content="AU-SA">
  <meta name="geo.placename" content="Adelaide">
  <meta name="geo.position" content="<?= e(config('geo.lat') . ';' . config('geo.lng')) ?>">
  <meta name="theme-color" content="#12393e">
  <?php if (config('google_site_verification')): ?>
    <meta name="google-site-verification" content="<?= e(config('google_site_verification')) ?>">
  <?php endif; ?>
  <link rel="icon" href="<?= e(url('favicon.ico')) ?>" sizes="any">
  <link rel="icon" href="<?= e(url('favicon.svg')) ?>" type="image/svg+xml">
  <link rel="apple-touch-icon" href="<?= e(url('apple-touch-icon.png')) ?>">
  <link rel="manifest" href="<?= e(url('site.webmanifest')) ?>">
  <link rel="preload" href="<?= e(url('assets/fonts/barlow-condensed-800.woff2')) ?>" as="font" type="font/woff2"
    crossorigin>
  <link rel="preload" href="<?= e(url('assets/fonts/inter-var.woff2')) ?>" as="font" type="font/woff2" crossorigin>
  <?php if ($page['preload_image']): ?>
    <link rel="preload" href="<?= e(asset($page['preload_image'])) ?>" as="image" fetchpriority="high">
  <?php endif; ?>
  <link rel="stylesheet" href="<?= e(asset('assets/css/style.css')) ?>">
  <script src="<?= e(asset('assets/js/main.js')) ?>" defer></script>
  <?= json_ld($schema) ?>
  <?php if (config('ga4_id')): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e(config('ga4_id')) ?>"></script>
    <script>window.dataLayer = window.dataLayer || []; function gtag() { dataLayer.push(arguments); } gtag('js', new Date()); gtag('config', '<?= e(config('ga4_id')) ?>');</script>
  <?php endif; ?>
</head>

<body class="<?= e($page['body_class']) ?>">
  <a class="skip-link" href="#main">Skip to content</a>

  <div class="topbar">
    <div class="container topbar__inner">
      <p><?= icon('pin') ?> Servicing Adelaide &amp; regional South Australia <span
          class="topbar__badge">&middot; Free quotes</span></p>
      <ul class="topbar__links">
        <li><a href="<?= e(email_href()) ?>"><?= icon('mail') ?><?= e(config('email')) ?></a></li>
        <li><a href="<?= e(phone_href()) ?>"><?= icon('phone') ?><?= e(config('phone')) ?></a></li>
      </ul>
    </div>
  </div>

  <header class="site-header">
    <div class="container site-header__inner">
      <?php partial('brand'); ?>

      <nav class="main-nav" id="main-nav" aria-label="Main">
        <ul class="main-nav__list">
          <li><a href="<?= e(url()) ?>" <?= nav_attrs('') ?>>Home</a></li>
          <li class="has-sub">
            <a href="<?= e(url('services')) ?>" <?= nav_attrs('services', true) ?>>Services</a>
            <button class="sub-toggle" type="button" aria-expanded="false" aria-controls="services-menu">
              <span class="visually-hidden">Show services</span><?= icon('chevron-down') ?>
            </button>
            <ul class="sub-menu" id="services-menu">
              <?php foreach ($services as $navSlug => $navService): ?>
                <li><a href="<?= e(service_url($navSlug)) ?>" <?= nav_attrs('services/' . $navSlug) ?>><?= icon($navService['icon']) ?><?= e($navService['name']) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </li>
          <li><a href="<?= e(url('gallery')) ?>" <?= nav_attrs('gallery') ?>>Gallery</a></li>
          <li><a href="<?= e(url('why-choose-us')) ?>" <?= nav_attrs('why-choose-us') ?>>Why Choose Us?</a></li>

          <li><a href="<?= e(url('service-areas')) ?>" <?= nav_attrs('service-areas') ?>>Service Areas</a></li>
          <li><a href="<?= e(url('contact')) ?>" <?= nav_attrs('contact') ?>>Contact</a></li>
        </ul>
        <div class="main-nav__cta">
          <a class="btn btn--primary btn--lg btn--block" href="<?= e(url('free-quote')) ?>">Get a Free Quote</a>
          <a class="btn btn--outline btn--lg btn--block" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> Call
            <?= e(config('phone')) ?></a>
        </div>
      </nav>

      <div class="site-header__actions">
        <a class="header-phone" href="<?= e(phone_href()) ?>">
          <span class="header-phone__icon"><?= icon('phone') ?></span>
          <span><small>Call for a free quote</small><strong><?= e(config('phone')) ?></strong></span>
        </a>
        <a class="btn btn--primary header-cta" href="<?= e(url('free-quote')) ?>">Free Quote</a>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="main-nav">
          <span class="nav-toggle__bars"></span><span class="visually-hidden">Menu</span>
        </button>
      </div>
    </div>
  </header>

  <main id="main">