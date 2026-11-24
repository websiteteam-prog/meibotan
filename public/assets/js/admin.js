/* Savié Amour — admin interactions (vanilla JS) */
(function () {
  'use strict';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  // ---------------------------------------------------------------- image previews
  // Variant image: preview inside the small card thumbnail.
  document.addEventListener('change', function (e) {
    var input = e.target;
    if (!input.matches('.vc-media input[type=file]') || !input.files[0]) return;
    var box = input.closest('.vc-media');
    var reader = new FileReader();
    reader.onload = function () {
      var prev = box.querySelector('img, .vc-swatch');
      if (prev) prev.parentNode.removeChild(prev);
      var img = document.createElement('img'); img.src = reader.result; img.alt = '';
      box.insertBefore(img, box.firstChild);
    };
    reader.readAsDataURL(input.files[0]);
  });

  document.addEventListener('change', function (e) {
    var input = e.target;
    if (!input.matches('.img-drop input[type=file]')) return;
    var drop = input.closest('.img-drop');
    var hint = $('.hint span', drop);
    if (input.multiple) {
      if (hint) hint.textContent = input.files.length ? input.files.length + ' image(s) selected — they will upload on save' : 'Choose images';
      var list = drop.parentNode.querySelector('[data-new-previews]');
      if (list) {
        list.innerHTML = '';
        Array.prototype.forEach.call(input.files, function (f) {
          var r = new FileReader();
          r.onload = function () { var d = document.createElement('div'); d.className = 'gallery-item'; d.innerHTML = '<img alt="">'; d.firstChild.src = r.result; list.appendChild(d); };
          r.readAsDataURL(f);
        });
      }
      return;
    }
    var file = input.files[0];
    if (!file) return;
    var img = $('img', drop);
    if (!img) { img = document.createElement('img'); drop.insertBefore(img, drop.firstChild); }
    var reader = new FileReader();
    reader.onload = function () { img.src = reader.result; };
    reader.readAsDataURL(file);
    if (hint) hint.textContent = file.name;
  });
  $$('.img-drop').forEach(function (d) {
    ['dragenter', 'dragover'].forEach(function (ev) { d.addEventListener(ev, function () { d.classList.add('drag'); }); });
    ['dragleave', 'drop'].forEach(function (ev) { d.addEventListener(ev, function () { d.classList.remove('drag'); }); });
  });

  // ---------------------------------------------------------------- rich text editor
  $$('[data-rte]').forEach(function (wrap) {
    var area = $('.rte-area', wrap), src = $('.rte-src', wrap);
    function sync() { if (!wrap.classList.contains('show-src')) src.value = area.innerHTML; }
    area.addEventListener('input', sync);
    $$('[data-cmd]', wrap).forEach(function (b) {
      b.addEventListener('click', function (e) {
        e.preventDefault();
        var cmd = b.getAttribute('data-cmd'), val = b.getAttribute('data-val') || null;
        if (cmd === 'source') {
          if (wrap.classList.contains('show-src')) { area.innerHTML = src.value; wrap.classList.remove('show-src'); }
          else { src.value = area.innerHTML; wrap.classList.add('show-src'); }
          return;
        }
        if (cmd === 'createLink') { val = window.prompt('Link URL (https://… or /page)'); if (!val) return; }
        area.focus();
        document.execCommand(cmd, false, val);
        sync();
      });
    });
    var form = wrap.closest('form');
    if (form) form.addEventListener('submit', function () { if (wrap.classList.contains('show-src')) area.innerHTML = src.value; src.value = area.innerHTML; });
  });

  // ---------------------------------------------------------------- repeaters
  $$('[data-repeater]').forEach(function (rep) {
    var tpl = $('template', rep), list = $('[data-repeater-list]', rep);
    var idx = $$('[data-repeater-item]', list).length + 1000;
    $('[data-repeater-add]', rep).addEventListener('click', function () {
      var html = tpl.innerHTML.replace(/__INDEX__/g, String(idx++));
      list.insertAdjacentHTML('beforeend', html);
      var first = list.lastElementChild && $('input, select', list.lastElementChild);
      if (first) first.focus();
    });
    rep.addEventListener('click', function (e) {
      var rm = e.target.closest('[data-repeater-remove]');
      if (rm) { e.preventDefault(); rm.closest('[data-repeater-item]').remove(); }
    });
  });

  // ---------------------------------------------------------------- slug auto-generation
  function slugify(s) { return s.toString().normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, ''); }
  $$('[data-slug-source]').forEach(function (src) {
    var target = $(src.getAttribute('data-slug-source'));
    if (!target) return;
    var manual = target.value !== '';
    target.addEventListener('input', function () { manual = target.value !== ''; });
    src.addEventListener('input', function () { if (!manual) target.value = slugify(src.value); });
  });

  // ---------------------------------------------------------------- dependent subcategory select
  $$('[data-category-select]').forEach(function (cat) {
    var sub = $(cat.getAttribute('data-category-select'));
    function filter() {
      $$('option[data-cat]', sub).forEach(function (o) { var ok = o.getAttribute('data-cat') === cat.value; o.hidden = !ok; o.disabled = !ok; });
      var sel = sub.options[sub.selectedIndex];
      if (sel && sel.disabled) sub.value = '';
    }
    cat.addEventListener('change', filter);
    filter();
  });

  // ---------------------------------------------------------------- confirm / auto-submit / bulk
  document.addEventListener('submit', function (e) {
    var f = e.target.closest('[data-confirm]');
    if (f && !window.confirm(f.getAttribute('data-confirm'))) { e.preventDefault(); return; }
    var btn = e.target.querySelector('[type=submit]:not([data-no-loading])');
    if (btn && !e.defaultPrevented) { setTimeout(function () { btn.disabled = true; }, 10); }
  });
  $$('[data-autosubmit]').forEach(function (el) { el.addEventListener('change', function () { el.form.submit(); }); });
  var all = $('[data-check-all]');
  if (all) {
    all.addEventListener('change', function () { $$('[data-check-item]').forEach(function (c) { c.checked = all.checked; }); syncBulk(); });
    document.addEventListener('change', function (e) { if (e.target.matches('[data-check-item]')) syncBulk(); });
  }
  function syncBulk() {
    var n = $$('[data-check-item]:checked').length;
    var bar = $('[data-bulk-bar]');
    if (bar) { bar.hidden = n === 0; var c = $('[data-bulk-count]', bar); if (c) c.textContent = n; }
  }

  // ---------------------------------------------------------------- modal forms (create / edit)
  document.addEventListener('click', function (e) {
    var trg = e.target.closest('[data-fill-form]');
    if (!trg) return;
    var form = $(trg.getAttribute('data-fill-form'));
    if (!form) return;
    var values = {};
    try { values = JSON.parse(trg.getAttribute('data-values') || '{}'); } catch (err) { values = {}; }
    form.reset();
    $$('[data-preview]', form).forEach(function (img) { img.removeAttribute('src'); img.hidden = true; });
    $$('input[type=hidden][data-reset]', form).forEach(function (h) { h.value = h.getAttribute('data-reset'); });
    Object.keys(values).forEach(function (k) {
      var fields = $$('[name="' + k + '"]', form);
      var hasBox = fields.some(function (x) { return x.type === 'checkbox'; });
      fields.forEach(function (f) {
        if (f.type === 'hidden' && hasBox) return; // keep the "0" fallback of switches
        if (f.type === 'checkbox') f.checked = String(values[k]) === '1' || values[k] === true;
        else if (f.type === 'radio') f.checked = f.value === String(values[k]);
        else if (f.type !== 'file') f.value = values[k] === null ? '' : values[k];
      });
      var prev = $('[data-preview="' + k + '"]', form);
      if (prev && values[k]) { prev.src = values[k]; prev.hidden = false; }
    });
    var title = trg.getAttribute('data-title');
    var t = form.closest('.modal') && $('.modal-title', form.closest('.modal'));
    if (t && title) t.textContent = title;
  });

  // ---------------------------------------------------------------- copy to clipboard
  document.addEventListener('click', function (e) {
    var c = e.target.closest('[data-copy]');
    if (!c) return;
    navigator.clipboard && navigator.clipboard.writeText(c.getAttribute('data-copy'));
    var old = c.innerHTML; c.textContent = 'Copied'; setTimeout(function () { c.innerHTML = old; }, 1200);
  });
})();
