<?php $commfrontfunc = service('commfrontfunc');
$discount_percent = "";
$product_id = $productdata->product_id;
$product_price = $productdata->product_price;
$product_saleprice = $productdata->product_saleprice;
$product_slug = $productdata->product_slug;
if ($product_saleprice != "") {
    $mathfunc = service('mathfunc');
    $discount_percent = $mathfunc->getDiscountPercentage($product_price, $product_saleprice);
}
$product_category = $productdata->product_category;
$catar = explode(",", $product_category);

$product_url = "https://meibotan.com/product/" . $product_slug;

$metapro_img = "";
$metaproduct_thumb = $productdata->product_thumb;
if ($metaproduct_thumb != "") {
    $metapro_img = CUSTOM_UPLOAD_PATH . $metaproduct_thumb;
} else {
    $metapro_img = DEFAULT_PRODUCTIMG;
}


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


<meta property="og:type" content="product" />
<meta property="og:title"
      content="<?php echo $productdata->product_name; ?>" />
<meta property="og:image"
      content="<?php echo $metapro_img; ?>" />
<meta property="og:description"
      content="<?php echo $productdata->product_shortdescription; ?>" />

    <meta property="product:price:amount" content="<?php $productdata->product_shortdescription ?>"/>
     <?php if ($discount_percent > 0) { ?>
            <meta property="product:price:amount" content="<?php echo $product_price; ?>"/>
    <?php } else { ?>
            <meta property="product:price:amount" content="<?php echo $product_saleprice; ?>"/>
    <?php } ?>
    <meta property="product:price:currency"
      content="INR"/>


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

        <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=6602601c88484200124fca81&product=inline-share-buttons' async='async'></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/vendor/fontawesome-free/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/css/style.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/demo4.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/css/custom.css" />
