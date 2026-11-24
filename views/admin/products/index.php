<?php /** @var array $products @var App\Core\Paginator $pager @var array $categories @var int $threshold */ ?>
<?= adm_head('Products', 'Manage your catalogue, prices, stock and visibility.', '<a class="btn-a" href="' . e(url('admin/products/create')) . '">' . icon('plus', 'ic-sm') . ' Add product</a>') ?>

<form class="filters" method="get">
  <input class="form-control grow" type="search" name="q" value="<?= e(input('q')) ?>" placeholder="Search by name or SKU…">
  <select class="form-select" name="category" data-autosubmit><option value="">All categories</option><?php foreach ($categories as $c): ?><option value="<?= (int) $c['id'] ?>" <?= input_int('category') === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select>
  <select class="form-select" name="status" data-autosubmit><option value="">Any status</option><option value="active" <?= input('status') === 'active' ? 'selected' : '' ?>>Active</option><option value="inactive" <?= input('status') === 'inactive' ? 'selected' : '' ?>>Hidden</option></select>
  <select class="form-select" name="stock" data-autosubmit><option value="">Any stock</option><option value="low" <?= input('stock') === 'low' ? 'selected' : '' ?>>Low (≤ <?= $threshold ?>)</option><option value="out" <?= input('stock') === 'out' ? 'selected' : '' ?>>Out of stock</option></select>
  <select class="form-select" name="flag" data-autosubmit><option value="">All products</option><option value="featured" <?= input('flag') === 'featured' ? 'selected' : '' ?>>Featured</option><option value="bestseller" <?= input('flag') === 'bestseller' ? 'selected' : '' ?>>Best sellers</option><option value="new" <?= input('flag') === 'new' ? 'selected' : '' ?>>New arrivals</option></select>
  <select class="form-select" name="sort" data-autosubmit><option value="">Newest first</option><option value="name" <?= input('sort') === 'name' ? 'selected' : '' ?>>Name</option><option value="price" <?= input('sort') === 'price' ? 'selected' : '' ?>>Price</option><option value="stock" <?= input('sort') === 'stock' ? 'selected' : '' ?>>Stock (low first)</option><option value="sold" <?= input('sort') === 'sold' ? 'selected' : '' ?>>Best selling</option></select>
  <button class="btn-a dark" type="submit"><?= icon('search', 'ic-sm') ?> Filter</button>
</form>

