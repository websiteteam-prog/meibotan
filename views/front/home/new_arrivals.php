<?php
/** @var array $s */
$extra = '<div class="track-nav"><button type="button" class="btn-icon" data-track-prev aria-label="Previous">' . icon('arrow-left') . '</button><button type="button" class="btn-icon" data-track-next aria-label="Next">' . icon('arrow-right') . '</button></div>';
?>
<section class="section">
  <div class="container-xl" data-track-scope>
    <?= App\Core\View::partial('partials/section-head', ['s' => $s, 'extra' => $extra]) ?>
    <div class="track" data-track>
      <?php foreach ($s['products'] as $p): ?><?= App\Core\View::partial('partials/product-card', ['p' => $p, 'sizes' => '(max-width: 576px) 70vw, 25vw']) ?><?php endforeach; ?>
    </div>
  </div>
</section>
