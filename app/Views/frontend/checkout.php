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
    /*==================================
      Checkout — brand tokens
    ===================================*/
    :root {
      --co-teal: #0F766E;
      --co-teal-2: #14B8A6;
      --co-amber: #F59E0B;
      --co-ink: #1F2937;
      --co-muted: #6B7280;
      --co-line: #E6EBF2;
      --co-soft: #F1F5F9;
      --co-card: #FFFFFF;
    }

    .main.checkout {
      background: linear-gradient(170deg, #ECFEFF 0%, #F8FAFC 42%, #F5F8FB 100%);
      padding: 30px 0px 50px;

    }

    .main.checkout .container {
      max-width: 1180px;
    }

    /*==================================
      Checkout Progress (stepper)
    ===================================*/
    .checkout-progress-bar {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      list-style: none;
      padding: 46px 0 30px;
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
      background: var(--co-line);
      border-radius: 20px;
      z-index: 1;
    }

    .checkout-progress-bar li.active:not(:last-child)::after {
      background: linear-gradient(90deg, var(--co-teal-2), var(--co-teal));
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
      background: linear-gradient(135deg, var(--co-teal-2), var(--co-teal));
      border: none;
      box-shadow: 0 12px 26px rgba(15, 118, 110, .28);
    }

    .checkout-progress-bar li.active .step-circle i {
      color: #fff;
    }

    .checkout-progress-bar li.active .step-title {
      color: var(--co-teal);
    }

    /* Current (step you are on) */
    .checkout-progress-bar li.current .step-circle {
      border: 3px solid var(--co-teal-2);
      box-shadow: 0 0 0 9px rgba(20, 184, 166, .12);
    }

    .checkout-progress-bar li.current .step-circle i {
      color: var(--co-teal-2);
    }

    .checkout-progress-bar li.current .step-title {
      color: var(--co-ink);
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

    /*==================================
      Cards
    ===================================*/
    .checkout_left,
    .checkout_right {
      background: var(--co-card);
      border: 1px solid #EEF2F7;
      border-radius: 18px;
      box-shadow: 0 18px 45px rgba(15, 23, 42, .06);
    }

    .checkout_left {
      padding: 30px 30px 24px;
    }

    /* Section head */
    .checkhead {
      display: flex;
      align-items: center;
      gap: 12px;
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
      font-weight: 600;
      letter-spacing: .04em;
      text-transform: uppercase;
      color: var(--co-ink);
      margin-bottom: 22px;
      padding-bottom: 16px;
      border-bottom: 1px solid #EEF2F7;
    }

    .checkhead i {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      color: #fff;
      background: linear-gradient(135deg, var(--co-teal-2), var(--co-teal));
      box-shadow: 0 8px 18px rgba(15, 118, 110, .25);
    }

    /* Form fields */
    .checkout .form-label {
      font-family: 'Poppins', sans-serif;
      font-size: 12.5px;
      font-weight: 600;
      color: #374151;
      margin-bottom: 6px;
    }

    .checkout .req {
      color: #EF4444;
    }

    .checkout .checkout_form .form-control,
    .checkout .checkout_form .form-select {
      height: auto;
      padding: 11px 15px;
      font-size: 14px;
      color: var(--co-ink);
      background-color: #FBFCFE;
      border: 1.5px solid #E4E9F1;
      border-radius: 11px;
      transition: border-color .2s, box-shadow .2s, background-color .2s;
    }

    .checkout .checkout_form .form-control:focus,
    .checkout .checkout_form .form-select:focus {
      border-color: var(--co-teal-2);
      background-color: #fff;
      box-shadow: 0 0 0 4px rgba(20, 184, 166, .12);
      outline: none;
    }

    .checkout .checkout_form .form-control::placeholder {
      color: #AEB6C2;
    }

    .checkout .error {
      color: #EF4444;
      font-size: 12px;
      margin-top: 5px;
    }

    /* Different-address checkbox */
    .checkout .custom-control {
      display: flex;
      align-items: center;
      gap: 12px;
      background: #F6FBFA;
      border: 1px dashed rgba(15, 118, 110, .30);
      border-radius: 12px;
      padding: 14px 16px;
      margin-top: 6px;
      min-height: auto;
    }

    /* neutralise the theme's custom checkbox pseudo-box so the real box aligns */
    .checkout .custom-control .custom-control-label::before,
    .checkout .custom-control .custom-control-label::after {
      display: none !important;
    }

    .checkout .custom-control .custom-control-input {
      position: static;
      z-index: auto;
      opacity: 1;
      pointer-events: auto;
      flex: 0 0 auto;
      width: 18px;
      height: 18px;
      accent-color: var(--co-teal);
      cursor: pointer;
      margin: 0;
    }

    .checkout .custom-control .custom-control-label {
      font-size: 13.5px;
      font-weight: 600;
      color: #334155;
      cursor: pointer;
      margin: 0;
      padding-left: 0;
    }

    #collapseFour .deladdress {
      background: #F9FBFD;
      border: 1px solid #EEF2F7;
      border-radius: 14px;
      padding: 22px 22px 6px;
      margin-top: 20px;
    }

    #collapseFour .checkhead {
      margin-bottom: 18px;
    }

    /* Submit button */
    .checkout .btn-login {
      background: linear-gradient(135deg, var(--co-teal-2), var(--co-teal));
      border: none;
      color: #fff;
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      font-size: 15px;
      letter-spacing: .02em;
      padding: 14px 40px;
      border-radius: 50px;
      box-shadow: 0 14px 30px rgba(15, 118, 110, .30);
      transition: transform .2s, box-shadow .2s;
    }

    .checkout .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 18px 38px rgba(15, 118, 110, .38);
      color: #fff;
    }

    /* icon spacing (Bootstrap-version independent) */
    .checkout .btn-login i {
      margin-right: 7px;
    }

    .checkout .co-discount .co-label i {
      margin-right: 5px;
    }

    /*==================================
      Order Summary card
    ===================================*/
    .checkout_right {
      padding: 26px 26px 28px;
      position: sticky;
      top: 24px;
    }

    .order-summary h3 {
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: 'Poppins', sans-serif;
      font-size: 18px;
      font-weight: 600;
      color: var(--co-ink);
      margin: 0 0 20px;
      padding-bottom: 16px;
      border-bottom: 1px solid #EEF2F7;
    }

    .order-summary h3 i {
      color: var(--co-teal);
    }

    /* Product rows */
    .co-item {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 14px 0;
      border-bottom: 1px dashed #EAF0F6;
    }

    .co-item:first-child {
      padding-top: 0;
    }

    .co-thumb {
      position: relative;
      flex: 0 0 64px;
      width: 64px;
      height: 64px;
      border-radius: 12px;
      background: #fff;
      border: 1px solid #E2E8F0;
    }

    /* keep the image rounded here so the badge (outside the box) isn't clipped */
    .co-thumb a {
      display: block;
      width: 100%;
      height: 100%;
      border-radius: 11px;
      overflow: hidden;
    }

    .co-thumb img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      padding: 5px;
      display: block;
    }

    .co-qty-badge {
      position: absolute;
      top: -9px;
      right: -9px;
      z-index: 3;
      min-width: 23px;
      height: 23px;
      padding: 0 6px;
      border-radius: 23px;
      background: linear-gradient(135deg, var(--co-teal-2), var(--co-teal));
      color: #fff;
      font-size: 11.5px;
      font-weight: 700;
      line-height: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 5px 12px rgba(15, 118, 110, .30);
      border: 2px solid #fff;
    }

    .co-item-info {
      flex: 1;
      min-width: 0;
    }

    .co-item-info .co-name {
      display: block;
      font-family: 'Poppins', sans-serif;
      font-size: 13.5px;
      font-weight: 600;
      color: var(--co-ink);
      line-height: 1.4;
      text-decoration: none;
    }

    .co-item-info .co-name:hover {
      color: var(--co-teal);
    }

    .co-item-info .co-meta {
      font-size: 12px;
      color: var(--co-muted);
      margin-top: 3px;
    }

    .co-item .co-line-price {
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      font-weight: 700;
      color: var(--co-ink);
      white-space: nowrap;
    }

    /* Coupon box */
    .co-coupon {
      margin-top: 18px;
      background: #F8FAFC;
      border: 1px solid #E7EDF3;
      border-radius: 14px;
      padding: 16px;
    }

    .co-coupon h4 {
      display: flex;
      align-items: center;
      gap: 7px;
      font-family: 'Poppins', sans-serif;
      font-size: 13px;
      font-weight: 600;
      color: var(--co-ink);
      margin: 0 0 12px;
    }

    .co-coupon h4 i {
      color: var(--co-amber);
    }

    .co-coupon .input-group {
      display: flex;
    }

    .co-coupon .form-control {
      flex: 1;
      min-width: 0;
      height: auto;
      padding: 11px 16px;
      font-size: 13px;
      color: var(--co-ink);
      border: 1.5px solid #E4E9F1;
      border-right: none;
      border-radius: 30px 0 0 30px;
      background: #fff;
    }

    .co-coupon .form-control:focus {
      border-color: var(--co-teal-2);
      box-shadow: none;
      outline: none;
    }

    .co-coupon .btn-apply {
      border: none;
      border-radius: 0 30px 30px 0;
      padding: 0 22px;
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      font-size: 13px;
      letter-spacing: .03em;
      text-transform: uppercase;
      color: #fff;
      background: linear-gradient(135deg, var(--co-teal-2), var(--co-teal));
      transition: background .25s ease;
      white-space: nowrap;
    }

    .co-coupon .btn-apply:hover {
      background: var(--co-amber);
      color: #fff;
    }

    .co-coupon-applied {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-top: 11px;
      font-size: 12px;
      font-weight: 600;
      color: #059669;
    }

    /* Totals */
    .co-totals {
      margin-top: 18px;
      padding-top: 4px;
    }

    .co-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      font-size: 14px;
      color: #475467;
    }

    .co-row .co-label .inc_tax {
      font-size: 11px;
      color: #98A2B3;
      font-weight: 500;
    }

    .co-row.co-discount {
      color: #059669;
      font-weight: 600;
    }

    .co-payable {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 14px;
      padding: 16px 18px;
      border-radius: 14px;
      background: linear-gradient(135deg, #ECFDF5, #E6F7F4);
      border: 1px solid rgba(15, 118, 110, .16);
    }

    .co-payable .co-payable-label {
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      font-weight: 600;
      color: var(--co-ink);
    }

    .co-payable .co-payable-label .inc_tax {
      display: block;
      font-size: 11px;
      font-weight: 500;
      color: #6B7280;
      margin-top: 2px;
    }

    .co-payable .co-payable-amt {
      text-align: right;
    }

    .co-payable .total-price span {
      font-family: 'Poppins', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: var(--co-teal);
    }

    .co-payable .includes_tax {
      display: block;
      font-size: 11px;
      color: #6B7280;
      margin-top: 2px;
    }

    /* Continue to Payment button (below order summary) */
    .co-cta {
      margin-top: 18px;
    }

    .co-cta .btn-login {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
    }

    .co-trust {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 16px;
      font-size: 12px;
      color: #667085;
    }

    .co-trust i {
      color: var(--co-teal-2);
    }

    /* Alerts spacing */
    .checkout .auth-content-warning {
      margin-bottom: 6px;
    }

    /*==================================
      Responsive
    ===================================*/
    @media (max-width: 991px) {
      .checkout_right {
        position: static;
        margin-top: 24px;
      }
    }

    @media (max-width: 768px) {

      /* keep the stepper horizontal but compact on mobile */
      .checkout-progress-bar {
        padding: 26px 0 16px;
      }

      .checkout-progress-bar li {
        max-width: none;
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
        left: calc(50% + 50px);
        width: calc(100% - 52px);
        height: 3px;
      }

      .checkout_left {
        padding: 22px 18px 18px;
      }

      .checkout_right {
        padding: 22px 18px;
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
        left: calc(50% + 23px);
        width: calc(100% - 46px);
      }
    }
  </style>
</head>

<body>
  <div class="page-wrapper">
    <?= $this->include('frontend/partials/header') ?>
    <main class="main checkout">
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
            <a href="javascript:void(0)">

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
        <?php if (session()->has('stockerror')) {
          $stockerror = session()->get('stockerror');
          if ($stockerror) {
            foreach ($stockerror as $qtyerror_row) { ?>
              <div class="row">
                <div class="col-lg-12">
                  <div class="auth-content-warning my-auto">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"> <?php echo $qtyerror_row; ?>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }
          }
        }
        ?>
        <div class="row">
          <div class="col-lg-7">
            <div class="row">
              <div class="col-md-12">
                <div class="checkout_left checkout_pad">
                  <?php

                  $attributes = array('class' => 'custom-form checkout_form', 'id' => 'loginform');
                  echo form_open('checkout', $attributes);
                  ?>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="deladdress">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="checkhead"><i class="fa fa-home"></i> SHIPPING ADDRESS</div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div>
                              <div class="mb-2">
                                <label class="form-label">Name <span class="req">*</span></label>
                                <?php echo form_input(array(
                                  'name' => 'user_shipname',
                                  'id' => 'user_shipname',
                                  'type' => 'text',
                                  'maxlength' => 400,
                                  'class' => "form-control",
                                  'value' => set_value('user_shipname', $userdata->user_shipname)
                                ));

                                ?>
                                <?php if (isset($validation['user_shipname'])) { ?>
                                  <div class="error"><?php echo $validation['user_shipname']; ?></div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div>
                              <div class="mb-2">
                                <label class="form-label">Company Name </label>
                                <?php echo form_input(array(
                                  'name' => 'user_shipcompname',
                                  'id' => 'user_shipcompname',
                                  'type' => 'text',
                                  'maxlength' => 400,
                                  'class' => "form-control",
                                  'value' => set_value('user_shipcompname', $userdata->user_shipcompname)
                                ));

                                ?>
                                <?php if (isset($validation['user_shipcompname'])) { ?>
                                  <div class="error"><?php echo $validation['user_shipcompname']; ?></div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12">
                            <div>
                              <div class="mb-2">
                                <label class="form-label">Street Address <span class="req">*</span></label>
                                <?php echo form_input(array(
                                  'name' => 'user_shipaddress',
                                  'id' => 'user_shipaddress',
                                  'type' => 'text',
                                  'class' => "form-control",
                                  'value' => set_value('user_shipaddress', $userdata->user_shipaddress)
                                ));

                                ?>
                                <?php if (isset($validation['user_shipaddress'])) { ?>
                                  <div class="error"><?php echo $validation['user_shipaddress']; ?></div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div>
                              <div class="mb-2">
                                <label class="form-label">City <span class="req">*</span></label>
                                <?php echo form_input(array(
                                  'name' => 'user_shipcity',
                                  'id' => 'user_shipcity',
                                  'type' => 'text',
                                  'maxlength' => 400,
                                  'class' => "form-control",
                                  'value' => set_value('user_shipcity', $userdata->user_shipcity)
                                ));

                                ?>
                                <?php if (isset($validation['user_shipcity'])) { ?>
                                  <div class="error"><?php echo $validation['user_shipcity']; ?></div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div>
                              <div class="mb-2">
                                <label class="form-label">State <span class="req">*</span></label>
                                <select name="user_shipstate" class="form-control form-select">
                                  <option value="">--Select--</option>
                                  <?php foreach ($statedata as $staterow) { ?>
                                    <option value="<?php echo $staterow->state_id; ?>" <?php echo set_select('user_shipstate', $staterow->state_id, $userdata->user_shipstate == $staterow->state_id); ?>>
                                      <?php echo $staterow->state_name; ?>
                                    </option>
                                  <?php } ?>
                                </select>
                                <?php if (isset($validation['user_shipstate'])) { ?>
                                  <div class="error"><?php echo $validation['user_shipstate']; ?></div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div>
                              <div class="mb-2">
                                <label class="form-label">Pincode <span class="req">*</span></label>
                                <?php echo form_input(array(
                                  'name' => 'user_shippincode',
                                  'id' => 'user_shippincode',
                                  'type' => 'text',
                                  'maxlength' => 6,
                                  'class' => "form-control",
                                  'value' => set_value('user_shippincode', $userdata->user_shippincode)
                                ));

                                ?>
                                <?php if (isset($validation['user_shippincode'])) { ?>
                                  <div class="error"><?php echo $validation['user_shippincode']; ?></div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div>
                              <div class="mb-2">
                                <label class="form-label">Landmark </label>
                                <?php echo form_input(array(
                                  'name' => 'user_shiplandmark',
                                  'id' => 'user_shiplandmark',
                                  'type' => 'text',
                                  'class' => "form-control",
                                  'value' => set_value('user_shiplandmark', $userdata->user_shiplandmark, false)
                                ));

                                ?>
                                <?php if (isset($validation['user_shiplandmark'])) { ?>
                                  <div class="error"><?php echo $validation['user_shiplandmark']; ?></div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12">
                            <div>
                              <div class="mb-2">
                                <label class="form-label">Mobile No. <span class="req">*</span></label>
                                <?php echo form_input(array(
                                  'name' => 'user_shipmobile',
                                  'id' => 'user_shipmobile',
                                  'type' => 'text',
                                  'maxlength' => 10,
                                  'class' => "form-control",
                                  'value' => set_value('user_shipmobile', $userdata->user_shipmobile)
                                ));

                                ?>
                                <?php if (isset($validation['user_shipmobile'])) { ?>
                                  <div class="error"><?php echo $validation['user_shipmobile']; ?></div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>

                        </div>
                        <div class="row">
                          <div class="col-lg-12">
                            <div>
                              <div class="mb-2">
                                <label class="form-label">GSTIN Number </label>
                                <?php echo form_input(array(
                                  'name' => 'user_shipgst',
                                  'id' => 'user_shipgst',
                                  'type' => 'text',
                                  'maxlength' => 20,
                                  'class' => "form-control",
                                  'value' => set_value('user_shipgst', $userdata->user_shipgst)
                                ));

                                ?>
                                <?php if (isset($validation['user_shipgst'])) { ?>
                                  <div class="error"><?php echo $validation['user_shipgst']; ?></div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="custom-control custom-checkbox mt-0">
                                <input type="checkbox" class="custom-control-input" id="different-shipping" value="1"
                                  <?php echo set_checkbox('user_billsame', 1); ?> name="user_billsame">
                                <label class="custom-control-label" data-toggle="collapse" data-target="#collapseFour"
                                  aria-controls="collapseFour" for="different-shipping" aria-expanded="true">My billing
                                  and shipping address are different</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div id="collapseFour" class="collapse">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="deladdress">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="checkhead"><i class="fa fa-home"></i> BILLING ADDRESS</div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-6">
                                  <div>
                                    <div class="mb-2">
                                      <label class="form-label">Name <span class="req">*</span></label>
                                      <?php echo form_input(array(
                                        'name' => 'user_billname',
                                        'id' => 'user_billname',
                                        'type' => 'text',
                                        'maxlength' => 400,
                                        'class' => "form-control",
                                        'value' => set_value('user_billname', $userdata->user_billname)
                                      ));

                                      ?>
                                      <?php if (isset($validation['user_billname'])) { ?>
                                        <div class="error"><?php echo $validation['user_billname']; ?></div>
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div>
                                    <div class="mb-2">
                                      <label class="form-label">Company Name </label>
                                      <?php echo form_input(array(
                                        'name' => 'user_billcompname',
                                        'id' => 'user_billcompname',
                                        'type' => 'text',
                                        'maxlength' => 400,
                                        'class' => "form-control",
                                        'value' => set_value('user_billcompname', $userdata->user_billcompname)
                                      ));

                                      ?>
                                      <?php if (isset($validation['user_billcompname'])) { ?>
                                        <div class="error"><?php echo $validation['user_billcompname']; ?></div>
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>

                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                  <div>
                                    <div class="mb-2">
                                      <label class="form-label">Street Address <span class="req">*</span></label>
                                      <?php echo form_input(array(
                                        'name' => 'user_billaddress',
                                        'id' => 'user_billaddress',
                                        'type' => 'text',
                                        'class' => "form-control",
                                        'value' => set_value('user_billaddress', $userdata->user_billaddress)
                                      ));

                                      ?>
                                      <?php if (isset($validation['user_billaddress'])) { ?>
                                        <div class="error"><?php echo $validation['user_billaddress']; ?></div>
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-6">
                                  <div>
                                    <div class="mb-2">
                                      <label class="form-label">City <span class="req">*</span></label>
                                      <?php echo form_input(array(
                                        'name' => 'user_billcity',
                                        'id' => 'user_billcity',
                                        'type' => 'text',
                                        'maxlength' => 400,
                                        'class' => "form-control",
                                        'value' => set_value('user_billcity', $userdata->user_billcity)
                                      ));

                                      ?>
                                      <?php if (isset($validation['user_billcity'])) { ?>
                                        <div class="error"><?php echo $validation['user_billcity']; ?></div>
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div>
                                    <div class="mb-2">
                                      <label class="form-label">State <span class="req">*</span></label>
                                      <select name="user_billstate" class="form-control form-select">
                                        <option value="">--Select--</option>
                                        <?php foreach ($statedata as $staterow) { ?>
                                          <option value="<?php echo $staterow->state_id; ?>" <?php echo set_select('user_billstate', $staterow->state_id, $userdata->user_billstate == $staterow->state_id); ?>>
                                            <?php echo $staterow->state_name; ?>
                                          </option>
                                        <?php } ?>
                                      </select>
                                      <?php if (isset($validation['user_billstate'])) { ?>
                                        <div class="error"><?php echo $validation['user_billstate']; ?></div>
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                  <div>
                                    <div class="mb-2">
                                      <label class="form-label">Pincode <span class="req">*</span></label>
                                      <?php echo form_input(array(
                                        'name' => 'user_billpincode',
                                        'id' => 'user_billpincode',
                                        'type' => 'text',
                                        'maxlength' => 6,
                                        'class' => "form-control",
                                        'value' => set_value('user_billpincode', $userdata->user_billpincode, $userdata->user_billpincode)
                                      ));

                                      ?>
                                      <?php if (isset($validation['user_billpincode'])) { ?>
                                        <div class="error"><?php echo $validation['user_billpincode']; ?></div>
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>

                              </div>

                              <div class="row">
                                <div class="col-lg-12">
                                  <div>
                                    <div class="mb-2">
                                      <label class="form-label">GSTIN Number </label>
                                      <?php echo form_input(array(
                                        'name' => 'user_billgst',
                                        'id' => 'user_billgst',
                                        'type' => 'text',
                                        'maxlength' => 20,
                                        'class' => "form-control",
                                        'value' => set_value('user_billgst', $userdata->user_billgst)
                                      ));

                                      ?>
                                      <?php if (isset($validation['user_billgst'])) { ?>
                                        <div class="error"><?php echo $validation['user_billgst']; ?></div>
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php echo form_close(); ?>

                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="row">
              <div class="col-md-12">
                <div class="checkout_right">
                  <div class="order-summary">
                    <h3><i class="fas fa-receipt"></i> Order Summary</h3>

                    <div class="co-items">
                      <?php
                      $sub_total = 0;

                      foreach ($cartdata as $cartrow) {
                        $cart_productid = $cartrow->cart_productid;
                        $customenc = service('customencscript');

                        $enc_productid = $customenc->encrypt($cart_productid, ENC_KEY_PASS);
                        $sub_total = $sub_total + $cartrow->cart_pricetotal;
                        $commfrontfunc = service('commfrontfunc');
                        $prodata = $commfrontfunc->getPerProduct($cart_productid);
                        $pro_slug = $prodata->product_slug;

                        // Product thumbnail — same source as the cart page.
                        $product_image = $cartrow->product_thumb ?? '';
                        $co_prodimg = ($product_image != "")
                          ? CUSTOM_UPLOAD_PATH . $product_image
                          : DEFAULT_PRODUCTIMG;
                        ?>
                        <div class="co-item">
                          <div class="co-thumb">
                            <a href="<?php echo site_url("product/$pro_slug"); ?>" target="_blank">
                              <img src="<?php echo $co_prodimg; ?>" alt="<?php echo esc($cartrow->product_name); ?>"
                                onerror="this.onerror=null;this.src='<?php echo DEFAULT_PRODUCTIMG; ?>';">
                            </a>
                            <span class="co-qty-badge"><?php echo $cartrow->cart_qty; ?></span>
                          </div>
                          <div class="co-item-info">
                            <a class="co-name" href="<?php echo site_url("product/$pro_slug"); ?>"
                              target="_blank"><?php echo $cartrow->product_name; ?></a>
                            <div class="co-meta">Qty: <?php echo $cartrow->cart_qty; ?></div>
                          </div>
                          <div class="co-line-price">₹<?php echo $cartrow->cart_pricetotal; ?></div>
                        </div>
                      <?php } ?>
                    </div>

                    <div class="co-coupon">
                      <h4><i class="fas fa-tag"></i> Apply Coupon</h4>
                      <form method="post" action="<?php echo site_url('cart/apply_coupon'); ?>">
                        <div class="input-group">
                          <input type="text" name="coupon_code" class="form-control" placeholder="Enter Coupon Code"
                            required>
                          <button type="submit" class="btn-apply">Apply</button>
                        </div>
                      </form>
                      <?php if ((session()->get('coupon_discount') ?? 0) > 0) { ?>
                        <div class="co-coupon-applied">
                          <i class="fas fa-check-circle"></i> Coupon applied — you saved
                          ₹<?php echo session()->get('coupon_discount'); ?>
                        </div>
                      <?php } ?>
                    </div>

                    <div class="co-totals">
                      <div class="co-row">
                        <div class="co-label">Subtotal <span class="inc_tax">(Incl. GST)</span></div>
                        <div class="co-value">₹<?php echo $sub_total; ?></div>
                      </div>
                      <?php
                      $taxrate = $gstsetdata->gstset_taxrate;
                      $gstcalc = service('gstcalc');
                      $gstinc = $gstcalc->getGstInclude($sub_total, $taxrate);

                      $discount = session()->get('coupon_discount') ?? 0;
                      $final_total = $sub_total - $discount;
                      ?>
                      <?php if ($discount > 0) { ?>
                        <div class="co-row co-discount">
                          <div class="co-label"><i class="fas fa-tag me-1"></i> Coupon Discount</div>
                          <div class="co-value">- ₹<?php echo $discount; ?></div>
                        </div>
                      <?php } ?>
                    </div>

                    <div class="co-payable">
                      <div class="co-payable-label">
                        Payable Amount
                        <span class="inc_tax">(Incl. GST)</span>
                      </div>
                      <div class="co-payable-amt">
                        <b class="total-price"><span>₹<?php echo $final_total; ?></span></b>
                        <span class="includes_tax">(includes ₹<?php echo $gstinc; ?> GST)</span>
                      </div>
                    </div>

                    <div class="co-cta">
                      <button type="submit" form="loginform"
                        class="btn btn-primary rounded-pill btn-login btn_round">
                        <i class="fas fa-lock"></i> Continue to Payment</button>
                    </div>

                    <div class="co-trust">
                      <i class="fas fa-shield-alt"></i> Secure &amp; encrypted checkout
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
