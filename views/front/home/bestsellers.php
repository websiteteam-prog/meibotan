<?php
/** @var array $s */
$limit = (int) ($s['settings']['limit'] ?? 8);
ob_start(); ?>
<div class="pill-tabs" role="tablist" data-tabs data-limit="<?= $limit ?>">
  <button type="button" class="pill-tab active" data-tab="" role="tab" aria-selected="true">All</button>
  <?php foreach ($s['tabs'] as $c): if ((int) $c['product_count'] === 0) continue; ?>
    <button type="button" class="pill-tab" data-tab="<?= (int) $c['id'] ?>" role="tab" aria-selected="false"><?= e($c['name']) ?> (<?= (int) $c['product_count'] ?>)</button>
  <?php endforeach; ?>
</div>
<?php $extra = ob_get_clean(); ?>
<section class="section" style="padding-top:0">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/section-head', ['s' => $s, 'extra' => $extra]) ?>
    <div class="product-grid tab-grid" data-tab-grid>
      <?php foreach ($s['products'] as $p): ?><?= App\Core\View::partial('partials/product-card', ['p' => $p]) ?><?php endforeach; ?>
    </div>
    <div class="text-center mt-5"><a class="btn-sa btn-outline" href="<?= e(url('shop', ['sort' => 'bestselling'])) ?>" data-tab-link>View all best sellers <?= icon('arrow-right') ?></a></div>
  </div>
</section>
