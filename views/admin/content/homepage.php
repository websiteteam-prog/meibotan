<?php
/** @var array $sections @var array $benefits */
$icons = ['leaf' => 'Leaf', 'shield' => 'Shield', 'sparkle' => 'Sparkle', 'truck' => 'Truck', 'heart' => 'Heart', 'gift' => 'Gift', 'lock' => 'Lock', 'return' => 'Returns', 'star' => 'Star', 'cash' => 'Cash', 'check-circle' => 'Check'];
$benefitRow = static function ($k, array $b) use ($icons) {
    $opts = '';
    foreach ($icons as $v => $l) { $opts .= '<option value="' . $v . '"' . (($b['icon'] ?? '') === $v ? ' selected' : '') . '>' . $l . '</option>'; }
    return '<div class="repeater-row benefit-row" data-repeater-item><div><label>Icon</label><select class="form-select" name="benefits[' . $k . '][icon]">' . $opts . '</select></div>'
        . '<div><label>Title</label><input class="form-control" name="benefits[' . $k . '][title]" value="' . e($b['title'] ?? '') . '"></div>'
        . '<div><label>Text</label><input class="form-control" name="benefits[' . $k . '][text]" value="' . e($b['text'] ?? '') . '"></div>'
        . '<button type="button" class="btn-a sm danger" data-repeater-remove>' . icon('trash', 'ic-sm') . '</button></div>';
};
$notes = [
    'hero' => 'Slides are managed under Banners.', 'promos' => 'Banners are managed under Banners → Promotional.', 'collection' => 'Shows the collection marked “Feature on homepage”.',
    'categories' => 'Shows categories marked “Show on homepage”.', 'bestsellers' => 'Best-selling products with category tabs.', 'new_arrivals' => 'Newest products.',
    'trending' => 'Products marked Featured.', 'testimonials' => 'Managed under Testimonials.', 'instagram' => 'Managed under Instagram gallery.', 'benefits' => 'Edit the four benefits below.',
    'quote' => 'Title = first line, italic = second line.', 'marquee' => 'One phrase per line.', 'newsletter' => 'Subscribers appear under Newsletter.',
];
?>
<form method="post" action="<?= e(url('admin/homepage')) ?>">
<?= csrf_field() ?>
<?= adm_head('Homepage', 'Show, hide, reorder and rename every homepage section. Changes go live immediately.', '<a class="btn-a light" href="' . e(url('/')) . '" target="_blank" rel="noopener">' . icon('eye', 'ic-sm') . ' Preview</a><button class="btn-a" type="submit">' . icon('check', 'ic-sm') . ' Save homepage</button>') ?>
<div class="card-a flush"><div class="table-wrap"><table class="table-a">
  <thead><tr><th style="width:80px">Order</th><th style="width:70px">Visible</th><th>Section</th><th>Eyebrow</th><th>Title</th><th>Italic accent</th><th>Subtitle / options</th></tr></thead>
  <tbody>
  <?php foreach ($sections as $s): $k = 'sections[' . (int) $s['id'] . ']'; ?>
    <tr>
      <td><input class="form-control sort-input" type="number" name="<?= $k ?>[sort_order]" value="<?= (int) $s['sort_order'] ?>" aria-label="Order"></td>
      <td><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" name="<?= $k ?>[is_visible]" value="1" <?= $s['is_visible'] ? 'checked' : '' ?> aria-label="Visible"></div></td>
      <td><strong><?= e($s['name']) ?></strong><span class="sub" style="white-space:normal;max-width:220px"><?= e($notes[$s['section_key']] ?? '') ?></span></td>
      <?php if (in_array($s['section_key'], ['hero', 'promos', 'collection', 'benefits', 'marquee'], true)): ?>
        <td colspan="3" class="form-text"><?php if ($s['section_key'] === 'marquee'): ?><textarea class="form-control" rows="3" name="<?= $k ?>[items]" aria-label="Ticker phrases"><?= e(implode("\n", $s['settings']['items'] ?? [])) ?></textarea><?php else: ?>Content comes from its own module.<?php endif; ?></td>
        <td></td>
      <?php else: ?>
        <td><input class="form-control" name="<?= $k ?>[eyebrow]" value="<?= e($s['eyebrow'] ?? '') ?>" aria-label="Eyebrow"></td>
        <td><input class="form-control" name="<?= $k ?>[title]" value="<?= e($s['title'] ?? '') ?>" aria-label="Title"></td>
        <td><input class="form-control" name="<?= $k ?>[title_italic]" value="<?= e($s['title_italic'] ?? '') ?>" aria-label="Italic accent"></td>
        <td>
          <input class="form-control mb-1" name="<?= $k ?>[subtitle]" value="<?= e($s['subtitle'] ?? '') ?>" placeholder="Subtitle" aria-label="Subtitle">
          <?php if (isset($s['settings']['limit'])): ?><label class="form-text">Products shown <input class="form-control sort-input d-inline-block" type="number" min="1" max="24" name="<?= $k ?>[limit]" value="<?= (int) $s['settings']['limit'] ?>"></label><?php endif; ?>
        </td>
      <?php endif; ?>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table></div></div>

<div class="card-a" data-repeater>
  <h2>Brand benefits <small>The four promises shown in the benefits strip (also used on Our Story)</small></h2>
  <div data-repeater-list><?php foreach ($benefits as $i => $b): ?><?= $benefitRow($i, $b) ?><?php endforeach; ?></div>
  <template><?= $benefitRow('__INDEX__', []) ?></template>
  <button type="button" class="btn-a light" data-repeater-add><?= icon('plus', 'ic-sm') ?> Add benefit</button>
</div>
<button class="btn-a" type="submit"><?= icon('check', 'ic-sm') ?> Save homepage</button>
</form>
