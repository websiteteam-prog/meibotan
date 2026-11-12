/* AF Prestige Roofing: small progressive enhancements. The site works without JavaScript. */
(function () {
  'use strict';

  document.documentElement.classList.add('js');

  // Mobile navigation -------------------------------------------------------
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('main-nav');

  function setNav(open) {
    toggle.setAttribute('aria-expanded', String(open));
    document.body.classList.toggle('nav-open', open);
  }

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      setNav(toggle.getAttribute('aria-expanded') !== 'true');
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && document.body.classList.contains('nav-open')) {
        setNav(false);
        toggle.focus();
      }
    });
    window.matchMedia('(min-width: 1140px)').addEventListener('change', function (mq) {
      if (!mq.matches) return;
      setNav(false);
      document.querySelectorAll('.sub-toggle[aria-expanded="true"]').forEach(function (btn) { btn.click(); });
    });
  }

  document.querySelectorAll('.sub-toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var open = btn.getAttribute('aria-expanded') !== 'true';
      btn.setAttribute('aria-expanded', String(open));
      btn.closest('.has-sub').classList.toggle('is-open', open);
    });
  });

  // Header shadow once the page scrolls --------------------------------------
  var header = document.querySelector('.site-header');
  if (header) {
    var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 8); };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  // Before / after sliders --------------------------------------------------------
  document.querySelectorAll('.ba__range').forEach(function (range) {
    var frame = range.closest('.ba');
    var update = function () { frame.style.setProperty('--pos', range.value + '%'); };
    range.addEventListener('input', update);
    update();
  });

  // Back-to-top button (bottom right) ------------------------------------------------
  var toTop = document.querySelector('[data-to-top]');
  if (toTop) {
    var toggleTop = function () { toTop.classList.toggle('is-visible', window.scrollY > 500); };
    toggleTop();
    window.addEventListener('scroll', toggleTop, { passive: true });
    toTop.addEventListener('click', function () {
      var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
    });
  }

  // Gallery filters ----------------------------------------------------------------
  var filters = document.querySelector('[data-gallery-filters]');
  if (filters) {
    var items = document.querySelectorAll('[data-gallery-item]');
    var empty = document.querySelector('[data-gallery-empty]');
    filters.addEventListener('click', function (e) {
      var btn = e.target.closest('button[data-filter]');
      if (!btn) return;
      var filter = btn.getAttribute('data-filter');
      var shown = 0;
      filters.querySelectorAll('button').forEach(function (b) { b.setAttribute('aria-pressed', String(b === btn)); });
      items.forEach(function (item) {
        var match = filter === 'all' || item.getAttribute('data-tags').split(' ').indexOf(filter) !== -1;
        item.hidden = !match;
        if (match) shown++;
      });
      if (empty) empty.hidden = shown > 0;
    });
  }

  // Reveal-on-scroll animation -------------------------------------------------------
  var reveals = document.querySelectorAll('[data-reveal]');
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if ('IntersectionObserver' in window && !reduceMotion) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -8% 0px' });
    reveals.forEach(function (el) { io.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('is-visible'); });
  }

  // Enquiry forms: inline validation and submission without a page reload ----------
  function fieldError(form, input) {
    return form.querySelector('#' + input.id + '-error');
  }

  function showError(form, input, message) {
    var el = fieldError(form, input);
    input.setAttribute('aria-invalid', 'true');
    if (el) {
      el.textContent = message;
      el.hidden = false;
      input.setAttribute('aria-describedby', el.id);
    }
  }

  function clearError(form, input) {
    var el = fieldError(form, input);
    input.removeAttribute('aria-invalid');
    input.removeAttribute('aria-describedby');
    if (el) { el.textContent = ''; el.hidden = true; }
  }

  document.querySelectorAll('form[data-enquiry-form]').forEach(function (form) {
    var status = form.querySelector('.form-status');
    var submit = form.querySelector('[type="submit"]');
    var fields = Array.prototype.filter.call(form.elements, function (el) {
      return el.id && el.name && el.name !== 'website' && el.type !== 'hidden';
    });

    form.noValidate = true;

    fields.forEach(function (input) {
      input.addEventListener('input', function () {
        if (input.getAttribute('aria-invalid') === 'true' && input.checkValidity()) clearError(form, input);
      });
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var firstInvalid = null;
      fields.forEach(function (input) {
        if (input.checkValidity()) {
          clearError(form, input);
        } else {
          showError(form, input, input.getAttribute('data-error') || input.validationMessage);
          firstInvalid = firstInvalid || input;
        }
      });
      if (firstInvalid) {
        status.textContent = 'Please check the highlighted fields.';
        status.className = 'form-status is-error';
        firstInvalid.focus();
        return;
      }

      submit.disabled = true;
      submit.classList.add('is-loading');
      status.textContent = 'Sending your request…';
      status.className = 'form-status';

      fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
      })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (data.ok) {
            status.textContent = data.message || 'Thanks! Your request has been sent.';
            status.className = 'form-status is-success';
            if (window.gtag) window.gtag('event', 'generate_lead', { form_id: form.id });
            if (data.redirect) window.location.href = data.redirect;
            return;
          }
          var first = null;
          Object.keys(data.errors || {}).forEach(function (name) {
            var input = form.querySelector('[name="' + name + '"]');
            if (input && input.id) {
              showError(form, input, data.errors[name]);
              first = first || input;
            }
          });
          status.textContent = data.message || 'Please check the highlighted fields.';
          status.className = 'form-status is-error';
          if (first) first.focus();
        })
        .catch(function () {
          status.textContent = 'Sorry, something went wrong sending your request. Please call us instead.';
          status.className = 'form-status is-error';
        })
        .finally(function () {
          submit.disabled = false;
          submit.classList.remove('is-loading');
        });
    });
  });
})();
