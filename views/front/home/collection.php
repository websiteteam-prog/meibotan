<?php
/** @var array $s */
$c = $s['collection'];
$words = explode(' ', $c['name']);
$last = count($words) > 1 ? array_pop($words) : '';
?>
<section class="section">
  <div class="container-xl">
    <div class="collection-grid">
      <a class="collection-hero" href="<?= e(url('collection/' . $c['slug'])) ?>" data-reveal>
        <?= img_tag($c['image'], $c['name'], ['sizes' => '(max-width: 992px) 100vw, 45vw', 'width' => 900, 'height' => 1200]) ?>
        <div>
          <span class="eyebrow eyebrow-light"><?= e($c['eyebrow'] ?: 'Special collection') ?></span>
          <h2><?= e(implode(' ', $words)) ?> <?php if ($last): ?><em><?= e($last) ?></em><?php endif; ?></h2>
          <?php if ($c['tagline']): ?><p><?= e($c['tagline']) ?></p><?php endif; ?>
          <span class="btn-sa btn-light">Shop the collection <?= icon('arrow-right') ?></span>
        </div>
      </a>
      <div class="collection-products">
        <?php foreach ($s['products'] as $i => $p): ?>
          <div data-reveal data-reveal-delay="<?= $i % 2 + 1 ?>"><?= App\Core\View::partial('partials/product-card', ['p' => $p, 'sizes' => '(max-width: 576px) 50vw, 25vw']) ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
