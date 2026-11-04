<?php
/** Before/after comparison slider. Vars: $project (from data/gallery.php), $heading ('h2' or 'h3'). */
defined('ROOT_PATH') || exit;
$heading = $heading ?? 'h3';
$label = $project['title'] . ($project['location'] ? ' in ' . $project['location'] : '');
?>
<figure class="ba-card" data-gallery-item data-tags="<?= e(implode(' ', $project['tags'])) ?>">
  <div class="ba">
    <img class="ba__after" src="<?= e(asset($project['after'])) ?>" alt="After: <?= e($label) ?>" <?= img_size($project['after']) ?> loading="lazy" decoding="async">
    <img class="ba__before" src="<?= e(asset($project['before'])) ?>" alt="Before: <?= e($label) ?>" <?= img_size($project['before']) ?> loading="lazy" decoding="async">
    <span class="ba__label ba__label--before">Before</span>
    <span class="ba__label ba__label--after">After</span>
    <span class="ba__handle" aria-hidden="true"><span class="ba__knob"><?= icon('arrows-h') ?></span></span>
    <input class="ba__range" type="range" min="0" max="100" value="50" aria-label="Compare before and after: <?= e($label) ?>">
  </div>
  <figcaption class="ba-card__body">
    <<?= $heading ?>><?= e($project['title']) ?><?php if (!empty($project['sample'])): ?> <span class="sample-tag">Sample image</span><?php endif; ?></<?= $heading ?>>
    <?php if ($project['location']): ?><span class="ba-card__meta"><?= icon('pin') ?><?= e($project['location']) ?>, SA</span><?php endif; ?>
    <p><?= e($project['summary']) ?></p>
  </figcaption>
</figure>
