<?php /** @var array $collections */ ?>
<?= adm_head('Collections', 'Curated edits like “The Bridal Edit”. One collection can be featured on the homepage.', '<a class="btn-a" href="' . e(url('admin/collections/create')) . '">' . icon('plus', 'ic-sm') . ' New collection</a>') ?>
<div class="card-a flush"><div class="table-wrap"><table class="table-a">
  <thead><tr><th>Collection</th><th>Products</th><th>Homepage</th><th>Status</th><th class="actions">Actions</th></tr></thead>
  <tbody>
  <?php foreach ($collections as $c): ?>
    <tr>
      <td><div class="d-flex gap-3 align-items-center"><img class="thumb" src="<?= e(upload_url($c['image'], '300')) ?>" alt=""><div><a class="name" href="<?= e(url('admin/collections/' . $c['id'] . '/edit')) ?>"><?= e($c['name']) ?></a><span class="sub">/collection/<?= e($c['slug']) ?></span></div></div></td>
      <td><?= (int) $c['product_count'] ?></td>
      <td><?= $c['show_on_home'] ? '<span class="badge-a purple">Featured</span>' : '—' ?></td>
      <td><?= $c['is_active'] ? '<span class="badge-a green">Active</span>' : '<span class="badge-a grey">Hidden</span>' ?></td>
      <td class="actions"><a class="btn-a sm light" href="<?= e(url('admin/collections/' . $c['id'] . '/edit')) ?>"><?= icon('edit', 'ic-sm') ?> Edit</a> <a class="btn-a sm light" target="_blank" rel="noopener" href="<?= e(url('collection/' . $c['slug'])) ?>"><?= icon('eye', 'ic-sm') ?></a> <?= adm_post_button('admin/collections/' . $c['id'] . '/delete', icon('trash', 'ic-sm'), 'btn-a sm danger', 'Delete this collection?', 'Delete') ?></td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$collections): ?><tr><td colspan="5"><div class="empty"><?= icon('sparkle') ?><p>No collections yet.</p></div></td></tr><?php endif; ?>
  </tbody>
</table></div></div>
