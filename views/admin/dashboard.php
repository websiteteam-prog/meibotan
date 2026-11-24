<?php
/** @var array $stats @var array $series @var array $recent @var array $best @var array $statusCounts @var array $lowStock @var int $threshold @var array $checklist @var int $unpaidStale */
$admin = admin_user();
$change = $stats['sales_last_month'] > 0 ? round(($stats['sales_month'] - $stats['sales_last_month']) / $stats['sales_last_month'] * 100) : null;
$max = max(1, max(array_column($series, 'total')));
$w = 760; $h = 230; $pad = 30; $bw = ($w - $pad) / count($series);
$niceMax = $max <= 1 ? 1000 : (float) (ceil($max / pow(10, floor(log10($max)))) * pow(10, floor(log10($max))));
$sum30 = array_sum(array_column($series, 'total'));
$orders30 = array_sum(array_column($series, 'count'));
?>
<?= adm_head('Good ' . (date('H') < 12 ? 'morning' : (date('H') < 17 ? 'afternoon' : 'evening')) . ', <em>' . e(explode(' ', $admin['name'])[0]) . '</em>', 'Here’s what’s happening at ' . setting('site_name') . ' today, ' . date('l, d F Y') . '.', '<a class="btn-a light" href="' . e(url('admin/orders')) . '">' . icon('bag', 'ic-sm') . ' View orders</a>' . (App\Core\AdminAuth::can('catalog') ? '<a class="btn-a" href="' . e(url('admin/products/create')) . '">' . icon('plus', 'ic-sm') . ' Add product</a>' : '')) ?>

<?php foreach ($checklist as [$msg, $link]): ?>
  <div class="alert-strip"><?= icon('alert') ?><span><?= e($msg) ?></span><a class="ms-auto btn-a sm light" href="<?= e(url($link)) ?>">Fix now</a></div>
<?php endforeach; ?>
<?php if ($unpaidStale): ?>
  <div class="alert-strip red"><?= icon('alert') ?><span><?= $unpaidStale ?> online order(s) have been awaiting payment for over 2 hours. Stock is reserved until they are cancelled (automatically via <code>bin/cron.php</code>).</span><a class="ms-auto btn-a sm light" href="<?= e(url('admin/orders', ['payment' => 'pending', 'method' => 'razorpay'])) ?>">Review</a></div>
<?php endif; ?>

<div class="stat-grid">
  <div class="stat hero"><?= icon('chart') ?><span>Total sales</span><strong><?= money($stats['sales'], false) ?></strong><small><?= money($stats['sales_month'], false) ?> this month<?php if ($change !== null): ?> · <?= $change >= 0 ? '▲' : '▼' ?> <?= abs($change) ?>% vs last month<?php endif; ?></small></div>
  <div class="stat"><?= icon('bag') ?><span>Total orders</span><strong><?= number_format($stats['orders']) ?></strong><small><?= $stats['orders_today'] ?> today · AOV <?= money($stats['aov'], false) ?></small></div>
  <div class="stat"><?= icon('users') ?><span>Customers</span><strong><?= number_format($stats['customers']) ?></strong><small class="up">+<?= $stats['customers_month'] ?> this month</small></div>
  <div class="stat"><?= icon('package') ?><span>Products</span><strong><?= number_format($stats['products']) ?></strong><small><?= $stats['products_active'] ?> active</small></div>
</div>
<div class="stat-grid">
  <a class="stat" href="<?= e(url('admin/orders', ['status' => 'pending'])) ?>" style="color:inherit"><?= icon('clock') ?><span>Pending orders</span><strong><?= $stats['pending'] ?></strong><small>Awaiting processing</small></a>
  <a class="stat" href="<?= e(url('admin/orders', ['status' => 'shipped'])) ?>" style="color:inherit"><?= icon('truck') ?><span>In transit</span><strong><?= $stats['shipped'] ?></strong><small>Shipped, not delivered</small></a>
  <a class="stat" href="<?= e(url('admin/orders', ['status' => 'delivered'])) ?>" style="color:inherit"><?= icon('check-circle') ?><span>Completed orders</span><strong><?= $stats['completed'] ?></strong><small>Delivered</small></a>
  <div class="stat"><?= icon('alert') ?><span>Low stock</span><strong><?= count($lowStock) ?></strong><small>At or below <?= $threshold ?> units</small></div>
</div>

