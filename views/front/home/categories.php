<?php /** @var array $s */ ?>
<section class="section">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/section-head', ['s' => $s, 'align' => 'center']) ?>
    <div class="cat-grid">
      <?php foreach ($s['categories'] as $i => $c): ?>
      <a class="cat-card" href="<?= e($c['url']) ?>" data-reveal data-reveal-delay="<?= $i % 4 ?>">
        <div class="cat-media"><?= img_tag($c['image'], $c['name'], ['sizes' => '(max-width: 576px) 50vw, 25vw', 'width' => 800, 'height' => 1000]) ?></div>
        <h3><?= e($c['name']) ?></h3>
        <?php if ($c['tagline']): ?><p><?= e($c['tagline']) ?></p><?php endif; ?>
        <span class="cat-count"><?= e(plural((int) $c['product_count'], 'product')) ?> <?= icon('arrow-right') ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
