<section class="page-hero dark">
  <div class="container-xl">
    <?= App\Core\View::partial('partials/breadcrumbs', ['crumbs' => [['Home', url('/')], ['Contact', null]]]) ?>
    <span class="eyebrow">We’d love to hear from you</span>
    <h1 class="display-title">Get in <em>touch</em></h1>
    <p class="page-hero-sub">Questions about an order, a shade or a ritual? Our team is here to help.</p>
  </div>
</section>
<section class="section-tight">
  <div class="container-xl">
    <div class="contact-grid">
      <div class="contact-info">
        <?php if (setting('site_phone')): ?><a class="contact-tile" href="tel:<?= e(preg_replace('/[^\d+]/', '', (string) setting('site_phone'))) ?>"><span class="po-icon"><?= icon('phone') ?></span><span><small>Call us</small><strong><?= e(setting('site_phone')) ?></strong></span></a><?php endif; ?>
        <?php if (setting('whatsapp_number')): ?><a class="contact-tile" href="https://wa.me/<?= e(preg_replace('/\D/', '', (string) setting('whatsapp_number'))) ?>" target="_blank" rel="noopener"><span class="po-icon"><?= icon('whatsapp') ?></span><span><small>WhatsApp</small><strong>Chat with us</strong></span></a><?php endif; ?>
        <?php if (setting('site_email')): ?><a class="contact-tile" href="mailto:<?= e(setting('site_email')) ?>"><span class="po-icon"><?= icon('mail') ?></span><span><small>Email</small><strong><?= e(setting('site_email')) ?></strong></span></a><?php endif; ?>
        <?php if (setting('site_address')): ?><div class="contact-tile"><span class="po-icon"><?= icon('pin') ?></span><span><small>Studio</small><strong><?= nl2br(e(setting('site_address'))) ?></strong></span></div><?php endif; ?>
        <?php if (setting('business_hours')): ?><div class="contact-tile"><span class="po-icon"><?= icon('clock') ?></span><span><small>Hours</small><strong><?= e(setting('business_hours')) ?></strong></span></div><?php endif; ?>
      </div>
      <div class="summary-card" id="contact-form" style="position:static">
        <h2 class="serif">Send us a message</h2>
        <form method="post" action="<?= e(url('contact')) ?>" class="form-sa" novalidate>
          <?= csrf_field() ?>
          <div class="hp-field" aria-hidden="true"><label for="website">Website</label><input id="website" name="website" tabindex="-1" autocomplete="off"></div>
          <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="cname">Name</label><input class="form-control<?= invalid('name') ?>" id="cname" name="name" required value="<?= e(old('name', customer()['name'] ?? '')) ?>"><?= error_for('name') ?></div>
            <div class="col-md-6"><label class="form-label" for="cemail">Email</label><input class="form-control<?= invalid('email') ?>" type="email" id="cemail" name="email" required value="<?= e(old('email', customer()['email'] ?? '')) ?>"><?= error_for('email') ?></div>
            <div class="col-md-6"><label class="form-label" for="cphone">Phone (optional)</label><input class="form-control<?= invalid('phone') ?>" type="tel" id="cphone" name="phone" value="<?= e(old('phone', customer()['phone'] ?? '')) ?>"><?= error_for('phone') ?></div>
            <div class="col-md-6"><label class="form-label" for="csubject">Subject</label><select class="form-select" id="csubject" name="subject"><?php foreach (['Order enquiry', 'Product & shade advice', 'Returns & replacements', 'Wholesale & collaborations', 'Something else'] as $s): ?><option <?= old('subject') === $s ? 'selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?></select></div>
            <div class="col-12"><label class="form-label" for="cmessage">Message</label><textarea class="form-control<?= invalid('message') ?>" id="cmessage" name="message" rows="5" required minlength="10" maxlength="3000"><?= e(old('message')) ?></textarea><?= error_for('message') ?></div>
          </div>
          <button type="submit" class="btn-sa mt-4">Send message <?= icon('arrow-right') ?></button>
        </form>
      </div>
    </div>
  </div>
</section>
