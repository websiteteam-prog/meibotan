<?php /** @var array $c @var array $orders @var array $addresses @var int $wishlist @var float $spent */ ?>
<?= adm_head(e($c['name']), 'Customer since ' . format_date($c['created_at'], 'd M Y') . ($c['last_login_at'] ? ' · last login ' . format_date($c['last_login_at'], 'd M Y, h:i A') : ''), adm_post_button('admin/customers/' . $c['id'] . '/toggle', $c['is_active'] ? 'Deactivate account' : 'Activate account', 'btn-a ' . ($c['is_active'] ? 'danger' : ''), $c['is_active'] ? 'Deactivate this account?' : null), ['Customers', 'admin/customers']) ?>
<div class="stat-grid">
  <div class="stat"><?= icon('bag') ?><span>Orders</span><strong><?= count($orders) ?></strong></div>
  <div class="stat"><?= icon('chart') ?><span>Total spent</span><strong><?= money($spent, false) ?></strong></div>
  <div class="stat"><?= icon('heart') ?><span>Wishlist items</span><strong><?= $wishlist ?></strong></div>
  <div class="stat"><?= icon('pin') ?><span>Addresses</span><strong><?= count($addresses) ?></strong></div>
</div>
<div class="form-grid">
  <div>
    <div class="card-a flush">
      <div class="card-title">Orders <a class="btn-a sm light" href="<?= e(url('admin/orders', ['customer' => $c['id']])) ?>">Open in orders</a></div>
      <div class="table-wrap"><table class="table-a">
        <thead><tr><th>Order</th><th>Date</th><th>Status</th><th>Payment</th><th class="num">Total</th></tr></thead>
        <tbody>
        <?php foreach ($orders as $o): ?><tr><td><a class="name" href="<?= e(url('admin/orders/' . $o['id'])) ?>">#<?= e($o['order_number']) ?></a></td><td><?= format_date($o['created_at']) ?></td><td><?= adm_badge($o['status']) ?></td><td><?= adm_badge($o['payment_status']) ?></td><td class="num"><?= money($o['total']) ?></td></tr><?php endforeach; ?>
        <?php if (!$orders): ?><tr><td colspan="5"><div class="empty"><p>No orders yet.</p></div></td></tr><?php endif; ?>
        </tbody>
      </table></div>
    </div>
    <div class="card-a">
      <h2>Saved addresses</h2>
      <div class="grid-2-eq">
        <?php foreach ($addresses as $a): ?>
          <div class="p-3 border rounded-3"><strong><?= e($a['label']) ?></strong><?= $a['is_default'] ? ' <span class="badge-a green">Default</span>' : '' ?><br><?= e($a['full_name']) ?>, <?= e($a['address_line1']) ?><?= $a['address_line2'] ? ', ' . e($a['address_line2']) : '' ?>, <?= e($a['city']) ?>, <?= e($a['state']) ?> <?= e($a['postal_code']) ?><br><?= e($a['phone']) ?></div>
        <?php endforeach; ?>
        <?php if (!$addresses): ?><p class="text-muted m-0">No saved addresses.</p><?php endif; ?>
      </div>
    </div>
  </div>
  <div class="sticky-col">
    <div class="card-a">
      <h2>Edit customer</h2>
      <form method="post" action="<?= e(url('admin/customers/' . $c['id'])) ?>">
        <?= csrf_field() ?>
        <?= adm_input('name', 'Name', $c['name'], ['attrs' => ['required' => true]]) ?>
        <?= adm_input('email', 'Email', $c['email'], ['type' => 'email', 'attrs' => ['required' => true]]) ?>
        <?= adm_input('phone', 'Phone', $c['phone']) ?>
        <?= adm_input('new_password', 'Set new password', '', ['type' => 'password', 'optional' => true, 'help' => 'Leave blank to keep the current password.', 'attrs' => ['autocomplete' => 'new-password']]) ?>
        <?= adm_switch('is_active', 'Account active', (bool) $c['is_active']) ?>
        <?= adm_switch('newsletter', 'Newsletter opt-in', (bool) $c['newsletter']) ?>
        <button class="btn-a w-100 mt-3" type="submit">Save changes</button>
      </form>
    </div>
  </div>
</div>
