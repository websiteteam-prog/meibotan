<?php /** @var array $s */ ?>
<section class="section-tight" style="padding-top:0">
  <div class="container-xl">
    <div class="promo-grid">
      <?php foreach (array_slice($s['banners'], 0, 2) as $i => $b): ?>
      <a class="promo-card theme-<?= e($b['theme']) ?>" href="<?= e(link_url($b['button_link'])) ?>" data-reveal data-reveal-delay="<?= $i ?>">
        <?php if ($b['image']): ?><?= img_tag($b['image'], $b['title'], ['class' => 'promo-bg', 'sizes' => '(max-width: 768px) 100vw, 50vw', 'width' => 1200, 'height' => 800]) ?><?php endif; ?>
        <div class="promo-copy">
          <?php if ($b['eyebrow']): ?><span class="eyebrow"><?= e($b['eyebrow']) ?></span><?php endif; ?>
          <h3><?= e($b['title']) ?><?php if ($b['title_italic']): ?> <em><?= e($b['title_italic']) ?></em><?php endif; ?></h3>
          <?php if ($b['subtitle']): ?><p><?= e($b['subtitle']) ?></p><?php endif; ?>
          <?php if ($b['button_text']): ?><span class="btn-sa <?= $b['theme'] === 'cotton' ? 'btn-dark' : 'btn-light' ?>"><?= e($b['button_text']) ?> <?= icon('arrow-right') ?></span><?php endif; ?>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
