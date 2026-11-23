<?php /** @var array $items @var array $totals @var array $suggestions */ ?>
<section class="page-hero slim">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/breadcrumbs', ['crumbs' => [['Home', url('/')], ['Shopping bag', null]]]) ?>
    <h1 class="display-title">Your <em>bag</em></h1>
  </div>
</section>
<section class="section-tight" style="padding-top:30px">
  <div class="container-xl" data-cart-page>
    <?= App\Core\View::partial('front/partials/cart-body', ['items' => $items, 'totals' => $totals]) ?>
  </div>
</section>
<?php if ($suggestions): ?>
<section class="section" style="padding-top:20px">
  <div class="container-xl">
    <div class="section-head"><div><span class="eyebrow">Pairs beautifully</span><h2 class="section-title">Complete your <em>ritual</em></h2></div></div>
    <div class="product-grid"><?php foreach ($suggestions as $p): ?><?= App\Core\View::partial('partials/product-card', ['p' => $p]) ?><?php endforeach; ?></div>
  </div>
</section>
<?php endif; ?>