<style type="text/css">

    body { background-color: #fff; }

    /* =========================================
       SHARED SECTION HEADING (matches About/Contact pages)
       ========================================= */
    .section-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #E6F7F4;
        border: 1px solid rgba(15,118,110,.18);
        color: #0F766E;
        padding: 7px 20px;
        border-radius: 30px;
        margin-bottom: 16px;
    }
    .section-eyebrow i { font-size: 10px; color: #F59E0B; }
    .section-eyebrow span {
        font-family: 'Oswald', sans-serif;
        text-transform: uppercase;
        letter-spacing: .12em;
        font-size: 11.5px;
        font-weight: 700;
        color: #0F766E;
    }
    .section-title,
    .pd-wrap .section-heading {
        font-family: 'Poppins', sans-serif;
        font-size: 30px !important;
        font-weight: 600 !important;
        color: #1F2937 !important;
        line-height: 1.25;
        margin-bottom: 20px;
    }
    @media(max-width:767px) {
        .section-title, .pd-wrap .section-heading { font-size: 1.6rem !important; margin-bottom: 14px; }
        .section-eyebrow { padding: 6px 16px; margin-bottom: 12px; }
        .section-eyebrow span { font-size: 10px; letter-spacing: .1em; }
    }

    /* =========================================
       BREADCRUMB
       ========================================= */
    .pd-wrap .breadcrumb-nav {
        background: linear-gradient(160deg, #ECFEFF 0%, #F8FAFC 100%);
        border-bottom: 1px solid #E2E8F0;
        padding: 14px 0;
    }
    .pd-wrap .breadcrumb-nav .breadcrumb-item,
    .pd-wrap .breadcrumb-nav .breadcrumb-item a {
        font-size: 13px;
        color: #6B7280;
    }
    .pd-wrap .breadcrumb-nav .breadcrumb-item a { color: #0F766E; font-weight: 600; }
    .pd-wrap .breadcrumb-nav .breadcrumb-item a:hover { color: #F59E0B; }

    /* =========================================
       PRODUCT MAIN CARD
       ========================================= */
    .pd-wrap { padding-top: 36px; padding-bottom: 10px; }
    .pd-product-card {
        background: #fff;
        border: 1px solid #EEF2F6;
        border-radius: 22px;
        box-shadow: 0 14px 40px rgba(15,118,110,.08);
        padding: 34px;
    }
    @media(max-width:767px) {
        .pd-product-card { padding: 18px; border-radius: 16px; }
    }

    /* Gallery */
    .pd-gallery-wrap .product-single-carousel { border-radius: 16px; overflow: hidden; }
    .pd-gallery-wrap .product-single-image { border-radius: 16px; }
    .pd-gallery-wrap .dt_thumbsingle {
        width: 100%;
        border-radius: 16px;
        box-shadow: 0 10px 26px rgba(15,118,110,.10);
    }
    .pd-gallery-wrap .prod-thumbnail .owl-dot img {
        border-radius: 10px;
        border: 2px solid transparent;
        transition: border-color .25s ease;
    }
    .pd-gallery-wrap .prod-thumbnail .owl-dot.active img,
    .pd-gallery-wrap .prod-thumbnail .owl-dot:hover img {
        border-color: #14B8A6;
    }
    .pd-gallery-wrap .prod-full-screen {
        background: #fff;
        box-shadow: 0 4px 14px rgba(15,118,110,.18);
        color: #0F766E;
    }

    /* Title / rating */
    .pd-wrap .product-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: #1F2937;
        font-size: 26px;
        margin-bottom: 10px;
    }
    .pd-wrap .ratings-container .review-stars i,
    .pd-wrap .review-stars i { color: #E2E8F0; font-size: 14px; }
    .pd-wrap .review-stars i.active { color: #F59E0B; }
    .pd-wrap .ratings-container span.ml-2 { font-size: 12.5px; color: #6B7280; }

    .pd-wrap .short-divider {
        border-top: 1px solid #EEF2F6;
        margin: 18px 0;
    }

    /* Price box */
    .pd-wrap .price-box.jkll {
        background: linear-gradient(135deg, #E6F7F4, #ECFEFF);
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: baseline;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .pd-wrap .price-box.jkll .old-price {
        font-size: 15px;
        color: #94A3B8;
        text-decoration: line-through;
    }
    .pd-wrap .price-box.jkll .new-price {
        font-family: 'Poppins', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #0F766E;
    }
    .pd-wrap .price-box.jkll .old-price:only-child {
        font-size: 26px;
        font-weight: 700;
        color: #0F766E;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
    }

    /* Short description */
    .pd-wrap .product-desc {
        color: #6B7280;
        font-size: 14px;
        line-height: 1.75;
        margin-bottom: 18px;
    }

    /* Meta list (SKU / Category) */
    .pd-wrap .single-info-list {
        list-style: none;
        padding: 0;
        margin: 0 0 6px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .pd-wrap .single-info-list li {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 30px;
        padding: 7px 16px;
        font-size: 12.5px;
        color: #6B7280;
        letter-spacing: .03em;
    }
    .pd-wrap .single-info-list li strong { color: #1F2937; font-weight: 600; }
    .pd-wrap .single-info-list .product-category {
        color: #0F766E;
        font-weight: 600;
        text-decoration: none;
    }
    .pd-wrap .single-info-list .product-category:hover { color: #F59E0B; }

    /* Perks strip */
    .pd-wrap .single-product-custom-block .porto-block {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 8px 0 4px;
    }
    .pd-wrap .single-product-custom-block .porto-heading {
        display: inline-flex !important;
        align-items: center;
        gap: 7px;
        background: #fff;
        border: 1px solid rgba(15,118,110,.2);
        color: #0F766E !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        padding: 8px 16px;
        border-radius: 30px;
        margin: 0 !important;
        box-shadow: 0 4px 12px rgba(15,118,110,.06);
    }

    /* Qty + actions */
    .pd-wrap .product-single-qty { margin-bottom: 14px; }
    .pd-wrap .horizontal-quantity {
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        max-width: 110px;
        padding: 10px 14px;
    }
    .pd-wrap .product-action {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 14px;
    }
    .pd-wrap .product-action .btn.btn-dark {
        background: linear-gradient(135deg, #14B8A6, #0F766E);
        border: none;
        border-radius: 30px;
        font-weight: 600;
        font-size: 14px;
        padding: 13px 30px;
        transition: all .3s ease;
    }
    .pd-wrap .product-action .btn.btn-dark:hover {
        background: #F59E0B;
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(245,158,11,.3);
    }
    .pd-wrap .btn_wishlist {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #6B7280;
        font-size: 13.5px;
    }
    .pd-wrap .btn_wishlist:hover { color: #da5555; }

    .pd-wrap .divider { border-top: 1px solid #EEF2F6; }
    .pd-wrap .sharethis-inline-share-buttons { margin-top: 6px; }

    /* Specification table */
    .pd-wrap .products-table table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        color: #374151;
        margin-top: 10px;
    }
    .pd-wrap .products-table table td,
    .pd-wrap .products-table table th {
        border: 1px solid #EEF2F6;
        padding: 9px 14px;
    }
    .pd-wrap .products-table table tr:nth-child(odd) td { background: #F8FAFC; }

    /* Tabs */
    .pd-wrap .product-single-tabs { margin-top: 30px; }
    .pd-wrap .nav-tabs { border-bottom: 1px solid #EEF2F6; }
    .pd-wrap .nav-tabs .nav-link {
        border: none;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 15px;
        color: #6B7280;
        padding: 10px 4px;
        margin-right: 26px;
        position: relative;
    }
    .pd-wrap .nav-tabs .nav-link.active {
        color: #0F766E;
        background: transparent;
    }
    .pd-wrap .nav-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        left: 0; right: 0; bottom: -1px;
        height: 2px;
        background: linear-gradient(90deg, #14B8A6, #0F766E);
    }
    .pd-wrap .product-desc-content { color: #6B7280; font-size: 14px; line-height: 1.8; padding-top: 18px; }
    .pd-wrap .product-desc-content h4 {
        font-family: 'Poppins', sans-serif;
        color: #1F2937;
        font-weight: 600;
        margin-bottom: 12px;
    }

    /* =========================================
       REVIEWS
       ========================================= */
    .pd-reviews-section { padding: 60px 0; background: #F8FAFC; margin-top: 46px; }
    .review-main-box {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 28px rgba(15,118,110,.08);
    }
    @media(max-width:767px) { .review-main-box { padding: 18px; border-radius: 16px; } }

    .review-top-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        border-bottom: 1px solid #EEF2F6;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
    .review-heading {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: #1F2937;
        font-size: 22px;
        margin-bottom: 12px;
    }
    .review-summary-left { display: flex; align-items: center; gap: 14px; }
    .summary-big-rating { color: #E2E8F0; font-size: 18px; }
    .summary-big-rating i.active { color: #F59E0B; }
    .summary-big-rating span {
        margin-left: 8px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #1F2937;
        font-size: 16px;
    }
    .review-summary-left p { margin: 0; color: #6B7280; font-size: 13px; }

    .review-right-area { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
    .review-filter select.form-control {
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        font-size: 13px;
        padding: 9px 14px;
    }
    .write-review-btn {
        background: linear-gradient(135deg, #14B8A6, #0F766E);
        color: #fff;
        border: none;
        padding: 11px 26px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 13.5px;
        transition: all .3s ease;
    }
    .write-review-btn:hover, .write-review-btn.active-review-btn {
        background: #F59E0B;
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(245,158,11,.3);
    }

    /* Review form */
    .review-form.custom-form,
    form.review-form {
        background: #F8FAFC;
        border: 1px solid #EEF2F6;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 26px;
    }
    .review-form label { font-weight: 600; font-size: 13px; color: #1F2937; margin-bottom: 5px; }
    .review-form .form-control {
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        font-size: 13.5px;
        padding: 10px 14px;
    }
    .review-form .form-control:focus {
        border-color: #14B8A6;
        box-shadow: 0 0 0 3px rgba(20,184,166,.15);
        outline: none;
    }
    .real-star-rating { font-size: 20px; color: #E2E8F0; margin-bottom: 8px; }
    .real-star-rating i { cursor: pointer; margin-right: 4px; transition: color .15s ease; }
    .real-star-rating i.active { color: #F59E0B; }
    .review-media-wrap { display: flex; gap: 14px; margin: 16px 0; flex-wrap: wrap; }
    .review-upload-box {
        background: #fff;
        border: 1px dashed #CBD5E1;
        border-radius: 12px;
        padding: 14px 20px;
    }
    .review-upload-box label { display: flex; align-items: center; gap: 8px; cursor: pointer; margin: 0; font-weight: 500; color: #6B7280; font-size: 13px; }
    .review-upload-box i { color: #0F766E; }
    .review-submit-btn {
        background: linear-gradient(135deg, #14B8A6, #0F766E);
        color: #fff;
        border: none;
        padding: 12px 30px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 13.5px;
        transition: all .3s ease;
    }
    .review-submit-btn:hover { background: #F59E0B; transform: translateY(-2px); box-shadow: 0 10px 22px rgba(245,158,11,.3); }

    /* Review list */
    .review-list-wrap { margin-top: 6px; }
    .single-review-box {
        background: #fff;
        border: 1px solid #EEF2F6;
        border-radius: 14px;
        padding: 18px 20px 4px;
        margin-bottom: 4px;
        box-shadow: 0 6px 16px rgba(15,118,110,.05);
    }
    .single-review-box h4 { font-size: 15px; font-weight: 700; color: #1F2937; margin-bottom: 6px; }
    .single-review-box .review-stars i { font-size: 13px; }
    .review-user-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        border-left: 1px solid #EEF2F6;
        border-right: 1px solid #EEF2F6;
        padding: 0 20px;
        margin-bottom: 0;
    }
    .review-user-row h5 { font-size: 13px; font-weight: 600; color: #0F766E; margin: 0; }
    .review-date { font-size: 12px; color: #9CA3AF; }
    .review-list-wrap > p {
        background: #fff;
        border: 1px solid #EEF2F6;
        border-top: none;
        border-radius: 0 0 14px 14px;
        padding: 0 20px 18px;
        margin-bottom: 22px !important;
        color: #6B7280;
        font-size: 13.5px;
        line-height: 1.7;
    }
    .review-img, .review-video {
        max-width: 220px;
        border-radius: 10px;
        margin: 10px 20px 16px;
        box-shadow: 0 6px 16px rgba(15,118,110,.1);
    }
    .review-pagination { display: flex; justify-content: center; margin-top: 20px; }
    .review-pagination ul { display: flex; gap: 6px; list-style: none; padding: 0; margin: 0; }
    .review-pagination a, .review-pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        color: #6B7280;
        font-size: 13px;
        text-decoration: none;
    }
    .review-pagination .active span, .review-pagination a:hover {
        background: #0F766E;
        border-color: #0F766E;
        color: #fff;
    }

    /* =========================================
       PRODUCT DESCRIPTION (dynamic spec blocks)
       ========================================= */
    .pd-desc-section { padding: 60px 15px; background: #fff; }
    .pd-desc-section .descbotbox {
        background: #F8FAFC;
        border: 1px solid #EEF2F6;
        border-radius: 18px;
        padding: 26px 30px;
        margin-bottom: 24px;
        text-align: left;
        color: #6B7280;
        font-size: 14px;
        line-height: 1.8;
    }
    .pd-desc-section .imgdesc {
        max-width: 100%;
        border-radius: 14px;
        box-shadow: 0 10px 26px rgba(15,118,110,.08);
    }

    /* =========================================
       RELATED PRODUCTS
       ========================================= */
    .pd-related-section { padding: 60px 0 70px; background: #F8FAFC; }
    .pd-related-section .product-default {
        background: #fff;
        border-radius: 16px;
        padding: 14px 14px 18px;
        box-shadow: 0 8px 20px rgba(15,118,110,.06);
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .pd-related-section .product-default:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 34px rgba(15,118,110,.14);
    }
    .pd-related-section .product-default figure { border-radius: 12px; overflow: hidden; margin-bottom: 12px; }
    .pd-related-section .product-title.jkl { font-size: 14.5px; font-weight: 600; }
    .pd-related-section .product-title.jkl a { color: #1F2937; }
    .pd-related-section .product-category { color: #0F766E; font-size: 11.5px; font-weight: 600; }
    .pd-related-section .price-box .product-price { color: #0F766E; font-weight: 700; }

</style>
</head>
<body>
<div class="page-wrapper pd-wrap">
  <?= $this->include('frontend/partials/header') ?>
  <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url("shop"); ?>"><i class="icon-home"></i> Shop</a></li>
                        <li class="breadcrumb-item">Products</li>
                    </ol>
                </div>
            </nav>
                <div class="container">
            <div class="product-single-container product-single-info  product-center-vertical">
              <?php if (session()->getFlashdata('warning_error')) { ?>
              <div class="row">
                <div class="col-lg-12">
                  <div class="auth-content-warning my-auto">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <?= session()->getFlashdata('warning_error'); ?>
                    </div>
                  </div>
                </div>
              </div>
          <?php } ?>
            <?php if (session()->getFlashdata('success_msg')) { ?>
              <div class="row">
                <div class="col-lg-12">
                  <div class="auth-content-warning my-auto">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <?= session()->getFlashdata('success_msg'); ?>
                    </div>
                  </div>
                </div>
              </div>
          <?php } ?>
               <!-- <div class="cart-message d-none">
                    <strong class="single-cart-notice">"Men Black Sports Shoes"</strong>
                    <span>has been added to your cart.</span>
                </div>-->
        <div class="pd-product-card">
        <div class="product-single-container product-single-info  product-single-default  product-center-vertical">
        <div class="row">

                         <?php if (count($gallerydata) > 0) { ?>
                             <div class="col-lg-6 product-single-gallery  order-0 order-lg-0 pd-gallery-wrap">
                                <div class="product-slider-container mb-auto">

                                     <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                                    <?php foreach ($gallerydata as $galleryrow) {
                                        $progal_image = $galleryrow->progal_image;
                                        if ($progal_image != "") {
                                            $pro_img = CUSTOM_UPLOAD_PATH . $progal_image;
                                            ?>
                                                <div class="product-item">
                                                    <img class="product-single-image"
                                                        src="<?php echo $pro_img; ?>"
                                                        data-zoom-image="<?php echo $pro_img; ?>"  alt="product" />
                                                </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </div>
                                    <span class="prod-full-screen">
                                        <i class="icon-plus"></i>
                                    </span>
                                </div>
                                <div class="prod-thumbnail thumb-vertical  show-nav-hover owl-loaded owl-drag d-lg-block order-lg-first"
                                    id='carousel-custom-dots'>
                                    <?php foreach ($gallerydata as $gallerythumbrow) {
                                        $progal_imagethumb = $gallerythumbrow->progal_image;
                                        if ($progal_imagethumb != "") {
                                            $pro_imgthumb = CUSTOM_UPLOAD_PATH . $progal_imagethumb;
                                            ?>
                                            <div class="owl-dot">
                                                <img src="<?php echo $pro_imgthumb; ?>" width="110" height="110"
                                                    alt="product-thumbnail" />
                                            </div>
                                                <?php }

                                    } ?>


                                </div>
                                   </div>
                         <?php } else {
                             ?>
                                      <div class="col-lg-6   order-0 order-lg-0 pd-gallery-wrap">
                                    <img src="<?php echo $metapro_img; ?>" class="dt_thumbsingle"/>
                                    </div>
                                <?php
                         } ?>

                        <div class="col-lg-6 pb-1">
                         <div class="sidebar-wrapper">

                            <div class="product-single-details mb-1">
                                <h1 class="product-title"><?php echo $productdata->product_name; ?> </h1>
<div class="ratings-container mb-2">

<?php

$total_review = $totalReviews;

?>

<div class="review-stars d-flex align-items-center">

<?php for ($i = 1; $i <= 5; $i++) { ?>

        <?php if ($i <= $avg_rating) { ?>

                <i class="fa fa-star active"></i>

        <?php } else { ?>

                <i class="fa fa-star"></i>

        <?php } ?>

<?php } ?>

<span class="ml-2">

(<?php echo $total_review; ?> Reviews)

</span>

</div>

</div>
                                <!--<div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:60%"></span>
                                        <span class="tooltiptext tooltip-top"></span>
                                    </div>

                                    <a href="#" class="rating-link">( 7 Reviews )</a>
                                </div>-->

                                <hr class="short-divider">

                                <div class="price-box jkll">
                                <?php if ($discount_percent > 0) { ?>
                                        <span class="old-price"> ₹<?php echo $product_price; ?></span>
                                        <span class="new-price"> ₹<?php echo $product_saleprice; ?></span>
                                 <?php } else { ?>
                                          <span class="old-price"> ₹<?php echo $product_price; ?></span>
                                 <?php } ?>


                                    <!--<p>Inclusive of all taxes</p>-->
                                </div>
                                <!-- End .price-box -->

                                <div class="product-desc">
                                   <?php echo $productdata->product_shortdescription; ?>
                                </div>
                                <!-- End .product-desc -->

                                <ul class="single-info-list">
                                    <li>
                                        SKU: <strong><?php echo $productdata->product_sku; ?></strong>
                                    </li>

                                    <li>
                                        CATEGORY: <strong>  <?php foreach ($catar as $cat_id) {
                                            $catrow = $commfrontfunc->getPerCategory($cat_id);
                                            if ($catrow) {
                                                $cat_slug = $catrow->category_slug;
                                                ?>
                          <a href="<?php echo site_url("product-category/$cat_slug"); ?>" class="product-category"><?php echo $catrow->category_name; ?></a>
                  <?php
                                            }
                                        } ?></strong>
                                    </li>
                                </ul>

<br>

<div class="single-product-custom-block">
  <div class="porto-block">
    <h5 class="porto-heading d-inline-block">Free Delivery</h5>
    <h5 class="porto-heading d-inline-block">Non-Returnable </h5>
    <h5 class="porto-heading d-inline-block">Top Brand </h5>
  </div>
</div>


                                <!-- <div class="product-filters-container">
                                    <div class="product-single-filter">
                                        <label>Size:</label>
                                        <ul class="config-size-list">
                                            <li>
                                                <a href="javascript:;" class="d-flex align-items-center justify-content-center p-0">
                                                    <img src="assets/images/products/zoom/product-1.jpg" width="30" height="30" alt="filter-img" />
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="d-flex align-items-center justify-content-center p-0">
                                                    <img src="assets/images/products/zoom/product-2.jpg" width="30" height="30" alt="filter-img" />
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="javascript:;" class="d-flex align-items-center justify-content-center p-0">
                                                    <img src="assets/images/products/zoom/product-3.jpg" width="30" height="30" alt="filter-img" />
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="d-flex align-items-center justify-content-center p-0"> <img src="assets/images/products/zoom/product-4.jpg" width="30" height="30" alt="filter-img" />
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="product-single-filter">
                                        <label></label>
                                        <a class="font1 text-uppercase clear-btn" href="#">Clear</a>
                                    </div>
                                </div> -->

                                <div class="product-action">
               <?php $current_url = current_url();
               echo form_open('cart/addtocart');
               echo form_hidden('product_id', $productdata->product_id);
               echo form_hidden('back_url', $current_url); ?>

                                    <div class="product-single-qty">
                                        <input class="horizontal-quantity form-control" type="text" name="product_qty">
                                    </div>
                                    <!-- End .product-single-qty -->
                        <button type="submit" name="btn_cart" class="btn btn-dark  icon-shopping-cart mr-2" title="Add to Cart"> Add to Cart</button>

                        <button type="submit" name="btn_wishlist" class="btn_wishlist justify-content-start mb-lg-0 mb-1" title="Add to Wishlist"><i class="icon-wishlist-2"></i> Add to Wishlist</button>
                        <!--<a href="https://api.whatsapp.com/send?phone=+917009057196&amp;text=Hi!%20 I%20 would%20 like%20 to%20 buy:%20 <?php echo $product_url; ?>" title="<?php echo $productdata->product_name; ?>" target="_blank" class="btn  order_onwhatsapp"><img src="https://www.whisperinghomes.com/pub/media/images/order_whatsapp_desktop.png" alt="whatsapp_dekstop"></a>-->


                                              <!--  <a href="#" class="btn btn-dark add-cart icon-shopping-cart mr-2" title="Add to Cart">Add to Cart</a>-->
                                              <?php echo form_close(); ?>








                                </div>
                                <!-- End .product-action -->


                                <hr class="divider mb-0 mt-0 pt-3">
                                <div class="sharethis-inline-share-buttons"></div>


                                  <p class="pr-3"></p>




<div class="products-table">
    <?php echo $productdata->product_specification; ?>


</div> </div>
                            <!-- End .product-single-details -->
                         <?php if ($productdata->product_description != "") { ?>
                                <div class="product-single-tabs">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">Description</a>
                                        </li>

                               <!--          <li class="nav-item">
                                        <a class="nav-link" id="product-tab-size" data-toggle="tab" href="#product-size-content" role="tab" aria-controls="product-size-content" aria-selected="true">Size Guide</a>
                                    </li> -->

                                       <!-- <li class="nav-item">
                                        <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab" aria-controls="product-reviews-content" aria-selected="false">Reviews
                                            (1)</a>
                                    </li>-->
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                                            <div class="product-desc-content">

                                            <h4>About this item</h4>
                                            <?php echo $productdata->product_description;

                                            ?>
                                          </div>
                                            <!-- End .product-desc-content -->
                                        </div>
                                        <!-- End .tab-pane -->


                                        <!-- End .tab-pane -->
                                    </div>
                                    <!-- End .tab-content -->
                                </div>
                            <?php } ?>

                            <!-- End .product-single-tabs --></div>
                        </div>

            </div>
      </div>
        </div>

         </div>
</div>

<section class="pd-reviews-section">
<div class="container">
<div class="review-main-box">

<div class="review-top-bar">

<div class="review-left-area">

<h2 class="review-heading">
Customer Reviews
</h2>

<div class="review-summary-wrap">

<div class="review-summary-left">

<div class="summary-big-rating">

<?php for ($i = 1; $i <= 5; $i++) { ?>

    <?php if ($i <= round($avg_rating)) { ?>

        <i class="fa fa-star active"></i>

    <?php } else { ?>

        <i class="fa fa-star"></i>

    <?php } ?>

<?php } ?>

<span><?php echo $avg_rating; ?>/5</span>

</div>

<p>
Based on <?php echo $total_review; ?> reviews
</p>

</div>

</div>

</div>



<div class="review-right-area">

<div class="review-filter">

<select class="form-control"
        onchange="window.location=this.value">

<option value="?filter=highest"
<?= (isset($_GET['filter']) && $_GET['filter'] == 'highest') ? 'selected' : ''; ?>>
Highest Rating
</option>

<option value="?filter=lowest"
<?= (isset($_GET['filter']) && $_GET['filter'] == 'lowest') ? 'selected' : ''; ?>>
Lowest Rating
</option>

<option value="?filter=pictures"
<?= (isset($_GET['filter']) && $_GET['filter'] == 'pictures') ? 'selected' : ''; ?>>
Only Pictures
</option>

<option value="?filter=pictures_first"
<?= (isset($_GET['filter']) && $_GET['filter'] == 'pictures_first') ? 'selected' : ''; ?>>
Pictures First
</option>

<option value="?filter=videos_first"
<?= (isset($_GET['filter']) && $_GET['filter'] == 'videos_first') ? 'selected' : ''; ?>>
Videos First
</option>

</select>

</div>

<button type="button" class="write-review-btn">
Write a Review
</button>

</div>

</div>

<!-- REVIEW FORM -->

<form action="<?php echo base_url('save-review'); ?>"
      id="reviewFormBox"
      style="display:none;"

      method="post"
      enctype="multipart/form-data"
      class="review-form">

<input type="hidden"
       name="product_id"
       value="<?php echo $productdata->product_id; ?>">



<div class="row">

<div class="col-md-6">

<label>Name</label>

<input type="text"
       name="customer_name"
       class="form-control"
       required>

</div>



<div class="col-md-6">

<label>Email</label>

<input type="email"
       name="customer_email"
       class="form-control"
       required>

</div>

</div>



<div class="mt-3">

<label>Rating</label>

<div class="real-star-rating">

<i class="fa fa-star"
   data-value="1"></i>

<i class="fa fa-star"
   data-value="2"></i>

<i class="fa fa-star"
   data-value="3"></i>

<i class="fa fa-star"
   data-value="4"></i>

<i class="fa fa-star"
   data-value="5"></i>

</div>

<input type="hidden"
       name="rating"
       id="selected_rating"
       required>

</div>



<div class="mt-3">

<label>Review Title</label>

<input type="text"
       name="review_title"
       class="form-control">

</div>



<div class="mt-3">

<label>Review Content</label>

<textarea name="review_message"
          class="form-control"
          rows="5"
          required></textarea>

</div>



<!-- PHOTO VIDEO -->

<div class="review-media-wrap">

<div class="review-upload-box">

<label>

<input type="file"
       name="review_image"
       hidden>

<i class="fa fa-camera"></i>

<span>Photo</span>

</label>

</div>



<div class="review-upload-box">
<p id="image-name"></p>
<p id="video-name"></p>
<label>

<input type="file"
       name="review_video"
       hidden>

<i class="fa fa-video-camera"></i>

<span>Video</span>

</label>

</div>

</div>



<button type="submit"
        class="review-submit-btn">

Submit Review

</button>

</form>



<!-- SHOW REVIEWS -->

<div class="review-list-wrap">

<?php if (!empty($reviews)) { ?>

    <?php foreach ($reviews as $review) { ?>



        <div class="single-review-box"

        data-rating="<?php echo $review->rating; ?>"

        data-image="<?php echo ($review->review_image != "") ? 1 : 0; ?>"

        data-video="<?php echo ($review->review_video != "") ? 1 : 0; ?>"

        >

        <h4>

        <?php echo $review->review_title; ?>

        </h4>



        <div class="review-stars">

        <?php for ($i = 1; $i <= 5; $i++) { ?>

            <?php if ($i <= $review->rating) { ?>

                <i class="fa fa-star active"></i>

            <?php } else { ?>

                <i class="fa fa-star"></i>

            <?php } ?>

        <?php } ?>

        </div>

        </div>

        <div class="review-user-row">

        <h5>
        <?php echo $review->customer_name; ?>
        </h5>

        <span class="review-date">

        <?php echo date('d M Y', strtotime($review->created_at)); ?>

        </span>

        </div>



        <p>

        <?php echo $review->review_message; ?>

        </p>



        <?php if ($review->review_image != "") { ?>

            <img src="<?php echo base_url('uploads/reviews/' . $review->review_image); ?>"
                 class="review-img">

        <?php } ?>



        <?php if ($review->review_video != "") { ?>

            <video controls
                   class="review-video">

            <source src="<?php echo base_url('uploads/reviews/' . $review->review_video); ?>">

            </video>

        <?php } ?>



        </div>



    <?php } ?>

<?php } ?>

<?php if ($totalReviews > $perPage) { ?>

    <div class="review-pagination">
        <?= $pager_links ?>
    </div>

<?php } ?>

<?php if (empty($reviews)) { ?>

    <p class="text-center">
    No Reviews Found
    </p>

<?php } ?>

</div>
</div>
</div>
</section>
             <?php if (count($prospecdata) > 0) { ?>
                <div class="pd-desc-section">
        <div class="row align-items-center justify-content-center">

        <h2 class="section-title">Product Description</h2>
            <div class="col-md-12">
                <div class="productionn text-center">
                   <?php foreach ($prospecdata as $prospecrow) {
                       $productspec_image = $prospecrow->productspec_image;
                       $productspec_text = $prospecrow->productspec_text;

                       ?>
                        <?php if ($productspec_image != "") { ?>

                                            <div class="row">
                                                <div class="col-md-8 offset-md-2">
                                                        <div class="descbotbox">
                                        <?php if ($productspec_text != "") { ?>
                                                <div class="row">
                                                <div class="col-md-12">
                                                        <?php echo $productspec_text; ?>
                                                  </div>
                                                </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                     <p class="text-center"><img src="<?php echo CUSTOM_UPLOAD_PATH . $productspec_image; ?>" class="imgdesc"/></p>
                                              </div>
                                            </div>
                                          </div>
                    </div> </div>


                        <?php }
                   } ?>





        </div>
    </div>
    </div>
            <?php

             } ?>



            <?php $proreldata = $commfrontfunc->getPerProRelatedProducts($product_id, $catar); ?>
</main>

<?php if (count($prospecdata) > 0) { ?>
                <section class="pd-related-section">
                <div class="container">
                    <div class="products-section pt-0">
                        <div class="section-eyebrow"><i class="fas fa-leaf"></i><span>You May Also Like</span></div>
                        <h2 class="section-title">Related Products</h2>
    <div class="products-slider custom-products owl-carousel owl-theme nav-outer show-nav-hover nav-image-center" data-owl-options="{'dots': false,'nav': true}">

         <?php foreach ($proreldata as $prorelrow) {
             $rel_discount_percent = "";
             $rel_product_price = $prorelrow->product_price;
             $rel_product_saleprice = $prorelrow->product_saleprice;
             $rel_product_slug = $prorelrow->product_slug;
             if ($rel_product_saleprice != "") {
                 $mathfunc = service('mathfunc');
                 $rel_discount_percent = $mathfunc->getDiscountPercentage($rel_product_price, $rel_product_saleprice);
             }
             $rel_product_category = $prorelrow->product_category;
             $relcatar = explode(",", $rel_product_category);

             $rel_proimg = "";
             $rel_product_thumb = $prorelrow->product_thumb;
             if ($rel_product_thumb != "") {
                 $rel_proimg = CUSTOM_UPLOAD_PATH . $rel_product_thumb;
             } else {
                 $rel_proimg = DEFAULT_PRODUCTIMG;
             }


             ?>
            <div class="product-default appear-animate" data-animation-name="fadeInRightShorter">
                <figure>
                    <a href="<?php echo site_url("product/$rel_product_slug"); ?>"> <img src="<?php echo $rel_proimg; ?>" /></a>
                    <div class="label-group">
                    <?php if ($rel_discount_percent > 0) { ?>

                            <div class="product-label label-hot">Sale</div>
                            <div class="product-label label-sale">-<?php echo $rel_discount_percent; ?>%</div>
                        <?php } ?>
                    </div>
                </figure>
                <div class="product-details">
                    <div class="category-list">
                     <?php foreach ($relcatar as $rel_catid) {
                         $relcatrow = $commfrontfunc->getPerCategory($rel_catid);
                         if ($relcatrow) {
                             $rel_catslug = $relcatrow->category_slug;
                             ?>
                                  <a href="<?php echo site_url("product-category/$rel_catslug"); ?>" class="product-category"><?php echo $relcatrow->category_name; ?></a>
                          <?php
                         }
                     } ?>

                    </div>
                    <h3 class="product-title jkl"><a href="<?php echo site_url("product/$rel_product_slug"); ?>"><?php echo $prorelrow->product_name; ?></a></h3>
                   <!-- <div class="ratings-container">
                <div class="product-ratings">
                    <span class="ratings" style="width: 80%;"></span>
                    <span class="tooltiptext tooltip-top"></span>
                </div>

            </div>-->
                    <div class="price-box">
                        <?php if ($rel_discount_percent > 0) { ?>
                        <del class="old-price">₹<?php echo $rel_product_price; ?></del> <span class="product-price">₹<?php echo $rel_product_saleprice; ?></span>
                        <?php } else { ?>
                                <span class="product-price">₹<?php echo $rel_product_saleprice; ?></span>
                        <?php } ?>
                    </div>
                    <div class="product-action">
                        <a href="<?php echo site_url("product/$rel_product_slug"); ?>" class="btn-icon btn-add-cart"><i class="icon-heart"></i><span>View</span></a>
                    </div>
                </div>

            </div>
        <?php } ?>

    </div>
                    </div>
                </div>
                </section>
            <?php } ?>

<?= $this->include('frontend/partials/footer') ?>
<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
<script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/optional/isotope.pkgd.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/plugins.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.appear.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/main.min.js"></script>
<script>

$(document).ready(function(){

    $('.real-star-rating i').click(function(){

        let rating = $(this).data('value');

        $('#selected_rating').val(rating);

        $('.real-star-rating i').removeClass('active');

        $('.real-star-rating i').each(function(){

            if($(this).data('value') <= rating){

                $(this).addClass('active');

            }

        });

    });

});

</script>
<script>

$('#reviewFilter').change(function(){

    var filter = $(this).val();

    let reviews = $('.single-review-box');

    reviews.show();

    if(filter == 'Highest Rating')
    {
        reviews.sort(function(a,b){
            return $(b).data('rating') - $(a).data('rating');
        });

        reviews.insertBefore('.review-pagination');
    }

    if(filter == 'Lowest Rating')
    {
        reviews.sort(function(a,b){
            return $(a).data('rating') - $(b).data('rating');
        });

        reviews.insertBefore('.review-pagination');
    }

    if(filter == 'Only Pictures')
    {
        reviews.hide();

        reviews.filter(function(){
            return $(this).data('image') == 1;
        }).show();
    }

    if(filter == 'Pictures First')
    {
        reviews.sort(function(a,b){
            return $(b).data('image') - $(a).data('image');
        });

        reviews.insertBefore('.review-pagination');
    }

    if(filter == 'Videos First')
    {
        reviews.sort(function(a,b){
            return $(b).data('video') - $(a).data('video');
        });

        reviews.insertBefore('.review-pagination');
    }

});

</script>
<script>

$('.write-review-btn').click(function(){

    $('#reviewFormBox').slideToggle();

    $(this).toggleClass('active-review-btn');

    if($(this).hasClass('active-review-btn'))
    {
        $(this).text('Cancel Review');
    }
    else
    {
        $(this).text('Write a Review');
    }

});

</script>
</body>
</html>
</content>
