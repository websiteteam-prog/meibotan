<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Thank You | AF Prestige Roofing',
    'description' => 'Thanks for your enquiry. We will be in touch soon to arrange your free roof inspection.',
    'path'        => 'thank-you',
    'noindex'     => true,
    'hide_cta'    => true,
];
include ROOT_PATH . '/includes/header.php';
?>

<section class="section section--paper">
  <div class="container message-page">
    <span class="message-page__icon"><?= icon('check') ?></span>
    <h1>Thank you!</h1>
    <p>Your quote request has been sent. We'll be in touch soon to arrange your free roof inspection.</p>
    <p>Need us sooner? Call <a href="<?= e(phone_href()) ?>"><strong><?= e(config('phone')) ?></strong></a>.</p>
    <div class="hero__actions">
      <a class="btn btn--dark btn--lg" href="<?= e(url('gallery')) ?>">See our work <?= icon('arrow-right', 'icon-shift') ?></a>
      <a class="btn btn--outline-dark btn--lg" href="<?= e(url()) ?>">Back to home</a>
    </div>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
