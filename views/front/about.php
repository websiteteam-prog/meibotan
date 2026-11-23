<?php /** @var ?array $page @var array $benefits @var array $categories @var array $featured */ ?>
<section class="about-hero">
  <div class="container-xl">
    <div class="about-hero-grid">
      <div>
        <?= App\Core\View::partial('partials/breadcrumbs', ['crumbs' => [['Home', url('/')], ['Our story', null]]]) ?>
        <span class="eyebrow eyebrow-light"><?= e(setting('site_tagline', 'the art of beauty')) ?></span>
        <h1 class="hero-title">Rooted in ritual, <em>made to linger.</em></h1>
        <p class="hero-sub">The story of <?= e(setting('site_name')) ?> — colour crafted where sacred vermilion meets the velvety depth of noir.</p>
      </div>
      <div class="about-hero-logo"><img src="<?= e(App\Services\Layout::logo('cotton')) ?>" alt="<?= e(setting('site_name')) ?>" width="647" height="365"></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container-xl">
    <div class="about-story">
      <div class="about-story-media" data-reveal>
        <?php if (!empty($categories[0]['image'])): ?><?= img_tag($categories[0]['image'], 'Savié Amour sindoor ritual', ['sizes' => '(max-width: 992px) 100vw, 40vw']) ?><?php endif; ?>
        <?php if (!empty($categories[1]['image'])): ?><div class="about-story-inset"><?= img_tag($categories[1]['image'], 'Savié Amour tints', ['sizes' => '220px']) ?></div><?php endif; ?>
      </div>
      <div class="rich-text about-copy" data-reveal>
        <?= $page['content'] ?? '' ?>
      </div>
    </div>
  </div>
</section>

<section class="section quote-section">
  <div class="container-xl" data-reveal>
    <svg class="quote-mark ic" aria-hidden="true"><use href="#i-sparkle"></use></svg>
    <blockquote class="quote-text"><span>“Where sacred vermilion meets the velvety depth of noir —</span><span>crafted for rituals that linger.”</span></blockquote>
  </div>
</section>

<?php if ($benefits): ?>
<section class="benefits">
  <div class="container-xl"><div class="benefit-grid">
    <?php foreach (array_slice($benefits, 0, 4) as $i => $b): ?>
      <div class="benefit" data-reveal data-reveal-delay="<?= $i ?>"><div class="benefit-icon"><?= icon($b['icon'] ?? 'sparkle') ?></div><h4><?= e($b['title'] ?? '') ?></h4><p><?= e($b['text'] ?? '') ?></p></div>
    <?php endforeach; ?>
  </div></div>
</section>
<?php endif; ?>

<?php if ($featured): ?>
<section class="section">
  <div class="container-xl">
    <div class="section-head"><div><span class="eyebrow">Begin here</span><h2 class="section-title">Our most <em>loved</em></h2></div><a class="link-arrow" href="<?= e(url('shop')) ?>">Shop all <?= icon('arrow-right') ?></a></div>
    <div class="product-grid"><?php foreach ($featured as $p): ?><?= App\Core\View::partial('partials/product-card', ['p' => $p]) ?><?php endforeach; ?></div>
  </div>
</section>
<?php endif; ?>
