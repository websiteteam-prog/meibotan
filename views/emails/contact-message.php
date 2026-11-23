<?php /** @var array $m */ ?>
<h1 style="font-family:Georgia,serif;font-weight:normal;font-size:26px;margin:0 0 12px">New contact message</h1>
<p><strong><?= e($m['name']) ?></strong> &lt;<?= e($m['email']) ?>&gt;<?= $m['phone'] ? ' · ' . e($m['phone']) : '' ?><br>Subject: <?= e($m['subject'] ?? '—') ?></p>
<p style="background:#EDEBDD;padding:14px 18px;border-radius:10px;white-space:pre-line"><?= e($m['message']) ?></p>
