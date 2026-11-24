<?php /** @var array $messages @var App\Core\Paginator $pager */ ?>
<?= adm_head('Messages', 'Enquiries sent through the contact form.') ?>
<div class="card-a flush"><div class="table-wrap"><table class="table-a">
  <thead><tr><th>From</th><th>Subject</th><th>Received</th><th class="actions"></th></tr></thead>
  <tbody>
  <?php foreach ($messages as $m): ?>
    <tr>
      <td><a class="name" href="<?= e(url('admin/messages/' . $m['id'])) ?>"><?= $m['is_read'] ? '' : '<span class="dot" style="color:var(--cherry)"></span> ' ?><?= e($m['name']) ?></a><span class="sub"><?= e($m['email']) ?></span></td>
      <td><?= $m['is_read'] ? e($m['subject'] ?? '—') : '<strong>' . e($m['subject'] ?? '—') . '</strong>' ?><span class="sub" style="white-space:normal;max-width:520px"><?= e(str_limit($m['message'], 110)) ?></span></td>
      <td><?= format_date($m['created_at'], 'd M Y, h:i A') ?></td>
      <td class="actions"><a class="btn-a sm light" href="<?= e(url('admin/messages/' . $m['id'])) ?>">Open</a> <?= adm_post_button('admin/messages/' . $m['id'] . '/delete', icon('trash', 'ic-sm'), 'btn-a sm danger', 'Delete this message?', 'Delete') ?></td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$messages): ?><tr><td colspan="4"><div class="empty"><?= icon('mail') ?><p>No messages yet.</p></div></td></tr><?php endif; ?>
  </tbody>
</table></div><?= adm_pager($pager, 'admin/messages') ?></div>
