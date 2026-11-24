<?php /** @var array $pages */ ?>
<?= adm_head('Pages', 'About us, policies and other content pages.', '<a class="btn-a" href="' . e(url('admin/pages/create')) . '">' . icon('plus', 'ic-sm') . ' New page</a>') ?>
<div class="card-a flush"><div class="table-wrap"><table class="table-a">
  <thead><tr><th>Title</th><th>URL</th><th>Footer</th><th>Status</th><th>Updated</th><th class="actions"></th></tr></thead>
  <tbody>
  <?php foreach ($pages as $p): $path = $p['slug'] === 'about-us' ? 'about-us' : 'page/' . $p['slug']; ?>
    <tr>
      <td><a class="name" href="<?= e(url('admin/pages/' . $p['id'] . '/edit')) ?>"><?= e($p['title']) ?></a></td>
      <td><a href="<?= e(url($path)) ?>" target="_blank" rel="noopener">/<?= e($path) ?></a></td>
      <td><?= $p['show_in_footer'] ? 'Yes' : '—' ?></td>
      <td><?= $p['is_active'] ? '<span class="badge-a green">Published</span>' : '<span class="badge-a grey">Draft</span>' ?></td>
      <td><?= format_date($p['updated_at'] ?: $p['created_at']) ?></td>
      <td class="actions"><a class="btn-a sm light" href="<?= e(url('admin/pages/' . $p['id'] . '/edit')) ?>"><?= icon('edit', 'ic-sm') ?> Edit</a> <?php if ($p['slug'] !== 'about-us'): ?><?= adm_post_button('admin/pages/' . $p['id'] . '/delete', icon('trash', 'ic-sm'), 'btn-a sm danger', 'Delete this page?', 'Delete') ?><?php endif; ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table></div></div>
