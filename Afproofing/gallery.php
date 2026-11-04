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

$filters = ['all' => 'All projects', 'terracotta' => 'Terracotta', 'concrete' => 'Concrete', 'ridge-capping' => 'Ridge capping', 'painting' => 'Painting', 'repairs' => 'Repairs'];
$hasSamples = (bool) array_filter($gallery, fn($p) => !empty($p['sample']));
?>

<section class="section section--paper">
  <div class="container">
    <?php if ($hasSamples): ?>
      <p class="notice"><?= icon('eye') ?><span>Sample images are shown while we add photos from our latest projects. Ask
          us for more examples of our work when we visit for your free quote.</span></p>
    <?php endif; ?>

    <div class="filters" data-gallery-filters role="group" aria-label="Filter projects">
      <?php foreach ($filters as $value => $label): ?>
        <button type="button" data-filter="<?= e($value) ?>"
          aria-pressed="<?= $value === 'all' ? 'true' : 'false' ?>"><?= e($label) ?></button>
      <?php endforeach; ?>
    </div>

    <div class="ba-grid">
      <?php foreach ($gallery as $project)
        partial('ba-card', ['project' => $project, 'heading' => 'h2']); ?>
    </div>
    <p class="center text-muted mt-lg" data-gallery-empty hidden>No projects in this category yet. Check back soon.</p>
  </div>
</section>

<?php include ROOT_PATH . '/includes/footer.php'; ?>