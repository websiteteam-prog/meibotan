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
            background-color: #F8FAFC;
        }

        /* guard against any accidental horizontal scroll on small screens */
        .cartpage {
            overflow-x: hidden;
        }

        /*==================================
          Checkout Progress (stepper)
        ===================================*/
        .checkout-progress-bar {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            list-style: none;
            padding: 40px 0 24px;
            margin: 0;
        }

        .checkout-progress-bar li {
            position: relative;
            text-align: center;
            flex: 1;
            max-width: 240px;
        }

        .checkout-progress-bar li a {
            text-decoration: none;
            display: block;
        }

        /* connector line between circles */
        .checkout-progress-bar li:not(:last-child)::after {
            content: "";
            position: absolute;
            top: 27px;
            left: calc(50% + 50px);
            width: calc(100% - 68px);
            height: 4px;
            background: #E6EBF2;
            border-radius: 20px;
            z-index: 1;
        }

        .checkout-progress-bar li.active:not(:last-child)::after {
            background: linear-gradient(90deg, #14B8A6, #0F766E);
        }

        /* hide any inherited theme (Porto) chevron connectors */
        .checkout-progress-bar li::before {
            content: none !important;
            display: none !important;
        }

        .step-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #D8DEE8;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            transition: .35s ease;
            position: relative;
            z-index: 2;
        }

        .step-circle i {
            font-size: 19px;
            color: #9AA6B2;
        }

        .step-title {
            display: block;
            margin-top: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            color: #98A2B3;
            line-height: 1.4;
        }

        /* Active (completed step) */
        .checkout-progress-bar li.active .step-circle {
            background: linear-gradient(135deg, #14B8A6, #0F766E);
            border: none;
            box-shadow: 0 12px 26px rgba(15, 118, 110, .28);
        }

        .checkout-progress-bar li.active .step-circle i {
            color: #fff;
        }

        .checkout-progress-bar li.active .step-title {
            color: #0F766E;
        }

        /* Current (step you are on) */
        .checkout-progress-bar li.current .step-circle {
            border: 3px solid #14B8A6;
            box-shadow: 0 0 0 9px rgba(20, 184, 166, .12);
        }

        .checkout-progress-bar li.current .step-circle i {
            color: #14B8A6;
        }

        .checkout-progress-bar li.current .step-title {
            color: #1F2937;
        }

        /* Disabled (upcoming) */
        .checkout-progress-bar li.disabled .step-circle {
            background: #fff;
        }

        .checkout-progress-bar li.disabled .step-circle i,
        .checkout-progress-bar li.disabled .step-title {
            color: #B5BEC9;
        }

        .checkout-progress-bar li:hover .step-circle {
            transform: translateY(-3px);
        }

        /* Mobile stepper — compact horizontal */
        @media (max-width: 768px) {
            .checkout-progress-bar {
                padding: 26px 0 14px;
            }

            .checkout-progress-bar li {
                max-width: none;
                padding: 0 4px;
            }

            .step-circle {
                width: 44px;
                height: 44px;
            }

            .step-circle i {
                font-size: 15px;
            }

            .step-title {
                margin-top: 10px;
                font-size: 11px;
            }

            .checkout-progress-bar li.current .step-circle {
                box-shadow: 0 0 0 6px rgba(20, 184, 166, .12);
            }

            .checkout-progress-bar li:not(:last-child)::after {
                top: 21px;
                left: calc(50% + 28px);
                width: calc(100% - 56px);
                height: 3px;
            }
        }

        @media (max-width: 400px) {
            .step-circle {
                width: 40px;
                height: 40px;
            }

            .step-circle i {
                font-size: 13px;
            }

            .step-title {
                font-size: 10px;
                letter-spacing: -.01em;
            }

            .checkout-progress-bar li:not(:last-child)::after {
                top: 19px;
                left: calc(50% + 26px);
                width: calc(100% - 52px);
            }
        }

        /* =========================================
       CART SECTION
       ========================================= */
        .cartpage_section {
            padding: 10px 0 70px;
        }

        .cart-table-container {
            background: #fff;
            border-radius: 18px;
            padding: 26px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, .05);
        }

        .table-cart {
            margin-bottom: 0;
        }

        .table-cart thead th {
            border: none;
            border-bottom: 1px solid #EEF2F6;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #6B7280;
            font-weight: 700;
            padding-bottom: 14px;
        }

        .table-cart tbody tr.product-row {
            border-top: 1px solid #EEF2F6;
        }

        .table-cart td {
            vertical-align: middle;
            padding: 18px 10px;
            border: none;
        }

        .product-image-container {
            position: relative;
            width: 76px;
            margin: 0;
        }

        .product-image-container .product-image {
            display: block;
            width: 76px;
            height: 76px;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #E2E8F0;
            background: #F8FAFC;
        }

        .product-image-container .product-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 6px;
        }

        .product-image-container .btn-remove {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid #E2E8F0;
            color: #DC2626;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            box-shadow: 0 2px 10px rgb(233 233 233 / 65%);
            transition: all .25s ease;
        }

        .product-image-container .btn-remove:hover {
            background: #DC2626;
            color: #fff;
            border-color: #DC2626;
        }

        .product-title {
            font-size: 14px;
            font-weight: 700;
            color: #1F2937;
            margin: 0;
            word-break: break-word;
        }

        .subtotal-price {
            font-weight: 700;
            color: #0F766E;
            font-size: 15px;
        }

        .product-single-qty .input-group {
            border: 1px solid #E2E8F0;
            border-radius: 30px;
            overflow: hidden;
            max-width: 110px;
        }

        .horizontal-quantity {
            text-align: center;
            border: none !important;
            font-weight: 600;
            font-size: 13.5px;
            box-shadow: none !important;
        }

        .btn-update-cart {
            background: #fff;
            border: 1px solid rgba(20, 184, 166, .5);
            color: #0F766E;
            font-weight: 600;
            font-size: 13.5px;
            padding: 10px 26px;
            border-radius: 30px;
            transition: all .25s ease;
        }

        .btn-update-cart:hover {
            background: #0F766E;
            color: #fff;
            border-color: #0F766E;
        }

        /* Mobile cart — stack each row into a card (no horizontal scroll) */
        @media (max-width: 767px) {
            .cart-table-container {
                padding: 16px;
            }

            .table-cart thead {
                display: none;
            }

            .table-cart tbody,
            .table-cart tbody tr,
            .table-cart tbody td {
                display: block;
                width: 100%;
            }

            .table-cart tbody tr.product-row {
                position: relative;
                border: 1px solid #EEF2F6;
                border-top: 1px solid #EEF2F6;
                border-radius: 14px;
                padding: 16px 16px 16px 106px;
                margin-bottom: 14px;
                min-height: 108px;
            }

            .table-cart tbody tr.product-row td {
                border: none !important;
                padding: 3px 0;
                text-align: left;
            }

            /* image cell pinned to the left of the card */
            .table-cart tbody tr.product-row td:first-child {
                position: absolute;
                left: 16px;
                top: 16px;
                width: 76px;
                padding: 0;
            }

            .table-cart tbody tr.product-row td.product-col {
                padding-bottom: 6px;
            }

            /* label chips from data-label */
            .table-cart tbody tr.product-row td[data-label]::before {
                content: attr(data-label);
                display: inline-block;
                min-width: 74px;
                font-weight: 700;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: .03em;
                color: #6B7280;
            }

            .table-cart tbody tr.product-row td.text-right {
                text-align: left;
            }

            .product-single-qty {
                display: inline-block;
                vertical-align: middle;
            }

            .product-single-qty .input-group {
                max-width: 120px;
            }

            /* tfoot */
            .table-cart tfoot,
            .table-cart tfoot tr,
            .table-cart tfoot td {
                display: block;
                width: 100%;
            }

            .table-cart tfoot td {
                padding: 6px 0 0 !important;
            }

            .table-cart tfoot .float-right {
                float: none !important;
            }

            .btn-update-cart {
                width: 100%;
            }
        }

        /* Very small phones — tighter cards so nothing overflows */
        @media (max-width: 420px) {
            .table-cart tbody tr.product-row {
                padding: 14px 12px 14px 90px;
                min-height: 96px;
            }

            .table-cart tbody tr.product-row td:first-child {
                left: 12px;
                top: 14px;
                width: 64px;
            }

            .product-image-container {
                width: 64px;
            }

            .product-image-container .product-image {
                width: 64px;
                height: 64px;
            }

            .table-cart tbody tr.product-row td[data-label]::before {
                min-width: 64px;
                font-size: 10px;
            }

            .product-single-qty .input-group {
                max-width: 104px;
            }
        }

        /* =========================================
       CART SUMMARY
       ========================================= */
        .cart-summary {
            position: relative;
            background: #fff;
            border-radius: 18px;
            padding: 30px 26px;
            box-shadow: 0 2px 10px rgb(233 233 233 / 65%) !important;
            overflow: hidden;
        }

        .cart-summary::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #F59E0B, #14B8A6, #0F766E);
        }

        .cart-summary h3 {
            font-size: 17px;
            font-weight: 700;
            color: #1F2937;
            letter-spacing: .03em;
            margin-bottom: 22px;
        }

        .coupon-box {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 18px;
        }

        .coupon-box h4 {
            font-size: 13.5px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 12px;
        }

        .coupon-box .input-group {
            flex-wrap: nowrap;
        }

        .coupon-box .form-control {
            border-radius: 30px 0 0 30px;
            border: 1px solid #E2E8F0;
            font-size: 13px;
            min-width: 0;
        }

        .coupon-box .form-control:focus {
            border-color: #14B8A6;
            box-shadow: 0 0 0 3px rgba(20, 184, 166, .15);
        }

        .coupon-box .btn-dark {
            background: linear-gradient(135deg, #14B8A6, #0F766E);
            border: none;
            border-radius: 0 30px 30px 0;
            font-weight: 600;
            font-size: 13px;
            padding: 0 22px;
            white-space: nowrap;
            transition: all .25s ease;
        }

        .coupon-box .btn-dark:hover {
            background: #F59E0B;
        }

        .table-totals {
            margin: 22px 0 0;
        }

        .table-totals td {
            border: none;
            padding: 9px 0;
            font-size: 13.5px;
            color: #6B7280;
        }

        .table-totals td:last-child {
            text-align: right;
            font-weight: 600;
            color: #1F2937;
        }

        .table-totals tfoot td {
            border-top: 1px solid #E2E8F0;
            padding-top: 16px;
            font-size: 17px;
            font-weight: 700;
            color: #1F2937;
        }

        .table-totals tfoot td:last-child {
            color: #0F766E;
        }

        .checkout-methods .btn-dark {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, #14B8A6, #0F766E);
            border: none;
            color: #fff;
            font-weight: 700;
            font-size: 14.5px;
            padding: 14px;
            border-radius: 30px;
            margin-top: 20px;
            text-decoration: none !important;
            transition: all .3s ease;
        }

        .checkout-methods .btn-dark:hover {
            background: #F59E0B;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(245, 158, 11, .3);
        }

        @media(max-width:991px) {
            .cart-summary {
                margin-top: 24px;
            }
        }

        @media(max-width:575px) {
            .cartpage_section {
                padding: 4px 0 50px;
            }

            .cart-summary {
                padding: 24px 18px;
            }

            .cart-summary h3 {
                margin-bottom: 16px;
            }

            .coupon-box {
                padding: 14px;
            }

            .coupon-box .btn-dark {
                padding: 0 18px;
            }
        }

        .cart-table-container .btn-shop:hover,
        .cart-table-container .btn-sm:hover {
            color: #fff;
            background-color: #F59E0B;
        }

        /* =========================================
       EMPTY CART
       ========================================= */
        .cart-empty-page {
            background: #fff;
            border-radius: 20px;
            padding: 70px 30px;
            box-shadow: 0 2px 10px rgb(233 233 233 / 65%) !important
        }

        .cart-empty-page .icon-shopping-cart {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background: linear-gradient(135deg, #14B8A6, #0F766E);
            color: #fff;
            font-size: 34px;
            margin-bottom: 24px;
            box-shadow: 0 10px 26px rgba(15, 118, 110, .3);
        }

        .cart-empty-page .cart-empty {
            font-size: 16px;
            font-weight: 600;
            color: #1F2937;
            margin-bottom: 6px;
        }

        .cart-empty-page .return-to-shop .btn-primary {
            background: #F59E0B;
            border: none;
            color: #fff !important;
            font-weight: 700;
            font-size: 14px;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none !important;
            transition: all .3s ease;
        }

        .cart-empty-page .return-to-shop .btn-primary:hover {
            background: #0F766E;
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(15, 118, 110, .3);
        }

        @media(max-width:575px) {
            .cart-empty-page {
                padding: 50px 20px;
            }

            .cart-empty-page .icon-shopping-cart {
                width: 72px;
                height: 72px;
                font-size: 28px;
                margin-bottom: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <?= $this->include('frontend/partials/header') ?>
        <main class="main cartpage">
            <div class="container">
                <ul class="checkout-progress-bar">

                    <li class="active">
                        <a href="<?= site_url('cart'); ?>">
                            <span class="step-circle">
                                <i class="fas fa-shopping-cart"></i>
                            </span>

                            <span class="step-title">
                                Shopping Cart
                            </span>
                        </a>
                    </li>

                    <li class="current">
                        <a href="<?= site_url('checkout'); ?>">

                            <span class="step-circle">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>

                            <span class="step-title">
                                Delivery Address
                            </span>

                        </a>
                    </li>

                    <li class="disabled">
                        <a href="javascript:void(0)">

                            <span class="step-circle">
                                <i class="far fa-credit-card"></i>
                            </span>

                            <span class="step-title">
                                Payment Method
                            </span>

                        </a>
                    </li>

                </ul>
            </div>
            <section class="cartpage_section">
                <div class="container">
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
                    <?php if (session()->getFlashdata('warning_msg')) { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="auth-content-warning my-auto">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <?= session()->getFlashdata('warning_msg'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (count($cartdata) > 0) { ?>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="cart-table-container cartitems">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php echo form_open('cart/update'); ?>
                                            <table class="table table-cart">
                                                <thead>
                                                    <tr>
                                                        <th class="thumbnail-col"></th>
                                                        <th class="product-col">Product</th>
                                                        <th class="price-col">Price</th>
                                                        <th class="qty-col">Quantity</th>
                                                        <th class="text-right">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sub_total = 0;
                                                    foreach ($cartdata as $cartrow) {
                                                        $product_image = $cartrow->product_thumb;
                                                        $cart_id = $cartrow->cart_id;
                                                        $customenc = service('customencscript');
                                                        $enc_cartid = $customenc->encrypt($cart_id, ENC_KEY_PASS);
                                                        $sub_total = $sub_total + $cartrow->cart_pricetotal;
                                                        echo form_hidden('cart[' . $cart_id . '][id]', $cart_id);
                                                        echo form_hidden('cart[' . $cart_id . '][cart_productid]', $cartrow->cart_productid);

                                                        //echo form_hidden('cart['.$cart_id.'][id]', $cartval->tmp_proid);


                                                        ?>
                                                        <tr class="product-row">
                                                            <td>
                                                                <figure class="product-image-container"> <a href=""
                                                                        class="product-image">
                                                                        <?php if ($product_image != "") { ?>
                                                                            <img
                                                                                src="<?php echo CUSTOM_UPLOAD_PATH . $product_image; ?>">
                                                                        <?php } else { ?>
                                                                            <img src="<?php echo DEFAULT_PRODUCTIMG; ?>">
                                                                        <?php } ?>
                                                                    </a> <a
                                                                        href="<?php echo site_url("cart/removeitem/$enc_cartid"); ?>"
                                                                        class="btn-remove icon-cancel" title="Remove Item"></a>
                                                                </figure>
                                                            </td>
                                                            <td class="product-col">
                                                                <h5 class="product-title"> <?php echo $cartrow->product_name ?>


                                                                </h5>

                                                            </td>
                                                            <td data-label="Price"><?php echo "₹" . $cartrow->cart_price; ?>
                                                            </td>
                                                            <td data-label="Quantity">
                                                                <div class="product-single-qty">
                                                                    <div
                                                                        class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                                        <span class="input-group-btn input-group-prepend">
                                                                        </span>
                                                                        <input class="horizontal-quantity form-control"
                                                                            type="text"
                                                                            name="cart[<?php echo $cart_id; ?>][qty]"
                                                                            value="<?php echo $cartrow->cart_qty; ?>">
                                                                        <span class="input-group-btn input-group-append"></span>
                                                                    </div>
                                                                </div>
                                                                <!-- End .product-single-qty -->
                                                            </td>
                                                            <td class="text-right" data-label="Subtotal"><span
                                                                    class="subtotal-price"><?php echo "₹" . $cartrow->cart_pricetotal; ?></span>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" class="clearfix">
                                                            <div class="float-left"> </div>
                                                            <!-- End .float-left -->

                                                            <div class="float-right">
                                                                <button type="submit" class="btn btn-shop btn-update-cart">
                                                                    Update Cart </button>
                                                            </div>
                                                            <!-- End .float-right -->
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- End .cart-table-container -->
                            </div>
                            <div class="col-lg-4">
                                <div class="cart-summary">
                                    <h3>CART TOTALS</h3>
                                    <!-- Coupon Box Start -->
                                    <div class="coupon-box mb-3">
                                        <h4>Apply Coupon</h4>

                                        <form method="post" action="<?php echo site_url('cart/apply_coupon'); ?>">
                                            <div class="input-group">
                                                <input type="text" name="coupon_code" class="form-control"
                                                    placeholder="Enter Coupon Code" required>

                                                <button type="submit" class="btn btn-dark">
                                                    Apply
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Coupon Box End -->
                                    <?php
                                    $discount = session()->get('coupon_discount') ?? 0;
                                    ?>

                                    <table class="table table-totals">

                                        <tbody>

                                            <tr>
                                                <td>Subtotal</td>
                                                <td>₹<?php echo $sub_total; ?></td>
                                            </tr>

                                            <?php if ($discount > 0) { ?>

                                                <tr>
                                                    <td>Discount</td>
                                                    <td>- ₹<?php echo $discount; ?></td>
                                                </tr>

                                            <?php } ?>

                                        </tbody>

                                        <tfoot>

                                            <tr>
                                                <td>Total</td>
                                                <td>
                                                    ₹<?php echo $sub_total - $discount; ?>
                                                </td>
                                            </tr>

                                        </tfoot>

                                    </table>
                                    <div class="checkout-methods">

                                        <a href="<?php echo site_url("checkout") ?>" class="btn btn-block btn-dark">Proceed
                                            to Checkout <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                                <!-- End .cart-summary -->
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="cart-empty-page text-center">
                                    <div class="cart-wrapper"></div>

                                    <i class="icon-shopping-cart"></i>
                                    <p class="px-3 py-2 cart-empty">No products added to the cart</p>
                                    <p class="return-to-shop">
                                        <a class="btn btn-primary" href="<?php echo site_url("shop"); ?>">
                                            Return to shop </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </main>
        <?= $this->include('frontend/partials/footer') ?>
        <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/optional/isotope.pkgd.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/plugins.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.appear.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/frontend/js/main.min.js"></script>
</body>

</html>
