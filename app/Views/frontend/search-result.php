<?php $commfrontfunc = service('commfrontfunc'); ?>
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

        .shop-hero-sub {
            font-size: 14px;
            color: #6B7280;
            margin: 8px 0 0;
        }

        .shop-hero-sub b {
            color: #0F766E;
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
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        .shop-card:hover {
            transform: translateY(-6px);
            border-color: rgba(20, 184, 166, .5);
            box-shadow: 0 18px 38px rgba(15, 118, 110, .14);
        }

        /* -- equal height cards (content chhota/bada ho, height same) -- */
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
            padding: 14px;
        }

        .shop-card-media img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform .3s ease;
        }

        .shop-card:hover .shop-card-media img {
            transform: scale(1.06);
        }

        .shop-badges {
            position: absolute;
            top: 12px;
            left: 12px;
            display: flex;
            flex-direction: column;
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

        /* -- pager -- */
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
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .shop-pager-wrap li.disabled {
            display: none;
        }

        .shop-pager-wrap a,
        .shop-pager-wrap span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 10px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            color: #0F766E;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
            transition: all .2s ease;
        }

        .shop-pager-wrap a:hover {
            border-color: #0F766E;
            background: #0F766E;
            color: #fff;
        }

        .shop-pager-wrap .active a,
        .shop-pager-wrap .active span,
        .shop-pager-wrap .current,
        .shop-pager-wrap [aria-current="page"] {
            background: #0F766E;
            border-color: #0F766E;
            color: #fff;
        }

        .shop-pager-wrap .disabled a,
        .shop-pager-wrap .disabled span {
            display: none;
        }

        /* distinct Previous / Next round arrow buttons */
        .shop-pager-wrap li.pg-arrow a {
            border-radius: 50%;
            width: 38px;
            min-width: 38px;
            padding: 0;
            background: #fff;
        }

        .shop-pager-wrap li.pg-arrow a i {
            font-size: 12px;
        }

        .shop-pager-wrap li.pg-arrow a:hover {
            background: #0F766E;
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

            <!-- SEARCH HERO -->
            <?php
            // searched keyword nikaalo (jo bhi available ho use kar lega)
            $req = service('request');
            $search_term = '';
            foreach (['search', 'keyword', 'q', 's', 'searchkey', 'searchword'] as $__k) {
                $__v = $req->getGet($__k);
                if (!empty($__v)) {
                    $search_term = $__v;
                    break;
                }
            }
            if ($search_term === '' && isset($searchkey)) {
                $search_term = $searchkey;
            }
            if ($search_term === '' && isset($keyword)) {
                $search_term = $keyword;
            }
            if ($search_term === '' && isset($search_key)) {
                $search_term = $search_key;
            }
            $search_term = trim((string) $search_term);

            // selected category from the header search dropdown (?cat=<category_id>)
            $cat_name = '';
            $sel_cat = $req->getGet('cat');
            if (!empty($sel_cat) && $sel_cat !== 'All' && is_numeric($sel_cat)) {
                $selcatrow = $commfrontfunc->getPerCategory($sel_cat);
                if ($selcatrow) {
                    $cat_name = $selcatrow->category_name;
                }
            }

            // hero title: category name (like product-by-category) > search term > default
            if ($cat_name !== '') {
                $hero_title = esc($cat_name);
            } elseif ($search_term !== '') {
                $hero_title = esc($search_term);
            } else {
                $hero_title = 'Search Results';
            }
            ?>
            <section class="shop-hero">
                <div class="container">
                    <nav aria-label="breadcrumb" class="shop-breadcrumb-nav">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                            <?php if ($cat_name !== '') { ?>
                                <li class="breadcrumb-item"><a href="<?php echo site_url('search'); ?>">Search</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo esc($cat_name); ?></li>
                            <?php } else { ?>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $hero_title; ?></li>
                            <?php } ?>
                        </ol>
                    </nav>
                    <h1><?php echo $hero_title; ?></h1>
                    <?php if ($cat_name !== '' && $search_term !== '') { ?>
                        <p class="shop-hero-sub">Results for <b>"<?php echo esc($search_term); ?>"</b></p>
                    <?php } ?>
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
                        if (count($productdata) > 0) {
                            foreach ($productdata as $productrow) {
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
                                $product_category = $productrow->product_category;
                                $catar = explode(",", $product_category);
                                $pro_link = site_url("product/$product_slug");
                                ?>
                                <div class="col-6 col-sm-4">
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
                                                    if ($catrow) {
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
                        } else { ?>
                            <div class="col-md-12">
                                <p class="shop-empty">No product found please try again</p>
                            </div>
                        <?php } ?>
                    </div><!-- End .row -->

                    <?php if (isset($pager_links) && strpos($pager_links, 'page=2') !== false) { ?>
                        <div class="shop-pager-wrap">
                            <?php echo $pager_links ?>
                        </div>
                    <?php } ?>

                </div><!-- End .container -->
            </section>
        </main>
        <?= $this->include('frontend/partials/footer') ?>
        <script>
            (function () {
                var pagerLinks = document.querySelectorAll('.shop-pager-wrap ul li a');
                pagerLinks.forEach(function (a) {
                    var label = a.textContent.trim().toLowerCase();
                    var li = a.closest('li');
                    if (!li) return;
                    if (label === 'first' || label === 'last') {
                        li.style.display = 'none';
                    } else if (label === 'previous') {
                        li.classList.add('pg-arrow');
                        a.innerHTML = '<i class="fas fa-chevron-left"></i>';
                    } else if (label === 'next') {
                        li.classList.add('pg-arrow');
                        a.innerHTML = '<i class="fas fa-chevron-right"></i>';
                    }
                });
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
