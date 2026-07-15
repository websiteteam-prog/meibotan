<?php $commfrontfunc = service('commfrontfunc'); ?>
<?php
// ---------------------------------------------------------------------------
// FRONTEND-ONLY category hiding (same list as header). DB untouched.
// Kisi aur category ko hide karna ho to niche list me naam/slug add kar do.
// ---------------------------------------------------------------------------
$HIDDEN_FRONT_CATEGORIES = ['gummies'];
$isHiddenFrontCategory = function ($cat) use ($HIDDEN_FRONT_CATEGORIES) {
    $name = strtolower(trim($cat->category_name ?? ''));
    $slug = strtolower(trim($cat->category_slug ?? ''));
    return in_array($name, $HIDDEN_FRONT_CATEGORIES, true)
        || in_array($slug, $HIDDEN_FRONT_CATEGORIES, true);
};
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>
        <?php if (isset($metadata['page_title'])) {
            echo $metadata['page_title'];
        } ?>
    </title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="Ankush Sharma" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>/assets/frontend/images/favicon.png" />
    <script>
        WebFontConfig = {
            google: {
                families: ["Open+Sans:300,400,600,700,800", "Poppins:300,400,500,600,700,800", "Oswald:300,400,500,600,700,800"],
            },
        };
        (function (d) {
            var wf = d.createElement("script"),
                s = d.scripts[0];
            wf.src = "<?php echo base_url(); ?>/assets/frontend/js/webfont.js";
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>/assets/frontend/vendor/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/css/style.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/demo4.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/css/custom.css" />

    <style type="text/css">
        body {
            background-color: #fff;
        }

        /* =========================================
       SHOP HERO
       ========================================= */
        .shop-hero {
            position: relative;
            padding: 46px 0;
            text-align: center;
            overflow: hidden;
            background: #ebf7f7;
        }

        .shop-hero h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 30px;
            font-weight: 600;
            color: #0F766E;
            margin: 10px 0 0;
        }

        .shop-breadcrumb-nav {
            background: transparent;
            border: none;
            padding: 0;
        }

        .shop-breadcrumb-nav .breadcrumb {
            justify-content: center;
            background: transparent;
            margin: 0;
            padding: 0;
        }

        .shop-breadcrumb-nav .breadcrumb-item,
        .shop-breadcrumb-nav .breadcrumb-item a {
            color: rgb(111 110 110 / 84%);
            font-size: 13px;
        }

        .shop-breadcrumb-nav .breadcrumb-item.active {
            color: #F59E0B;
            font-weight: 600;
        }

        .shop-breadcrumb-nav .breadcrumb-item+.breadcrumb-item::before {
            color: rgb(111 110 110 / 84%);
            content: "/";
        }

        @media(max-width:767px) {
            .shop-hero {
                padding: 34px 0;
            }

            .shop-hero h1 {
                font-size: 22px;
            }
        }

        /* =========================================
       SHOP LISTING SECTION
       ========================================= */
        .shop-section {
            padding: 45px 0 65px;
            background: #F8FAFC;
        }

        .shop-empty {
            color: #6B7280;
            font-size: 14px;
            padding: 20px 0;
        }

        /* -- product card -- */
        .shop-card {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 18px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            margin-bottom: 24px;
            border-color: rgba(20, 184, 166, .5);
        }

        /* -- equal height cards (content kam/zyada ho, height same) -- */
        .shop-grid>[class*="col-"] {
            display: flex;
            flex-direction: column;
        }

        .shop-grid>[class*="col-"]>form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            width: 100%;
            margin: 0;
        }

        .shop-grid .shop-card {
            flex: 1 1 auto;
            height: auto;
        }

        .shop-card-media {
            position: relative;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            background: #F8FAFC;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .shop-card-media img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .shop-badges {
            position: absolute;
            top: 12px;
            left: 12px;
            display: flex;
            gap: 6px;
            z-index: 2;
        }

        .shop-badge-hot,
        .shop-badge-off {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .shop-badge-hot {
            background: #0F766E;
            color: #fff;
        }

        .shop-badge-off {
            background: #F59E0B;
            color: #1F2937;
        }

        .shop-wish {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid #E2E8F0;
            color: #6B7280;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
            text-decoration: none !important;
            box-shadow: 0 4px 10px rgba(15, 118, 110, .1);
            transition: all .25s ease;
        }

        .shop-wish:hover {
            background: #0F766E;
            border-color: #0F766E;
            color: #fff;
            transform: scale(1.08);
        }

        .shop-wish.active {
            background: #0F766E;
            border-color: #0F766E;
            color: #fff;
        }

        .shop-wish.loading {
            opacity: .6;
            pointer-events: none;
        }

        .shop-card-body {
            padding: 16px 16px 18px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .shop-cat-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 8px;
        }

        .shop-category-tag {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .03em;
            color: #0F766E;
            background: #E6F7F4;
            border: 1px solid rgba(15, 118, 110, .18);
            padding: 3px 10px;
            border-radius: 20px;
            text-decoration: none !important;
        }

        .shop-category-tag:hover {
            background: #0F766E;
            color: #fff !important;
        }

        .shop-card-title {
            font-size: 14.5px;
            font-weight: 600;
            color: #1F2937;
            line-height: 1.4;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 40px;
        }

        .shop-card-title a {
            color: inherit;
            text-decoration: none;
            transition: color .2s ease;
        }

        .shop-card-title a:hover {
            color: #0F766E;
        }

        .shop-price-box {
            margin-bottom: 14px;
        }

        .shop-price-box .old-price {
            font-size: 12.5px;
            color: #6B7280;
            text-decoration: line-through;
            margin-right: 6px;
        }

        .shop-price-box .new-price {
            font-size: 18px;
            font-weight: 700;
            color: #0F766E;
        }

        .shop-addcart {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            background: #F59E0B;
            border: none;
            color: #fff;
            font-size: 13.5px;
            font-weight: 600;
            padding: 11px 0;
            border-radius: 30px;
            margin-top: auto;
            transition: all .25s ease;
        }

        .shop-addcart:hover {
            background: #0F766E;
            box-shadow: 0 8px 20px rgba(15, 118, 110, .3);
        }

        @media(max-width:767px) {
            .shop-section {
                padding: 30px 0 45px;
            }

            .shop-card-title {
                font-size: 13px;
                min-height: 36px;
            }

            .shop-price-box .new-price {
                font-size: 16px;
            }
        }

        /* -- pager (sirf Previous / Next arrows) -- */
        .shop-pager-wrap {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .shop-pager-wrap ul {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 12px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* round arrow buttons (enabled) */
        .shop-pager-wrap li.pg-arrow a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border: 1px solid #E2E8F0;
            border-radius: 50%;
            background: #fff;
            color: #0F766E;
            font-size: 13px;
            text-decoration: none !important;
            transition: all .2s ease;
        }

        .shop-pager-wrap li.pg-arrow a:hover {
            border-color: #0F766E;
            background: #0F766E;
            color: #fff;
        }

        .shop-pager-wrap li.pg-arrow a i {
            font-size: 13px;
        }

        /* round arrow buttons (disabled — icon dikhega par click nahi) */
        .shop-pager-wrap li.pg-arrow.pg-disabled span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border: 1px solid #E2E8F0;
            border-radius: 50%;
            background: #F1F5F9;
            color: #CBD5E1;
            font-size: 13px;
            cursor: not-allowed;
            pointer-events: none;
            opacity: 1;
        }

        .shop-pager-wrap li.pg-arrow.pg-disabled span i {
            font-size: 13px;
        }

        /* -- toast -- */
        .mb-toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: #0F766E;
            color: #fff;
            padding: 12px 24px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            z-index: 999999;
            opacity: 0;
            transition: all .3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
            white-space: nowrap;
            max-width: 92vw;
        }

        .mb-toast i {
            margin-right: 6px;
        }

        .mb-toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .mb-toast.err {
            background: #B91C1C;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <?= $this->include('frontend/partials/header') ?>
        <main class="main">

            <!-- SHOP HERO -->
            <section class="shop-hero">
                <div class="container">
                    <nav aria-label="breadcrumb" class="shop-breadcrumb-nav">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shop</li>
                        </ol>
                    </nav>
                    <h1>Shop</h1>
                </div>
            </section>

            <section class="shop-section">
                <div class="container">

                    <?php if (session()->getFlashdata('success_msg')) { ?>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('success_msg'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (session()->getFlashdata('warning_msg')) { ?>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('warning_msg'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row shop-grid">
                        <?php
                        $shown_count = 0; // kitne product actually dikhaye (gummies skip ke baad)
                        if (count($productdata) > 0) {
                            foreach ($productdata as $productrow) {
                                $product_category = $productrow->product_category;
                                $catar = explode(",", $product_category);

                                // Frontend-only: agar product ki kisi bhi category me gummies hai to poora product skip
                                $hide_product = false;
                                foreach ($catar as $chk_cid) {
                                    $chk_crow = $commfrontfunc->getPerCategory($chk_cid);
                                    if ($chk_crow && $isHiddenFrontCategory($chk_crow)) {
                                        $hide_product = true;
                                        break;
                                    }
                                }
                                if ($hide_product) {
                                    continue;
                                }
                                $shown_count++;

                                $current_url = current_url();
                                $sale_tag = "";
                                $discount_percent = "";
                                $product_price = $productrow->product_price;
                                $product_saleprice = $productrow->product_saleprice;
                                $product_slug = $productrow->product_slug;

                                if ($product_saleprice != "") {
                                    $mathfunc = service('mathfunc');
                                    $discount_percent = $mathfunc->getDiscountPercentage($product_price, $product_saleprice);
                                }
                                $pro_img = "";
                                $product_thumb = $productrow->product_thumb;
                                if ($product_thumb != "") {
                                    $pro_img = CUSTOM_UPLOAD_PATH . $product_thumb;
                                } else {
                                    $pro_img = DEFAULT_PRODUCTIMG;
                                }
                                $pro_link = site_url("product/$product_slug");
                                ?>
                                <div class="col-12 col-sm-3">
                                    <?php echo form_open('cart/addtocart'); ?>
                                    <?php echo form_hidden('product_id', $productrow->product_id); ?>
                                    <?php echo form_hidden('back_url', $current_url); ?>
                                    <div class="shop-card">
                                        <div class="shop-card-media">
                                            <?php if ($discount_percent > 0) { ?>
                                                <div class="shop-badges">
                                                    <span class="shop-badge-hot">Sale</span>
                                                    <span class="shop-badge-off">-<?php echo $discount_percent; ?>%</span>
                                                </div>
                                            <?php } ?>
                                            <a href="javascript:;" class="shop-wish"
                                                data-pid="<?php echo $productrow->product_id; ?>" title="Add to Wishlist">
                                                <i class="far fa-heart"></i>
                                            </a>
                                            <a href="<?php echo $pro_link; ?>">
                                                <img src="<?php echo $pro_img; ?>"
                                                    alt="<?php echo $productrow->product_name; ?>">
                                            </a>
                                        </div><!-- End .shop-card-media -->

                                        <div class="shop-card-body">
                                            <div class="shop-cat-tags">
                                                <?php foreach ($catar as $cat_id) {
                                                    $catrow = $commfrontfunc->getPerCategory($cat_id);
                                                    // gummies jaisi hidden category ka tag mat dikhao
                                                    if ($catrow && !$isHiddenFrontCategory($catrow)) {
                                                        $cat_slug = $catrow->category_slug;
                                                        ?>
                                                        <a href="<?php echo site_url("product-category/$cat_slug"); ?>"
                                                            class="shop-category-tag"><?php echo $catrow->category_name; ?></a>
                                                    <?php }
                                                } ?>
                                            </div>

                                            <h3 class="shop-card-title"><a
                                                    href="<?php echo $pro_link; ?>"><?php echo $productrow->product_name; ?></a>
                                            </h3>

                                            <div class="shop-price-box">
                                                <?php if ($discount_percent > 0) { ?>
                                                    <span class="old-price">₹<?php echo $product_price; ?></span>
                                                    <span class="new-price">₹<?php echo $product_saleprice; ?></span>
                                                <?php } else { ?>
                                                    <span class="new-price">₹<?php echo $product_price; ?></span>
                                                <?php } ?>
                                            </div>

                                            <button type="submit" name="btn_cart" class="shop-addcart" title="Add to Cart"><i
                                                    class="icon-shopping-cart"></i> Add to Cart</button>
                                        </div><!-- End .shop-card-body -->
                                    </div><!-- End .shop-card -->
                                    <?php echo form_close(); ?>
                                </div>
                            <?php }
                        }
                        if ($shown_count === 0) { ?>
                            <div class="col-md-12">
                                <p class="shop-empty">No product found please try again</p>
                            </div>
                        <?php } ?>
                    </div><!-- End .row -->

                    <?php
                    // Pager tabhi dikhao jab 1 se zyada page ho.
                    // (Sirf "page=2" check karna galat tha — deep/last page par pager gayab ho jata tha.
                    //  Ye regex kisi bhi page>=2 ke link ko match karta hai, to har multipage case par pager aata hai.)
                    if (preg_match('/page=(?:[2-9]|\d{2,})/', $pager_links)) { ?>
                        <div class="shop-pager-wrap">
                            <?php echo $pager_links ?>
                        </div>
                    <?php } ?>

                </div><!-- End .container -->
            </section>
        </main>
        <?= $this->include('frontend/partials/footer') ?>
        <script>
            // =========================================================================
            // PAGER: hamesha DO arrows dikhao — left (Previous) aur right (Next).
            //  - Page 1 par left DISABLED (icon dikhega par click nahi hoga).
            //  - Page 2+ par left WORKING ho jayega.
            //  - Last page par right (Next) DISABLED.
            //
            //  CodeIgniter ka default pager page 1 par "Previous" render hi nahi karta
            //  (aur last page par "Next" nahi), isliye purana JS page 1 par left arrow
            //  dikha hi nahi paata tha. Ab hum pager ko current page se khud rebuild
            //  karte hain taaki dono arrows hamesha maujood rahein.
            // =========================================================================
            (function () {
                var wrap = document.querySelector('.shop-pager-wrap');
                if (!wrap) return;
                var ul = wrap.querySelector('ul');
                if (!ul) { wrap.style.display = 'none'; return; }

                function pageOf(str) {
                    if (!str) return null;
                    var m = str.match(/[?&]page=(\d+)/);
                    return m ? parseInt(m[1], 10) : null;
                }

                var prevHref = null, nextHref = null, templateHref = null, maxNum = 0, activeNum = null;

                Array.prototype.forEach.call(ul.querySelectorAll('li'), function (li) {
                    var a = li.querySelector('a');
                    var href = a ? a.getAttribute('href') : null;
                    var label = (a ? a.textContent : li.textContent).trim().toLowerCase();

                    // koi bhi href jisme page=N ho use ek template ki tarah rakh lo
                    if (href && /[?&]page=\d+/.test(href)) templateHref = href;

                    if (label === 'previous') {
                        prevHref = href;
                    } else if (label === 'next') {
                        nextHref = href;
                    } else if (label === 'first' || label === 'last') {
                        // ignore — humein sirf prev/next chahiye
                    } else {
                        var n = parseInt(label, 10);
                        if (!isNaN(n)) {
                            if (n > maxNum) maxNum = n;
                            if (li.classList.contains('active') || !href) activeNum = n;
                        }
                    }
                });

                // current page: URL se, warna active number, warna 1
                var current = pageOf(window.location.search) || activeNum || 1;

                // kisi bhi page number ka URL banao (template ka number swap karke)
                function hrefForPage(n) {
                    if (templateHref && /[?&]page=\d+/.test(templateHref)) {
                        return templateHref.replace(/([?&]page=)\d+/, '$1' + n);
                    }
                    if (/[?&]page=\d+/.test(window.location.search)) {
                        return (window.location.pathname + window.location.search)
                            .replace(/([?&]page=)\d+/, '$1' + n);
                    }
                    var sep = window.location.search ? '&' : '?';
                    return window.location.pathname + window.location.search + sep + 'page=' + n;
                }

                var hasPrev = current > 1;
                // next tab hai jab server ne Next diya ho, ya koi numbered link current se bada ho
                var hasNext = !!nextHref || (maxNum > current);

                // sirf ek hi page hai to pura pager hata do
                if (!hasPrev && !hasNext) { wrap.style.display = 'none'; return; }

                var prevUrl = prevHref || (hasPrev ? hrefForPage(current - 1) : null);
                var nextUrl = nextHref || (hasNext ? hrefForPage(current + 1) : null);

                function makeArrow(dir, url, enabled) {
                    var li = document.createElement('li');
                    li.className = 'pg-arrow' + (enabled ? '' : ' pg-disabled');
                    var icon = (dir === 'prev') ? 'fa-chevron-left' : 'fa-chevron-right';
                    var lbl = (dir === 'prev') ? 'Previous' : 'Next';
                    if (enabled && url) {
                        var a = document.createElement('a');
                        a.setAttribute('href', url);
                        a.setAttribute('aria-label', lbl);
                        a.innerHTML = '<i class="fas ' + icon + '"></i>';
                        li.appendChild(a);
                    } else {
                        var span = document.createElement('span');
                        span.setAttribute('aria-disabled', 'true');
                        span.setAttribute('title', lbl);
                        span.innerHTML = '<i class="fas ' + icon + '"></i>';
                        li.appendChild(span);
                    }
                    return li;
                }

                // ul ko sirf do arrows se dobara banao
                ul.innerHTML = '';
                ul.appendChild(makeArrow('prev', prevUrl, hasPrev));
                ul.appendChild(makeArrow('next', nextUrl, hasNext));
            })();

            var MB_AJAX = "<?= rtrim(site_url('ajaxcart'), '/'); ?>";

            function mbToast(msg, ok) {
                var t = document.createElement('div');
                t.className = 'mb-toast' + (ok ? '' : ' err');
                t.innerHTML = (ok ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-exclamation-circle"></i> ') + msg;
                document.body.appendChild(t);
                requestAnimationFrame(function () { t.classList.add('show'); });
                setTimeout(function () {
                    t.classList.remove('show');
                    setTimeout(function () { t.remove(); }, 300);
                }, 2500);
            }

            document.addEventListener('click', function (e) {
                var wishBtn = e.target.closest('.shop-wish');
                if (wishBtn && wishBtn.dataset.pid) {
                    e.preventDefault();
                    mbAddToWish(wishBtn);
                }
            });

            function mbAddToWish(btn) {
                if (btn.classList.contains('loading')) return;
                btn.classList.add('loading');
                fetch(MB_AJAX + '/wish/' + btn.dataset.pid, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function (r) { return r.json(); })
                    .then(function (d) {
                        btn.classList.remove('loading');
                        if (d.ok) {
                            var badge = document.getElementById('wishCountBadge');
                            if (badge) { badge.textContent = d.wishcount; badge.style.display = 'inline-block'; }
                            var ic = btn.querySelector('i');
                            if (ic) { ic.classList.remove('far'); ic.classList.add('fas'); }
                            btn.classList.add('active');
                            mbToast(d.message, true);
                            try { localStorage.removeItem('guest_wish_count'); } catch (e) { }
                        } else if (d.login) {
                            try {
                                var guest = parseInt(localStorage.getItem('guest_wish_count') || 0, 10) || 0;
                                guest = guest + 1;
                                localStorage.setItem('guest_wish_count', guest);
                                var badge = document.getElementById('wishCountBadge');
                                if (badge) {
                                    var current = parseInt(badge.textContent || 0, 10) || 0;
                                    badge.textContent = current + 1;
                                    badge.style.display = 'inline-block';
                                }
                            } catch (e) { }
                            mbToast(d.message, false);
                        } else {
                            mbToast(d.message || 'Something went wrong', false);
                        }
                    })
                    .catch(function () { btn.classList.remove('loading'); mbToast('Network error, try again', false); });
            }
        </script>
        <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/optional/isotope.pkgd.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/plugins.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.appear.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/main.min.js"></script>
</body>

</html>
