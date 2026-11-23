<?php /** @var array $page */ ?>
<section class="page-hero slim">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/breadcrumbs', ['crumbs' => [['Home', url('/')], [$page['title'], null]]]) ?>
    <h1 class="display-title"><?= e($page['title']) ?></h1>
    <?php if ($page['updated_at'] || $page['created_at']): ?><p class="page-hero-sub">Last updated <?= format_date($page['updated_at'] ?: $page['created_at'], 'd F Y') ?></p><?php endif; ?>
  </div>
</section>
<section class="section-tight">
  <div class="container-xl">
    <article class="rich-text page-content"><?= $page['content'] ?></article>
  </div>
</section>
