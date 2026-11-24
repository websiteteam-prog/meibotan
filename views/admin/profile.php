<?php /** @var array $me */ ?>
<?= adm_head('My <em>profile</em>', 'Signed in as ' . (App\Core\AdminAuth::ROLE_LABELS[$me['role']] ?? $me['role'])) ?>
<div class="grid-2-eq">
  <div class="card-a"><h2>Profile</h2>
    <form method="post" action="<?= e(url('admin/profile')) ?>"><?= csrf_field() ?>
      <?= adm_input('name', 'Name', $me['name'], ['attrs' => ['required' => true]]) ?>
      <?= adm_input('email', 'Email', $me['email'], ['type' => 'email', 'attrs' => ['required' => true]]) ?>
      <?= adm_input('phone', 'Phone', $me['phone'] ?? '', ['optional' => true]) ?>
      <button class="btn-a" type="submit">Save profile</button>
    </form>
  </div>
  <div class="card-a"><h2>Change password</h2>
    <form method="post" action="<?= e(url('admin/profile/password')) ?>"><?= csrf_field() ?>
      <?= adm_input('current_password', 'Current password', '', ['type' => 'password', 'attrs' => ['required' => true, 'autocomplete' => 'current-password']]) ?>
      <?= adm_input('password', 'New password', '', ['type' => 'password', 'help' => 'At least 8 characters with a letter and a number.', 'attrs' => ['required' => true, 'autocomplete' => 'new-password']]) ?>
      <?= adm_input('password_confirmation', 'Confirm new password', '', ['type' => 'password', 'attrs' => ['required' => true]]) ?>
      <button class="btn-a" type="submit">Update password</button>
    </form>
  </div>
</div>
