<?php
/** @var App\Core\Paginator $pager @var string $path */
if ($pager->pages <= 1) { return; }
?>
<nav class="pager" aria-label="Pagination">
  <?php if ($pager->page > 1): ?><a href="<?= e(query_url(['page' => $pager->page - 1 > 1 ? $pager->page - 1 : null], $path)) ?>" data-page="<?= $pager->page - 1 ?>" aria-label="Previous page"><?= icon('chevron-left') ?></a><?php endif; ?>
  <?php foreach ($pager->window() as $n): ?>
    <?php if ($n === '…'): ?><span class="gap">…</span>
    <?php elseif ($n === $pager->page): ?><span class="current" aria-current="page"><?= $n ?></span>
    <?php else: ?><a href="<?= e(query_url(['page' => $n > 1 ? $n : null], $path)) ?>" data-page="<?= $n ?>"><?= $n ?></a><?php endif; ?>
  <?php endforeach; ?>
  <?php if ($pager->hasMore()): ?><a href="<?= e(query_url(['page' => $pager->page + 1], $path)) ?>" data-page="<?= $pager->page + 1 ?>" aria-label="Next page"><?= icon('chevron-right') ?></a><?php endif; ?>
</nav>
