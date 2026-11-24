<?php /** @var array $items */ ?>
<?= adm_head('Testimonials', 'Customer quotes shown in the “Notes of amour” section on the homepage.', '<button class="btn-a" type="button" data-bs-toggle="modal" data-bs-target="#tModal" data-fill-form="#tForm" data-title="New testimonial" data-values=\'{"id":"0","rating":"5","is_active":"1"}\'>' . icon('plus', 'ic-sm') . ' New testimonial</button>') ?>
<div class="alert-strip"><?= icon('alert') ?><span>Only publish genuine customer feedback you have permission to use. The starter quotes are samples — replace them before launch.</span></div>
<div class="card-a flush"><div class="table-wrap"><table class="table-a">
  <thead><tr><th>Customer</th><th>Quote</th><th>Rating</th><th>Order</th><th>Status</th><th class="actions"></th></tr></thead>
  <tbody>
  <?php foreach ($items as $t): $vals = $t; $vals['avatar'] = $t['avatar'] ? upload_url($t['avatar'], '300') : ''; ?>
    <tr>
      <td><strong><?= e($t['name']) ?></strong><span class="sub"><?= e($t['location'] ?? '') ?></span></td>
      <td style="white-space:normal;max-width:480px"><?= e(str_limit($t['content'], 160)) ?><span class="sub"><?= e($t['product_name'] ?? '') ?></span></td>
      <td style="color:var(--cherry)"><?= str_repeat('★', (int) $t['rating']) ?></td>
      <td><?= (int) $t['sort_order'] ?></td>
      <td><?= $t['is_active'] ? '<span class="badge-a green">Visible</span>' : '<span class="badge-a grey">Hidden</span>' ?></td>
      <td class="actions"><button type="button" class="btn-a sm light" data-bs-toggle="modal" data-bs-target="#tModal" data-fill-form="#tForm" data-title="Edit testimonial" data-values='<?= e(json_encode($vals)) ?>'><?= icon('edit', 'ic-sm') ?></button> <?= adm_post_button('admin/testimonials/' . $t['id'] . '/delete', icon('trash', 'ic-sm'), 'btn-a sm danger', 'Delete this testimonial?', 'Delete') ?></td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$items): ?><tr><td colspan="6"><div class="empty"><p>No testimonials yet.</p></div></td></tr><?php endif; ?>
  </tbody>
</table></div></div>
<div class="modal fade" id="tModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content">
  <form id="tForm" method="post" action="<?= e(url('admin/testimonials/save')) ?>" enctype="multipart/form-data">
    <div class="modal-header"><h5 class="modal-title">Testimonial</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
    <div class="modal-body"><?= csrf_field() ?><input type="hidden" name="id" value="0" data-reset="0">
      <div class="row">
        <div class="col-md-8">
          <div class="row"><?= adm_input('name', 'Name', '', ['col' => 'col-md-6 mb-3', 'attrs' => ['required' => true]]) ?><?= adm_input('location', 'City', '', ['col' => 'col-md-6 mb-3']) ?></div>
          <?= adm_textarea('content', 'Quote', '', ['rows' => 4, 'attrs' => ['required' => true, 'maxlength' => 1000]]) ?>
          <div class="row"><?= adm_input('product_name', 'Product (optional)', '', ['col' => 'col-md-6 mb-3']) ?><?= adm_select('rating', 'Rating', [5 => '5 stars', 4 => '4 stars', 3 => '3 stars', 2 => '2 stars', 1 => '1 star'], 5, ['col' => 'col-md-3 mb-3']) ?><?= adm_input('sort_order', 'Order', '0', ['type' => 'number', 'col' => 'col-md-3 mb-3']) ?></div>
        </div>
        <div class="col-md-4"><?= adm_image('avatar', 'Photo (optional)', null, ['preview_key' => 'avatar', 'small' => true]) ?><?= adm_switch('is_active', 'Visible', true) ?></div>
      </div>
    </div>
    <div class="modal-footer"><button type="button" class="btn-a light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-a">Save</button></div>
  </form>
</div></div></div>
