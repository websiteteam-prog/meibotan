<?php /** @var array $admins */ use App\Core\AdminAuth; ?>
<?= adm_head('Admin users', 'Give your team access with the right role.', '<button class="btn-a" type="button" data-bs-toggle="modal" data-bs-target="#aModal" data-fill-form="#aForm" data-title="New admin user" data-values=\'{"id":"0","role":"manager","is_active":"1"}\'>' . icon('plus', 'ic-sm') . ' Add user</button>') ?>
<div class="grid-2">
  <div class="card-a flush"><div class="table-wrap"><table class="table-a">
    <thead><tr><th>User</th><th>Role</th><th>Last login</th><th>Status</th><th class="actions"></th></tr></thead>
    <tbody>
    <?php foreach ($admins as $a): ?>
      <tr>
        <td><strong><?= e($a['name']) ?></strong><span class="sub"><?= e($a['email']) ?></span></td>
        <td><span class="badge-a <?= $a['role'] === 'super_admin' ? 'purple' : ($a['role'] === 'manager' ? 'blue' : '') ?>"><?= e(AdminAuth::ROLE_LABELS[$a['role']] ?? $a['role']) ?></span></td>
        <td><?= $a['last_login_at'] ? format_date($a['last_login_at'], 'd M Y, h:i A') : 'Never' ?></td>
        <td><?= $a['is_active'] ? '<span class="badge-a green">Active</span>' : '<span class="badge-a grey">Disabled</span>' ?></td>
        <td class="actions"><button type="button" class="btn-a sm light" data-bs-toggle="modal" data-bs-target="#aModal" data-fill-form="#aForm" data-title="Edit admin user" data-values='<?= e(json_encode(['id' => $a['id'], 'name' => $a['name'], 'email' => $a['email'], 'phone' => $a['phone'], 'role' => $a['role'], 'is_active' => $a['is_active']])) ?>'><?= icon('edit', 'ic-sm') ?></button>
          <?php if ((int) $a['id'] !== (int) admin_user()['id']): ?><?= adm_post_button('admin/admins/' . $a['id'] . '/delete', icon('trash', 'ic-sm'), 'btn-a sm danger', 'Delete this admin user?', 'Delete') ?><?php endif; ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table></div></div>
  <div class="card-a">
    <h2>Roles &amp; permissions</h2>
    <p class="mb-2"><strong>Super Admin</strong> — full access, including settings and admin users.</p>
    <p class="mb-2"><strong>Store Manager</strong> — products, categories, orders, customers, coupons, content, reviews and messages.</p>
    <p class="mb-0"><strong>Customer Support</strong> — orders, customers, reviews and messages.</p>
  </div>
</div>
<div class="modal fade" id="aModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content">
  <form id="aForm" method="post" action="<?= e(url('admin/admins/save')) ?>">
    <div class="modal-header"><h5 class="modal-title">Admin user</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
    <div class="modal-body"><?= csrf_field() ?><input type="hidden" name="id" value="0" data-reset="0">
      <?= adm_input('name', 'Name', '', ['attrs' => ['required' => true]]) ?>
      <?= adm_input('email', 'Email', '', ['type' => 'email', 'attrs' => ['required' => true]]) ?>
      <?= adm_input('phone', 'Phone', '', ['optional' => true]) ?>
      <?= adm_select('role', 'Role', AdminAuth::ROLE_LABELS, 'manager') ?>
      <?= adm_input('password', 'Password', '', ['type' => 'password', 'help' => 'Required for new users. Leave blank to keep the current password.', 'attrs' => ['autocomplete' => 'new-password']]) ?>
      <?= adm_switch('is_active', 'Active', true) ?>
    </div>
    <div class="modal-footer"><button type="button" class="btn-a light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-a">Save user</button></div>
  </form>
</div></div></div>
