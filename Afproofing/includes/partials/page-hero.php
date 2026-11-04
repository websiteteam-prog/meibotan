<?php
/**
 * Inner page banner.
 * Vars: $title, $lead, $crumbs (list of [name, path]; last item is the current page),
 *       $image (optional background), $eyebrow (optional), $actions (bool, default true).
 */
defined('ROOT_PATH') || exit;
$crumbs = $crumbs ?? [];
$actions = $actions ?? true;
?>
<section class="page-hero">
  <?php if (!empty($image)): ?>
    <div class="page-hero__bg"><img src="<?= e(asset($image)) ?>" alt="" <?= img_size($image) ?> fetchpriority="high"></div>
  <?php endif; ?>
  <div class="container">
    <nav class="breadcrumbs" aria-label="Breadcrumb">
      <ol>
        <li><a href="<?= e(url()) ?>">Home</a></li>
        <?php foreach ($crumbs as $i => [$name, $path]): ?>
          <?php if ($i === array_key_last($crumbs)): ?>
            <li><span aria-current="page"><?= e($name) ?></span></li>
          <?php else: ?>
            <li><a href="<?= e(url($path)) ?>"><?= e($name) ?></a></li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ol>
    </nav>
    <?php if (!empty($eyebrow)): ?><p class="eyebrow"><?= e($eyebrow) ?></p><?php endif; ?>
    <h1><?= e($title) ?></h1>
    <?php if (!empty($lead)): ?><p class="page-hero__lead"><?= e($lead) ?></p><?php endif; ?>
    <?php if ($actions): ?>
      <div class="page-hero__actions">
        <a class="btn btn--primary btn--lg" href="<?= e(url('free-quote')) ?>">Get a Free Quote <?= icon('arrow-right', 'icon-shift') ?></a>
        <a class="btn btn--outline btn--lg" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> <?= e(config('phone')) ?></a>
      </div>
    <?php endif; ?>
  </div>
</section>
