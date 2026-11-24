<?php /** @var array $banners */
$newHero = e(json_encode(['id' => 0, 'type' => 'hero', 'theme' => 'cotton', 'is_active' => 1, 'sort_order' => 0]));
$newPromo = e(json_encode(['id' => 0, 'type' => 'promo', 'theme' => 'cotton', 'is_active' => 1, 'sort_order' => 0]));
?>
<?= adm_head('Banners', 'Hero slides at the top of the homepage and the two promotional banners below the new arrivals.',
  '<button class="btn-a light" type="button" data-bs-toggle="modal" data-bs-target="#bannerModal" data-fill-form="#bannerForm" data-title="New promo banner" data-values="' . $newPromo . '">' . icon('plus', 'ic-sm') . ' Promo banner</button>'
  . '<button class="btn-a" type="button" data-bs-toggle="modal" data-bs-target="#bannerModal" data-fill-form="#bannerForm" data-title="New hero slide" data-values="' . $newHero . '">' . icon('plus', 'ic-sm') . ' Hero slide</button>') ?>
<?php foreach (['hero' => 'Hero slider', 'promo' => 'Promotional banners'] as $type => $label): $list = array_filter($banners, static fn($b) => $b['type'] === $type); ?>
<div class="card-a flush">
  <div class="card-title"><?= $label ?> <small><?= $type === 'hero' ? 'Three panels: left image · text · right image. Portrait images (about 9:10) work best.' : 'Landscape 3:2 image; text sits on the left half.' ?></small></div>
  <div class="table-wrap"><table class="table-a">
    <thead><tr><th>Banner</th><th>Buttons</th><th>Theme</th><th>Schedule</th><th>Order</th><th>Status</th><th class="actions"></th></tr></thead>
    <tbody>
    <?php foreach ($list as $b):
      $vals = $b; $vals['image'] = $b['image'] ? upload_url($b['image'], '300') : ''; $vals['image2'] = !empty($b['image2']) ? upload_url($b['image2'], '300') : ''; $vals['starts_at'] = $b['starts_at'] ? date('Y-m-d\TH:i', strtotime($b['starts_at'])) : ''; $vals['ends_at'] = $b['ends_at'] ? date('Y-m-d\TH:i', strtotime($b['ends_at'])) : ''; ?>
      <tr>
        <td><div class="d-flex gap-3 align-items-center"><img class="thumb" src="<?= e(upload_url($b['image'], '300')) ?>" alt="" style="width:<?= $type === 'hero' ? 46 : 80 ?>px"><?php if ($type === 'hero' && !empty($b['image2'])): ?><img class="thumb" src="<?= e(upload_url($b['image2'], '300')) ?>" alt="" style="width:46px"><?php endif; ?><div><span class="sub"><?= e($b['eyebrow'] ?? '') ?></span><strong><?= e($b['title']) ?> <em class="text-danger"><?= e($b['title_italic'] ?? '') ?></em></strong><span class="sub"><?= e(str_limit($b['subtitle'], 80)) ?></span></div></div></td>
        <td><?= e($b['button_text'] ?? '—') ?><span class="sub"><?= e($b['button_link'] ?? '') ?></span><?php if ($b['button2_text']): ?><span class="sub"><?= e($b['button2_text']) ?> → <?= e($b['button2_link']) ?></span><?php endif; ?></td>
        <td><span class="badge-a"><?= e(ucfirst($b['theme'])) ?></span></td>
        <td><span class="sub"><?= $b['starts_at'] ? 'From ' . format_date($b['starts_at']) : 'Always' ?><?= $b['ends_at'] ? ' until ' . format_date($b['ends_at']) : '' ?></span></td>
        <td><?= (int) $b['sort_order'] ?></td>
        <td><?= $b['is_active'] ? '<span class="badge-a green">Live</span>' : '<span class="badge-a grey">Hidden</span>' ?></td>
        <td class="actions"><button type="button" class="btn-a sm light" data-bs-toggle="modal" data-bs-target="#bannerModal" data-fill-form="#bannerForm" data-title="Edit banner" data-values='<?= e(json_encode($vals)) ?>'><?= icon('edit', 'ic-sm') ?> Edit</button> <?= adm_post_button('admin/banners/' . $b['id'] . '/delete', icon('trash', 'ic-sm'), 'btn-a sm danger', 'Delete this banner?', 'Delete') ?></td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$list): ?><tr><td colspan="7"><div class="empty"><p>No <?= $type ?> banners yet.</p></div></td></tr><?php endif; ?>
    </tbody>
  </table></div>
</div>
<?php endforeach; ?>

<div class="modal fade" id="bannerModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-xl modal-dialog-scrollable"><div class="modal-content">
  <form id="bannerForm" method="post" action="<?= e(url('admin/banners/save')) ?>" enctype="multipart/form-data">
    <div class="modal-header"><h5 class="modal-title">Banner</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
    <div class="modal-body">
      <?= csrf_field() ?><input type="hidden" name="id" value="0" data-reset="0">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <?= adm_select('type', 'Placement', ['hero' => 'Hero slider', 'promo' => 'Promotional banner'], 'hero', ['col' => 'col-md-4 mb-3']) ?>
            <?= adm_select('theme', 'Text panel colour', ['cotton' => 'Cotton (light)', 'noir' => 'Noir (dark)', 'cherry' => 'Cherry (red)'], 'cotton', ['col' => 'col-md-4 mb-3']) ?>
            <?= adm_input('sort_order', 'Order', '0', ['type' => 'number', 'col' => 'col-md-4 mb-3']) ?>
          </div>
          <?= adm_input('eyebrow', 'Eyebrow (small text above title)', '', ['optional' => true]) ?>
          <div class="row">
            <?= adm_input('title', 'Title', '', ['col' => 'col-md-7 mb-3', 'attrs' => ['required' => true]]) ?>
            <?= adm_input('title_italic', 'Italic accent', '', ['col' => 'col-md-5 mb-3', 'help' => 'Shown in italic after the title', 'optional' => true]) ?>
          </div>
          <?= adm_textarea('subtitle', 'Subtitle', '', ['rows' => 2]) ?>
          <div class="row">
            <?= adm_input('button_text', 'Button text', '', ['col' => 'col-md-6 mb-3']) ?>
            <?= adm_input('button_link', 'Button link', '', ['col' => 'col-md-6 mb-3', 'attrs' => ['placeholder' => '/shop or https://…']]) ?>
            <?= adm_input('button2_text', 'Second button text', '', ['col' => 'col-md-6 mb-3', 'optional' => true]) ?>
            <?= adm_input('button2_link', 'Second button link', '', ['col' => 'col-md-6 mb-3', 'optional' => true]) ?>
            <?= adm_input('starts_at', 'Show from', '', ['type' => 'datetime-local', 'col' => 'col-md-6 mb-3', 'optional' => true]) ?>
            <?= adm_input('ends_at', 'Show until', '', ['type' => 'datetime-local', 'col' => 'col-md-6 mb-3', 'optional' => true]) ?>
          </div>
        </div>
        <div class="col-lg-4">
          <?= adm_image('image', 'Image (hero: left panel)', null, ['preview_key' => 'image', 'small' => true]) ?>
          <?= adm_image('image2', 'Right panel image (hero only)', null, ['preview_key' => 'image2', 'small' => true]) ?>
          <?= adm_switch('is_active', 'Live on homepage', true) ?>
        </div>
      </div>
    </div>
    <div class="modal-footer"><button type="button" class="btn-a light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-a">Save banner</button></div>
  </form>
</div></div></div>