<div class="grid-2">
  <div class="card-a">
    <div class="card-title">Sales overview <small>Last 30 days · <?= money($sum30, false) ?> from <?= $orders30 ?> orders</small></div>
    <svg class="chart" viewBox="0 0 <?= $w ?> <?= $h + 24 ?>" role="img" aria-label="Daily sales for the last 30 days">
      <?php for ($g = 0; $g <= 4; $g++): $y = $h - ($h - 10) * $g / 4; ?>
        <line class="grid" x1="<?= $pad ?>" x2="<?= $w ?>" y1="<?= $y ?>" y2="<?= $y ?>"/>
        <text x="0" y="<?= $y + 3 ?>"><?= $g === 0 ? '0' : e(number_format($niceMax * $g / 4 / 1000, 1)) . 'k' ?></text>
      <?php endfor; ?>
      <?php foreach ($series as $i => $d):
        $bh = $d['total'] > 0 ? max(3, ($h - 10) * $d['total'] / $niceMax) : 0;
        $x = $pad + $i * $bw + 3; ?>
        <rect class="bar" x="<?= round($x, 1) ?>" y="<?= round($h - $bh, 1) ?>" width="<?= round($bw - 6, 1) ?>" height="<?= round($bh, 1) ?>" rx="3"><title><?= e(date('d M', strtotime($d['date']))) ?>: <?= e(money($d['total'])) ?> (<?= $d['count'] ?> orders)</title></rect>
        <?php if ($i % 5 === 0 || $i === 29): ?><text x="<?= round($x + ($bw - 6) / 2, 1) ?>" y="<?= $h + 16 ?>" text-anchor="middle"><?= e(date('d M', strtotime($d['date']))) ?></text><?php endif; ?>
      <?php endforeach; ?>
    </svg>
  </div>
  <div class="card-a">
    <div class="card-title">Orders by status</div>
    <?php $totalOrders = max(1, array_sum($statusCounts)); foreach (App\Services\OrderService::STATUSES as $s): $c = (int) ($statusCounts[$s] ?? 0); ?>
      <div class="d-flex align-items-center gap-2 mb-2">
        <span style="width:96px"><?= adm_badge($s) ?></span>
        <div class="flex-grow-1" style="height:8px;background:#efede6;border-radius:99px;overflow:hidden"><div style="height:100%;width:<?= round($c / $totalOrders * 100) ?>%;background:var(--cherry)"></div></div>
        <strong style="width:34px;text-align:right"><?= $c ?></strong>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="grid-2">
  <div class="card-a flush">
    <div class="card-title">Recent orders <a class="btn-a sm light" href="<?= e(url('admin/orders')) ?>">View all</a></div>
    <div class="table-wrap">
      <table class="table-a">
        <thead><tr><th>Order</th><th>Customer</th><th>Status</th><th>Payment</th><th class="num">Total</th></tr></thead>
        <tbody>
        <?php foreach ($recent as $o): ?>
          <tr>
            <td><a class="name" href="<?= e(url('admin/orders/' . $o['id'])) ?>">#<?= e($o['order_number']) ?></a><span class="sub"><?= format_date($o['created_at'], 'd M, h:i A') ?></span></td>
            <td><?= e($o['customer_name']) ?><span class="sub"><?= e($o['customer_phone']) ?></span></td>
            <td><?= adm_badge($o['status']) ?></td>
            <td><?= adm_badge($o['payment_status']) ?><span class="sub"><?= $o['payment_method'] === 'cod' ? 'COD' : 'Razorpay' ?></span></td>
            <td class="num"><strong><?= money($o['total']) ?></strong></td>
          </tr>
        <?php endforeach; ?>
        <?php if (!$recent): ?><tr><td colspan="5"><div class="empty"><?= icon('bag') ?><p>No orders yet. They’ll appear here as soon as customers check out.</p></div></td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div>
    <div class="card-a">
      <div class="card-title">Best-selling products</div>
      <?php foreach ($best as $i => $b): ?>
        <div class="d-flex align-items-center gap-3 py-2 <?= $i ? 'border-top' : '' ?>">
          <img src="<?= e(upload_url($b['image'], '300')) ?>" alt="" width="40" height="50" style="object-fit:cover;border-radius:8px">
          <div class="flex-grow-1 min-w-0"><a class="fw-semibold text-dark" href="<?= e(url('admin/products/' . $b['id'] . '/edit')) ?>"><?= e($b['name']) ?></a><div class="form-text m-0"><?= e($b['sku']) ?></div></div>
          <div class="text-end"><strong><?= (int) $b['qty'] ?></strong><div class="form-text m-0">sold<?= $b['revenue'] !== null ? ' · ' . money($b['revenue'], false) : '' ?></div></div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="card-a">
      <div class="card-title">Low-stock alerts <a class="btn-a sm light" href="<?= e(url('admin/products', ['stock' => 'low'])) ?>">Manage</a></div>
      <?php if (!$lowStock): ?><p class="text-muted m-0">All products are well stocked.</p><?php endif; ?>
      <?php foreach ($lowStock as $l): ?>
        <div class="d-flex align-items-center gap-3 py-2 border-top">
          <img src="<?= e(upload_url($l['image'], '300')) ?>" alt="" width="36" height="45" style="object-fit:cover;border-radius:8px">
          <div class="flex-grow-1"><a class="text-dark fw-semibold" href="<?= e(url('admin/products/' . $l['id'] . '/edit')) ?>"><?= e($l['name']) ?></a><?php if ($l['variant']): ?><div class="form-text m-0"><?= e($l['variant']) ?></div><?php endif; ?></div>
          <span class="badge-a <?= (int) $l['qty'] <= 0 ? 'red' : 'amber' ?>"><?= (int) $l['qty'] <= 0 ? 'Out of stock' : (int) $l['qty'] . ' left' ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
