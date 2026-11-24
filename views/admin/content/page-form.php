<?php /** @var ?array $page */ $p = $page ?? []; ?>
<?= adm_head($p ? 'Edit <em>' . e($p['title']) . '</em>' : 'New <em>page</em>', '', '', ['Pages', 'admin/pages']) ?>
<form method="post" action="<?= e(url('admin/pages/save')) ?>">
  <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) ($p['id'] ?? 0) ?>">
  <div class="form-grid">
    <div class="card-a">
      <?= adm_input('title', 'Title', $p['title'] ?? '', ['attrs' => ['required' => true, 'data-slug-source' => '#f_slug']]) ?>
      <?= adm_input('slug', 'Slug', $p['slug'] ?? '', ['prefix' => '/page/', 'attrs' => ($p['slug'] ?? '') === 'about-us' ? ['readonly' => true] : []]) ?>
      <?= adm_rte('content', 'Content', $p['content'] ?? '') ?>
    </div>
    <div class="sticky-col">
      <div class="card-a">
        <?= adm_switch('is_active', 'Published', (bool) ($p['is_active'] ?? 1)) ?>
        <?= adm_switch('show_in_footer', 'Link in footer', (bool) ($p['show_in_footer'] ?? 1)) ?>
        <button class="btn-a w-100 mt-3" type="submit">Save page</button>
      </div>
      <div class="card-a">
        <h2>SEO</h2>
        <?= adm_input('meta_title', 'Meta title', $p['meta_title'] ?? '') ?>
        <?= adm_textarea('meta_description', 'Meta description', $p['meta_description'] ?? '', ['rows' => 3]) ?>
      </div>
    </div>
  </div>
</form>
