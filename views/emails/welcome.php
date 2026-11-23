<?php /** @var array $customer */ ?>
<h1 style="font-family:Georgia,serif;font-weight:normal;font-size:28px;margin:0 0 12px">Welcome, <?= e(explode(' ', $customer['name'])[0]) ?>.</h1>
<p>Your <?= e(setting('site_name')) ?> account is ready. Save favourites to your wishlist, check out faster and follow every order from your account.</p>
<?= App\Core\View::partial('emails/button', ['href' => url('shop'), 'label' => 'Explore the collection']) ?>
<p style="color:#6c6260;font-size:13px">With amour,<br>The <?= e(setting('site_name')) ?> team</p>
