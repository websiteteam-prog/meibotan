<?php
/** Before/after comparison slider (photos only, no caption). Vars: $project (from data/gallery.php). */
defined('ROOT_PATH') || exit;
$label = $project['title'] . (!empty($project['location']) ? ' in ' . $project['location'] : '');
?>
<figure class="ba-card">
  <div class="ba">
    <img class="ba__after" src="<?= e(asset($project['after'])) ?>" alt="After: <?= e($label) ?>" <?= img_size($project['after']) ?> loading="lazy" decoding="async">
    <img class="ba__before" src="<?= e(asset($project['before'])) ?>" alt="Before: <?= e($label) ?>" <?= img_size($project['before']) ?> loading="lazy" decoding="async">
    <span class="ba__label ba__label--before">Before</span>
    <span class="ba__label ba__label--after">After</span>
    <span class="ba__handle" aria-hidden="true"><span class="ba__knob"><?= icon('arrows-h') ?></span></span>
    <input class="ba__range" type="range" min="0" max="100" value="50" aria-label="Compare before and after: <?= e($label) ?>">
  </div>
</figure>
