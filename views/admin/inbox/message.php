<?php /** @var array $m */ ?>
<?= adm_head(e($m['subject'] ?: 'Message'), 'Received ' . format_date($m['created_at'], 'd M Y, h:i A'), '<a class="btn-a" href="mailto:' . e($m['email']) . '?subject=' . rawurlencode('Re: ' . ($m['subject'] ?: 'Your message')) . '">' . icon('mail', 'ic-sm') . ' Reply by e-mail</a>', ['Messages', 'admin/messages']) ?>
<div class="form-grid">
  <div class="card-a"><p style="white-space:pre-line;font-size:15px;line-height:1.7" class="m-0"><?= e($m['message']) ?></p></div>
  <div class="card-a"><dl class="kv"><dt>Name</dt><dd><?= e($m['name']) ?></dd><dt>Email</dt><dd><a href="mailto:<?= e($m['email']) ?>"><?= e($m['email']) ?></a></dd><dt>Phone</dt><dd><?= e($m['phone'] ?: '—') ?></dd><dt>IP</dt><dd><?= e($m['ip_address'] ?? '—') ?></dd></dl>
  <div class="mt-3"><?= adm_post_button('admin/messages/' . $m['id'] . '/delete', icon('trash', 'ic-sm') . ' Delete message', 'btn-a danger', 'Delete this message?') ?></div></div>
</div>
