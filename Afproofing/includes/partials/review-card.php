<?php
/** One customer review. Vars: $review (from data/reviews.php). */
defined('ROOT_PATH') || exit;
$sample = !empty($review['sample']);
$name = $sample ? "" : $review['name'];
$meta = array_filter([$review['location'] ? $review['location'] . ', SA' : '', $review['service']]);
?>
<article class="review-card" data-reveal>
  <?= icon('quote', 'review-card__quote') ?>
  <div class="stars" role="img" aria-label="<?= (int) $review['rating'] ?> out of 5 stars">
    <?php for ($i = 0; $i < (int) $review['rating']; $i++) echo icon('star'); ?>
  </div>
  <blockquote><p>&ldquo;<?= e($review['text']) ?>&rdquo;</p></blockquote>
  <footer>
    <span class="avatar" aria-hidden="true"><?= $sample ? icon('users') : e(mb_strtoupper(mb_substr($name, 0, 1))) ?></span>
    <div>
      <cite><?= e($name) ?></cite><?php if ($sample): ?> <?php endif; ?>
      <?php if ($meta): ?><span class="review-card__meta"><?= e(implode(' · ', $meta)) ?></span><?php endif; ?>
    </div>
  </footer>
</article>
