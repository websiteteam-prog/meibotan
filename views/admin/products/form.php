<?php
/**
 * @var ?array $p @var array $categories @var array $subcategories @var array $collections @var array $selectedCollections
 * @var array $images @var array $variants @var array $specs
 */
$p = $p ?? [];
$v = static fn(string $k, $d = '') => $p[$k] ?? $d;
$catOptions = [];
foreach ($categories as $c) { $catOptions[$c['id']] = $c['name']; }
$subOptions = [];
foreach ($subcategories as $s) { $subOptions[$s['id']] = ['label' => $s['name'], 'attrs' => ['data-cat' => $s['category_id']]]; }
$variantRow = static function ($key, array $row) {
    $img = !empty($row['image']) ? '<img class="v-img" src="' . e(upload_url($row['image'], '300')) . '" alt="">' : '';
    return '<div class="repeater-row variant-row" data-repeater-item>'
        . '<input type="hidden" name="variants[' . $key . '][id]" value="' . (int) ($row['id'] ?? 0) . '">'
        . '<div><label>Name</label><input class="form-control" name="variants[' . $key . '][name]" value="' . e($row['name'] ?? '') . '" placeholder="e.g. Cherry Amour" required></div>'
        . '<div><label>Swatch <input type="checkbox" name="variants[' . $key . '][use_swatch]" value="1" ' . (!array_key_exists('swatch', $row) || !empty($row['swatch']) ? 'checked' : '') . ' title="Use colour swatch"></label><input type="color" name="variants[' . $key . '][swatch]" value="' . e($row['swatch'] ?? '#810100') . '"></div>'
        . '<div><label>SKU</label><input class="form-control" name="variants[' . $key . '][sku]" value="' . e($row['sku'] ?? '') . '"></div>'
        . '<div><label>Price (blank = product)</label><input class="form-control" type="number" step="0.01" min="0" name="variants[' . $key . '][price]" value="' . e($row['price'] ?? '') . '"></div>'
        . '<div><label>Sale price</label><input class="form-control" type="number" step="0.01" min="0" name="variants[' . $key . '][sale_price]" value="' . e($row['sale_price'] ?? '') . '"></div>'
        . '<div><label>Stock</label><input class="form-control" type="number" min="0" name="variants[' . $key . '][stock_qty]" value="' . e($row['stock_qty'] ?? 0) . '" required></div>'
        . '<div><label>Image</label><div class="d-flex gap-1 align-items-center">' . $img . '<input class="form-control form-control-sm" type="file" name="variant_images[' . $key . ']" accept="image/*" style="max-width:100%"></div>'
        . ($img ? '<label class="mt-1"><input type="checkbox" name="variants[' . $key . '][remove_image]" value="1"> remove</label>' : '') . '</div>'
        . '<div class="d-flex flex-column gap-1 align-items-end"><label class="m-0"><input type="checkbox" name="variants[' . $key . '][is_active]" value="1" ' . (!isset($row['is_active']) || $row['is_active'] ? 'checked' : '') . '> Active</label>'
        . '<input type="hidden" name="variants[' . $key . '][sort_order]" value="' . (int) ($row['sort_order'] ?? 0) . '">'
        . '<button type="button" class="btn-a sm danger" data-repeater-remove title="Remove">' . icon('trash', 'ic-sm') . '</button></div>'
        . '</div>';
};
$specRow = static fn($key, array $row) => '<div class="repeater-row spec-row" data-repeater-item>'
    . '<div><label>Label</label><input class="form-control" name="specs[' . $key . '][label]" value="' . e($row['label'] ?? '') . '" placeholder="e.g. Net quantity"></div>'
    . '<div><label>Value</label><input class="form-control" name="specs[' . $key . '][value]" value="' . e($row['value'] ?? '') . '" placeholder="e.g. 4 ml"></div>'
    . '<button type="button" class="btn-a sm danger" data-repeater-remove title="Remove">' . icon('trash', 'ic-sm') . '</button></div>';
