<?php
defined('ROOT_PATH') || exit;

$steps = [
  ['img' => 'assets/img/Free Inspection.jpg', 'icon' => 'search', 'title' => 'Free Inspection & Quote', 'text' => 'We inspect your roof, explain what it needs and give you a clear, itemised quote.'],
  ['img' => 'assets/img/High-Pressure Clean.jpg', 'icon' => 'drop', 'title' => 'High-Pressure Clean', 'text' => 'Moss, lichen, dirt and loose growth are removed so we can see the true condition of every tile.'],
  ['img' => 'assets/img/Repairs & Replacements.jpg', 'icon' => 'tile-broken', 'title' => 'Repairs & Replacements', 'text' => 'Cracked, broken or slipped tiles are repaired or replaced to match your roof.'],
  ['img' => 'assets/img/Ridge Capping & Pointing.jpg', 'icon' => 'ridge', 'title' => 'Ridge Capping & Pointing', 'text' => 'Ridge caps are re-bedded and re-pointed with flexible pointing for a watertight finish.'],
  ['img' => 'assets/img/Seal, Paint & Protect.jpg', 'icon' => 'shield', 'title' => 'Seal, Paint & Protect', 'text' => 'A premium sealer and roof paint finish locks in colour and protects against weather.'],
];
?>
<ol class="process">
  <?php foreach ($steps as $i => $step): ?>
    <li class="process__step" data-reveal>
      <div class="process__media">
        <span class="process__circle">
          <?php if (is_file(ROOT_PATH . '/' . $step['img'])): ?>
            <img src="<?= e(asset($step['img'])) ?>" alt="<?= e($step['title']) ?>" width="360" height="360" loading="lazy"
              decoding="async">
          <?php else: ?>
            <?= icon($step['icon']) ?>
          <?php endif; ?>
        </span>
        <span class="process__num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
      </div>
      <div class="process__body">
        <h3><?= e($step['title']) ?></h3>
        <p><?= e($step['text']) ?></p>
      </div>
    </li>
  <?php endforeach; ?>
</ol>