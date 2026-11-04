<?php
/**
 * Page footer. Set $page['hide_cta'] = true to skip the yellow call-to-action band.
 */
defined('ROOT_PATH') || exit;

$social = array_filter(config('social', []));
$socialLabels = ['facebook' => 'Facebook', 'instagram' => 'Instagram', 'google' => 'Google Business Profile'];
?>
</main>

<?php if (empty($page['hide_cta'])) partial('cta-band'); ?>

<footer class="site-footer">
  <div class="container site-footer__grid">
    <div>
      <?php partial('brand'); ?>
      <p class="site-footer__about">Premium roof restoration for terracotta and concrete tiled roofs across Adelaide and surrounding suburbs. Quality workmanship, honest advice and free quotes.</p>
      <?php if ($social): ?>
        <ul class="social-links">
          <?php foreach ($social as $network => $link): ?>
            <li><a href="<?= e($link) ?>" target="_blank" rel="noopener" aria-label="<?= e($socialLabels[$network] ?? ucfirst($network)) ?>"><?= icon($network) ?></a></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>

    <div>
      <h2 class="footer-title">Our Services</h2>
      <ul class="footer-links">
        <?php foreach ($services as $navSlug => $navService): ?>
          <li><a href="<?= e(service_url($navSlug)) ?>"><?= e($navService['name']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div>
      <h2 class="footer-title">Explore</h2>
      <ul class="footer-links">
        <li><a href="<?= e(url()) ?>">Home</a></li>
        <li><a href="<?= e(url('services')) ?>">All Services</a></li>
        <li><a href="<?= e(url('gallery')) ?>">Before &amp; After Gallery</a></li>
        <li><a href="<?= e(url('why-choose-us')) ?>">Why Choose Us</a></li>
        <li><a href="<?= e(url('reviews')) ?>">Customer Reviews</a></li>
        <li><a href="<?= e(url('service-areas')) ?>">Service Areas</a></li>
        <li><a href="<?= e(url('contact')) ?>">Contact Us</a></li>
      </ul>
    </div>

    <div>
      <h2 class="footer-title">Get in Touch</h2>
      <ul class="footer-contact">
        <li><?= icon('phone') ?><a href="<?= e(phone_href()) ?>"><strong><?= e(config('phone')) ?></strong></a></li>
        <li><?= icon('mail') ?><a href="<?= e(email_href()) ?>"><?= e(config('email')) ?></a></li>
        <li><?= icon('pin') ?><span>Servicing Adelaide &amp; surrounding suburbs, including the Adelaide Hills</span></li>
        <?php foreach (config('hours', []) as $row): ?>
          <li><?= icon('clock') ?><span><?= e($row['label']) ?>: <?= e(format_hours($row['open'], $row['close'])) ?></span></li>
        <?php endforeach; ?>
      </ul>
      <a class="btn btn--primary" href="<?= e(url('free-quote')) ?>">Get a Free Quote <?= icon('arrow-right', 'icon-shift') ?></a>
    </div>
  </div>

  <div class="container site-footer__bottom">
    <p>&copy; <?= date('Y') ?> <?= e(config('site_name')) ?>. All rights reserved.<?php
      if (config('abn')): ?> ABN <?= e(config('abn')) ?>.<?php endif;
      if (config('licence')): ?> Licence <?= e(config('licence')) ?>.<?php endif; ?></p>
    <p><a href="<?= e(url('privacy-policy')) ?>">Privacy Policy</a> &middot; <a href="<?= e(url('sitemap.xml')) ?>">Sitemap</a></p>
  </div>
</footer>

<div class="mobile-cta">
  <a class="mobile-cta__call" href="<?= e(phone_href()) ?>"><?= icon('phone') ?> Call Now</a>
  <a class="mobile-cta__quote" href="<?= e(url('free-quote')) ?>"><?= icon('clipboard') ?> Free Quote</a>
</div>
</body>
</html>
