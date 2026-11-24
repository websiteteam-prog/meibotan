<?php /** @var ?array $c @var array $products @var array $selected */ $c = $c ?? []; ?>
<?= adm_head($c ? 'Edit <em>' . e($c['name']) . '</em>' : 'New <em>collection</em>', '', $c ? '<a class="btn-a light" target="_blank" rel="noopener" href="' . e(url('collection/' . $c['slug'])) . '">' . icon('eye', 'ic-sm') . ' View</a>' : '', ['Collections', 'admin/collections']) ?>
<form method="post" action="<?= e(url('admin/collections/save')) ?>" enctype="multipart/form-data">
  <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) ($c['id'] ?? 0) ?>">
  <div class="form-grid">
    <div>
      <div class="card-a">
        <h2>Details</h2>
        <?= adm_input('name', 'Name', $c['name'] ?? '', ['attrs' => ['required' => true, 'data-slug-source' => '#f_slug']]) ?>
        <div class="row"><?= adm_input('slug', 'Slug', $c['slug'] ?? '', ['col' => 'col-md-6 mb-3', 'prefix' => '/collection/']) ?><?= adm_input('eyebrow', 'Eyebrow label', $c['eyebrow'] ?? 'Special collection', ['col' => 'col-md-6 mb-3']) ?></div>
        <?= adm_input('tagline', 'Tagline', $c['tagline'] ?? '') ?>
        <?= adm_textarea('description', 'Description', $c['description'] ?? '', ['rows' => 3]) ?>
      </div>
      <div class="card-a flush">
        <div class="card-title">Products in this collection <small>Tick products and set their order</small></div>
        <div class="table-wrap" style="max-height:520px;overflow-y:auto"><table class="table-a">
          <thead><tr><th></th><th>Product</th><th>Category</th><th>Order</th></tr></thead>
          <tbody>
          <?php foreach ($products as $p): $on = array_key_exists($p['id'], $selected); ?>
            <tr>
              <td><input class="form-check-input" type="checkbox" name="products[]" value="<?= (int) $p['id'] ?>" <?= $on ? 'checked' : '' ?> aria-label="Include <?= e($p['name']) ?>"></td>
              <td><div class="d-flex gap-2 align-items-center"><img class="thumb" src="<?= e(upload_url($p['image'], '300')) ?>" alt="" style="width:36px;height:44px"><span><?= e($p['name']) ?><span class="sub"><?= e($p['sku']) ?><?= $p['is_active'] ? '' : ' · hidden' ?></span></span></div></td>
              <td><?= e($p['category'] ?? '—') ?></td>
              <td><input class="form-control sort-input" type="number" name="product_sort[<?= (int) $p['id'] ?>]" value="<?= (int) ($selected[$p['id']] ?? 0) ?>" aria-label="Order"></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table></div>
      </div>
    </div>
    <div class="sticky-col">
      <div class="card-a">
        <h2>Publish</h2>
        <?= adm_switch('is_active', 'Active', (bool) ($c['is_active'] ?? 1)) ?>
        <?= adm_switch('show_on_home', 'Feature on homepage', (bool) ($c['show_on_home'] ?? 0), 'Replaces the currently featured collection.') ?>
        <?= adm_input('sort_order', 'Display order', $c['sort_order'] ?? 0, ['type' => 'number']) ?>
        <button class="btn-a w-100" type="submit">Save collection</button>
      </div>
      <div class="card-a"><h2>Cover image</h2><?= adm_image('image', '', $c['image'] ?? null, ['help' => 'Portrait image (3:4). Text sits over the lower third.']) ?></div>
    </div>
  </div>
</form>
