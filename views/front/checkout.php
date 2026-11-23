<?php
/**
 * @var array $items @var array $totals @var array $methods @var string $method @var ?array $customer
 * @var array $addresses @var ?array $default @var array $states @var array $countries
 */
$val = static function (string $key, ?string $fallback = '') { return old($key, $fallback ?? ''); };
$d = $default ?? [];
$stateField = static function (string $name, string $value, array $states, bool $required = true, string $attrs = '') {
    $html = '<select class="form-select" id="' . e($name) . '" name="' . e($name) . '" ' . ($required ? 'required' : '') . ' ' . $attrs . ' autocomplete="address-level1"><option value="">Select state</option>';
    foreach ($states as $s) { $html .= '<option' . ($s === $value ? ' selected' : '') . '>' . e($s) . '</option>'; }
    return $html . '</select>';
};
?>
<section class="page-hero slim">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/breadcrumbs', ['crumbs' => [['Home', url('/')], ['Bag', url('cart')], ['Checkout', null]]]) ?>
    <h1 class="display-title">Secure <em>checkout</em></h1>
  </div>
</section>
<section class="section-tight" style="padding-top:30px">
  <div class="container-xl">
    <?php if (!$methods): ?>
      <div class="flash flash-error"><?= icon('alert') ?> Checkout is temporarily unavailable because no payment method is enabled. Please contact us to place your order.</div>
    <?php endif; ?>
    <div class="checkout-layout">
      <form id="checkoutForm" class="form-sa checkout-form" method="post" action="<?= e(url('checkout')) ?>" data-checkout novalidate>
        <?= csrf_field() ?>
        <div class="co-step">
          <div class="co-step-head"><span>1</span><h2>Contact information</h2>
            <?php if (!$customer): ?><small>Have an account? <a href="<?= e(url('login', ['redirect' => '/checkout'])) ?>">Log in</a></small><?php endif; ?></div>
          <div class="row g-3">
            <div class="col-md-12"><label class="form-label" for="name">Full name</label><input class="form-control<?= invalid('name') ?>" id="name" name="name" required maxlength="120" autocomplete="name" value="<?= e($val('name', $customer['name'] ?? '')) ?>"><div class="invalid-feedback"><?= e(errors()['name'] ?? 'Please enter your name.') ?></div></div>
            <div class="col-md-6"><label class="form-label" for="email">Email</label><input class="form-control<?= invalid('email') ?>" type="email" id="email" name="email" required maxlength="190" autocomplete="email" value="<?= e($val('email', $customer['email'] ?? '')) ?>"><div class="invalid-feedback"><?= e(errors()['email'] ?? 'Please enter a valid email.') ?></div></div>
            <div class="col-md-6"><label class="form-label" for="phone">Phone number</label><input class="form-control<?= invalid('phone') ?>" type="tel" id="phone" name="phone" required pattern="[0-9+\s\-]{10,16}" autocomplete="tel" value="<?= e($val('phone', $customer['phone'] ?? ($d['phone'] ?? ''))) ?>"><div class="invalid-feedback"><?= e(errors()['phone'] ?? 'Please enter a valid phone number.') ?></div></div>
          </div>
        </div>

        <div class="co-step">
          <div class="co-step-head"><span>2</span><h2>Shipping address</h2></div>
          <?php if ($addresses): ?>
          <div class="mb-3">
            <label class="form-label" for="savedAddress">Use a saved address</label>
            <select class="form-select" id="savedAddress" data-saved-address>
              <option value="">— Choose —</option>
              <?php foreach ($addresses as $a): ?>
                <option value="<?= (int) $a['id'] ?>" <?= $default && $default['id'] === $a['id'] ? 'selected' : '' ?> data-address='<?= e(json_encode(['address1' => $a['address_line1'], 'address2' => $a['address_line2'], 'city' => $a['city'], 'state' => $a['state'], 'country' => $a['country'], 'postal_code' => $a['postal_code']])) ?>'><?= e($a['label'] . ' — ' . $a['address_line1'] . ', ' . $a['city']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <?php endif; ?>
          <div class="row g-3">
            <div class="col-12"><label class="form-label" for="shipping_address1">Address</label><input class="form-control<?= invalid('shipping_address1') ?>" id="shipping_address1" name="shipping_address1" required maxlength="190" autocomplete="address-line1" placeholder="House no., building, street" value="<?= e($val('shipping_address1', $d['address_line1'] ?? '')) ?>"><div class="invalid-feedback"><?= e(errors()['shipping_address1'] ?? 'Please enter your address.') ?></div></div>
            <div class="col-12"><label class="form-label" for="shipping_address2">Apartment, landmark <span class="text-muted-sa">(optional)</span></label><input class="form-control" id="shipping_address2" name="shipping_address2" maxlength="190" autocomplete="address-line2" value="<?= e($val('shipping_address2', $d['address_line2'] ?? '')) ?>"></div>
            <div class="col-md-6"><label class="form-label" for="shipping_city">City</label><input class="form-control<?= invalid('shipping_city') ?>" id="shipping_city" name="shipping_city" required maxlength="100" autocomplete="address-level2" value="<?= e($val('shipping_city', $d['city'] ?? '')) ?>"><div class="invalid-feedback"><?= e(errors()['shipping_city'] ?? 'Please enter your city.') ?></div></div>
            <div class="col-md-6"><label class="form-label" for="shipping_state">State</label><?= $stateField('shipping_state', (string) $val('shipping_state', $d['state'] ?? ''), $states) ?><div class="invalid-feedback"><?= e(errors()['shipping_state'] ?? 'Please choose your state.') ?></div></div>
            <div class="col-md-6"><label class="form-label" for="shipping_country">Country</label>
              <select class="form-select" id="shipping_country" name="shipping_country" required autocomplete="country-name"><?php foreach ($countries as $c): ?><option <?= $val('shipping_country', $d['country'] ?? '') === $c ? 'selected' : '' ?>><?= e($c) ?></option><?php endforeach; ?></select></div>
            <div class="col-md-6"><label class="form-label" for="shipping_postal_code">PIN code</label><input class="form-control<?= invalid('shipping_postal_code') ?>" id="shipping_postal_code" name="shipping_postal_code" required maxlength="12" inputmode="numeric" autocomplete="postal-code" value="<?= e($val('shipping_postal_code', $d['postal_code'] ?? '')) ?>"><div class="invalid-feedback"><?= e(errors()['shipping_postal_code'] ?? 'Please enter your PIN code.') ?></div></div>
          </div>
          <?php if ($customer): ?>
            <label class="check-line mt-3"><input type="checkbox" name="save_address" value="1" <?= $addresses ? '' : 'checked' ?>> Save this address to my account</label>
          <?php endif; ?>
          <label class="check-line mt-2"><input type="checkbox" name="billing_same" value="1" <?= old('billing_same', '1') === '1' ? 'checked' : '' ?>> Billing address is the same as shipping</label>
          <div class="billing-fields mt-3" data-billing-fields hidden>
            <h3 class="serif fs-4 mb-3">Billing address</h3>
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label" for="billing_name">Full name</label><input class="form-control" id="billing_name" name="billing_name" maxlength="120" data-billing-required value="<?= e($val('billing_name')) ?>"><div class="invalid-feedback">Required.</div></div>
              <div class="col-md-6"><label class="form-label" for="billing_phone">Phone</label><input class="form-control" type="tel" id="billing_phone" name="billing_phone" data-billing-required value="<?= e($val('billing_phone')) ?>"><div class="invalid-feedback">Required.</div></div>
              <div class="col-12"><label class="form-label" for="billing_address1">Address</label><input class="form-control" id="billing_address1" name="billing_address1" maxlength="190" data-billing-required value="<?= e($val('billing_address1')) ?>"><div class="invalid-feedback">Required.</div></div>
              <div class="col-12"><label class="form-label" for="billing_address2">Apartment, landmark (optional)</label><input class="form-control" id="billing_address2" name="billing_address2" maxlength="190" value="<?= e($val('billing_address2')) ?>"></div>
              <div class="col-md-6"><label class="form-label" for="billing_city">City</label><input class="form-control" id="billing_city" name="billing_city" maxlength="100" data-billing-required value="<?= e($val('billing_city')) ?>"><div class="invalid-feedback">Required.</div></div>
              <div class="col-md-6"><label class="form-label" for="billing_state">State</label><?= $stateField('billing_state', (string) $val('billing_state'), $states, false, 'data-billing-required') ?><div class="invalid-feedback">Required.</div></div>
              <div class="col-md-6"><label class="form-label" for="billing_country">Country</label><select class="form-select" id="billing_country" name="billing_country"><?php foreach ($countries as $c): ?><option><?= e($c) ?></option><?php endforeach; ?></select></div>
              <div class="col-md-6"><label class="form-label" for="billing_postal_code">PIN code</label><input class="form-control" id="billing_postal_code" name="billing_postal_code" maxlength="12" data-billing-required value="<?= e($val('billing_postal_code')) ?>"><div class="invalid-feedback">Required.</div></div>
            </div>
          </div>
        </div>

        <div class="co-step">
          <div class="co-step-head"><span>3</span><h2>Payment</h2></div>
          <div class="pay-options">
            <?php foreach ($methods as $key => $m): ?>
            <label class="pay-option">
              <input type="radio" name="payment_method" value="<?= e($key) ?>" <?= $key === $method ? 'checked' : '' ?> required>
              <span class="po-icon"><?= icon($m['icon']) ?></span>
              <span><strong><?= e($m['label']) ?></strong><small><?= e($m['desc']) ?></small></span>
            </label>
            <?php endforeach; ?>
          </div>
          <div class="mt-4"><label class="form-label" for="notes">Order notes <span class="text-muted-sa">(optional)</span></label><textarea class="form-control" id="notes" name="notes" rows="3" maxlength="500" placeholder="Gift message or delivery instructions"><?= e($val('notes')) ?></textarea></div>
          <p class="small text-muted-sa mt-3 mb-0">By placing your order you agree to our <a href="<?= e(url('page/terms-and-conditions')) ?>">terms</a> and <a href="<?= e(url('page/return-refund-policy')) ?>">return policy</a>.</p>
        </div>
      </form>

      <aside class="summary-card checkout-summary" data-checkout-summary>
        <?= App\Core\View::partial('front/partials/checkout-summary', ['items' => $items, 'totals' => $totals]) ?>
      </aside>
    </div>
  </div>
</section>
