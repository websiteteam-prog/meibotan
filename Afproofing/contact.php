<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Contact Us | AF Prestige Roofing Adelaide',
    'description' => 'Contact AF Prestige Roofing for a free roof restoration quote in Adelaide. Call ' . config('phone') . ', email us or send an enquiry online.',
    'path'        => 'contact',
    'schema'      => [
        breadcrumb_schema([['Contact', 'contact']]),
        ['@type' => 'ContactPage', 'url' => absolute_url('contact'), 'name' => 'Contact AF Prestige Roofing', 'about' => ['@id' => absolute_url('#business')]],
    ],
];
include ROOT_PATH . '/includes/header.php';

partial('page-hero', [
    'title'   => 'Contact Us',
    'lead'    => "Have a question or ready for your free roof restoration quote? Call, email or send us a message and we'll be in touch.",
    'eyebrow' => 'Get in touch',
    'crumbs'  => [['Contact', 'contact']],
    'actions' => false,
]);
?>

<section class="section section--paper">
  <div class="container contact-grid">
    <ul class="contact-list">
      <li class="contact-item">
        <span class="contact-item__icon"><?= icon('phone') ?></span>
        <div><h2>Phone</h2><a href="<?= e(phone_href()) ?>"><?= e(config('phone')) ?></a><p>The fastest way to reach us.</p></div>
      </li>
      <li class="contact-item">
        <span class="contact-item__icon"><?= icon('mail') ?></span>
        <div><h2>Email</h2><a href="<?= e(email_href()) ?>"><?= e(config('email')) ?></a><p>Photos of your roof are always welcome.</p></div>
      </li>
      <li class="contact-item">
        <span class="contact-item__icon"><?= icon('pin') ?></span>
        <div><h2>Service area</h2><strong>Adelaide &amp; surrounding suburbs</strong><p>North, south, east, west, inner Adelaide and the Adelaide Hills. <a class="plain-link" href="<?= e(url('service-areas')) ?>">See all areas</a></p></div>
      </li>
      <li class="contact-item">
        <span class="contact-item__icon"><?= icon('clock') ?></span>
        <div>
          <h2>Hours</h2>
          <ul class="hours-list">
            <?php foreach (config('hours', []) as $row): ?>
              <li><span><?= e($row['label']) ?></span><strong><?= e(format_hours($row['open'], $row['close'])) ?></strong></li>
            <?php endforeach; ?>
          </ul>
          <?php if (config('hours_note')): ?><p><?= e(config('hours_note')) ?></p><?php endif; ?>
        </div>
      </li>
    </ul>

    <div class="form-panel" id="enquiry">
      <p class="eyebrow">Free quote</p>
      <h2>Send us an enquiry</h2>
      <p>Fill in the form and we'll get back to you to arrange your free, no-obligation roof inspection and quote.</p>
      <?php partial('quote-form', ['id' => 'contact', 'variant' => 'full', 'button' => 'Send My Enquiry']); ?>
    </div>
  </div>
</section>

<section class="section section--tight">
  <div class="container">
    <div class="map-embed map-embed--wide">
      <iframe src="https://www.google.com/maps?q=Adelaide%20SA&amp;z=9&amp;output=embed" title="Map of Adelaide, our service area" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
