<?php
/** @var array $s */
$items = $s['settings']['items'] ?? [];
if (!$items) { return; }
$row = '';
foreach ($items as $it) { $row .= '<span class="marquee-item">' . e($it) . ' ' . icon('sparkle') . '</span>'; }
?>
<div class="marquee" aria-hidden="true"><div class="marquee-track"><?= str_repeat($row, 3) ?><?= str_repeat($row, 3) ?></div></div>
