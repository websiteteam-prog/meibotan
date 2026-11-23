<?php
/** @var array $s home section row  @var string $align  @var string $extra right-hand HTML */
$align = $align ?? '';
?>
<div class="section-head <?= e($align) ?>" data-reveal>
  <div>
    <?php if (!empty($s['eyebrow'])): ?><span class="eyebrow"><?= e($s['eyebrow']) ?></span><?php endif; ?>
    <h2 class="section-title"><?= e($s['title'] ?? '') ?><?php if (!empty($s['title_italic'])): ?> <em><?= e($s['title_italic']) ?></em><?php endif; ?></h2>
    <?php if (!empty($s['subtitle'])): ?><p class="section-sub"><?= e($s['subtitle']) ?></p><?php endif; ?>
  </div>
  <?= $extra ?? '' ?>
</div>
