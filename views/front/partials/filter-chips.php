<?php /** @var array $chips */ if (!$chips) { return; } ?>
<?php foreach ($chips as $c): ?>
  <button type="button" class="chip active" data-clear-filter="<?= e($c['name']) ?>" <?= isset($c['value']) ? 'data-value="' . e($c['value']) . '"' : '' ?>><?= e($c['label']) ?> <?= icon('close', 'ic-sm') ?></button>
<?php endforeach; ?>
<button type="button" class="chip-clear" data-clear-filter="all">Clear all</button>
