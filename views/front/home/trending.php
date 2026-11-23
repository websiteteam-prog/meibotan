<?php
/** @var array $s */
$extra = '<a class="link-arrow" href="' . e(url('shop', ['sort' => 'featured'])) . '">Shop all ' . icon('arrow-right') . '</a>';
?>
<section class="section" style="padding-top:0">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/section-head', ['s' => $s, 'extra' => $extra]) ?>
    <div class="product-grid">
      <?php foreach ($s['products'] as $i => $p): ?>
        <div data-reveal data-reveal-delay="<?= $i % 4 ?>"><?= App\Core\View::partial('partials/product-card', ['p' => $p]) ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
