<?php /** @var array $subscribers @var App\Core\Paginator $pager @var int $active_count */ ?>
<?= adm_head('Newsletter', $active_count . ' active subscribers. Export the list to import into your e-mail marketing tool.', '<a class="btn-a light" href="' . e(url('admin/newsletter/export')) . '">' . icon('download', 'ic-sm') . ' Export CSV</a>') ?>
<form class="filters" method="get"><input class="form-control grow" type="search" name="q" value="<?= e(input('q')) ?>" placeholder="Search e-mail"><button class="btn-a dark" type="submit">Search</button></form>
<div class="card-a flush"><div class="table-wrap"><table class="table-a">
  <thead><tr><th>E-mail</th><th>Status</th><th>Subscribed</th><th class="actions"></th></tr></thead>
  <tbody>
  <?php foreach ($subscribers as $s): ?>
    <tr><td><?= e($s['email']) ?></td><td><?= adm_badge($s['status']) ?></td><td><?= format_date($s['created_at'], 'd M Y, h:i A') ?></td><td class="actions"><?= adm_post_button('admin/newsletter/' . $s['id'] . '/delete', icon('trash', 'ic-sm'), 'btn-a sm danger', 'Remove this subscriber?', 'Remove') ?></td></tr>
  <?php endforeach; ?>
  <?php if (!$subscribers): ?><tr><td colspan="4"><div class="empty"><p>No subscribers yet.</p></div></td></tr><?php endif; ?>
  </tbody>
</table></div><?= adm_pager($pager, 'admin/newsletter') ?></div>
