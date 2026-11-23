<?php
/**
 * @var array $p @var array $reviews @var array $dist @var ?array $myReview @var bool $hasPurchased
 * @var array $related @var array $recent @var array $crumbs
 */
$customer = customer();
$gallery = $p['gallery'];
?>
<section class="product-page">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <div class="product-layout" data-product-scope>
      <div class="pd-gallery" data-gallery>
        <?php if (count($gallery) > 1): ?>
        <div class="pd-thumbs" role="tablist" aria-label="Product images">
          <?php foreach ($gallery as $i => $g): ?>
            <button type="button" class="<?= $i === 0 ? 'active' : '' ?>" data-thumb data-full="<?= e(upload_url($g)) ?>" aria-label="View image <?= $i + 1 ?>">
              <img src="<?= e(upload_url($g, '300')) ?>" alt="" width="90" height="112" loading="lazy">
            </button>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="pd-main">
          <div class="zoom" data-zoom>
            <?= img_tag($p['image'], $p['name'], ['data-main-image' => true, 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '(max-width: 992px) 100vw, 50vw', 'width' => 1000, 'height' => 1250]) ?>
            <span class="zoom-hint d-none d-lg-flex"><?= icon('zoom') ?> Hover to zoom</span>
          </div>
          <?php if ($p['badges']): ?>
            <div class="pcard-badges"><?php foreach ($p['badges'] as $b): ?><span class="badge-sa type-<?= e($b['type']) ?>"><?= e($b['label']) ?></span><?php endforeach; ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="pd-info">
        <div class="pd-sticky">
          <?php if ($p['category_name']): ?><a class="eyebrow" href="<?= e(url('category/' . $p['category_slug'])) ?>"><?= e($p['category_name']) ?><?= $p['subcategory_name'] ? ' · ' . e($p['subcategory_name']) : '' ?></a><?php endif; ?>
          <h1 class="pd-title"><?= e($p['name']) ?></h1>
          <div class="pd-rating">
            <?php if ((int) $p['rating_count'] > 0): ?>
              <?= stars((float) $p['rating_avg']) ?> <strong><?= number_format((float) $p['rating_avg'], 1) ?></strong>
              <a href="#reviews" data-jump-tab="tab-reviews"><?= e(plural((int) $p['rating_count'], 'review')) ?></a>
            <?php else: ?>
              <a href="#reviews" data-jump-tab="tab-reviews">Be the first to review</a>
            <?php endif; ?>
          </div>
          <?php if ($p['short_description']): ?><p class="pd-short"><?= e($p['short_description']) ?></p><?php endif; ?>

          <?= App\Core\View::partial('front/partials/buy-box', ['p' => $p]) ?>

          <ul class="pd-perks">
            <li><?= icon('truck') ?><span><?= (float) setting('free_shipping_threshold', 0) > 0 ? 'Free shipping on orders above ' . money(setting('free_shipping_threshold')) : 'Fast, insured shipping' ?><small><?= e(setting('delivery_estimate', 'Delivered in 3–7 business days')) ?></small></span></li>
            <?php if (setting('cod_enabled') === '1'): ?><li><?= icon('cash') ?><span>Cash on Delivery available<small>Pay when your order arrives</small></span></li><?php endif; ?>
            <li><?= icon('shield') ?><span>Secure checkout<small>UPI, cards &amp; net banking via Razorpay</small></span></li>
            <li><?= icon('return') ?><span>Easy replacements<small><a href="<?= e(url('page/return-refund-policy')) ?>">Damaged or incorrect items replaced</a></small></span></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Details tabs -->
    <div class="pd-tabs" id="reviews">
      <div class="pd-tabs-nav" role="tablist" data-tabs-nav>
        <button type="button" class="active" role="tab" aria-selected="true" data-tab-target="tab-desc">Description</button>
        <?php if ($p['specs']): ?><button type="button" role="tab" aria-selected="false" data-tab-target="tab-specs">Specifications</button><?php endif; ?>
        <?php if ($p['additional_info']): ?><button type="button" role="tab" aria-selected="false" data-tab-target="tab-info">Additional information</button><?php endif; ?>
        <button type="button" role="tab" aria-selected="false" data-tab-target="tab-reviews">Reviews (<?= (int) $p['rating_count'] ?>)</button>
      </div>
      <div class="pd-tab rich-text" id="tab-desc" data-tab-panel role="tabpanel">
        <?= $p['description'] ?: '<p>' . e($p['short_description']) . '</p>' ?>
      </div>
      <?php if ($p['specs']): ?>
      <div class="pd-tab" id="tab-specs" data-tab-panel role="tabpanel" hidden>
        <table class="spec-table">
          <tbody>
            <tr><th>SKU</th><td><?= e($p['sku']) ?></td></tr>
            <?php foreach ($p['specs'] as $s): ?><tr><th><?= e($s['label'] ?? '') ?></th><td><?= e($s['value'] ?? '') ?></td></tr><?php endforeach; ?>
            <?php if ($p['variants']): ?><tr><th><?= e($p['variant_label'] ?: 'Options') ?></th><td><?= e(implode(', ', array_column($p['variants'], 'name'))) ?></td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
      <?php if ($p['additional_info']): ?>
      <div class="pd-tab rich-text" id="tab-info" data-tab-panel role="tabpanel" hidden><?= $p['additional_info'] ?></div>
      <?php endif; ?>
      <div class="pd-tab" id="tab-reviews" data-tab-panel role="tabpanel" hidden>
        <div class="reviews-layout">
          <div class="reviews-summary">
            <div class="rs-score"><?= number_format((float) $p['rating_avg'], 1) ?></div>
            <?= stars((float) $p['rating_avg']) ?>
            <p class="text-muted-sa mb-3">Based on <?= e(plural((int) $p['rating_count'], 'review')) ?></p>
            <?php $total = max(1, array_sum($dist)); for ($i = 5; $i >= 1; $i--): ?>
              <div class="rs-bar"><span><?= $i ?> ★</span><div><i style="width:<?= round($dist[$i] / $total * 100) ?>%"></i></div><small><?= $dist[$i] ?></small></div>
            <?php endfor; ?>
          </div>
          <div class="reviews-list">
            <?php if (!$reviews): ?><p class="serif fs-4 fst-italic text-muted-sa">No reviews yet — share your thoughts and help others choose.</p><?php endif; ?>
            <?php foreach ($reviews as $r): ?>
              <article class="review">
                <div class="d-flex justify-content-between flex-wrap gap-2"><?= stars((float) $r['rating']) ?><time class="text-muted-sa small" datetime="<?= e($r['created_at']) ?>"><?= format_date($r['created_at']) ?></time></div>
                <?php if ($r['title']): ?><h4><?= e($r['title']) ?></h4><?php endif; ?>
                <p><?= nl2br(e($r['comment'])) ?></p>
                <span class="review-by"><?= e($r['name']) ?><?php if ($r['is_verified']): ?> · <span class="verified"><?= icon('check-circle', 'ic-sm') ?> Verified buyer</span><?php endif; ?></span>
              </article>
            <?php endforeach; ?>

            <div class="review-form-wrap">
              <?php if (!$customer): ?>
                <p>Please <a href="<?= e(url('login', ['redirect' => '/product/' . $p['slug'] . '#reviews'])) ?>">log in</a> to write a review.</p>
              <?php elseif ($myReview): ?>
                <p class="text-muted-sa">Thank you for reviewing this product<?= $myReview['status'] === 'pending' ? ' — your review is awaiting approval' : '' ?>.</p>
              <?php else: ?>
                <h3 class="serif">Write a review</h3>
                <form method="post" action="<?= e(url('product/' . $p['slug'] . '/review')) ?>" class="form-sa">
                  <?= csrf_field() ?>
                  <div class="star-input" role="radiogroup" aria-label="Rating">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                      <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" <?= (int) old('rating', 5) === $i ? 'checked' : '' ?>><label for="star<?= $i ?>" title="<?= $i ?> stars"><?= icon('star-fill') ?></label>
                    <?php endfor; ?>
                  </div>
                  <?= error_for('rating') ?>
                  <div class="mb-3"><label class="form-label" for="rv-title">Title (optional)</label><input class="form-control<?= invalid('title') ?>" id="rv-title" name="title" maxlength="120" value="<?= e(old('title')) ?>"><?= error_for('title') ?></div>
                  <div class="mb-3"><label class="form-label" for="rv-comment">Your review</label><textarea class="form-control<?= invalid('comment') ?>" id="rv-comment" name="comment" rows="4" required minlength="10" maxlength="2000"><?= e(old('comment')) ?></textarea><?= error_for('comment') ?></div>
                  <button class="btn-sa" type="submit">Submit review</button>
                  <?php if (!$hasPurchased): ?><small class="d-block mt-2 text-muted-sa">Reviews from verified buyers are marked with a badge.</small><?php endif; ?>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if ($related): ?>
