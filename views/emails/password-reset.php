<?php /** @var string $name @var string $link */ ?>
<h1 style="font-family:Georgia,serif;font-weight:normal;font-size:28px;margin:0 0 12px">Reset your password</h1>
<p>Hi <?= e(explode(' ', $name)[0]) ?>, we received a request to reset your password. Click below to choose a new one. This link expires in 60 minutes.</p>
<?= App\Core\View::partial('emails/button', ['href' => $link, 'label' => 'Reset password']) ?>
<p style="color:#6c6260;font-size:13px">If you didn’t request this, you can safely ignore this e-mail — your password won’t change.</p>
