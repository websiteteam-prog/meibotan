<?php
/** @var array $orders @var App\Core\Paginator $pager @var array $counts @var float $sum */
use App\Services\OrderService;
$status = (string) input('status', '');
$exportUrl = url('admin/orders/export', array_filter($_GET, static fn($k) => $k !== 'page', ARRAY_FILTER_USE_KEY));
?>
<?= adm_head('Orders', 'Search, filter and fulfil customer orders.', '<a class="btn-a light" href="' . e($exportUrl) . '">' . icon('download', 'ic-sm') . ' Export CSV</a>') ?>
<div class="tabs-a">
  <a class="<?= $status === '' ? 'active' : '' ?>" href="<?= e(query_url(['status' => null, 'page' => null])) ?>">All <small><?= array_sum($counts) ?></small></a>
  <?php foreach (OrderService::STATUSES as $s): ?><a class="<?= $status === $s ? 'active' : '' ?>" href="<?= e(query_url(['status' => $s, 'page' => null])) ?>"><?= e(status_label($s)) ?> <small><?= (int) ($counts[$s] ?? 0) ?></small></a><?php endforeach; ?>
</div>
<form class="filters" method="get">
  <input type="hidden" name="status" value="<?= e($status) ?>">
  <input class="form-control grow" type="search" name="q" value="<?= e(input('q')) ?>" placeholder="Order number, customer name, email or phone">
  <select class="form-select" name="payment" data-autosubmit><option value="">Any payment status</option><?php foreach (OrderService::PAYMENT_STATUSES as $p): ?><option value="<?= $p ?>" <?= input('payment') === $p ? 'selected' : '' ?>><?= e(status_label($p)) ?></option><?php endforeach; ?></select>
  <select class="form-select" name="method" data-autosubmit><option value="">Any method</option><option value="cod" <?= input('method') === 'cod' ? 'selected' : '' ?>>Cash on Delivery</option><option value="razorpay" <?= input('method') === 'razorpay' ? 'selected' : '' ?>>Razorpay</option></select>
  <input class="form-control" type="date" name="from" value="<?= e(input('from')) ?>" aria-label="From date">
  <input class="form-control" type="date" name="to" value="<?= e(input('to')) ?>" aria-label="To date">
  <button class="btn-a dark" type="submit"><?= icon('search', 'ic-sm') ?> Filter</button>
  <?php if ($_GET): ?><a class="btn-a ghost" href="<?= e(url('admin/orders')) ?>">Reset</a><?php endif; ?>
</form>
<div class="card-a flush">
  <div class="table-wrap"><table class="table-a">
    <thead><tr><th>Order</th><th>Date</th><th>Customer</th><th>Items</th><th>Payment</th><th>Status</th><th class="num">Total</th><th class="actions"></th></tr></thead>
    <tbody>
    <?php foreach ($orders as $o): ?>
      <tr>
        <td><a class="name" href="<?= e(url('admin/orders/' . $o['id'])) ?>">#<?= e($o['order_number']) ?></a></td>
        <td><?= format_date($o['created_at'], 'd M Y') ?><span class="sub"><?= format_date($o['created_at'], 'h:i A') ?></span></td>
        <td><?= e($o['customer_name']) ?><span class="sub"><?= e($o['customer_email']) ?> · <?= e($o['customer_phone']) ?></span></td>
        <td><?= (int) $o['qty'] ?></td>
        <td><?= adm_badge($o['payment_status']) ?><span class="sub"><?= $o['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Razorpay' ?></span></td>
        <td><?= adm_badge($o['status']) ?></td>
        <td class="num"><strong><?= money($o['total']) ?></strong></td>
        <td class="actions"><a class="btn-a sm light" href="<?= e(url('admin/orders/' . $o['id'])) ?>">View</a> <a class="btn-a sm light" href="<?= e(url('admin/orders/' . $o['id'] . '/invoice')) ?>" title="Invoice"><?= icon('printer', 'ic-sm') ?></a></td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$orders): ?><tr><td colspan="8"><div class="empty"><?= icon('bag') ?><p>No orders found.</p></div></td></tr><?php endif; ?>
    </tbody>
  </table></div>
  <div class="d-flex justify-content-end px-3 pt-2 form-text">Total of filtered orders: <strong class="ms-1"><?= money($sum) ?></strong></div>
  <?= adm_pager($pager, 'admin/orders') ?>
</div>
