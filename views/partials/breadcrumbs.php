<?php /** @var array $crumbs [[label, url|null], …] */ ?>
<nav aria-label="Breadcrumb" class="crumbs">
  <ol>
    <?php foreach ($crumbs as $i => [$label, $link]): ?>
      <li><?php if ($link && $i < count($crumbs) - 1): ?><a href="<?= e($link) ?>"><?= e($label) ?></a><?php else: ?><span aria-current="page"><?= e($label) ?></span><?php endif; ?></li>
    <?php endforeach; ?>
  </ol>
</nav>
