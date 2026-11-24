<?php /** @var array $reviews @var string $status @var array $counts @var App\Core\Paginator $pager */ ?>
<?= adm_head('Reviews', 'Approve customer reviews before they appear on product pages (or enable auto-approval in Settings).') ?>
<div class="tabs-a">
  <?php foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'All'] as $k => $label): ?>
    <a class="<?= $status === $k ? 'active' : '' ?>" href="<?= e(url('admin/reviews', ['status' => $k])) ?>"><?= $label ?> <small><?= $k === 'all' ? array_sum($counts) : (int) ($counts[$k] ?? 0) ?></small></a>
  <?php endforeach; ?>
</div>
<div class="card-a flush"><div class="table-wrap"><table class="table-a">
  <thead><tr><th>Product</th><th>Review</th><th>Customer</th><th>Status</th><th class="actions">Actions</th></tr></thead>
  <tbody>
  <?php foreach ($reviews as $r): ?>
    <tr>
      <td style="width:220px"><div class="d-flex gap-2 align-items-center"><img class="thumb" src="<?= e(upload_url($r['image'], '300')) ?>" alt="" style="width:36px;height:44px"><a class="name" target="_blank" rel="noopener" href="<?= e(url('product/' . $r['slug'])) ?>"><?= e($r['product_name']) ?></a></div></td>
      <td><span style="color:var(--cherry)"><?= str_repeat('★', (int) $r['rating']) ?><?= str_repeat('☆', 5 - (int) $r['rating']) ?></span><?php if ($r['title']): ?> <strong><?= e($r['title']) ?></strong><?php endif; ?><span class="sub" style="white-space:normal;max-width:520px"><?= e($r['comment']) ?></span></td>
      <td><?= e($r['name']) ?><span class="sub"><?= format_date($r['created_at']) ?><?= $r['is_verified'] ? ' · Verified buyer' : '' ?></span></td>
      <td><?= adm_badge($r['status']) ?></td>
      <td class="actions">
        <?php if ($r['status'] !== 'approved'): ?><form method="post" action="<?= e(url('admin/reviews/' . $r['id'] . '/status')) ?>"><?= csrf_field() ?><input type="hidden" name="status" value="approved"><button class="btn-a sm" type="submit"><?= icon('check', 'ic-sm') ?> Approve</button></form><?php endif; ?>
        <?php if ($r['status'] !== 'rejected'): ?><form method="post" action="<?= e(url('admin/reviews/' . $r['id'] . '/status')) ?>"><?= csrf_field() ?><input type="hidden" name="status" value="rejected"><button class="btn-a sm light" type="submit">Reject</button></form><?php endif; ?>
        <?= adm_post_button('admin/reviews/' . $r['id'] . '/delete', icon('trash', 'ic-sm'), 'btn-a sm danger', 'Delete this review?', 'Delete') ?>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$reviews): ?><tr><td colspan="5"><div class="empty"><?= icon('star') ?><p>No reviews here.</p></div></td></tr><?php endif; ?>
  </tbody>
</table></div><?= adm_pager($pager, 'admin/reviews') ?></div>