<form method="post" action="<?= e(url('admin/products/bulk')) ?>" data-confirm="Apply this action to the selected products?">
  <?= csrf_field() ?>
  <div class="card-a flush">
    <div class="d-flex gap-2 align-items-center p-3 border-bottom" data-bulk-bar hidden>
      <strong><span data-bulk-count>0</span> selected</strong>
      <select class="form-select form-select-sm w-auto" name="action">
        <option value="">Bulk action…</option><option value="activate">Show on store</option><option value="deactivate">Hide from store</option>
        <option value="feature">Mark featured</option><option value="unfeature">Remove featured</option><option value="bestseller">Mark best seller</option>
        <option value="in_stock">Set in stock</option><option value="out_of_stock">Set out of stock</option><option value="delete">Delete</option>
      </select>
      <button class="btn-a sm" type="submit">Apply</button>
    </div>
    <div class="table-wrap">
      <table class="table-a">
        <thead><tr><th style="width:36px"><input type="checkbox" class="form-check-input" data-check-all aria-label="Select all"></th><th>Product</th><th>Category</th><th class="num">Price</th><th class="num">Stock</th><th>Status</th><th class="num">Sold</th><th class="actions">Actions</th></tr></thead>
        <tbody>
        <?php foreach ($products as $p):
          $stock = (int) $p['stock'];
          $onSale = $p['sale_price'] !== null && (float) $p['sale_price'] < (float) $p['price']; ?>
          <tr>
            <td><input type="checkbox" class="form-check-input" name="ids[]" value="<?= (int) $p['id'] ?>" data-check-item aria-label="Select <?= e($p['name']) ?>"></td>
            <td>
              <div class="d-flex align-items-center gap-3">
                <img class="thumb" src="<?= e(upload_url($p['image'], '300')) ?>" alt="" loading="lazy">
                <div>
                  <a class="name" href="<?= e(url('admin/products/' . $p['id'] . '/edit')) ?>"><?= e($p['name']) ?></a>
                  <span class="sub">SKU <?= e($p['sku']) ?><?= $p['variant_count'] ? ' · ' . (int) $p['variant_count'] . ' ' . e(strtolower($p['variant_label'] ?: 'variant')) . 's' : '' ?></span>
                  <span class="d-flex gap-1 mt-1"><?php if ($p['is_featured']): ?><span class="badge-a purple">Featured</span><?php endif; ?><?php if ($p['is_bestseller']): ?><span class="badge-a blue">Best seller</span><?php endif; ?><?php if ($p['is_new']): ?><span class="badge-a">New</span><?php endif; ?><?php if ($p['badge']): ?><span class="badge-a amber"><?= e($p['badge']) ?></span><?php endif; ?></span>
                </div>
              </div>
            </td>
            <td><?= e($p['category_name'] ?? '—') ?><span class="sub"><?= e($p['subcategory_name'] ?? '') ?></span></td>
            <td class="num"><?php if ($onSale): ?><strong><?= money($p['sale_price']) ?></strong><span class="sub"><s><?= money($p['price']) ?></s></span><?php else: ?><strong><?= money($p['price']) ?></strong><?php endif; ?></td>
            <td class="num"><?php if ($p['stock_status'] === 'out_of_stock'): ?><span class="badge-a red">Out of stock</span><?php else: ?><span class="badge-a <?= $stock <= 0 ? 'red' : ($stock <= $threshold ? 'amber' : 'green') ?>"><?= $stock ?></span><?php endif; ?></td>
            <td><?= $p['is_active'] ? '<span class="badge-a green"><span class="dot"></span> Active</span>' : '<span class="badge-a grey">Hidden</span>' ?></td>
            <td class="num"><?= (int) $p['sold_count'] ?></td>
            <td class="actions">
              <a class="btn-a sm light" href="<?= e(url('admin/products/' . $p['id'] . '/edit')) ?>" title="Edit"><?= icon('edit', 'ic-sm') ?></a>
              <a class="btn-a sm light" href="<?= e(url('product/' . $p['slug'])) ?>" target="_blank" rel="noopener" title="View on store"><?= icon('eye', 'ic-sm') ?></a>
              <button class="btn-a sm light" type="submit" form="dup<?= (int) $p['id'] ?>" title="Duplicate" data-no-loading><?= icon('copy', 'ic-sm') ?></button>
              <button class="btn-a sm light" type="submit" form="tog<?= (int) $p['id'] ?>" title="<?= $p['is_active'] ? 'Hide' : 'Show' ?>" data-no-loading><?= icon($p['is_active'] ? 'eye' : 'check', 'ic-sm') ?> <?= $p['is_active'] ? 'Hide' : 'Show' ?></button>
              <button class="btn-a sm danger" type="submit" form="del<?= (int) $p['id'] ?>" title="Delete" data-no-loading><?= icon('trash', 'ic-sm') ?></button>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (!$products): ?><tr><td colspan="8"><div class="empty"><?= icon('package') ?><p>No products match these filters.</p><a class="btn-a" href="<?= e(url('admin/products/create')) ?>">Add your first product</a></div></td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
    <?= adm_pager($pager, 'admin/products') ?>
  </div>
</form>
<?php foreach ($products as $p): ?>
  <form id="dup<?= (int) $p['id'] ?>" method="post" action="<?= e(url('admin/products/' . $p['id'] . '/duplicate')) ?>" hidden><?= csrf_field() ?></form>
  <form id="tog<?= (int) $p['id'] ?>" method="post" action="<?= e(url('admin/products/' . $p['id'] . '/toggle')) ?>" hidden><?= csrf_field() ?></form>
  <form id="del<?= (int) $p['id'] ?>" method="post" action="<?= e(url('admin/products/' . $p['id'] . '/delete')) ?>" data-confirm="Delete “<?= e($p['name']) ?>”? This cannot be undone." hidden><?= csrf_field() ?></form>
<?php endforeach; ?>
