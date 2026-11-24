<?php /** @var array $customers @var App\Core\Paginator $pager */ ?>
<?= adm_head('Customers', 'Registered customer accounts.', '<a class="btn-a light" href="' . e(url('admin/customers/export', array_filter($_GET, static fn($k) => $k !== 'page', ARRAY_FILTER_USE_KEY))) . '">' . icon('download', 'ic-sm') . ' Export CSV</a>') ?>
<form class="filters" method="get">
  <input class="form-control grow" type="search" name="q" value="<?= e(input('q')) ?>" placeholder="Search name, email or phone">
  <select class="form-select" name="status" data-autosubmit><option value="">All accounts</option><option value="active" <?= input('status') === 'active' ? 'selected' : '' ?>>Active</option><option value="inactive" <?= input('status') === 'inactive' ? 'selected' : '' ?>>Deactivated</option></select>
  <select class="form-select" name="sort" data-autosubmit><option value="">Newest</option><option value="spent" <?= input('sort') === 'spent' ? 'selected' : '' ?>>Top spenders</option><option value="orders" <?= input('sort') === 'orders' ? 'selected' : '' ?>>Most orders</option><option value="name" <?= input('sort') === 'name' ? 'selected' : '' ?>>Name</option></select>
  <label class="form-check m-0"><input class="form-check-input" type="checkbox" name="newsletter" value="1" <?= input('newsletter') ? 'checked' : '' ?> data-autosubmit> Subscribed</label>
  <button class="btn-a dark" type="submit"><?= icon('search', 'ic-sm') ?> Search</button>
</form>
<div class="card-a flush"><div class="table-wrap"><table class="table-a">
  <thead><tr><th>Customer</th><th>Phone</th><th class="num">Orders</th><th class="num">Spent</th><th>Last order</th><th>Joined</th><th>Status</th><th class="actions"></th></tr></thead>
  <tbody>
  <?php foreach ($customers as $c): ?>
    <tr>
      <td><a class="name" href="<?= e(url('admin/customers/' . $c['id'])) ?>"><?= e($c['name']) ?></a><span class="sub"><?= e($c['email']) ?></span></td>
      <td><?= e($c['phone'] ?: '—') ?></td>
      <td class="num"><?= (int) $c['order_count'] ?></td>
      <td class="num"><?= money($c['spent']) ?></td>
      <td><?= $c['last_order'] ? format_date($c['last_order']) : '—' ?></td>
      <td><?= format_date($c['created_at']) ?></td>
      <td><?= $c['is_active'] ? '<span class="badge-a green">Active</span>' : '<span class="badge-a red">Deactivated</span>' ?></td>
      <td class="actions"><a class="btn-a sm light" href="<?= e(url('admin/customers/' . $c['id'])) ?>">View</a> <?= adm_post_button('admin/customers/' . $c['id'] . '/toggle', $c['is_active'] ? 'Deactivate' : 'Activate', 'btn-a sm ' . ($c['is_active'] ? 'danger' : 'light'), $c['is_active'] ? 'Deactivate this account? The customer will not be able to log in.' : null) ?></td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$customers): ?><tr><td colspan="8"><div class="empty"><?= icon('users') ?><p>No customers found.</p></div></td></tr><?php endif; ?>
  </tbody>
</table></div><?= adm_pager($pager, 'admin/customers') ?></div>
