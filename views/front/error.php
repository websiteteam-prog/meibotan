<?php /** @var int $code @var string $title @var string $message */ ?>
<section class="section">
  <div class="container-xl">
    <div class="empty-state" style="min-height:50vh;justify-content:center">
      <div class="empty-icon"><?= icon($code === 404 ? 'search' : 'alert') ?></div>
      <span class="eyebrow">Error <?= (int) $code ?></span>
      <h1 class="display-title"><?= e($title) ?></h1>
      <p><?= e($message) ?></p>
      <div class="d-flex gap-2 flex-wrap justify-content-center">
        <a href="<?= e(url('/')) ?>" class="btn-sa">Back to home</a>
        <a href="<?= e(url('shop')) ?>" class="btn-sa btn-outline">Explore products</a>
      </div>
    </div>
  </div>
</section>
