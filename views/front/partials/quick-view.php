<?php /** @var array $p */ ?>
<div class="qv-media" data-gallery>
  <div class="zoom" data-zoom><img src="<?= e(upload_url($p['image'], '600')) ?>" alt="<?= e($p['name']) ?>" data-main-image width="600" height="750"></div>
  <?php if (count($p['gallery']) > 1): ?>
  <div class="qv-thumbs">
    <?php foreach (array_slice($p['gallery'], 0, 4) as $i => $g): ?>
      <button type="button" class="<?= $i === 0 ? 'active' : '' ?>" data-thumb data-full="<?= e(upload_url($g, '600')) ?>" aria-label="Image <?= $i + 1 ?>"><img src="<?= e(upload_url($g, '300')) ?>" alt="" width="60" height="75"></button>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>
<div class="qv-info" data-product-scope>
  <span class="eyebrow"><?= e($p['category_name'] ?? '') ?></span>
  <h2 class="qv-title"><?= e($p['name']) ?></h2>
  <?php if ((int) $p['rating_count'] > 0): ?><div class="rating-line mb-2"><?= stars((float) $p['rating_avg']) ?> <?= number_format((float) $p['rating_avg'], 1) ?> (<?= (int) $p['rating_count'] ?>)</div><?php endif; ?>
  <?= App\Core\View::partial('front/partials/buy-box', ['p' => $p, 'compact' => true]) ?>
  <?php if ($p['short_description']): ?><p class="qv-desc"><?= e($p['short_description']) ?></p><?php endif; ?>
  <a class="link-arrow" href="<?= e($p['url']) ?>">View full details <?= icon('arrow-right') ?></a>
</div>
