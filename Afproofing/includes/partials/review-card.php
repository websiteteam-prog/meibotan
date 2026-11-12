<?php
/** One customer review, Google-style card. Vars: $review (from data/reviews.php). */
defined('ROOT_PATH') || exit;
$name = trim((string) ($review['name'] ?? ''));
$initial = (string) ($review['initial'] ?? ($name !== '' ? mb_substr($name, 0, 1) : ''));
$source = (string) ($review['source'] ?? '');
$rating = max(1, min(5, (int) ($review['rating'] ?? 5)));
$who = $name !== '' ? $name : ($source !== '' ? $source . ' reviewer' : 'Customer');
$meta = array_filter([!empty($review['location']) ? $review['location'] . ', SA' : '', $review['service'] ?? '']);
?>
<article class="review-card" data-reveal>
  <header class="review-card__head">
    <span class="avatar" aria-hidden="true"><?= $initial !== '' ? e(mb_strtoupper($initial)) : icon('users') ?></span>
    <div>
      <cite><?= e($who) ?></cite>
      <?php if ($meta): ?><span class="review-card__meta"><?= e(implode(' · ', $meta)) ?></span><?php endif; ?>
    </div>
    <?php if (strcasecmp($source, 'Google') === 0): ?>
      <span class="review-card__source" title="Google review"><?= google_logo_svg() ?></span>
    <?php endif; ?>
  </header>
  <div class="stars" role="img" aria-label="<?= $rating ?> out of 5 stars">
    <?php for ($i = 0; $i < $rating; $i++) echo icon('star'); ?>
  </div>
  <blockquote><p>&ldquo;<?= e($review['text']) ?>&rdquo;</p></blockquote>
</article>
