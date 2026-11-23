<?php
use App\Services\Layout;

$cats = Layout::categories();
$pages = Layout::footerPages();
$socials = Layout::socials();
$copyright = str_replace('{year}', date('Y'), (string) setting('copyright_text', '© {year} Savié Amour. All rights reserved.'));
?>
<footer class="site-footer">
  <div class="container-xl">
    <div class="footer-top">
      <div class="footer-brand">
        <a href="<?= e(url('/')) ?>"><img src="<?= e(Layout::logo('cotton')) ?>" alt="<?= e(setting('site_name')) ?>" width="647" height="365" loading="lazy"></a>
        <p><?= e(setting('footer_about', '')) ?></p>
        <?php if ($socials): ?>
        <div class="socials">
          <?php foreach ($socials as $icon => $link): ?>
            <a href="<?= e($link) ?>" target="_blank" rel="noopener" aria-label="<?= e(ucfirst($icon)) ?>"><?= icon($icon) ?></a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
      <div class="footer-col">
        <h5>Shop</h5>
        <ul>
          <li><a href="<?= e(url('shop')) ?>">Shop all</a></li>
          <?php foreach ($cats as $c): ?><li><a href="<?= e($c['url']) ?>"><?= e($c['name']) ?></a></li><?php endforeach; ?>
          <li><a href="<?= e(url('shop', ['sort' => 'newest'])) ?>">New arrivals</a></li>
          <li><a href="<?= e(url('shop', ['sort' => 'bestselling'])) ?>">Best sellers</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Help</h5>
        <ul>
          <li><a href="<?= e(url('about-us')) ?>">Our story</a></li>
          <li><a href="<?= e(url('contact')) ?>">Contact us</a></li>
          <?php foreach ($pages as $p): ?><li><a href="<?= e(url('page/' . $p['slug'])) ?>"><?= e($p['title']) ?></a></li><?php endforeach; ?>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Account</h5>
        <ul>
          <li><a href="<?= e(url('account')) ?>">My account</a></li>
          <li><a href="<?= e(url('account/orders')) ?>">Track orders</a></li>
          <li><a href="<?= e(url('wishlist')) ?>">Wishlist</a></li>
          <li><a href="<?= e(url('cart')) ?>">Shopping bag</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Get in touch</h5>
        <ul class="footer-contact">
          <?php if (setting('site_address')): ?><li><?= icon('pin') ?><span><?= nl2br(e(setting('site_address'))) ?></span></li><?php endif; ?>
          <?php if (setting('site_phone')): ?><li><?= icon('phone') ?><a href="tel:<?= e(preg_replace('/[^\d+]/', '', (string) setting('site_phone'))) ?>"><?= e(setting('site_phone')) ?></a></li><?php endif; ?>
          <?php if (setting('site_email')): ?><li><?= icon('mail') ?><a href="mailto:<?= e(setting('site_email')) ?>"><?= e(setting('site_email')) ?></a></li><?php endif; ?>
          <?php if (setting('business_hours')): ?><li><?= icon('clock') ?><span><?= e(setting('business_hours')) ?></span></li><?php endif; ?>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span><?= e($copyright) ?></span>
      <div class="pay-badges" aria-label="Accepted payments">
        <span>UPI</span><span>VISA</span><span>MASTERCARD</span><span>RUPAY</span><span>NET BANKING</span><?php if (setting('cod_enabled') === '1'): ?><span>COD</span><?php endif; ?>
      </div>
    </div>
  </div>
  <div class="footer-word" aria-hidden="true">Savié Amour</div>
</footer>
