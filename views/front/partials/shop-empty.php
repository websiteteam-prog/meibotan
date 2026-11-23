<?php /** @var string $q */ ?>
<div class="empty-state" style="grid-column:1/-1">
  <div class="empty-icon"><?= icon('search') ?></div>
  <h3>Nothing <em class="text-cherry">here</em> yet</h3>
  <p><?= $q !== '' ? 'We couldn’t find products matching “' . e($q) . '”. Try a different word or browse our categories.' : 'No products match these filters. Try removing a filter or two.' ?></p>
  <a href="<?= e(url('shop')) ?>" class="btn-sa">Explore all products <?= icon('arrow-right') ?></a>
</div>
