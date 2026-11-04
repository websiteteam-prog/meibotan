<?php
/**
 * Site logo. Pass ['light' => true] on dark backgrounds (e.g. the footer)
 * to use the reversed version: yellow house mark with white lettering.
 */
defined('ROOT_PATH') || exit;
$logoFile = !empty($light) ? 'assets/img/logo-horizontal-light.svg' : 'assets/img/logo-horizontal.svg';
?>
<a class="brand<?= !empty($light) ? ' brand--light' : '' ?>" href="<?= e(url()) ?>" aria-label="<?= e(config('site_name')) ?>, home">
  <img class="brand__logo" src="<?= e(asset($logoFile)) ?>" alt="<?= e(config('site_name')) ?>" width="703" height="191">
</a>
