<?php
require_once __DIR__ . '/includes/bootstrap.php';

http_response_code(404);
$page = [
    'title'       => 'Page Not Found | AF Prestige Roofing',
    'description' => 'Sorry, we could not find that page.',
    'path'        => CURRENT_PATH,
    'noindex'     => true,
];
include ROOT_PATH . '/includes/header.php';
?>

<section class="section section--paper">
  <div class="container message-page">
    <p class="big-404" aria-hidden="true">404</p>
    <h1>Page not found</h1>
    <p>Sorry, the page you're looking for has moved or doesn't exist. Try one of these instead:</p>
    <div class="hero__actions">
      <a class="btn btn--dark btn--lg" href="<?= e(url()) ?>">Home</a>
      <a class="btn btn--outline-dark btn--lg" href="<?= e(url('services')) ?>">Our services</a>
      <a class="btn btn--primary btn--lg" href="<?= e(url('free-quote')) ?>">Free quote</a>
    </div>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
