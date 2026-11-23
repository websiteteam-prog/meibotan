<?php
/**
 * @var array $ctx @var array $products @var App\Core\Paginator $pager @var array $categories
 * @var ?array $selectedCat @var array $selectedSubs @var array $chips @var string $q @var string $sort
 * @var int $minBound @var int $maxBound @var int $minPrice @var int $maxPrice @var string $countLabel @var string $basePath @var array $crumbs
 */
use App\Services\ProductService;

$type = $ctx['type'];
$fixedCat = $ctx['category'] ?? null;
$subGroups = $fixedCat ? array_values(array_filter($categories, static fn($c) => (int) $c['id'] === (int) $fixedCat['id'])) : $categories;
$sorts = ProductService::SORTS;
if ($type === 'collection') { $sorts = ['collection' => 'Curated order'] + $sorts; }
?>
<section class="page-hero<?= !empty($ctx['image']) ? ' has-image' : '' ?>">
  <div class="container-xl">
    <div class="page-hero-inner">
      <div>
        <?= App\Core\View::partial('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
        <span class="eyebrow"><?= e($ctx['eyebrow'] ?? ($type === 'subcategory' ? $fixedCat['name'] : ($type === 'category' ? 'Category' : 'Savié Amour'))) ?></span>
        <h1 class="display-title"><?= e($ctx['title']) ?><?php if (!empty($ctx['italic'])): ?> <em><?= e($ctx['italic']) ?></em><?php endif; ?></h1>
        <?php if (!empty($ctx['description'])): ?><p class="page-hero-sub"><?= e($ctx['description']) ?></p><?php endif; ?>
        <?php
          $catRow = null;
          if ($fixedCat) { foreach ($categories as $c) { if ((int) $c['id'] === (int) $fixedCat['id']) { $catRow = $c; } } }
        ?>
        <?php if ($catRow && $catRow['subs']): ?>
          <div class="sub-links">
            <a class="chip<?= $type === 'category' ? ' active' : '' ?>" href="<?= e(url('category/' . $catRow['slug'])) ?>">All <?= e($catRow['name']) ?></a>
            <?php foreach ($catRow['subs'] as $s): ?>
              <a class="chip<?= isset($ctx['subcategory']) && (int) $ctx['subcategory']['id'] === (int) $s['id'] ? ' active' : '' ?>" href="<?= e(url('category/' . $catRow['slug'] . '/' . $s['slug'])) ?>"><?= e($s['name']) ?></a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
      <?php if (!empty($ctx['image'])): ?>
        <div class="page-hero-media d-none d-md-block"><?= img_tag($ctx['image'], $ctx['title'], ['sizes' => '320px', 'loading' => 'eager', 'width' => 800, 'height' => 1000]) ?></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="shop-wrap">
  <div class="container-xl">
    <div class="shop-layout" data-shop data-path="<?= e(url($basePath)) ?>">
      <aside class="offcanvas-lg offcanvas-start shop-filters" tabindex="-1" id="shopFilters" aria-labelledby="shopFiltersTitle">
        <div class="offcanvas-header">
          <h2 class="offcanvas-title" id="shopFiltersTitle">Filters</h2>
          <button type="button" class="btn-icon" data-bs-dismiss="offcanvas" data-bs-target="#shopFilters" aria-label="Close"><?= icon('close') ?></button>
        </div>
        <div class="offcanvas-body">
          <form data-filter-form action="<?= e(url($basePath)) ?>" method="get" class="filter-form">
            <?php if ($type !== 'search'): ?>
            <div class="filter-block">
              <h3>Search</h3>
              <div class="filter-search"><?= icon('search') ?><input type="search" name="q" value="<?= e($q) ?>" placeholder="Search within…" aria-label="Search within results"></div>
            </div>
            <?php else: ?>
              <input type="hidden" name="q" value="<?= e($q) ?>">
            <?php endif; ?>

            <?php if (!$fixedCat): ?>
            <div class="filter-block">
              <h3>Category</h3>
              <label class="filter-opt"><input type="radio" name="category" value="" <?= $selectedCat ? '' : 'checked' ?>><span>All categories</span></label>
              <?php foreach ($categories as $c): ?>
                <label class="filter-opt"><input type="radio" name="category" value="<?= e($c['slug']) ?>" <?= $selectedCat && $selectedCat['id'] === $c['id'] ? 'checked' : '' ?>><span><?= e($c['name']) ?></span><small><?= (int) $c['product_count'] ?></small></label>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!isset($ctx['subcategory'])): ?>
            <div class="filter-block">
              <h3>Type</h3>
              <?php foreach ($subGroups as $c): if (!$c['subs']) continue; ?>
                <div data-sub-group="<?= e($c['slug']) ?>" <?= ($selectedCat && $selectedCat['id'] !== $c['id']) ? 'hidden' : '' ?>>
                  <?php if (!$fixedCat): ?><span class="filter-group-label"><?= e($c['name']) ?></span><?php endif; ?>
                  <?php foreach ($c['subs'] as $s): ?>
                    <label class="filter-opt"><input type="checkbox" name="sub[]" value="<?= (int) $s['id'] ?>" data-cat="<?= e($c['slug']) ?>" <?= in_array((int) $s['id'], $selectedSubs, true) ? 'checked' : '' ?>><span><?= e($s['name']) ?></span></label>
                  <?php endforeach; ?>
                </div>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($maxBound > $minBound): ?>
            <div class="filter-block">
              <h3>Price</h3>
              <div class="range">
                <div class="range-track"><span data-range-fill></span></div>
                <input type="range" min="<?= $minBound ?>" max="<?= $maxBound ?>" step="10" value="<?= $minPrice ?>" data-range-min aria-label="Minimum price">
                <input type="range" min="<?= $minBound ?>" max="<?= $maxBound ?>" step="10" value="<?= $maxPrice ?>" data-range-max aria-label="Maximum price">
              </div>
              <input type="hidden" name="min_price" value="<?= $minPrice ?>" data-default="<?= $minBound ?>">
              <input type="hidden" name="max_price" value="<?= $maxPrice ?>" data-default="<?= $maxBound ?>">
              <div class="range-out" data-price-out><?= money($minPrice) ?> — <?= money($maxPrice) ?></div>
            </div>
            <?php endif; ?>

            <div class="filter-block">
              <h3>Availability &amp; offers</h3>
              <?php foreach (['in_stock' => 'In stock only', 'on_sale' => 'On sale', 'new' => 'New arrivals', 'bestseller' => 'Best sellers', 'featured' => 'Featured'] as $k => $label): ?>
                <label class="filter-opt"><input type="checkbox" name="<?= $k ?>" value="1" <?= input($k) ? 'checked' : '' ?>><span><?= e($label) ?></span></label>
              <?php endforeach; ?>
            </div>
            <noscript><button class="btn-sa btn-block" type="submit">Apply filters</button></noscript>
            <button type="button" class="btn-sa btn-block d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#shopFilters">Show results</button>
          </form>
        </div>
      </aside>

      <div class="shop-main">
        <div class="shop-toolbar">
          <button class="btn-sa btn-outline btn-sm d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#shopFilters" aria-controls="shopFilters"><?= icon('filter') ?> Filters</button>
          <span class="shop-count" data-shop-count><?= e($countLabel) ?></span>
          <label class="sort-select">
            <span class="d-none d-sm-inline">Sort by</span>
            <select data-sort aria-label="Sort products">
              <?php foreach ($sorts as $k => $label): ?><option value="<?= e($k) ?>" <?= $sort === $k ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
            </select>
          </label>
        </div>
        <div class="active-filters" data-active-filters><?= App\Core\View::partial('front/partials/filter-chips', ['chips' => $chips]) ?></div>

        <div class="product-grid cols-3 tab-grid" data-shop-grid>
          <?php foreach ($products as $p): ?><?= App\Core\View::partial('partials/product-card', ['p' => $p, 'sizes' => '(max-width: 576px) 50vw, (max-width: 1200px) 33vw, 22vw']) ?><?php endforeach; ?>
          <?php if (!$products): ?><?= App\Core\View::partial('front/partials/shop-empty', ['q' => $q]) ?><?php endif; ?>
        </div>

        <div class="shop-more">
          <button type="button" class="btn-sa btn-outline" data-load-more data-next="<?= $pager->page + 1 ?>" <?= $pager->hasMore() ? '' : 'hidden' ?>>Load more</button>
          <div data-shop-pager><?= App\Core\View::partial('front/partials/pager', ['pager' => $pager, 'path' => $basePath]) ?></div>
        </div>
      </div>
    </div>
  </div>
</section>
