<?php /** @var string $content @var string $subject */ ?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title><?= e($subject) ?></title></head>
<body style="margin:0;padding:0;background:#EDEBDD;font-family:Helvetica,Arial,sans-serif;color:#1B1717">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#EDEBDD;padding:28px 12px">
  <tr><td align="center">
    <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#F5F3EA;border-radius:18px;overflow:hidden">
      <tr><td align="center" style="background:#630000;padding:30px 20px"><img src="<?= e(url('assets/img/logo-cotton.png')) ?>" width="150" alt="<?= e(setting('site_name')) ?>" style="display:block;width:150px;height:auto"></td></tr>
      <tr><td style="padding:36px 36px 28px;font-size:15px;line-height:1.65">
        <?= $content ?>
      </td></tr>
      <tr><td style="background:#1B1717;color:#cfcabc;padding:22px 36px;font-size:12px;line-height:1.6" align="center">
        <?= e(setting('site_name')) ?> · <?= e(setting('site_tagline')) ?><br>
        <?php if (setting('site_email')): ?><a href="mailto:<?= e(setting('site_email')) ?>" style="color:#EDEBDD"><?= e(setting('site_email')) ?></a><?php endif; ?><?php if (setting('site_phone')): ?> · <?= e(setting('site_phone')) ?><?php endif; ?>
      </td></tr>
    </table>
  </td></tr>
</table>
</body></html>
