<?php /** @var string $content @var string $title */ ?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e(($title ?? 'Admin') . ' · ' . setting('site_name')) ?></title>
<link rel="icon" href="<?= e(asset('img/favicon-32.png')) ?>">
<link rel="stylesheet" href="<?= e(asset('vendor/bootstrap/bootstrap.min.css')) ?>">
<link rel="stylesheet" href="<?= e(asset(is_file(PUBLIC_PATH . '/assets/css/admin.min.css') ? 'css/admin.min.css' : 'css/admin.css')) ?>">
</head>
<body class="admin adm-auth">
<?= App\Core\View::partial('partials/icons') ?>
<div class="adm-auth-card">
  <img class="adm-auth-logo" src="<?= e(asset('img/logo-maroon.webp')) ?>" alt="<?= e(setting('site_name')) ?>" width="647" height="365">
  <?php foreach (flash_messages() as $f): ?><div class="adm-flash <?= e($f['type']) ?>"><?= icon($f['type'] === 'success' ? 'check-circle' : 'alert') ?><span><?= e($f['text']) ?></span></div><?php endforeach; ?>
  <?= $content ?>
</div>
<script src="<?= e(asset('vendor/bootstrap/bootstrap.bundle.min.js')) ?>" defer></script>
</body>
</html>