?>
<?= adm_head($p ? 'Edit <em>' . e($p['name']) . '</em>' : 'Add <em>product</em>', $p ? 'Last updated ' . format_date($p['updated_at'] ?: $p['created_at'], 'd M Y, h:i A') : 'Create a new product for your store.',
    $p ? '<a class="btn-a light" href="' . e(url('product/' . $p['slug'])) . '" target="_blank" rel="noopener">' . icon('eye', 'ic-sm') . ' View on store</a>' : '', ['Products', 'admin/products']) ?>

<form method="post" action="<?= e(url('admin/products/save')) ?>" enctype="multipart/form-data" novalidate>
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= (int) $v('id', 0) ?>">
  <div class="form-grid">
    <div>
      <div class="card-a">
        <h2>General</h2>
        <?= adm_input('name', 'Product name', $v('name'), ['attrs' => ['required' => true, 'maxlength' => 190, 'data-slug-source' => '#f_slug']]) ?>
        <div class="row">
          <?= adm_input('slug', 'URL slug', $v('slug'), ['col' => 'col-md-7 mb-3', 'prefix' => '/product/', 'help' => 'Leave blank to generate from the name.']) ?>
          <?= adm_input('sku', 'SKU / product code', $v('sku'), ['col' => 'col-md-5 mb-3', 'attrs' => ['required' => true, 'maxlength' => 64]]) ?>
        </div>
        <?= adm_textarea('short_description', 'Short description', $v('short_description'), ['rows' => 2, 'help' => 'Shown near the price and in search results (max 600 characters).', 'attrs' => ['maxlength' => 600]]) ?>
        <?= adm_rte('description', 'Full description', $v('description')) ?>
      </div>

      <div class="card-a">
        <h2>Pricing &amp; inventory</h2>
        <div class="row">
          <?= adm_input('price', 'Regular price', $v('price'), ['type' => 'number', 'col' => 'col-md-4 mb-3', 'prefix' => setting('currency_symbol', '₹'), 'attrs' => ['step' => '0.01', 'min' => 0, 'required' => true]]) ?>
          <?= adm_input('sale_price', 'Sale price', $v('sale_price'), ['type' => 'number', 'col' => 'col-md-4 mb-3', 'prefix' => setting('currency_symbol', '₹'), 'optional' => true, 'attrs' => ['step' => '0.01', 'min' => 0]]) ?>
          <?= adm_input('stock_qty', 'Stock quantity', $v('stock_qty', 0), ['type' => 'number', 'col' => 'col-md-4 mb-3', 'help' => 'Used when the product has no variants.', 'attrs' => ['min' => 0, 'required' => true]]) ?>
        </div>
        <div class="row">
          <?= adm_select('stock_status', 'Stock status', ['in_stock' => 'In stock (sell while quantity > 0)', 'out_of_stock' => 'Out of stock (disable purchase)'], $v('stock_status', 'in_stock'), ['col' => 'col-md-6 mb-0']) ?>
          <?= adm_input('badge', 'Custom badge', $v('badge'), ['col' => 'col-md-6 mb-0', 'optional' => true, 'help' => 'e.g. “Iconic Shade”, “Limited Edition”. New, Sale and Best Seller badges are automatic.', 'attrs' => ['maxlength' => 40]]) ?>
        </div>
      </div>

      <div class="card-a" data-repeater>
        <h2>Variants <small>Shades, sizes or other options with their own price &amp; stock</small></h2>
        <?= adm_input('variant_label', 'Option name', $v('variant_label'), ['help' => 'Shown to customers, e.g. “Shade” or “Size”.', 'attrs' => ['maxlength' => 40, 'placeholder' => 'Shade']]) ?>
        <div data-repeater-list>
          <?php foreach ($variants as $i => $row): ?><?= $variantRow($i, $row) ?><?php endforeach; ?>
        </div>
        <template><?= $variantRow('__INDEX__', []) ?></template>
        <button type="button" class="btn-a light" data-repeater-add><?= icon('plus', 'ic-sm') ?> Add variant</button>
        <?= error_for('variants') ?>
      </div>

      <div class="card-a" data-repeater>
        <h2>Specifications</h2>
        <div data-repeater-list>
          <?php foreach ($specs as $i => $row): ?><?= $specRow($i, $row) ?><?php endforeach; ?>
        </div>
        <template><?= $specRow('__INDEX__', []) ?></template>
        <button type="button" class="btn-a light" data-repeater-add><?= icon('plus', 'ic-sm') ?> Add specification</button>
      </div>

      <div class="card-a">
        <h2>Additional information</h2>
        <?= adm_rte('additional_info', 'How to use, ingredients, manufacturer details', $v('additional_info')) ?>
      </div>

      <div class="card-a">
        <h2>Search engine listing</h2>
        <?= adm_input('meta_title', 'Meta title', $v('meta_title'), ['optional' => true, 'help' => 'Defaults to the product name. Aim for under 60 characters.', 'attrs' => ['maxlength' => 190]]) ?>
        <?= adm_textarea('meta_description', 'Meta description', $v('meta_description'), ['rows' => 2, 'help' => 'Defaults to the short description. Aim for 140–160 characters.', 'attrs' => ['maxlength' => 300]]) ?>
      </div>
    </div>

    <div class="sticky-col">
      <div class="card-a">
        <h2>Publish</h2>
        <?= adm_switch('is_active', 'Visible on store', (bool) $v('is_active', 1)) ?>
        <?= adm_switch('is_featured', 'Featured / trending', (bool) $v('is_featured', 0)) ?>
        <?= adm_switch('is_bestseller', 'Best seller', (bool) $v('is_bestseller', 0)) ?>
        <?= adm_switch('is_new', 'New arrival', (bool) $v('is_new', 1)) ?>
        <div class="d-grid gap-2 mt-3">
          <button class="btn-a" type="submit"><?= icon('check', 'ic-sm') ?> Save product</button>
          <button class="btn-a light" type="submit" name="save_and" value="new">Save &amp; add another</button>
        </div>
      </div>
      <div class="card-a">
        <h2>Organisation</h2>
        <?= adm_select('category_id', 'Category', $catOptions, $v('category_id'), ['placeholder' => 'Choose category', 'attrs' => ['required' => true, 'data-category-select' => '#f_subcategory_id']]) ?>
        <?= adm_select('subcategory_id', 'Subcategory', $subOptions, $v('subcategory_id'), ['placeholder' => 'None']) ?>
        <?php if ($collections): ?>
          <label class="form-label">Collections</label>
          <?php foreach ($collections as $c): ?>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="collections[]" value="<?= (int) $c['id'] ?>" id="col<?= (int) $c['id'] ?>" <?= in_array((int) $c['id'], $selectedCollections, true) ? 'checked' : '' ?>><label class="form-check-label" for="col<?= (int) $c['id'] ?>"><?= e($c['name']) ?></label></div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="card-a">
        <h2>Images</h2>
        <?= adm_image('image', 'Main image', $v('image') ?: null, ['help' => 'Square or 4:5 portrait, at least 1000px wide. JPG, PNG or WebP — converted to optimised WebP automatically.']) ?>
        <?= adm_image('hover_image', 'Hover image', $v('hover_image') ?: null, ['small' => true, 'removable' => true, 'help' => 'Shown when shoppers hover the product card.']) ?>
        <label class="form-label">Gallery</label>
        <?php if ($images): ?>
        <div class="gallery-grid">
          <?php foreach ($images as $img): ?>
            <div class="gallery-item">
              <img src="<?= e(upload_url($img['image'], '300')) ?>" alt="">
              <div class="g-tools"><input type="number" name="gallery_sort[<?= (int) $img['id'] ?>]" value="<?= (int) $img['sort_order'] ?>" title="Order" aria-label="Order"><label class="g-del"><input type="checkbox" name="gallery_delete[<?= (int) $img['id'] ?>]" value="1"> <?= icon('trash', 'ic-sm') ?></label></div>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="gallery-grid" data-new-previews></div>
        <div class="img-drop small"><input type="file" name="gallery[]" multiple accept="image/jpeg,image/png,image/webp,image/gif"><div class="hint"><?= icon('upload', 'ic-sm') ?><span>Add gallery images</span></div></div>
      </div>
    </div>
  </div>
</form>
