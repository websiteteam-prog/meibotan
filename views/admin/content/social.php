<?php /** @var array $items */ ?>
<?= adm_head('Instagram gallery', 'Six square images shown in the “Rituals on Instagram” section. Each can link to its Instagram post.', '<button class="btn-a" type="button" data-bs-toggle="modal" data-bs-target="#sModal" data-fill-form="#sForm" data-title="Add image" data-values=\'{"id":"0","is_active":"1"}\'>' . icon('plus', 'ic-sm') . ' Add image</button>') ?>
<div class="gallery-grid" style="grid-template-columns:repeat(auto-fill,minmax(190px,1fr))">
  <?php foreach ($items as $s): $vals = $s; $vals['image'] = upload_url($s['image'], '300'); ?>
    <div class="card-a p-2 m-0">
      <img src="<?= e(upload_url($s['image'], '300')) ?>" alt="" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:10px">
      <div class="p-2"><div class="small text-truncate"><?= e($s['caption'] ?: '—') ?></div><div class="d-flex gap-1 mt-2 align-items-center"><?= $s['is_active'] ? '<span class="badge-a green">Visible</span>' : '<span class="badge-a grey">Hidden</span>' ?> <span class="form-text ms-1">#<?= (int) $s['sort_order'] ?></span>
        <button type="button" class="btn-a sm light ms-auto" data-bs-toggle="modal" data-bs-target="#sModal" data-fill-form="#sForm" data-title="Edit image" data-values='<?= e(json_encode($vals)) ?>'><?= icon('edit', 'ic-sm') ?></button><?= adm_post_button('admin/social/' . $s['id'] . '/delete', icon('trash', 'ic-sm'), 'btn-a sm danger', 'Delete this image?', 'Delete') ?></div></div>
    </div>
  <?php endforeach; ?>
</div>
<div class="modal fade" id="sModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content">
  <form id="sForm" method="post" action="<?= e(url('admin/social/save')) ?>" enctype="multipart/form-data">
    <div class="modal-header"><h5 class="modal-title">Gallery image</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
    <div class="modal-body"><?= csrf_field() ?><input type="hidden" name="id" value="0" data-reset="0">
      <?= adm_image('image', 'Square image', null, ['preview_key' => 'image']) ?>
      <?= adm_input('link', 'Post link', '', ['type' => 'url', 'optional' => true, 'attrs' => ['placeholder' => 'https://www.instagram.com/p/…']]) ?>
      <?= adm_input('caption', 'Caption / alt text', '') ?>
      <?= adm_input('sort_order', 'Order', '0', ['type' => 'number']) ?>
      <?= adm_switch('is_active', 'Visible', true) ?>
    </div>
    <div class="modal-footer"><button type="button" class="btn-a light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-a">Save</button></div>
  </form>
</div></div></div>
