<?php /** @var array $categories */ ?>
<?= adm_head('Categories', 'Organise products into categories and subcategories. Featured categories appear on the homepage.',
  '<button class="btn-a light" type="button" data-bs-toggle="modal" data-bs-target="#subModal" data-fill-form="#subForm" data-title="Add subcategory" data-values=\'{"id":"0","is_active":"1"}\'>' . icon('plus', 'ic-sm') . ' Subcategory</button>'
  . '<button class="btn-a" type="button" data-bs-toggle="modal" data-bs-target="#catModal" data-fill-form="#catForm" data-title="Add category" data-values=\'{"id":"0","is_active":"1","is_featured":"1"}\'>' . icon('plus', 'ic-sm') . ' Category</button>') ?>

<form method="post" action="<?= e(url('admin/categories/reorder')) ?>">
  <?= csrf_field() ?>
  <?php foreach ($categories as $c): ?>
  <div class="cat-block">
    <div class="cat-block-head">
      <img src="<?= e(upload_url($c['image'], '300')) ?>" alt="">
      <div class="grow">
        <strong class="fs-6"><?= e($c['name']) ?></strong> <?= $c['is_active'] ? '<span class="badge-a green">Active</span>' : '<span class="badge-a grey">Hidden</span>' ?> <?= $c['is_featured'] ? '<span class="badge-a purple">On homepage</span>' : '' ?>
        <div class="form-text m-0">/category/<?= e($c['slug']) ?> · <?= (int) $c['product_count'] ?> products<?= $c['tagline'] ? ' · ' . e($c['tagline']) : '' ?></div>
      </div>
      <label class="form-text m-0">Order <input class="form-control sort-input d-inline-block" type="number" name="order[<?= (int) $c['id'] ?>]" value="<?= (int) $c['sort_order'] ?>"></label>
      <button type="button" class="btn-a sm light" data-bs-toggle="modal" data-bs-target="#catModal" data-fill-form="#catForm" data-title="Edit category"
        data-values='<?= e(json_encode(['id' => $c['id'], 'name' => $c['name'], 'slug' => $c['slug'], 'tagline' => $c['tagline'], 'description' => $c['description'], 'sort_order' => $c['sort_order'], 'is_active' => $c['is_active'], 'is_featured' => $c['is_featured'], 'meta_title' => $c['meta_title'], 'meta_description' => $c['meta_description'], 'image' => $c['image'] ? upload_url($c['image'], '300') : ''])) ?>'><?= icon('edit', 'ic-sm') ?> Edit</button>
      <button class="btn-a sm light" type="submit" form="ctog<?= (int) $c['id'] ?>" data-no-loading><?= $c['is_active'] ? 'Hide' : 'Show' ?></button>
      <button class="btn-a sm danger" type="submit" form="cdel<?= (int) $c['id'] ?>" data-no-loading title="Delete"><?= icon('trash', 'ic-sm') ?></button>
    </div>
    <div class="cat-subs">
      <?php foreach ($c['subs'] as $s): ?>
        <div class="sub-row">
          <span class="flex-grow-1"><strong><?= e($s['name']) ?></strong> <span class="form-text">/<?= e($c['slug']) ?>/<?= e($s['slug']) ?> · <?= (int) $s['product_count'] ?> products</span> <?= $s['is_active'] ? '' : '<span class="badge-a grey">Hidden</span>' ?></span>
          <input class="form-control sort-input" type="number" name="sub_order[<?= (int) $s['id'] ?>]" value="<?= (int) $s['sort_order'] ?>" aria-label="Order">
          <button type="button" class="btn-a sm light" data-bs-toggle="modal" data-bs-target="#subModal" data-fill-form="#subForm" data-title="Edit subcategory"
            data-values='<?= e(json_encode(['id' => $s['id'], 'category_id' => $s['category_id'], 'name' => $s['name'], 'slug' => $s['slug'], 'description' => $s['description'], 'sort_order' => $s['sort_order'], 'is_active' => $s['is_active']])) ?>'><?= icon('edit', 'ic-sm') ?></button>
          <button class="btn-a sm light" type="submit" form="stog<?= (int) $s['id'] ?>" data-no-loading><?= $s['is_active'] ? 'Hide' : 'Show' ?></button>
          <button class="btn-a sm danger" type="submit" form="sdel<?= (int) $s['id'] ?>" data-no-loading title="Delete"><?= icon('trash', 'ic-sm') ?></button>
        </div>
      <?php endforeach; ?>
      <?php if (!$c['subs']): ?><div class="sub-row form-text">No subcategories yet.</div><?php endif; ?>
    </div>
  </div>
  <?php endforeach; ?>
  <?php if ($categories): ?><button class="btn-a dark" type="submit"><?= icon('check', 'ic-sm') ?> Save display order</button><?php else: ?><div class="card-a empty"><?= icon('layers') ?><p>No categories yet.</p></div><?php endif; ?>
