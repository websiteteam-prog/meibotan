<?php
require_once __DIR__ . '/includes/bootstrap.php';

$page = [
  'title' => 'Roof Restoration Before & After Gallery | Adelaide',
  'description' => 'See before and after photos of tiled roof restorations, roof painting, cleaning and ridge capping by AF Prestige Roofing across Adelaide.',
  'path' => 'gallery',
  'schema' => [breadcrumb_schema([['Gallery', 'gallery']])],
];
include ROOT_PATH . '/includes/header.php';

partial('page-hero', [
  'title' => 'Before & After Gallery',
  'lead' => 'The proof is in the finish. Drag each slider to compare our tiled roof restorations before and after.',
  'eyebrow' => 'Our work',
  'crumbs' => [['Gallery', 'gallery']],
  'image' => 'assets/img/gallery/gallery-hero-banner.png',
]);
?>

<section class="section section--paper">
  <div class="container">
  

    <div class="ba-grid">
      <?php foreach ($gallery as $project)
        partial('ba-card', ['project' => $project]); ?>
    </div>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>