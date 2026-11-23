<?php
/** @var array $s */
$igUrl = setting('instagram_url') ?: '#';
?>
<section class="section">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/section-head', ['s' => $s, 'align' => 'center']) ?>
    <div class="insta-grid">
      <?php foreach ($s['items'] as $i => $post): ?>
      <a class="insta-item" href="<?= e($post['link'] ?: $igUrl) ?>" target="_blank" rel="noopener" aria-label="<?= e($post['caption'] ?: 'Instagram post') ?>" data-reveal data-reveal-delay="<?= $i % 4 ?>">
        <?= img_tag($post['image'], $post['caption'] ?: 'Savié Amour on Instagram', ['sizes' => '(max-width: 576px) 33vw, 16vw', 'width' => 400, 'height' => 400]) ?>
        <?= icon('instagram') ?>
      </a>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-5"><a class="btn-sa btn-outline" href="<?= e($igUrl) ?>" target="_blank" rel="noopener"><?= icon('instagram') ?> Follow <?= e(setting('instagram_handle', '@savieamour')) ?></a></div>
  </div>
</section>