</form>

<?php foreach ($categories as $c): ?>
  <form id="ctog<?= (int) $c['id'] ?>" method="post" action="<?= e(url('admin/categories/' . $c['id'] . '/toggle')) ?>" hidden><?= csrf_field() ?></form>
  <form id="cdel<?= (int) $c['id'] ?>" method="post" action="<?= e(url('admin/categories/' . $c['id'] . '/delete')) ?>" data-confirm="Delete category “<?= e($c['name']) ?>”?" hidden><?= csrf_field() ?></form>
  <?php foreach ($c['subs'] as $s): ?>
    <form id="stog<?= (int) $s['id'] ?>" method="post" action="<?= e(url('admin/subcategories/' . $s['id'] . '/toggle')) ?>" hidden><?= csrf_field() ?></form>
    <form id="sdel<?= (int) $s['id'] ?>" method="post" action="<?= e(url('admin/subcategories/' . $s['id'] . '/delete')) ?>" data-confirm="Delete subcategory “<?= e($s['name']) ?>”?" hidden><?= csrf_field() ?></form>
  <?php endforeach; ?>
<?php endforeach; ?>

<div class="modal fade" id="catModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content">
  <form id="catForm" method="post" action="<?= e(url('admin/categories/save')) ?>" enctype="multipart/form-data">
    <div class="modal-header"><h5 class="modal-title">Category</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
    <div class="modal-body">
      <?= csrf_field() ?><input type="hidden" name="id" value="0" data-reset="0">
      <div class="row">
        <div class="col-md-7">
          <?= adm_input('name', 'Name', '', ['id' => 'cat_name', 'attrs' => ['required' => true, 'data-slug-source' => '#cat_slug']]) ?>
          <?= adm_input('slug', 'Slug', '', ['id' => 'cat_slug', 'prefix' => '/category/']) ?>
          <?= adm_input('tagline', 'Tagline', '', ['id' => 'cat_tagline', 'optional' => true]) ?>
          <?= adm_textarea('description', 'Description', '', ['id' => 'cat_desc', 'rows' => 3]) ?>
          <div class="row"><?= adm_input('meta_title', 'Meta title', '', ['id' => 'cat_mt', 'col' => 'col-md-6 mb-3']) ?><?= adm_input('sort_order', 'Display order', '0', ['type' => 'number', 'id' => 'cat_sort', 'col' => 'col-md-6 mb-3']) ?></div>
          <?= adm_textarea('meta_description', 'Meta description', '', ['id' => 'cat_md', 'rows' => 2]) ?>
        </div>
        <div class="col-md-5">
          <?= adm_image('image', 'Category image', null, ['preview_key' => 'image', 'help' => 'Portrait 4:5 works best.']) ?>
          <?= adm_switch('is_active', 'Active', true) ?>
          <?= adm_switch('is_featured', 'Show on homepage', true) ?>
        </div>
      </div>
    </div>
    <div class="modal-footer"><button type="button" class="btn-a light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-a">Save category</button></div>
  </form>
</div></div></div>

<div class="modal fade" id="subModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content">
  <form id="subForm" method="post" action="<?= e(url('admin/subcategories/save')) ?>">
    <div class="modal-header"><h5 class="modal-title">Subcategory</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
    <div class="modal-body">
      <?= csrf_field() ?><input type="hidden" name="id" value="0" data-reset="0">
      <?= adm_select('category_id', 'Parent category', array_column($categories, 'name', 'id'), '', ['id' => 'sub_cat', 'placeholder' => 'Choose category', 'attrs' => ['required' => true]]) ?>
      <?= adm_input('name', 'Name', '', ['id' => 'sub_name', 'attrs' => ['required' => true, 'data-slug-source' => '#sub_slug']]) ?>
      <?= adm_input('slug', 'Slug', '', ['id' => 'sub_slug']) ?>
      <?= adm_textarea('description', 'Description', '', ['id' => 'sub_desc', 'rows' => 2]) ?>
      <?= adm_input('sort_order', 'Display order', '0', ['type' => 'number', 'id' => 'sub_sort']) ?>
      <?= adm_switch('is_active', 'Active', true) ?>
    </div>
    <div class="modal-footer"><button type="button" class="btn-a light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-a">Save subcategory</button></div>
  </form>
</div></div></div>
