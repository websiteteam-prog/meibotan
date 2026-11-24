/* ==========================================================================
   Savié Amour — storefront interactions (vanilla JS, no jQuery)
   ========================================================================== */
(function () {
  'use strict';

  var SA = window.SA || { base: '', csrf: '' };
  var $ = function (sel, ctx) { return (ctx || document).querySelector(sel); };
  var $$ = function (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); };
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ------------------------------------------------------------ helpers
  function api(path, data, method) {
    var opts = {
      method: method || (data ? 'POST' : 'GET'),
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-Token': SA.csrf },
      credentials: 'same-origin'
    };
    if (data) {
      opts.body = data instanceof FormData ? data : toForm(data);
    }
    var url = /^https?:/.test(path) ? path : SA.base + path;
    return fetch(url, opts).then(function (res) {
      return res.json().catch(function () { return { ok: false, message: 'Unexpected response from server.' }; })
        .then(function (json) { json.status = res.status; return json; });
    }).catch(function () { return { ok: false, status: 0, message: 'Network error — please check your connection.' }; });
  }
  function toForm(obj) {
    var fd = new FormData();
    Object.keys(obj).forEach(function (k) { if (obj[k] !== undefined && obj[k] !== null) fd.append(k, obj[k]); });
    return fd;
  }
  function money(n) {
    n = Number(n) || 0;
    var dec = n % 1 !== 0;
    return SA.currency + n.toLocaleString('en-IN', { minimumFractionDigits: dec ? 2 : 0, maximumFractionDigits: 2 });
  }
  function debounce(fn, ms) {
    var t; return function () { var a = arguments, c = this; clearTimeout(t); t = setTimeout(function () { fn.apply(c, a); }, ms); };
  }
  function iconSvg(name) { return '<svg class="ic" aria-hidden="true"><use href="#i-' + name + '"></use></svg>'; }
  function escapeHtml(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }

  function toast(message, type, link) {
    var stack = $('[data-toasts]');
    if (!stack || !message) return;
    var el = document.createElement('div');
    el.className = 'toast-sa' + (type === 'error' ? ' error' : '');
    el.setAttribute('role', type === 'error' ? 'alert' : 'status');
    el.innerHTML = iconSvg(type === 'error' ? 'alert' : 'check-circle') + '<span>' + escapeHtml(message) + '</span>' +
      (link ? '<a href="' + escapeHtml(link.href) + '">' + escapeHtml(link.label) + '</a>' : '');
    stack.appendChild(el);
    setTimeout(function () { el.classList.add('is-leaving'); setTimeout(function () { el.remove(); }, 400); }, 4200);
  }
  SA.toast = toast;
  SA.api = api;
  SA.money = money;

  function setLoading(btn, on) { if (btn) { btn.classList.toggle('is-loading', !!on); btn.disabled = !!on; } }

  function updateCounts(data) {
    if (typeof data.count === 'number') {
      $$('[data-cart-count]').forEach(function (el) {
        el.textContent = data.count; el.setAttribute('data-count', data.count);
        el.classList.remove('bump'); void el.offsetWidth; el.classList.add('bump');
      });
      $$('[data-cart-label]').forEach(function (el) { el.textContent = data.count + (data.count === 1 ? ' item' : ' items'); });
    }
    if (typeof data.wishlist_count === 'number') {
      $$('[data-wish-count]').forEach(function (el) {
        el.textContent = data.wishlist_count; el.setAttribute('data-count', data.wishlist_count);
        el.classList.remove('bump'); void el.offsetWidth; el.classList.add('bump');
      });
    }
  }

  // ------------------------------------------------------------ header
  var header = $('#siteHeader');
  var toTop = $('[data-to-top]');
  function onScroll() {
    var y = window.scrollY;
    if (header) header.classList.toggle('is-scrolled', y > 40);
    if (toTop) toTop.classList.toggle('is-visible', y > 700);
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
  if (toTop) toTop.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' }); });

  // announcement rotator
  $$('[data-rotator]').forEach(function (rot) {
    var items = $$('span', rot);
    if (items.length < 2) return;
    var i = 0;
    setInterval(function () {
      var cur = items[i];
      cur.classList.remove('is-active'); cur.classList.add('is-leaving');
      setTimeout(function () { cur.classList.remove('is-leaving'); }, 650);
      i = (i + 1) % items.length;
      items[i].classList.add('is-active');
    }, 4500);
  });

  // ------------------------------------------------------------ search
  var searchPanel = $('#searchPanel');
  var searchInput = $('[data-search-input]');
  var searchResults = $('[data-search-results]');
  function openSearch() {
    if (!searchPanel) return;
    searchPanel.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    setTimeout(function () { searchInput && searchInput.focus(); }, 120);
  }
  function closeSearch() {
    if (!searchPanel) return;
    searchPanel.classList.remove('is-open');
    document.body.style.overflow = '';
  }
  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-search-open]')) { e.preventDefault(); openSearch(); }
    if (e.target.closest('[data-search-close]')) { e.preventDefault(); closeSearch(); }
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeSearch();
    if (e.key === '/' && !/input|textarea|select/i.test(document.activeElement.tagName)) { e.preventDefault(); openSearch(); }
  });
  var lastQuery = '';
  var runSearch = debounce(function () {
    var q = searchInput.value.trim();
    if (q === lastQuery) return;
    lastQuery = q;
    if (q.length < 2) { searchResults.innerHTML = ''; return; }
    searchResults.innerHTML = '<div class="spinner"></div>';
    api('/api/search?q=' + encodeURIComponent(q)).then(function (res) {
      if (q !== lastQuery) return;
      if (!res.ok || (!res.products.length && !res.categories.length)) {
        searchResults.innerHTML = '<p class="sr-empty">No matches for “' + escapeHtml(q) + '”. Try “sindoor” or “kohl”.</p>';
        return;
      }
      var html = '';
      if (res.categories.length) {
        html += '<div class="search-hints mb-3"><span>Categories:</span>' + res.categories.map(function (c) {
          return '<a class="chip" href="' + escapeHtml(c.url) + '">' + escapeHtml(c.name) + '</a>';
        }).join('') + '</div>';
      }
      html += '<div class="sr-grid">' + res.products.map(function (p) {
        return '<a class="sr-item" href="' + escapeHtml(p.url) + '"><img src="' + escapeHtml(p.image) + '" alt="" loading="lazy">' +
          '<span><span class="sr-cat d-block">' + escapeHtml(p.category || '') + '</span><span class="sr-name d-block">' + escapeHtml(p.name) + '</span>' +
          '<span class="sr-price">' + escapeHtml(p.price) + (p.regular ? ' <s class="text-muted-sa fw-normal">' + escapeHtml(p.regular) + '</s>' : '') + '</span></span></a>';
      }).join('') + '</div>';
      if (res.total > res.products.length) {
        html += '<div class="mt-4"><a class="link-arrow" href="' + SA.base + '/search?q=' + encodeURIComponent(q) + '">View all ' + res.total + ' results ' + iconSvg('arrow-right') + '</a></div>';
      }
      searchResults.innerHTML = html;
    });
  }, 220);
  if (searchInput) searchInput.addEventListener('input', runSearch);

  // ------------------------------------------------------------ cart drawer
  var drawerEl = $('#cartDrawer');
  var drawer = null;
  function getDrawer() {
    if (!drawer && drawerEl && window.bootstrap) drawer = bootstrap.Offcanvas.getOrCreateInstance(drawerEl);
    return drawer;
  }
  function renderMini(html) {
    var body = $('[data-mini-cart]');
    if (body && typeof html === 'string') body.innerHTML = html;
  }
  function loadMini() {
    return api('/api/cart').then(function (res) { if (res.ok) { renderMini(res.html); updateCounts(res); } });
  }
  function openCart(html) {
    if (html) renderMini(html); else loadMini();
    var d = getDrawer(); if (d) d.show();
  }
  SA.openCart = openCart;
  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-cart-open]')) { e.preventDefault(); openCart(); }
  });

  function addToCart(productId, variantId, qty, btn) {
    setLoading(btn, true);
    return api('/api/cart/add', { product_id: productId, variant_id: variantId || '', quantity: qty || 1 }).then(function (res) {
      setLoading(btn, false);
      if (!res.ok) { toast(res.message, 'error'); return res; }
      updateCounts(res);
      var qv = $('#quickView');
      if (qv && qv.classList.contains('show') && window.bootstrap) bootstrap.Modal.getInstance(qv).hide();
      openCart(res.html);
      return res;
    });
  }
  SA.addToCart = addToCart;

  document.addEventListener('click', function (e) {
    var add = e.target.closest('[data-add-to-cart]');
    if (add) { e.preventDefault(); addToCart(add.getAttribute('data-add-to-cart'), add.getAttribute('data-variant') || '', 1, add); }
  });

  // quantity widgets (generic)
  document.addEventListener('click', function (e) {
    var minus = e.target.closest('[data-qty-minus]');
    var plus = e.target.closest('[data-qty-plus]');
    if (!minus && !plus) return;
    var wrap = (minus || plus).closest('[data-qty]');
    var input = $('input', wrap);
    var min = parseInt(input.min || '1', 10), max = parseInt(input.max || '99', 10);
    var val = parseInt(input.value || '1', 10) + (plus ? 1 : -1);
    if (minus && val < min && input.hasAttribute('data-cart-qty')) { val = 0; }
    val = Math.min(Math.max(val, input.hasAttribute('data-cart-qty') ? 0 : min), max);
    input.value = val;
    input.dispatchEvent(new Event('change', { bubbles: true }));
  });

  // mini cart / cart page line updates
  function cartUpdate(itemId, qty, scope) {
    var fd = { item_id: itemId, quantity: qty, context: scope || 'drawer' };
    return api(qty > 0 ? '/api/cart/update' : '/api/cart/remove', fd).then(function (res) {
      if (!res.ok) toast(res.message, 'error');
      updateCounts(res);
      if (res.html) renderMini(res.html);
      if (res.page_html) {
        var page = $('[data-cart-page]');
        if (page) page.innerHTML = res.page_html;
      }
      return res;
    });
  }
  document.addEventListener('change', function (e) {
    var input = e.target.closest('[data-cart-qty]');
    if (!input) return;
    var scope = input.closest('[data-cart-page]') ? 'page' : 'drawer';
    cartUpdate(input.getAttribute('data-cart-qty'), parseInt(input.value || '0', 10), scope);
  });
  document.addEventListener('click', function (e) {
    var rm = e.target.closest('[data-cart-remove]');
    if (!rm) return;
    e.preventDefault();
    var scope = rm.closest('[data-cart-page]') ? 'page' : 'drawer';
    var row = rm.closest('[data-item]');
    if (row) row.style.opacity = '.4';
    cartUpdate(rm.getAttribute('data-cart-remove'), 0, scope).then(function (res) { if (res.ok) toast('Removed from your bag.'); });
  });

  // coupons (cart page + checkout)
  document.addEventListener('submit', function (e) {
    var form = e.target.closest('[data-coupon-form]');
    if (!form) return;
    e.preventDefault();
    var btn = $('button[type=submit]', form);
    setLoading(btn, true);
    var fd = new FormData(form);
    fd.append('context', form.getAttribute('data-context') || 'page');
    api('/api/cart/coupon', fd).then(function (res) {
      setLoading(btn, false);
      toast(res.message, res.ok ? 'success' : 'error');
      if (res.ok) refreshContext(form.getAttribute('data-context'), res);
    });
  });
  document.addEventListener('click', function (e) {
    var rm = e.target.closest('[data-coupon-remove]');
    if (!rm) return;
    e.preventDefault();
    var ctx = rm.getAttribute('data-coupon-remove');
    api('/api/cart/coupon/remove', { context: ctx }).then(function (res) {
      toast(res.message || 'Coupon removed.');
      refreshContext(ctx, res);
    });
  });
  function refreshContext(ctx, res) {
    if (ctx === 'checkout') { refreshCheckoutSummary(); return; }
    if (res.page_html) { var page = $('[data-cart-page]'); if (page) page.innerHTML = res.page_html; }
    if (res.html) renderMini(res.html);
  }

  // ------------------------------------------------------------ wishlist
  var authModalEl = $('#authRequired');
  function showAuthModal(productId) {
    if (!authModalEl || !window.bootstrap) { window.location = SA.base + '/login'; return; }
    var redirect = window.location.pathname.replace(new RegExp('^' + (new URL(SA.base + '/')).pathname.replace(/\/$/, '')), '') + window.location.search;
    $$('[data-auth-login], [data-auth-register]', authModalEl).forEach(function (a) {
      var u = new URL(a.href, window.location.origin);
      u.searchParams.set('redirect', redirect || '/');
      a.href = u.toString();
    });
    bootstrap.Modal.getOrCreateInstance(authModalEl).show();
  }
  document.addEventListener('click', function (e) {
    var gate = e.target.closest('[data-auth-required]');
    if (gate && !SA.loggedIn) { e.preventDefault(); showAuthModal(null); return; }
    var btn = e.target.closest('[data-wishlist]');
    if (!btn) return;
    e.preventDefault();
    var pid = btn.getAttribute('data-wishlist');
    api('/api/wishlist/toggle', { product_id: pid }).then(function (res) {
      if (res.status === 401 || res.auth === false) { showAuthModal(pid); return; }
      if (!res.ok) { toast(res.message, 'error'); return; }
      $$('[data-wishlist="' + pid + '"]').forEach(function (b) {
        b.classList.toggle('is-active', res.in_wishlist);
        b.setAttribute('aria-pressed', res.in_wishlist ? 'true' : 'false');
        b.setAttribute('aria-label', res.in_wishlist ? 'Remove from wishlist' : 'Add to wishlist');
        b.classList.remove('pop'); void b.offsetWidth; b.classList.add('pop');
        var label = $('[data-wish-label]', b); if (label) label.textContent = res.in_wishlist ? 'Saved to wishlist' : 'Add to wishlist';
      });
      updateCounts(res);
      toast(res.message, 'success', res.in_wishlist ? { href: SA.base + '/wishlist', label: 'View' } : null);
      var row = btn.closest('[data-wishlist-row]');
      if (row && !res.in_wishlist) { row.style.transition = 'opacity .4s'; row.style.opacity = '0'; setTimeout(function () { row.remove(); if (!$('[data-wishlist-row]')) window.location.reload(); }, 400); }
    });
  });

  // ------------------------------------------------------------ product form (product page + quick view)
  function initProductForm(form) {
    if (!form || form.__init) return;
    form.__init = true;
    var variants = [];
    try { variants = JSON.parse(form.getAttribute('data-variants') || '[]'); } catch (err) { variants = []; }
    var variantInput = $('[name=variant_id]', form);
    var qtyInput = $('[name=quantity]', form);
    var scope = form.closest('[data-product-scope]') || form;
    var baseStock = parseInt(form.getAttribute('data-base-stock') || '0', 10);

    function setStock(qty) {
      var el = $('[data-stock]', scope);
      var low = parseInt(form.getAttribute('data-low') || '5', 10);
      if (el) {
        if (qty <= 0) { el.className = 'stock-pill out'; el.innerHTML = 'Out of stock'; }
        else if (qty <= low) { el.className = 'stock-pill low'; el.innerHTML = 'Only ' + qty + ' left — order soon'; }
        else { el.className = 'stock-pill in'; el.innerHTML = 'In stock'; }
      }
      if (qtyInput) { qtyInput.max = Math.max(1, qty); if (parseInt(qtyInput.value, 10) > qty) qtyInput.value = Math.max(1, qty); }
      $$('[data-requires-stock]', form).forEach(function (b) { b.disabled = qty <= 0; });
    }
    function select(v, btn) {
      $$('[data-variant]', form).forEach(function (b) { b.classList.toggle('active', b === btn); b.setAttribute('aria-checked', b === btn ? 'true' : 'false'); });
      variantInput.value = v.id;
      var name = $('[data-variant-name]', form); if (name) name.textContent = v.name;
      var now = $('[data-price-now]', scope), old = $('[data-price-old]', scope), off = $('[data-price-off]', scope), wrap = $('[data-price]', scope);
      if (now) now.textContent = money(v.price);
      if (old) { old.textContent = v.regular > v.price ? money(v.regular) : ''; old.hidden = !(v.regular > v.price); }
      if (off) { off.textContent = v.off ? '-' + v.off + '%' : ''; off.hidden = !v.off; }
      if (wrap) wrap.classList.toggle('on-sale', v.regular > v.price);
      var sku = $('[data-sku]', scope); if (sku && v.sku) sku.textContent = v.sku;
      setStock(v.qty);
      if (v.image) {
        var main = $('[data-main-image]', scope);
        if (main) { main.src = v.image; main.removeAttribute('srcset'); var z = main.closest('[data-zoom]'); if (z) z.style.setProperty('--zoom-img', 'url("' + v.image + '")'); }
      }
    }
    $$('[data-variant]', form).forEach(function (btn) {
      btn.addEventListener('click', function () {
        var id = btn.getAttribute('data-variant');
        var v = variants.filter(function (x) { return String(x.id) === id; })[0];
        if (v) select(v, btn);
      });
    });
    if (!variants.length) setStock(baseStock);
    else {
      var preferred = $('[data-variant].active', form) || $$('[data-variant]', form).filter(function (b) { return !b.classList.contains('is-out'); })[0];
      if (preferred) preferred.click(); else setStock(0);
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var buyNow = e.submitter && e.submitter.hasAttribute('data-buy-now');
      if (variants.length && !variantInput.value) { toast('Please choose a ' + (form.getAttribute('data-variant-label') || 'option').toLowerCase() + '.', 'error'); return; }
      var btn = e.submitter || $('[type=submit]', form);
      if (buyNow) {
        setLoading(btn, true);
        api('/api/cart/add', { product_id: form.getAttribute('data-product-id'), variant_id: variantInput ? variantInput.value : '', quantity: qtyInput ? qtyInput.value : 1 }).then(function (res) {
          setLoading(btn, false);
          if (!res.ok) { toast(res.message, 'error'); return; }
          window.location = SA.base + '/checkout';
        });
        return;
      }
      addToCart(form.getAttribute('data-product-id'), variantInput ? variantInput.value : '', qtyInput ? qtyInput.value : 1, btn);
    });
  }
  SA.initProductForm = initProductForm;
  $$('[data-product-form]').forEach(initProductForm);

  // ------------------------------------------------------------ quick view
  var qvEl = $('#quickView');
  document.addEventListener('click', function (e) {
    var trigger = e.target.closest('[data-quick-view]');
    if (!trigger || !qvEl || !window.bootstrap) return;
    e.preventDefault();
    var body = $('[data-qv-body]', qvEl);
    body.innerHTML = '<div class="qv-loading"><div class="spinner"></div></div>';
    bootstrap.Modal.getOrCreateInstance(qvEl).show();
    api('/api/quick-view/' + trigger.getAttribute('data-quick-view')).then(function (res) {
      if (!res.ok) { body.innerHTML = '<div class="qv-loading">' + escapeHtml(res.message || 'Not available.') + '</div>'; return; }
      body.innerHTML = res.html;
      initProductForm($('[data-product-form]', body));
      initGallery(body);
    });
  });

  // ------------------------------------------------------------ gallery + zoom
  function initGallery(ctx) {
    $$('[data-gallery]', ctx).forEach(function (g) {
      if (g.__init) return; g.__init = true;
      var main = $('[data-main-image]', g);
      var zoom = $('[data-zoom]', g);
      $$('[data-thumb]', g).forEach(function (t) {
        t.addEventListener('click', function () {
          $$('[data-thumb]', g).forEach(function (x) { x.classList.toggle('active', x === t); });
          main.style.opacity = '0';
          setTimeout(function () {
            main.src = t.getAttribute('data-full');
            main.removeAttribute('srcset');
            if (zoom) zoom.style.setProperty('--zoom-img', 'url("' + t.getAttribute('data-full') + '")');
            main.style.opacity = '1';
          }, 180);
        });
      });
      if (zoom && window.matchMedia('(hover: hover)').matches) {
        zoom.style.setProperty('--zoom-img', 'url("' + (main.currentSrc || main.src) + '")');
        zoom.addEventListener('mousemove', function (ev) {
          var r = zoom.getBoundingClientRect();
          zoom.style.setProperty('--zx', ((ev.clientX - r.left) / r.width * 100) + '%');
          zoom.style.setProperty('--zy', ((ev.clientY - r.top) / r.height * 100) + '%');
        });
        zoom.addEventListener('mouseenter', function () { zoom.classList.add('is-zooming'); });
        zoom.addEventListener('mouseleave', function () { zoom.classList.remove('is-zooming'); });
      }
    });
  }
  initGallery(document);

  // product tabs (description / specs / reviews)
  $$('[data-tabs-nav]').forEach(function (nav) {
    var btns = $$('[data-tab-target]', nav);
    btns.forEach(function (b) {
      b.addEventListener('click', function () {
        btns.forEach(function (x) { x.classList.toggle('active', x === b); x.setAttribute('aria-selected', x === b ? 'true' : 'false'); });
        $$('[data-tab-panel]').forEach(function (p) { p.hidden = p.id !== b.getAttribute('data-tab-target'); });
      });
    });
  });
  document.addEventListener('click', function (e) {
    var j = e.target.closest('[data-jump-tab]');
    if (!j) return;
    var b = $('[data-tab-target="' + j.getAttribute('data-jump-tab') + '"]');
    if (b) { e.preventDefault(); b.click(); b.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
  });

  // ------------------------------------------------------------ hero slider
  $$('[data-hero]').forEach(function (hero) {
    var slides = $$('.hero-slide', hero), dots = $$('[data-hero-dot]', hero), count = $('[data-hero-count]', hero);
    if (slides.length < 2) return;
    var i = 0, timer = null, delay = 6500;
    hero.style.setProperty('--hero-delay', delay + 'ms');
    function go(n) {
      slides[i].classList.remove('is-active'); if (dots[i]) dots[i].classList.remove('is-active');
      i = (n + slides.length) % slides.length;
      slides[i].classList.add('is-active');
      if (dots[i]) { dots[i].classList.remove('is-active'); void dots[i].offsetWidth; dots[i].classList.add('is-active'); }
      hero.classList.toggle('on-cotton', slides[i].getAttribute('data-theme') === 'cotton');
      if (count) count.textContent = ('0' + (i + 1)).slice(-2) + ' / ' + ('0' + slides.length).slice(-2);
      restart();
    }
    function restart() { clearTimeout(timer); if (!reduceMotion) timer = setTimeout(function () { go(i + 1); }, delay); }
    dots.forEach(function (d) { d.addEventListener('click', function () { go(parseInt(d.getAttribute('data-hero-dot'), 10)); }); });
    var prev = $('[data-hero-prev]', hero), next = $('[data-hero-next]', hero);
    if (prev) prev.addEventListener('click', function () { go(i - 1); });
    if (next) next.addEventListener('click', function () { go(i + 1); });
    hero.addEventListener('mouseenter', function () { clearTimeout(timer); hero.classList.add('paused'); });
    hero.addEventListener('mouseleave', function () { hero.classList.remove('paused'); restart(); });
    var sx = null;
    hero.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
    hero.addEventListener('touchend', function (e) {
      if (sx === null) return;
      var dx = e.changedTouches[0].clientX - sx;
      if (Math.abs(dx) > 50) go(i + (dx < 0 ? 1 : -1));
      sx = null;
    });
    document.addEventListener('visibilitychange', function () { if (document.hidden) clearTimeout(timer); else restart(); });
    restart();
  });

  // ------------------------------------------------------------ horizontal tracks
  $$('[data-track-scope]').forEach(function (scope) {
    var track = $('[data-track]', scope);
    var prev = $('[data-track-prev]', scope), next = $('[data-track-next]', scope);
    if (!track) return;
    function step() { var c = track.firstElementChild; return c ? c.getBoundingClientRect().width + 24 : 300; }
    function sync() {
      if (prev) prev.disabled = track.scrollLeft < 8;
      if (next) next.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 8;
    }
    if (prev) prev.addEventListener('click', function () { track.scrollBy({ left: -step(), behavior: 'smooth' }); });
    if (next) next.addEventListener('click', function () { track.scrollBy({ left: step(), behavior: 'smooth' }); });
    track.addEventListener('scroll', debounce(sync, 60), { passive: true });
    window.addEventListener('resize', debounce(sync, 120));
    sync();
  });

  // ------------------------------------------------------------ best-seller tabs
  $$('[data-tabs]').forEach(function (tabs) {
    var grid = tabs.closest('.section').querySelector('[data-tab-grid]');
    var link = tabs.closest('.section').querySelector('[data-tab-link]');
    $$('[data-tab]', tabs).forEach(function (btn) {
      btn.addEventListener('click', function () {
        if (btn.classList.contains('active')) return;
        $$('[data-tab]', tabs).forEach(function (b) { b.classList.toggle('active', b === btn); b.setAttribute('aria-selected', b === btn ? 'true' : 'false'); });
        grid.classList.add('is-loading');
        var cat = btn.getAttribute('data-tab');
        api('/api/products/tab?category=' + encodeURIComponent(cat) + '&limit=' + (tabs.getAttribute('data-limit') || 8)).then(function (res) {
          grid.classList.remove('is-loading');
          if (res.ok) { grid.innerHTML = res.html; if (link && res.link) link.href = res.link; }
        });
      });
    });
  });

  // ------------------------------------------------------------ newsletter
  $$('[data-newsletter]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn = $('button[type=submit]', form), msg = form.parentNode.querySelector('[data-newsletter-msg]');
      setLoading(btn, true);
      api('/api/newsletter', new FormData(form)).then(function (res) {
        setLoading(btn, false);
        if (msg) msg.textContent = res.message || '';
        if (res.ok) form.reset();
      });
    });
  });

  // ------------------------------------------------------------ shop filters (AJAX)
  var shop = $('[data-shop]');
  if (shop) {
    var filterForm = $('[data-filter-form]');
    var grid = $('[data-shop-grid]', shop);
    var countEl = $('[data-shop-count]');
    var loadMore = $('[data-load-more]');
    var pager = $('[data-shop-pager]');
    var sortSel = $('[data-sort]');
    var basePath = shop.getAttribute('data-path');

    function params(page) {
      var fd = new FormData(filterForm);
      var p = new URLSearchParams();
      fd.forEach(function (v, k) { if (v !== '' && k !== '_token') p.append(k, v); });
      if (sortSel && sortSel.value && sortSel.value !== 'featured') p.set('sort', sortSel.value);
      if (page && page > 1) p.set('page', page);
      // drop price defaults
      var pmin = $('[name=min_price]', filterForm), pmax = $('[name=max_price]', filterForm);
      if (pmin && pmin.value === pmin.getAttribute('data-default')) p.delete('min_price');
      if (pmax && pmax.value === pmax.getAttribute('data-default')) p.delete('max_price');
      return p;
    }
    function load(page, append) {
      var p = params(page);
      var url = basePath + (p.toString() ? '?' + p.toString() : '');
      if (!append) grid.classList.add('is-loading');
      if (loadMore) setLoading(loadMore, append);
      return api(url).then(function (res) {
        grid.classList.remove('is-loading');
        if (loadMore) setLoading(loadMore, false);
        if (!res.ok) { toast(res.message, 'error'); return; }
        if (append) grid.insertAdjacentHTML('beforeend', res.html); else grid.innerHTML = res.html;
        if (countEl) countEl.textContent = res.count_label;
        if (pager) pager.innerHTML = res.pager;
        if (loadMore) { loadMore.hidden = !res.has_more; loadMore.setAttribute('data-next', res.next_page); }
        var chips = $('[data-active-filters]'); if (chips) chips.innerHTML = res.chips;
        history.replaceState(null, '', url);
        if (!append) { var top = shop.getBoundingClientRect().top + window.scrollY - 160; if (window.scrollY > top) window.scrollTo({ top: top, behavior: 'smooth' }); }
      });
    }
    if (filterForm) {
      filterForm.addEventListener('change', debounce(function (e) {
        if (e.target.matches('[name=category]')) {
          $$('[name="sub[]"]', filterForm).forEach(function (s) { if (s.getAttribute('data-cat') !== e.target.value) s.checked = false; });
          $$('[data-sub-group]', filterForm).forEach(function (g) { g.hidden = e.target.value !== '' && g.getAttribute('data-sub-group') !== e.target.value; });
        }
        load(1, false);
      }, 250));
      filterForm.addEventListener('submit', function (e) { e.preventDefault(); load(1, false); });
      var priceMin = $('[name=min_price]', filterForm), priceMax = $('[name=max_price]', filterForm);
      var rangeMin = $('[data-range-min]', filterForm), rangeMax = $('[data-range-max]', filterForm);
      var out = $('[data-price-out]', filterForm), fill = $('[data-range-fill]', filterForm);
      function syncRange(src) {
        if (!rangeMin) return;
        var a = parseInt(rangeMin.value, 10), b = parseInt(rangeMax.value, 10);
        if (a > b) { if (src === rangeMin) rangeMin.value = a = b; else rangeMax.value = b = a; }
        priceMin.value = a; priceMax.value = b;
        var lo = parseInt(rangeMin.min, 10), hi = parseInt(rangeMin.max, 10);
        if (fill) { fill.style.left = ((a - lo) / (hi - lo) * 100) + '%'; fill.style.right = (100 - (b - lo) / (hi - lo) * 100) + '%'; }
        if (out) out.textContent = money(a) + ' — ' + money(b);
      }
      if (rangeMin) {
        [rangeMin, rangeMax].forEach(function (r) {
          r.addEventListener('input', function () { syncRange(r); });
          r.addEventListener('change', function () { priceMin.dispatchEvent(new Event('change', { bubbles: true })); });
        });
        syncRange();
      }
    }
    if (sortSel) sortSel.addEventListener('change', function () { load(1, false); });
    if (loadMore) loadMore.addEventListener('click', function () { load(parseInt(loadMore.getAttribute('data-next'), 10), true); });
    document.addEventListener('click', function (e) {
      var pg = e.target.closest('[data-shop-pager] a[data-page]');
      if (pg) { e.preventDefault(); load(parseInt(pg.getAttribute('data-page'), 10), false); }
      var clear = e.target.closest('[data-clear-filter]');
      if (clear && filterForm) {
        e.preventDefault();
        var name = clear.getAttribute('data-clear-filter');
        if (name === 'all') { $$('input[type=checkbox]', filterForm).forEach(function (c) { c.checked = false; }); var all = $('[name=category][value=""]', filterForm); if (all) all.checked = true; var qq = $('[name=q]', filterForm); if (qq) qq.value = ''; if (rangeMin) { rangeMin.value = rangeMin.min; rangeMax.value = rangeMax.max; syncRange(); } }
        else if (name === 'price' && rangeMin) { rangeMin.value = rangeMin.min; rangeMax.value = rangeMax.max; syncRange(); }
        else if (name === 'category') { var any = $('[name=category][value=""]', filterForm); if (any) any.checked = true; }
        else if (name === 'q') { var qi = $('[name=q]', filterForm); if (qi) qi.value = ''; }
        else { $$('[name="' + name + '"], [name="' + name + '[]"]', filterForm).forEach(function (c) { if (c.type === 'checkbox') { if (!clear.getAttribute('data-value') || c.value === clear.getAttribute('data-value')) c.checked = false; } }); }
        load(1, false);
      }
    });
  }

  // ------------------------------------------------------------ checkout
  var checkout = $('[data-checkout]');
  function refreshCheckoutSummary() {
    var summary = $('[data-checkout-summary]');
    if (!summary) return;
    var pm = $('[name=payment_method]:checked');
    api('/api/checkout/summary?payment_method=' + encodeURIComponent(pm ? pm.value : '')).then(function (res) {
      if (res.ok) summary.innerHTML = res.html;
      if (res.empty) window.location = SA.base + '/cart';
    });
  }
  if (checkout) {
    var sameBox = $('[name=billing_same]', checkout);
    var billing = $('[data-billing-fields]', checkout);
    function toggleBilling() {
      if (!billing) return;
      billing.hidden = sameBox.checked;
      $$('[data-billing-required]', billing).forEach(function (i) { i.required = !sameBox.checked; });
    }
    if (sameBox) { sameBox.addEventListener('change', toggleBilling); toggleBilling(); }
    $$('[name=payment_method]', checkout).forEach(function (r) { r.addEventListener('change', refreshCheckoutSummary); });
    var savedSelect = $('[data-saved-address]', checkout);
    if (savedSelect) {
      savedSelect.addEventListener('change', function () {
        var opt = savedSelect.options[savedSelect.selectedIndex];
        if (!opt.value) return;
        var a = JSON.parse(opt.getAttribute('data-address'));
        Object.keys(a).forEach(function (k) { var f = $('[name=shipping_' + k + ']', checkout); if (f) f.value = a[k] || ''; });
      });
    }
    checkout.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!checkout.checkValidity()) { checkout.classList.add('was-validated'); var bad = $(':invalid', checkout); if (bad) bad.focus(); toast('Please complete the highlighted fields.', 'error'); return; }
      var btn = $('[data-place-order]');
      setLoading(btn, true);
      api(checkout.getAttribute('action'), new FormData(checkout)).then(function (res) {
        if (!res.ok) {
          setLoading(btn, false);
          toast(res.message, 'error');
          if (res.errors) {
            Object.keys(res.errors).forEach(function (k) {
              var f = $('[name=' + k + ']', checkout);
              if (f) { f.classList.add('is-invalid'); var fb = f.parentNode.querySelector('.invalid-feedback'); if (fb) fb.textContent = res.errors[k]; }
            });
            var first = $('.is-invalid', checkout); if (first) first.focus();
          }
          if (res.refresh) refreshCheckoutSummary();
          return;
        }
        if (res.razorpay) { payWithRazorpay(res.razorpay, btn); return; }
        window.location = res.redirect;
      });
    });
    checkout.addEventListener('input', function (e) { if (e.target.classList.contains('is-invalid')) e.target.classList.remove('is-invalid'); });
  }

  function loadScript(src) {
    return new Promise(function (resolve, reject) {
      if (window.Razorpay) return resolve();
      var s = document.createElement('script'); s.src = src; s.onload = resolve; s.onerror = reject; document.head.appendChild(s);
    });
  }
  function payWithRazorpay(rz, btn) {
    loadScript('https://checkout.razorpay.com/v1/checkout.js').then(function () {
      var opts = rz.options;
      opts.handler = function (resp) {
        api('/api/payment/razorpay/verify', {
          order_number: rz.order_number,
          razorpay_order_id: resp.razorpay_order_id,
          razorpay_payment_id: resp.razorpay_payment_id,
          razorpay_signature: resp.razorpay_signature
        }).then(function (res) {
          if (res.ok) window.location = res.redirect;
          else { setLoading(btn, false); toast(res.message, 'error'); }
        });
      };
      opts.modal = { ondismiss: function () {
        setLoading(btn, false);
        api('/api/payment/razorpay/failed', { order_number: rz.order_number, reason: 'dismissed' });
        toast('Payment was cancelled. You can try again — your bag is saved.', 'error');
      } };
      var rp = new window.Razorpay(opts);
      rp.on('payment.failed', function (resp) {
        api('/api/payment/razorpay/failed', { order_number: rz.order_number, reason: (resp.error && resp.error.description) || 'failed' });
      });
      rp.open();
    }).catch(function () { setLoading(btn, false); toast('Could not load the payment window. Please check your connection.', 'error'); });
  }
  SA.payWithRazorpay = payWithRazorpay;

  // retry payment button (order page)
  document.addEventListener('click', function (e) {
    var b = e.target.closest('[data-retry-payment]');
    if (!b) return;
    e.preventDefault();
    setLoading(b, true);
    api('/api/payment/razorpay/retry', { order_number: b.getAttribute('data-retry-payment'), key: b.getAttribute('data-key') || '' }).then(function (res) {
      if (!res.ok) { setLoading(b, false); toast(res.message, 'error'); return; }
      payWithRazorpay(res.razorpay, b);
    });
  });

  // ------------------------------------------------------------ confirmations & misc
  document.addEventListener('submit', function (e) {
    var f = e.target.closest('[data-confirm]');
    if (f && !window.confirm(f.getAttribute('data-confirm'))) e.preventDefault();
  });
  $$('[data-password-toggle]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var input = btn.parentNode.querySelector('input');
      input.type = input.type === 'password' ? 'text' : 'password';
      btn.setAttribute('aria-pressed', input.type === 'text' ? 'true' : 'false');
    });
  });

  // ------------------------------------------------------------ review photos
  $$('[data-photo-drop] input[type=file]').forEach(function (input) {
    input.addEventListener('change', function () {
      var max = parseInt(input.getAttribute('data-max') || '3', 10);
      var box = input.closest('[data-photo-drop]').querySelector('[data-photo-previews]');
      box.innerHTML = '';
      if (input.files.length > max) { toast('You can add up to ' + max + ' photos.', 'error'); input.value = ''; return; }
      Array.prototype.forEach.call(input.files, function (f) {
        if (f.size > 5 * 1024 * 1024) { toast(f.name + ' is larger than 5 MB.', 'error'); return; }
        var reader = new FileReader();
        reader.onload = function () { var i = document.createElement('img'); i.src = reader.result; i.alt = ''; box.appendChild(i); };
        reader.readAsDataURL(f);
      });
    });
  });
  document.addEventListener('click', function (e) {
    var a = e.target.closest('[data-review-photo]');
    var modal = $('#photoModal');
    if (!a || !modal || !window.bootstrap) return;
    e.preventDefault();
    $('[data-photo-full]', modal).src = a.getAttribute('href');
    bootstrap.Modal.getOrCreateInstance(modal).show();
  });

  // ------------------------------------------------------------ reveal on scroll
  var revealEls = $$('[data-reveal]');
  if ('IntersectionObserver' in window && !reduceMotion) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-visible'); io.unobserve(en.target); } });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-visible'); });
  }

  // lazily load mini cart once the drawer is first opened via Bootstrap toggles
  if (drawerEl) drawerEl.addEventListener('show.bs.offcanvas', function () { if ($('[data-mini-cart] .qv-loading')) loadMini(); });
})();
