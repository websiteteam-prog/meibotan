<?php
/** @var array $s */
$extra = '<div class="track-nav"><button type="button" class="btn-icon" data-track-prev aria-label="Previous">' . icon('arrow-left') . '</button><button type="button" class="btn-icon" data-track-next aria-label="Next">' . icon('arrow-right') . '</button></div>';
?>
<section class="section testimonials">
  <div class="container-xl" data-track-scope>
    <?= App\Core\View::partial('partials/section-head', ['s' => $s, 'extra' => $extra]) ?>
    <div class="track" data-track>
      <?php foreach ($s['items'] as $t): ?>
      <figure class="t-card m-0">
        <div class="d-flex justify-content-between align-items-start"><span class="t-quote" aria-hidden="true">“</span><?= stars((float) $t['rating']) ?></div>
        <blockquote class="t-text m-0"><?= e($t['content']) ?></blockquote>
        <figcaption class="t-person">
          <span class="t-avatar"><?php if ($t['avatar']): ?><?= img_tag($t['avatar'], $t['name'], ['sizes' => '46px']) ?><?php else: ?><?= e(mb_substr($t['name'], 0, 1)) ?><?php endif; ?></span>
          <span><span class="t-name d-block"><?= e($t['name']) ?></span><span class="t-meta"><?= e(trim(($t['location'] ?? '') . ($t['product_name'] ? ' · ' . $t['product_name'] : ''), ' ·')) ?></span></span>
        </figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>
