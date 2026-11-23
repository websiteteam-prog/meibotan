<?php /** @var array $totals @var string $context */ ?>
<div class="coupon-box">
  <?php if ($totals['coupon_code']): ?>
    <div class="coupon-applied"><?= icon('tag', 'ic-sm') ?> <strong><?= e($totals['coupon_code']) ?></strong> applied <button type="button" class="mi-remove ms-auto" data-coupon-remove="<?= e($context) ?>">Remove</button></div>
  <?php else: ?>
    <?php if (!empty($totals['coupon_error'])): ?><p class="stock-low mb-2"><?= e($totals['coupon_error']) ?></p><?php endif; ?>
    <form class="coupon-form" data-coupon-form data-context="<?= e($context) ?>">
      <label class="visually-hidden" for="coupon-<?= e($context) ?>">Coupon code</label>
      <input type="text" id="coupon-<?= e($context) ?>" name="code" placeholder="Coupon code" autocomplete="off" required maxlength="40">
      <button type="submit" class="btn-sa btn-dark btn-sm">Apply</button>
    </form>
  <?php endif; ?>
</div>
