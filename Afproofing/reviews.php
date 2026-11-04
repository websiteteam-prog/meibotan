<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Customer Reviews | AF Prestige Roofing Adelaide',
    'description' => 'Read what Adelaide homeowners say about AF Prestige Roofing: roof restorations, roof painting, cleaning, ridge capping and repairs.',
    'path'        => 'reviews',
    'schema'      => [breadcrumb_schema([['Reviews', 'reviews']])],
];
include ROOT_PATH . '/includes/header.php';

partial('page-hero', [
    'title'   => 'Customer Reviews',
    'lead'    => 'Our reputation is built one roof at a time. Here is what our customers say about working with us.',
    'eyebrow' => 'Testimonials',
    'crumbs'  => [['Reviews', 'reviews']],
    'image'   => 'assets/img/gallery/project-1-after.jpeg',
]);
?>

<section class="section section--paper">
  <div class="container">
    <div class="reviews-grid">
      <?php foreach ($reviews as $review) partial('review-card', ['review' => $review]); ?>
    </div>

    <div class="review-cta">
      <div>
        <strong>Had work done with us?</strong>
        <p>We'd love to hear about your experience. Your review helps other Adelaide homeowners find a roofer they can trust.</p>
      </div>
      <div class="review-cta__actions">
        <?php if (config('google_review_url')): ?>
          <a class="btn btn--primary" href="<?= e(config('google_review_url')) ?>" target="_blank" rel="noopener"><?= icon('google') ?> Leave a Google review</a>
        <?php else: ?>
          <a class="btn btn--primary" href="<?= e(email_href()) ?>?subject=<?= rawurlencode('My review of AF Prestige Roofing') ?>"><?= icon('mail') ?> Send us your review</a>
        <?php endif; ?>
        <?php if (config('social.google')): ?>
          <a class="btn btn--outline" href="<?= e(config('social.google')) ?>" target="_blank" rel="noopener">Read our Google reviews</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
