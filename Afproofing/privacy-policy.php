<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Privacy Policy | AF Prestige Roofing',
    'description' => 'How AF Prestige Roofing collects, uses and protects your personal information.',
    'path'        => 'privacy-policy',
    'schema'      => [breadcrumb_schema([['Privacy Policy', 'privacy-policy']])],
];
include ROOT_PATH . '/includes/header.php';

partial('page-hero', [
    'title'   => 'Privacy Policy',
    'crumbs'  => [['Privacy Policy', 'privacy-policy']],
    'actions' => false,
]);
?>

<section class="section">
  <div class="container container--narrow prose">
    <p class="lead-text"><?= e(config('site_name')) ?> respects your privacy. This policy explains what personal information we collect through this website and how we use it.</p>

    <h2>Information we collect</h2>
    <p>When you send an enquiry or request a quote, we collect the details you provide, such as your name, phone number, email address, suburb and information about your roof. Our website may also collect anonymous usage data (for example, pages visited) to help us improve the site.</p>

    <h2>How we use your information</h2>
    <ul>
      <li>To respond to your enquiry and arrange a roof inspection</li>
      <li>To prepare and send your quote</li>
      <li>To carry out and follow up on work you engage us for</li>
    </ul>
    <p>We do not sell, rent or trade your personal information. We only share it where needed to deliver our services or where required by law.</p>

    <h2>Storage and security</h2>
    <p>We take reasonable steps to protect your information from misuse, loss and unauthorised access. Enquiries are delivered to us by email and a backup copy may be kept securely on our web server.</p>

    <h2>Access and corrections</h2>
    <p>You can ask to see or correct the personal information we hold about you, or ask us to delete it, at any time by contacting us.</p>

    <h2>Contact us</h2>
    <p>If you have any questions about this policy or how we handle your information, please email <a href="<?= e(email_href()) ?>"><?= e(config('email')) ?></a> or call <a href="<?= e(phone_href()) ?>"><?= e(config('phone')) ?></a>.</p>

    <p class="text-muted">Last updated: <?= date('F Y', filemtime(__FILE__)) ?></p>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
