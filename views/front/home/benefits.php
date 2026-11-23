<?php /** @var array $s */ ?>
<section class="benefits">
  <div class="container-xl">
    <div class="benefit-grid">
      <?php foreach (array_slice($s['items'], 0, 4) as $i => $b): ?>
      <div class="benefit" data-reveal data-reveal-delay="<?= $i ?>">
        <div class="benefit-icon"><?= icon($b['icon'] ?? 'sparkle') ?></div>
        <h4><?= e($b['title'] ?? '') ?></h4>
        <p><?= e($b['text'] ?? '') ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
