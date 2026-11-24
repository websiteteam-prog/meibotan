<?php
/** @var string $tab */
use App\Controllers\Admin\SettingsController;

$s = static fn(string $k, string $d = '') => (string) setting($k, $d);
$secretHint = static fn(string $k) => setting($k) ? 'A value is saved. Leave blank to keep it.' : 'Not set yet.';
?>
<?= adm_head('Settings', 'Store-wide configuration. Changes apply to the website immediately.') ?>
<div class="tabs-a">
  <?php foreach (SettingsController::tabs() as $k => $label): ?>
    <a class="<?= $tab === $k ? 'active' : '' ?>" href="<?= e(url('admin/settings', ['tab' => $k])) ?>"><?= e($label) ?></a>
  <?php endforeach; ?>
</div>

<form method="post" action="<?= e(url('admin/settings')) ?>" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <input type="hidden" name="tab" value="<?= e($tab) ?>">
  <div class="card-a" style="max-width:920px">
  <?php if ($tab === 'general'): ?>
    <div class="row">
      <?= adm_input('site_name', 'Store name', $s('site_name'), ['col' => 'col-md-6 mb-3', 'attrs' => ['required' => true]]) ?>
      <?= adm_input('site_email', 'Contact e-mail', $s('site_email'), ['type' => 'email', 'col' => 'col-md-6 mb-3']) ?>
      <?= adm_input('site_phone', 'Phone (shown in top bar & footer)', $s('site_phone'), ['col' => 'col-md-6 mb-3']) ?>
      <?= adm_input('whatsapp_number', 'WhatsApp number', $s('whatsapp_number'), ['col' => 'col-md-6 mb-3', 'help' => 'With country code, digits only, e.g. 919820000000']) ?>
      <?= adm_input('business_hours', 'Business hours', $s('business_hours'), ['col' => 'col-md-6 mb-3']) ?>
    </div>
    <?= adm_textarea('site_address', 'Address', $s('site_address'), ['rows' => 3, 'help' => 'Shown in the footer, on the Contact page and on invoices.']) ?>
  <?php elseif ($tab === 'website'): ?>
    <div class="alert-strip"><?= icon('lock', 'ic-sm') ?><span>Developer-only: these settings change the look and texts of the website.</span></div>
    <?= adm_input('site_tagline', 'Tagline', $s('site_tagline')) ?>
    <?= adm_textarea('announcement_messages', 'Announcement bar messages', $s('announcement_messages'), ['rows' => 3, 'help' => 'One message per line — they rotate in the top bar.']) ?>
    <?= adm_textarea('footer_about', 'Footer description', $s('footer_about'), ['rows' => 2]) ?>
    <?= adm_input('copyright_text', 'Copyright text', $s('copyright_text'), ['help' => '{year} is replaced with the current year.']) ?>
    <div class="row">
      <?= adm_image('logo', 'Logo (for light backgrounds)', $s('logo') ?: null, ['col' => 'col-md-6 mb-3', 'removable' => true, 'help' => 'Transparent PNG/WebP. Default: Savié Amour logo in maroon.']) ?>
      <?= adm_image('logo_light', 'Logo (for dark backgrounds)', $s('logo_light') ?: null, ['col' => 'col-md-6 mb-3', 'removable' => true, 'help' => 'Used in the footer. Default: logo in cotton.']) ?>
      <?= adm_image('favicon', 'Favicon', $s('favicon') ?: null, ['col' => 'col-md-6 mb-3', 'removable' => true, 'small' => true, 'help' => 'Square image, at least 64×64.']) ?>
      <?= adm_image('og_image', 'Social share image', $s('og_image') ?: null, ['col' => 'col-md-6 mb-3', 'removable' => true, 'small' => true, 'help' => '1200×630 image used when links are shared.']) ?>
    </div>
  <?php elseif ($tab === 'social'): ?>
    <div class="row">
      <?= adm_input('instagram_url', 'Instagram URL', $s('instagram_url'), ['type' => 'url', 'col' => 'col-md-6 mb-3']) ?>
      <?= adm_input('instagram_handle', 'Instagram handle', $s('instagram_handle'), ['col' => 'col-md-6 mb-3']) ?>
      <?= adm_input('facebook_url', 'Facebook URL', $s('facebook_url'), ['type' => 'url', 'col' => 'col-md-6 mb-3']) ?>
      <?= adm_input('youtube_url', 'YouTube URL', $s('youtube_url'), ['type' => 'url', 'col' => 'col-md-6 mb-3']) ?>
      <?= adm_input('pinterest_url', 'Pinterest URL', $s('pinterest_url'), ['type' => 'url', 'col' => 'col-md-6 mb-3']) ?>
      <?= adm_input('x_url', 'X / Twitter URL', $s('x_url'), ['type' => 'url', 'col' => 'col-md-6 mb-3']) ?>
    </div>
  <?php elseif ($tab === 'store'): ?>
    <div class="row">
      <?= adm_input('currency_code', 'Currency code', $s('currency_code', 'INR'), ['col' => 'col-md-4 mb-3']) ?>
      <?= adm_input('currency_symbol', 'Currency symbol', $s('currency_symbol', '₹'), ['col' => 'col-md-4 mb-3']) ?>
      <?= adm_input('order_prefix', 'Order number prefix', $s('order_prefix', 'SA'), ['col' => 'col-md-4 mb-3']) ?>
      <?= adm_input('products_per_page', 'Products per page', $s('products_per_page', '12'), ['type' => 'number', 'col' => 'col-md-6 mb-3']) ?>
      <?= adm_input('low_stock_threshold', 'Low-stock alert at', $s('low_stock_threshold', '5'), ['type' => 'number', 'col' => 'col-md-6 mb-3', 'suffix' => 'units']) ?>
    </div>
    <?= adm_switch('guest_checkout', 'Allow guest checkout', setting('guest_checkout') === '1', 'Customers can order without creating an account.') ?>
    <?= adm_switch('review_auto_approve', 'Publish reviews automatically', setting('review_auto_approve') === '1', 'Otherwise reviews wait for approval under Reviews.') ?>
  <?php elseif ($tab === 'shipping'): ?>
    <?= adm_switch('shipping_enabled', 'Charge shipping', setting('shipping_enabled') === '1') ?>
    <div class="row mt-3">
      <?= adm_input('shipping_flat_rate', 'Flat shipping rate', $s('shipping_flat_rate', '0'), ['type' => 'number', 'col' => 'col-md-6 mb-3', 'prefix' => $s('currency_symbol', '₹'), 'attrs' => ['step' => '0.01']]) ?>
      <?= adm_input('free_shipping_threshold', 'Free shipping above', $s('free_shipping_threshold', '0'), ['type' => 'number', 'col' => 'col-md-6 mb-3', 'prefix' => $s('currency_symbol', '₹'), 'help' => '0 = never free', 'attrs' => ['step' => '0.01']]) ?>
      <?= adm_input('delivery_estimate', 'Delivery estimate text', $s('delivery_estimate'), ['col' => 'col-md-6 mb-3']) ?>
      <?= adm_input('shipping_countries', 'Countries you ship to', $s('shipping_countries', 'India'), ['col' => 'col-md-6 mb-3', 'help' => 'Comma separated, e.g. India']) ?>
    </div>
    <?= adm_switch('cod_enabled', 'Cash on Delivery', setting('cod_enabled') === '1') ?>
    <?= adm_input('cod_fee', 'COD handling fee', $s('cod_fee', '0'), ['type' => 'number', 'prefix' => $s('currency_symbol', '₹'), 'attrs' => ['step' => '0.01']]) ?>
  <?php elseif ($tab === 'tax'): ?>
    <?= adm_switch('tax_enabled', 'Apply tax (GST)', setting('tax_enabled') === '1') ?>
    <?= adm_switch('prices_include_tax', 'Product prices already include tax', setting('prices_include_tax') === '1', 'If off, tax is added on top at checkout.') ?>
    <div class="row mt-3">
      <?= adm_input('tax_label', 'Tax label', $s('tax_label', 'GST'), ['col' => 'col-md-4 mb-3']) ?>
      <?= adm_input('tax_rate', 'Tax rate', $s('tax_rate', '18'), ['type' => 'number', 'col' => 'col-md-4 mb-3', 'suffix' => '%', 'attrs' => ['step' => '0.01']]) ?>
      <?= adm_input('gstin', 'GSTIN (printed on invoices)', $s('gstin'), ['col' => 'col-md-4 mb-3']) ?>
    </div>
  <?php elseif ($tab === 'payment'): ?>
    <?= adm_switch('razorpay_enabled', 'Accept online payments with Razorpay', setting('razorpay_enabled') === '1', 'UPI, cards, net banking and wallets.') ?>
    <div class="row mt-3">
      <?= adm_input('razorpay_key_id', 'Key ID', $s('razorpay_key_id'), ['col' => 'col-md-6 mb-3', 'help' => 'Starts with rzp_test_ or rzp_live_']) ?>
      <?= adm_input('razorpay_key_secret', 'Key secret', '', ['type' => 'password', 'col' => 'col-md-6 mb-3', 'help' => $secretHint('razorpay_key_secret'), 'attrs' => ['autocomplete' => 'off']]) ?>
      <?= adm_input('razorpay_webhook_secret', 'Webhook secret', '', ['type' => 'password', 'col' => 'col-md-6 mb-3', 'help' => $secretHint('razorpay_webhook_secret'), 'attrs' => ['autocomplete' => 'off']]) ?>
      <div class="col-md-6 mb-3"><label class="form-label">Webhook URL</label><div class="input-group"><input class="form-control" readonly value="<?= e(url('api/payment/razorpay/webhook')) ?>"><button class="btn-a light" type="button" data-copy="<?= e(url('api/payment/razorpay/webhook')) ?>">Copy</button></div><div class="form-text">Events: payment.captured, payment.failed, order.paid</div></div>
    </div>
  <?php elseif ($tab === 'email'): ?>
    <div class="row">
      <?= adm_select('mail_driver', 'Delivery method', ['log' => 'Log only (testing)', 'mail' => 'PHP mail()', 'smtp' => 'SMTP (recommended)'], $s('mail_driver', 'log'), ['col' => 'col-md-4 mb-3']) ?>
      <?= adm_input('mail_from_name', 'From name', $s('mail_from_name'), ['col' => 'col-md-4 mb-3']) ?>
      <?= adm_input('mail_from_address', 'From e-mail', $s('mail_from_address'), ['type' => 'email', 'col' => 'col-md-4 mb-3']) ?>
      <?= adm_input('admin_notification_email', 'Send order alerts to', $s('admin_notification_email'), ['type' => 'email', 'col' => 'col-md-6 mb-3']) ?>
    </div>
    <?= adm_switch('notify_admin_new_order', 'E-mail me about new orders', setting('notify_admin_new_order') === '1') ?>
    <?= adm_switch('notify_customer_order_status', 'E-mail customers when order status changes', setting('notify_customer_order_status') === '1') ?>
    <p class="section-title-a mt-4">SMTP</p>
    <div class="row">
      <?= adm_input('smtp_host', 'Host', $s('smtp_host'), ['col' => 'col-md-6 mb-3', 'attrs' => ['placeholder' => 'smtp.gmail.com']]) ?>
      <?= adm_input('smtp_port', 'Port', $s('smtp_port', '587'), ['type' => 'number', 'col' => 'col-md-3 mb-3']) ?>
      <?= adm_select('smtp_encryption', 'Encryption', ['tls' => 'TLS (587)', 'ssl' => 'SSL (465)', 'none' => 'None'], $s('smtp_encryption', 'tls'), ['col' => 'col-md-3 mb-3']) ?>
      <?= adm_input('smtp_username', 'Username', $s('smtp_username'), ['col' => 'col-md-6 mb-3', 'attrs' => ['autocomplete' => 'off']]) ?>
      <?= adm_input('smtp_password', 'Password', '', ['type' => 'password', 'col' => 'col-md-6 mb-3', 'help' => $secretHint('smtp_password'), 'attrs' => ['autocomplete' => 'new-password']]) ?>
    </div>
  <?php elseif ($tab === 'seo'): ?>
    <?= adm_input('meta_title', 'Homepage title', $s('meta_title')) ?>
    <?= adm_textarea('meta_description', 'Homepage meta description', $s('meta_description'), ['rows' => 3]) ?>
    <?= adm_input('meta_keywords', 'Keywords', $s('meta_keywords')) ?>
    <?= adm_input('google_analytics_id', 'Google Analytics ID', $s('google_analytics_id'), ['help' => 'e.g. G-XXXXXXXXXX']) ?>
    <?= adm_textarea('robots_extra', 'Extra robots.txt rules', $s('robots_extra'), ['rows' => 3]) ?>
    <p class="form-text m-0">Sitemap: <a href="<?= e(url('sitemap.xml')) ?>" target="_blank" rel="noopener"><?= e(url('sitemap.xml')) ?></a> · Robots: <a href="<?= e(url('robots.txt')) ?>" target="_blank" rel="noopener"><?= e(url('robots.txt')) ?></a></p>
  <?php endif; ?>
    <button class="btn-a mt-4" type="submit"><?= icon('check', 'ic-sm') ?> Save <?= e(strtolower(SettingsController::TABS[$tab])) ?> settings</button>
  </div>
</form>

<?php if ($tab === 'email'): ?>
<form method="post" action="<?= e(url('admin/settings/test-email')) ?>" class="card-a d-flex gap-2 align-items-end flex-wrap" style="max-width:920px">
  <?= csrf_field() ?>
  <?= adm_input('to', 'Send a test e-mail to', admin_user()['email'], ['type' => 'email', 'col' => 'flex-grow-1 mb-0']) ?>
  <button class="btn-a light" type="submit"><?= icon('mail', 'ic-sm') ?> Send test</button>
</form>
<?php endif; ?>
