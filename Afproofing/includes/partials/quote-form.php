<?php
/**
 * Free quote / enquiry form, submitted to enquiry.php.
 * Vars: $id (unique per page, e.g. 'hero'), $variant ('compact' or 'full'),
 *       $button (submit label).
 */
defined('ROOT_PATH') || exit;

$id = $id ?? 'quote';
$variant = $variant ?? 'full';
$compact = $variant === 'compact';
$button = $button ?? 'Request My Free Quote';
$flash = $GLOBALS['flash'];
$message = ($flash['form'] ?? '') === $id ? (string) ($flash['message'] ?? '') : '';

// Shared attributes for a field: value, validation state and error link.
$attrs = function (string $name) use ($id): string {
    $error = field_error($id, $name);
    $out = ' id="' . e("$id-$name") . '" name="' . e($name) . '"';
    if ($error !== '') {
        $out .= ' aria-invalid="true" aria-describedby="' . e("$id-$name-error") . '"';
    }
    return $out;
};
$error = function (string $name) use ($id): string {
    $msg = field_error($id, $name);
    return '<p class="field-error" id="' . e("$id-$name-error") . '"' . ($msg === '' ? ' hidden' : '') . '>' . e($msg) . '</p>';
};
?>
<form class="quote-form quote-form--<?= e($variant) ?>" id="<?= e($id) ?>-form" action="<?= e(url('enquiry.php')) ?>" method="post" data-enquiry-form>
  <input type="hidden" name="form_id" value="<?= e($id) ?>">
  <input type="hidden" name="token" value="<?= e(form_token()) ?>">
  <input type="hidden" name="page" value="<?= e('/' . CURRENT_PATH) ?>">
  <div class="hp-field" aria-hidden="true">
    <label for="<?= e($id) ?>-website">Leave this field empty</label>
    <input type="text" id="<?= e($id) ?>-website" name="website" tabindex="-1" autocomplete="off">
  </div>

  <div class="form-grid">
    <div class="field">
      <label for="<?= e($id) ?>-name">Full name <span class="req" aria-hidden="true">*</span></label>
      <input<?= $attrs('name') ?> type="text" autocomplete="name" required maxlength="80" value="<?= e(old($id, 'name')) ?>" data-error="Please enter your name.">
      <?= $error('name') ?>
    </div>
    <div class="field">
      <label for="<?= e($id) ?>-phone">Phone <span class="req" aria-hidden="true">*</span></label>
      <input<?= $attrs('phone') ?> type="tel" autocomplete="tel" inputmode="tel" required maxlength="20" pattern="[0-9 +()\-]{8,20}" value="<?= e(old($id, 'phone')) ?>" data-error="Please enter a valid phone number.">
      <?= $error('phone') ?>
    </div>
    <?php if (!$compact): ?>
      <div class="field">
        <label for="<?= e($id) ?>-email">Email</label>
        <input<?= $attrs('email') ?> type="email" autocomplete="email" maxlength="120" value="<?= e(old($id, 'email')) ?>" data-error="Please enter a valid email address.">
        <?= $error('email') ?>
      </div>
    <?php endif; ?>
    <div class="field">
      <label for="<?= e($id) ?>-suburb">Suburb <span class="req" aria-hidden="true">*</span></label>
      <input<?= $attrs('suburb') ?> type="text" autocomplete="address-level2" required maxlength="60" list="<?= e($id) ?>-suburbs" value="<?= e(old($id, 'suburb')) ?>" data-error="Please enter your suburb.">
      <datalist id="<?= e($id) ?>-suburbs">
        <?php foreach ($GLOBALS['areas'] as $region): foreach ($region['suburbs'] as $suburb): ?><option value="<?= e($suburb) ?>"><?php endforeach; endforeach; ?>
      </datalist>
      <?= $error('suburb') ?>
    </div>
    <div class="field">
      <label for="<?= e($id) ?>-service">Service required</label>
      <select<?= $attrs('service') ?>>
        <option value="">Select a service</option>
        <?php foreach (service_options() as $value => $label): ?>
          <option value="<?= e($value) ?>"<?= old($id, 'service', $GLOBALS['preselect_service'] ?? '') === $value ? ' selected' : '' ?>><?= e($label) ?></option>
        <?php endforeach; ?>
      </select>
      <?= $error('service') ?>
    </div>
    <?php if (!$compact): ?>
      <div class="field">
        <label for="<?= e($id) ?>-roof_type">Roof type</label>
        <select<?= $attrs('roof_type') ?>>
          <option value="">Select roof type</option>
          <?php foreach (roof_type_options() as $value => $label): ?>
            <option value="<?= e($value) ?>"<?= old($id, 'roof_type') === $value ? ' selected' : '' ?>><?= e($label) ?></option>
          <?php endforeach; ?>
        </select>
        <?= $error('roof_type') ?>
      </div>
      <div class="field field--full">
        <label for="<?= e($id) ?>-message">Tell us about your roof</label>
        <textarea<?= $attrs('message') ?> rows="4" maxlength="2000" placeholder="e.g. Faded concrete tiles, some cracked ridge capping, two-storey home"><?= e(old($id, 'message')) ?></textarea>
        <?= $error('message') ?>
      </div>
    <?php endif; ?>
  </div>

  <button class="btn btn--primary btn--lg btn--block" type="submit"><?= e($button) ?> <?= icon('arrow-right', 'icon-shift') ?></button>
  <p class="form-status<?= $message !== '' ? ' is-error' : '' ?>" role="status" aria-live="polite"><?= e($message) ?></p>
  <p class="form-note"><?= icon('lock') ?><span>Your details are safe with us and only used to respond to your enquiry. <a href="<?= e(url('privacy-policy')) ?>">Privacy policy</a></span></p>
</form>
