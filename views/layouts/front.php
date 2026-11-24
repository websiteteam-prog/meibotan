<?php
/**
 * Storefront layout.
 * @var string $content
 * @var array  $meta  title, description, canonical, image, type, robots
 * @var array  $schema optional JSON-LD objects
 */
use App\Services\CartService;
use App\Services\Layout;
use App\Services\WishlistService;

$meta = $meta ?? [];
$siteName = (string) setting('site_name', 'Savié Amour');
$title = $meta['title'] ?? (setting('meta_title') ?: $siteName);
$description = $meta['description'] ?? (string) setting('meta_description', '');
$canonical = $meta['canonical'] ?? url(request_path());
$ogImage = $meta['image'] ?? (setting('og_image') ? upload_url(setting('og_image')) : url('assets/img/og-default.jpg'));
$favicon = setting('favicon') ? upload_url(setting('favicon')) : asset('img/favicon-32.png');
$customer = customer();
$cartCount = CartService::count();
$wishCount = WishlistService::count();
$bodyClass = $bodyClass ?? '';
$schemas = $schema ?? [];
$schemas[] = [
    '@context' => 'https://schema.org', '@type' => 'Organization', 'name' => $siteName, 'url' => url('/'),
    'logo' => url('assets/img/logo-maroon.png'), 'sameAs' => array_values(Layout::socials()),
];
?><!doctype html>
<html lang="en-IN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<script>(function (h) { try { if (sessionStorage.getItem('sa_pl')) { h.className += ' pl-skip'; return; } } catch (e) {} h.className += ' pl-on'; })(document.documentElement);</script>
<title><?= e($title) ?></title>
<meta name="description" content="<?= e(str_limit($description, 300)) ?>">
<?php if (setting('meta_keywords')): ?><meta name="keywords" content="<?= e(setting('meta_keywords')) ?>"><?php endif; ?>
<meta name="robots" content="<?= e($meta['robots'] ?? 'index, follow') ?>">
<link rel="canonical" href="<?= e($canonical) ?>">
<meta name="theme-color" content="#630000">
<meta property="og:site_name" content="<?= e($siteName) ?>">
<meta property="og:type" content="<?= e($meta['type'] ?? 'website') ?>">
<meta property="og:title" content="<?= e($title) ?>">
<meta property="og:description" content="<?= e(str_limit($description, 200)) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="<?= e($favicon) ?>" sizes="32x32">
<link rel="icon" href="<?= e(asset('img/favicon-512.png')) ?>" sizes="512x512">
<link rel="apple-touch-icon" href="<?= e(asset('img/apple-touch-icon.png')) ?>">
<link rel="preload" href="<?= e(url('assets/fonts/cormorant-garamond-latin-400-normal.woff2')) ?>" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="<?= e(url('assets/fonts/plus-jakarta-sans-latin-400-normal.woff2')) ?>" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="<?= e(asset('vendor/bootstrap/bootstrap.min.css')) ?>">
<link rel="stylesheet" href="<?= e(asset(is_file(PUBLIC_PATH . '/assets/css/app.min.css') ? 'css/app.min.css' : 'css/app.css')) ?>">
<?php foreach ($schemas as $s): ?>
<script type="application/ld+json"><?= json_encode($s, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
<?php endforeach; ?>
<?php if ($ga = trim((string) setting('google_analytics_id'))): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($ga) ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config',<?= json_encode($ga) ?>);</script>
<?php endif; ?>
</head>
<body class="<?= e($bodyClass) ?>">
<div class="preloader" id="preloader" aria-hidden="true">
  <div class="pl-inner">
    <div class="pl-logo" style="--pl-logo:url('<?= e(App\Services\Layout::logo('maroon')) ?>')">
      <img src="<?= e(App\Services\Layout::logo('maroon')) ?>" alt="" width="647" height="365">
      <span class="pl-shine"></span>
      <svg class="pl-spark s1" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 1c.7 6 3.4 8.6 10 10-6.6 1.4-9.3 4-10 11-.7-7-3.4-9.6-10-11 6.6-1.4 9.3-4 10-10z"/></svg>
      <svg class="pl-spark s2" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 1c.7 6 3.4 8.6 10 10-6.6 1.4-9.3 4-10 11-.7-7-3.4-9.6-10-11 6.6-1.4 9.3-4 10-10z"/></svg>
    </div>
    <p class="pl-tag"><?= e(setting('site_tagline', 'the art of beauty')) ?></p>
    <div class="pl-bar"><span></span></div>
  </div>
</div>
<a class="visually-hidden-focusable" href="#main">Skip to content</a>
<?= App\Core\View::partial('partials/icons') ?>
<?= App\Core\View::partial('partials/header', compact('customer', 'cartCount', 'wishCount')) ?>

<main id="main">
  <?php $flashes = flash_messages(); if ($flashes): ?>
  <div class="flash-wrap"><div class="container-xl">
    <?php foreach ($flashes as $f): ?>
      <div class="flash flash-<?= e($f['type']) ?>" role="status"><?= icon($f['type'] === 'success' ? 'check-circle' : 'alert') ?><span><?= e($f['text']) ?></span></div>
    <?php endforeach; ?>
  </div></div>
  <?php endif; ?>
  <?= $content ?>
</main>

<?= App\Core\View::partial('partials/footer') ?>
<?= App\Core\View::partial('partials/overlays', compact('customer', 'cartCount')) ?>

<script>
window.SA = <?= json_encode([
    'base' => rtrim(url('/'), '/'),
    'csrf' => csrf_token(),
    'currency' => (string) setting('currency_symbol', '₹'),
    'loggedIn' => $customer !== null,
    'freeShip' => (float) setting('free_shipping_threshold', 0),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;
</script>
<script>
(function () {
  var pl = document.getElementById('preloader'), h = document.documentElement;
  if (!pl) return;
  function drop() { if (pl.parentNode) pl.parentNode.removeChild(pl); }
  if (h.className.indexOf('pl-skip') > -1) { drop(); return; }
  var start = Date.now(), finished = false, min = 1800;
  function done() {
    if (finished) return; finished = true;
    setTimeout(function () {
      pl.className += ' is-done';
      try { sessionStorage.setItem('sa_pl', '1'); } catch (e) {}
      setTimeout(function () { h.className = h.className.replace(' pl-on', ''); }, 350);
      setTimeout(drop, 1400);
    }, Math.max(0, min - (Date.now() - start)));
  }
  if (document.readyState === 'complete') done(); else window.addEventListener('load', done);
  setTimeout(done, 6000);
})();
</script>
<script src="<?= e(asset('vendor/bootstrap/bootstrap.bundle.min.js')) ?>" defer></script>
<script src="<?= e(asset(is_file(PUBLIC_PATH . '/assets/js/app.min.js') ? 'js/app.min.js' : 'js/app.js')) ?>" defer></script>
<?php if (!empty($scripts)) { echo $scripts; } ?>
</body>
</html>