<section class="section" style="padding-top:0">
  <div class="container-xl">
    <div class="section-head"><div><span class="eyebrow">Complete the ritual</span><h2 class="section-title">You may also <em>love</em></h2></div></div>
    <div class="product-grid"><?php foreach ($related as $rp): ?><?= App\Core\View::partial('partials/product-card', ['p' => $rp]) ?><?php endforeach; ?></div>
  </div>
</section>
<?php endif; ?>

<?php if ($recent): ?>
<section class="section" style="padding-top:0">
  <div class="container-xl">
    <div class="section-head"><div><span class="eyebrow">Your history</span><h2 class="section-title">Recently <em>viewed</em></h2></div></div>
    <div class="product-grid"><?php foreach ($recent as $rp): ?><?= App\Core\View::partial('partials/product-card', ['p' => $rp]) ?><?php endforeach; ?></div>
  </div>
</section>
<?php endif; ?>

<div class="mobile-buybar d-lg-none">
  <div><span class="mb-name"><?= e($p['name']) ?></span><span class="mb-price"><?= money($p['from_price'] ?? $p['final_price']) ?></span></div>
  <button type="button" class="btn-sa btn-dark btn-sm" onclick="document.querySelector('.buy-add').scrollIntoView({behavior:'smooth',block:'center'})">Add to bag</button>
</div>
