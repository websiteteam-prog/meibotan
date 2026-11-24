<?php
/**
 * Admin layout.
 * @var string $content @var string $title @var ?string $active
 */
use App\Core\AdminAuth;
use App\Core\DB;

$admin = AdminAuth::user();
$active = $active ?? '';
$pendingOrders = (int) DB::value("SELECT COUNT(*) FROM orders WHERE status = 'pending'");
$unreadMessages = (int) DB::value('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0');
$pendingReviews = (int) DB::value("SELECT COUNT(*) FROM reviews WHERE status = 'pending'");
$menu = [
    'Overview' => [
        ['dashboard', 'admin', 'chart', 'Dashboard', 'dashboard', 0],
    ],
    'Catalogue' => [
        ['products', 'admin/products', 'package', 'Products', 'catalog', 0],
        ['categories', 'admin/categories', 'layers', 'Categories', 'catalog', 0],
        ['collections', 'admin/collections', 'sparkle', 'Collections', 'catalog', 0],
        ['reviews', 'admin/reviews', 'star', 'Reviews', 'reviews', $pendingReviews],
    ],
    'Sales' => [
        ['orders', 'admin/orders', 'bag', 'Orders', 'orders', $pendingOrders],
        ['customers', 'admin/customers', 'users', 'Customers', 'customers', 0],
        ['coupons', 'admin/coupons', 'percent', 'Coupons', 'marketing', 0],
        ['newsletter', 'admin/newsletter', 'mail', 'Newsletter', 'marketing', 0],
    ],
    'Content' => [
        ['homepage', 'admin/homepage', 'home', 'Homepage', 'content', 0],
        ['banners', 'admin/banners', 'image', 'Banners', 'content', 0],
        ['testimonials', 'admin/testimonials', 'message', 'Testimonials', 'content', 0],
        ['social', 'admin/social', 'instagram', 'Instagram gallery', 'content', 0],
        ['pages', 'admin/pages', 'file', 'Pages', 'content', 0],
        ['messages', 'admin/messages', 'mail', 'Messages', 'messages', $unreadMessages],
    ],
    'System' => [
        ['settings', 'admin/settings', 'settings', 'Settings', 'settings', 0],
        ['admins', 'admin/admins', 'lock', 'Admin users', 'admins', 0],
    ],
];
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e(($title ?? 'Admin') . ' · ' . setting('site_name') . ' Admin') ?></title>
<link rel="icon" href="<?= e(asset('img/favicon-32.png')) ?>">
<link rel="stylesheet" href="<?= e(asset('vendor/bootstrap/bootstrap.min.css')) ?>">
<link rel="stylesheet" href="<?= e(asset(is_file(PUBLIC_PATH . '/assets/css/admin.min.css') ? 'css/admin.min.css' : 'css/admin.css')) ?>">
</head>
<body class="admin">
<?= App\Core\View::partial('partials/icons') ?>
<div class="adm-shell">
  <aside class="adm-side offcanvas-lg offcanvas-start" tabindex="-1" id="admSide">
    <div class="adm-brand">
      <a href="<?= e(url('admin')) ?>"><img src="<?= e(asset('img/logo-cotton.webp')) ?>" alt="<?= e(setting('site_name')) ?>" width="647" height="365"></a>
      <button type="button" class="adm-close d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#admSide" aria-label="Close menu"><?= icon('close') ?></button>
    </div>
    <nav class="adm-nav">
      <?php foreach ($menu as $group => $items):
        $visible = array_filter($items, static fn($i) => AdminAuth::can($i[4]));
        if (!$visible) continue; ?>
        <span class="adm-group"><?= e($group) ?></span>
        <?php foreach ($visible as [$key, $path, $ic, $label, $perm, $badge]): ?>
          <a href="<?= e(url($path)) ?>" class="<?= $active === $key ? 'active' : '' ?>"><?= icon($ic) ?><span><?= e($label) ?></span><?php if ($badge): ?><b><?= $badge ?></b><?php endif; ?></a>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </nav>
  </aside>
  <div class="adm-main">
    <header class="adm-top">
      <button class="adm-burger d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#admSide" aria-label="Open menu"><?= icon('menu') ?></button>
      <form class="adm-search d-none d-md-flex" action="<?= e(url('admin/orders')) ?>" method="get" role="search">
        <?= icon('search') ?><input type="search" name="q" placeholder="Search orders by number, name, email or phone…" aria-label="Search orders">
      </form>
      <div class="adm-top-right">
        <a class="adm-store" href="<?= e(url('/')) ?>" target="_blank" rel="noopener"><?= icon('external') ?> <span class="d-none d-sm-inline">View store</span></a>
        <div class="dropdown">
          <button class="adm-user" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="adm-avatar"><?= e(mb_strtoupper(mb_substr($admin['name'], 0, 1))) ?></span>
            <span class="d-none d-md-block text-start"><strong><?= e($admin['name']) ?></strong><small><?= e(AdminAuth::ROLE_LABELS[$admin['role']] ?? $admin['role']) ?></small></span>
            <?= icon('chevron-down', 'ic-sm') ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= e(url('admin/profile')) ?>"><?= icon('user', 'ic-sm') ?> My profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><form method="post" action="<?= e(url('admin/logout')) ?>"><?= csrf_field() ?><button class="dropdown-item" type="submit"><?= icon('logout', 'ic-sm') ?> Log out</button></form></li>
          </ul>
        </div>
      </div>
    </header>
    <main class="adm-content">
      <?php foreach (flash_messages() as $f): ?>
        <div class="adm-flash <?= e($f['type']) ?>" role="status"><?= icon($f['type'] === 'success' ? 'check-circle' : 'alert') ?><span><?= e($f['text']) ?></span><button type="button" onclick="this.parentNode.remove()" aria-label="Dismiss"><?= icon('close', 'ic-sm') ?></button></div>
      <?php endforeach; ?>
      <?php if ($errs = errors()): ?>
        <div class="adm-flash error" role="alert"><?= icon('alert') ?><span>Please fix the following: <?= e(implode(' ', array_filter($errs))) ?></span></div>
      <?php endif; ?>
      <?= $content ?>
    </main>
  </div>
</div>
<script>window.ADM = <?= json_encode(['base' => rtrim(url('/'), '/'), 'csrf' => csrf_token()], JSON_UNESCAPED_SLASHES) ?>;</script>
<script src="<?= e(asset('vendor/bootstrap/bootstrap.bundle.min.js')) ?>" defer></script>
<script src="<?= e(asset(is_file(PUBLIC_PATH . '/assets/js/admin.min.js') ? 'js/admin.min.js' : 'js/admin.js')) ?>" defer></script>
</body>
</html>
