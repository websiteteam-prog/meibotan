<?php
/** "Why choose us" feature cards. Vars: $light (bool) for light backgrounds, $center (bool) for centred icon cards. */
defined('ROOT_PATH') || exit;
$items = [
    ['users', 'Experienced Roofing Specialists', 'Over 20 years of combined experience in tile roof repairs and restorations across Adelaide.'],
    ['award', 'Quality Workmanship Guaranteed', 'Every roof repair and restoration is backed by our 10-year written workmanship warranty.'],
    ['thumbs-up', 'Honest Customer Service', 'Straight answers, clear communication and only the work your roof actually needs.'],
    ['shield', 'Licensed & Insured Roofers', 'Fully qualified and insured, so your home and property are protected from the moment we arrive.'],
    ['tag', 'Fixed, Competitive Pricing', 'Transparent fixed-price quotes with no hidden extras, and 20% off your quote when you book today.'],
    ['pin', 'Local Adelaide Team', 'Locally owned and operated, servicing all of Adelaide and regional areas within ' . config('service_radius_km') . 'km.'],
];
$classes = 'features' . (!empty($light) ? ' features--light' : '') . (!empty($center) ? ' features--center' : '');
?>
<div class="<?= $classes ?>">
  <?php foreach ($items as [$iconName, $title, $text]): ?>
    <div class="feature" data-reveal>
      <span class="feature__icon"><?= icon($iconName) ?></span>
      <h3><?= e($title) ?></h3>
      <p><?= e($text) ?></p>
    </div>
  <?php endforeach; ?>
</div>
