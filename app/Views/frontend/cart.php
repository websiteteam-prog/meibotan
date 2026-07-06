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

    /* =========================================
       SECTION EYEBROW / HEADING (matches other pages)
       ========================================= */
    .section-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #E6F7F4;
      border: 1px solid rgba(15, 118, 110, .18);
      color: #0F766E;
      padding: 7px 20px;
      border-radius: 30px;
      margin-bottom: 14px;
    }

    .section-eyebrow i {
      font-size: 10px;
      color: #F59E0B;
    }

    .section-eyebrow span {
      font-family: 'Oswald', sans-serif;
      text-transform: uppercase;
      letter-spacing: .12em;
      font-size: 11.5px;
      font-weight: 700;
      color: #0F766E;
    }

    .section-heading {
      font-family: 'Poppins', sans-serif;
      font-size: 24px;
      font-weight: 600;
      color: #1F2937;
      line-height: 1.25;
      margin-bottom: 22px;
    }

    .section-heading span {
      color: #0F766E;
    }

    /* =========================================
       CHECKOUT PROGRESS BAR
       ========================================= */
    .checkout-progress-bar {
      list-style: none;
      padding: 0;
      margin: 34px 0 6px;
    }

    .checkout-progress-bar li {
      position: relative;
      text-align: center;
      padding: 0 46px;
    }

    .checkout-progress-bar li:not(:last-child)::after {
      content: "";
      position: absolute;
      top: 17px;
      left: 100%;
      width: 90px;
      height: 2px;
      background: #E2E8F0;
    }

    .checkout-progress-bar li.active:not(:last-child)::after {
      background: linear-gradient(90deg, #14B8A6, #0F766E);
    }

    .checkout-progress-bar li a {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      text-decoration: none !important;
      font-size: 13px;
      font-weight: 600;
      color: #9CA3AF;
    }

    .checkout-progress-bar li a::before {
      counter-increment: step;
      content: counter(step);
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: #E2E8F0;
      color: #6B7280;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      font-weight: 700;
      transition: all .3s ease;
    }

    .checkout-progress-bar {
      counter-reset: step;
    }

    .checkout-progress-bar li.active a {
      color: #0F766E;
    }

    .checkout-progress-bar li.active a::before {
      background: linear-gradient(135deg, #14B8A6, #0F766E);
      color: #fff;
      box-shadow: 0 6px 16px rgba(15, 118, 110, .3);
    }

    @media(max-width:575px) {
      .checkout-progress-bar li {
        padding: 0 18px;
      }

      .checkout-progress-bar li:not(:last-child)::after {
        width: 40px;
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
      box-shadow: 0 12px 32px rgba(15, 118, 110, .08);
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
      box-shadow: 0 4px 10px rgba(0, 0, 0, .08);
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

    @media(max-width:767px) {
      .cart-table-container {
        padding: 16px;
        overflow-x: auto;
      }

      .table-cart {
        min-width: 560px;
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
      box-shadow: 0 12px 32px rgba(15, 118, 110, .08);
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

    .coupon-box .form-control {
      border-radius: 30px 0 0 30px;
      border: 1px solid #E2E8F0;
      font-size: 13px;
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

    /* =========================================
       EMPTY CART
       ========================================= */
    .cart-empty-page {
      background: #fff;
      border-radius: 20px;
      padding: 70px 30px;
      box-shadow: 0 12px 32px rgba(15, 118, 110, .08);
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
  </style>
</head>

<body>
  <div class="page-wrapper">
    <?= $this->include('frontend/partials/header') ?>
    <main class="main cartpage">
      <div class="container">
        <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
          <li class="active"> <a href="<?php echo site_url("cart"); ?>">Cart</a> </li>
          <li class="disabled"> <a href="javascript:void(0)">Address</a> </li>
          <li class="disabled"> <a href="javascript:void(0)">Payment</a> </li>
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
                  <div class="section-eyebrow"><i class="fas fa-shopping-bag"></i><span>Your Cart</span></div>
                  <h2 class="section-heading">Shopping <span>Cart</span></h2>
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
                              <td><figure class="product-image-container"> <a href="" class="product-image">
                                    <?php if ($product_image != "") { ?>
                                      <img src="<?php echo CUSTOM_UPLOAD_PATH . $product_image; ?>">
                                    <?php } else { ?>
                                      <img src="<?php echo DEFAULT_PRODUCTIMG; ?>">
                                    <?php } ?>
                                  </a> <a href="<?php echo site_url("cart/removeitem/$enc_cartid"); ?>"
                                    class="btn-remove icon-cancel" title="Remove Item"></a> </figure></td>
                              <td class="product-col">
                                <h5 class="product-title"> <?php echo $cartrow->product_name ?>


                                </h5>

                              </td>
                              <td><?php echo "₹" . $cartrow->cart_price; ?></td>
                              <td>
                                <div class="product-single-qty">
                                  <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected"><span
                                      class="input-group-btn input-group-prepend"> </span>
                                    <input class="horizontal-quantity form-control" type="text"
                                      name="cart[<?php echo $cart_id; ?>][qty]" value="<?php echo $cartrow->cart_qty; ?>">
                                    <span class="input-group-btn input-group-append"></span>
                                  </div>
                                </div>
                                <!-- End .product-single-qty -->
                              </td>
                              <td class="text-right"><span
                                  class="subtotal-price"><?php echo "₹" . $cartrow->cart_pricetotal; ?></span></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5" class="clearfix">
                              <div class="float-left"> </div>
                              <!-- End .float-left -->

                              <div class="float-right">
                                <button type="submit" class="btn btn-shop btn-update-cart"> Update Cart </button>
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
                        <input type="text" name="coupon_code" class="form-control" placeholder="Enter Coupon Code"
                          required>

                        <button type="submit" class="btn btn-dark">
                          Apply
                        </button>
                      </div>
                    </form>
                  </div>
                  <!-- Coupon Box End -->
                  <!--<table class="table table-totals">-->
                  <!--      <tbody>-->
                  <!--    <tr>-->
                  <!--          <td>Subtotal</td>-->
                  <!--          <td><?php echo "₹".$sub_total; ?></td>-->
                  <!--        </tr>-->
                  <!--  </tbody>-->
                  <!--      <tfoot>-->
                  <!--    <tr>-->
                  <!--          <td>Total</td>-->
                  <!--          <td><?php echo "₹".$sub_total; ?></td>-->
                  <!--        </tr>-->
                  <!--  </tfoot>-->
                  <!--    </table>-->
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

                    <a href="<?php echo site_url("checkout") ?>" class="btn btn-block btn-dark">Proceed to Checkout <i
                        class="fa fa-arrow-right"></i></a>
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
