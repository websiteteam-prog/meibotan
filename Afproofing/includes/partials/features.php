<?php
/** "Why choose us" feature cards. Vars: $light (bool) for use on light backgrounds. */
defined('ROOT_PATH') || exit;
$items = [
    ['award', 'Quality Workmanship', "We do every job properly the first time, using proven methods and quality products that stand up to Adelaide's climate."],
    ['eye', 'Attention to Detail', 'Straight ridge lines, neat pointing, even coats and a spotless site. The small details are what make a restoration look premium.'],
    ['calendar', 'Reliable Service', "We turn up when we say we will, keep you informed at every step and work to the agreed schedule, weather permitting."],
    ['thumbs-up', 'Customer Satisfaction', "Your satisfaction is our priority. We walk you through the finished job and make sure you're completely happy before we call it done."],
    ['tag', 'Free, Honest Quotes', "Clear, itemised quotes with no hidden extras and no pressure. We only recommend the work your roof actually needs."],
    ['pin', 'Local Adelaide Business', 'We live and work here. We know Adelaide homes and conditions, and our reputation in the local community matters to us.'],
];
?>
<div class="features<?= !empty($light) ? ' features--light' : '' ?>">
  <?php foreach ($items as [$iconName, $title, $text]): ?>
    <div class="feature" data-reveal>
      <span class="feature__icon"><?= icon($iconName) ?></span>
      <h3><?= e($title) ?></h3>
      <p><?= e($text) ?></p>
    </div>
  <?php endforeach; ?>
</div>
