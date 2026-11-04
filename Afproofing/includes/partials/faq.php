<?php
/** FAQ accordion. Vars: $faqs (list of ['q' => ..., 'a' => ...]). */
defined('ROOT_PATH') || exit;
?>
<div class="faq">
  <?php foreach ($faqs as $i => $faq): ?>
    <details<?= $i === 0 ? ' open' : '' ?>>
      <summary><?= e($faq['q']) ?><span class="faq__icon" aria-hidden="true"><?= icon('chevron-down') ?></span></summary>
      <div class="faq__answer"><p><?= e($faq['a']) ?></p></div>
    </details>
  <?php endforeach; ?>
</div>
