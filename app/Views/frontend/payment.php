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
      Payment — brand tokens
    ===================================*/
    :root {
      --co-teal: #0F766E;
      --co-teal-2: #14B8A6;
      --co-amber: #F59E0B;
      --co-ink: #1F2937;
      --co-muted: #6B7280;
      --co-line: #E6EBF2;
      --co-card: #FFFFFF;
    }

    .main.checkout {
      background: linear-gradient(170deg, #ECFEFF 0%, #F8FAFC 42%, #F5F8FB 100%);
      padding-bottom: 70px;
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

    .checkout-progress-bar li:not(:last-child)::after {
      content: "";
      position: absolute;
      top: 27px;
      left: calc(50% + 34px);
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
    .checkout_left {
      background: var(--co-card);
      border: 1px solid #EEF2F7;
      border-radius: 18px;
      box-shadow: 0 18px 45px rgba(15, 23, 42, .06);
      padding: 26px 28px;
      margin-bottom: 22px;
    }

    .checkout_right {
      background: var(--co-card);
      border: 1px solid #EEF2F7;
      border-radius: 18px;
      box-shadow: 0 18px 45px rgba(15, 23, 42, .06);
      padding: 26px 26px 28px;
      position: sticky;
      top: 24px;
    }

    /* Section header */
    .sechead {
      display: flex;
      align-items: center;
      gap: 11px;
      font-family: 'Poppins', sans-serif;
      font-size: 16px;
      font-weight: 600;
      color: var(--co-ink);
      margin: 0 0 4px;
    }

    .sechead::before {
      content: "";
      width: 34px;
      height: 34px;
      border-radius: 10px;
      flex: 0 0 34px;
      background: linear-gradient(135deg, var(--co-teal-2), var(--co-teal));
      box-shadow: 0 8px 16px rgba(15, 118, 110, .22);
    }

    .deladdress_box .sechead.addr::before {
      background: linear-gradient(135deg, var(--co-teal-2), var(--co-teal))
        url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' viewBox='0 0 384 512'><path d='M215.7 499.2C267 435 384 279.4 384 192 384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2 12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z'/></svg>") center/16px no-repeat;
    }

    /* Change button */
    .change_btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-family: 'Poppins', sans-serif;
      font-size: 12.5px;
      font-weight: 600;
      color: var(--co-teal);
      background: #E6F7F4;
      border: 1px solid rgba(15, 118, 110, .18);
      padding: 7px 16px;
      border-radius: 30px;
      text-decoration: none;
      transition: all .25s ease;
    }

    .change_btn:hover {
      background: var(--co-teal);
      color: #fff;
    }

    /* Delivery address text */
    .address-block {
      margin-top: 14px;
      padding: 16px 18px;
      background: #F8FAFC;
      border: 1px solid #EEF2F7;
      border-radius: 12px;
      font-size: 13.5px;
      color: #475467;
      line-height: 1.7;
    }

    .address-block .addr-name {
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      color: var(--co-ink);
      font-size: 14.5px;
    }

    .address-block strong {
      color: var(--co-ink);
    }

    /* Order note */
    .noterow {
      margin-top: 18px;
    }

    .noterow .form-label {
      font-family: 'Poppins', sans-serif;
      font-size: 12.5px;
      font-weight: 600;
      color: #374151;
      margin-bottom: 6px;
    }

    .checkout .form-control {
      font-size: 14px;
      color: var(--co-ink);
      background-color: #FBFCFE;
      border: 1.5px solid #E4E9F1;
      border-radius: 11px;
      padding: 11px 15px;
      transition: border-color .2s, box-shadow .2s, background-color .2s;
    }

    .checkout .form-control:focus {
      border-color: var(--co-teal-2);
      background-color: #fff;
      box-shadow: 0 0 0 4px rgba(20, 184, 166, .12);
      outline: none;
    }

    .checkout .error {
      color: #EF4444;
      font-size: 12px;
      margin-top: 5px;
    }

    /* Payment method options */
    .pay-options {
      margin-top: 16px;
      display: grid;
      gap: 12px;
    }

    .pay-option {
      display: block;
      margin: 0;
      cursor: pointer;
    }

    .pay-option .pay-input {
      position: absolute;
      opacity: 0;
      pointer-events: none;
    }

    .pay-option .pay-card {
      display: flex;
      align-items: center;
      gap: 13px;
      padding: 15px 18px;
      border: 1.5px solid #E4E9F1;
      border-radius: 13px;
      background: #FBFCFE;
      transition: all .22s ease;
    }

    .pay-option .pay-dot {
      flex: 0 0 20px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      border: 2px solid #CBD5E1;
      position: relative;
      transition: all .22s ease;
    }

    .pay-option .pay-name {
      flex: 1;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      font-weight: 600;
      color: var(--co-ink);
    }

    .pay-option .pay-check {
      color: var(--co-teal);
      font-size: 15px;
      opacity: 0;
      transition: opacity .22s ease;
    }

    .pay-option:hover .pay-card {
      border-color: var(--co-teal-2);
      background: #F6FBFA;
    }

    .pay-option .pay-input:checked+.pay-card {
      border-color: var(--co-teal-2);
      background: #ECFDF5;
      box-shadow: 0 0 0 4px rgba(20, 184, 166, .10);
    }

    .pay-option .pay-input:checked+.pay-card .pay-dot {
      border-color: var(--co-teal);
      background: radial-gradient(circle at center, var(--co-teal) 0 6px, #fff 7px 100%);
    }

    .pay-option .pay-input:checked+.pay-card .pay-check {
      opacity: 1;
    }

    .pay-option .pay-input:focus-visible+.pay-card {
      box-shadow: 0 0 0 4px rgba(20, 184, 166, .20);
    }

    /* Pay Now button */
    .checkout .btn-login {
      background: linear-gradient(135deg, var(--co-teal-2), var(--co-teal));
      border: none;
      color: #fff;
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      font-size: 15px;
      letter-spacing: .02em;
      padding: 14px 44px;
      border-radius: 50px;
      box-shadow: 0 14px 30px rgba(15, 118, 110, .30);
      transition: transform .2s, box-shadow .2s;
      margin-top: 22px;
    }

    .checkout .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 18px 38px rgba(15, 118, 110, .38);
      color: #fff;
    }

    .notepay {
      font-size: 12px;
      color: var(--co-muted);
      margin-top: 12px;
      display: flex;
      align-items: center;
      gap: 7px;
    }

    .notepay::before {
      content: "\f05a";
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      color: var(--co-teal-2);
    }

    /*==================================
      Order Summary card
    ===================================*/
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

    .order-summary h3::before {
      content: "\f543";
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      color: var(--co-teal);
      font-size: 16px;
    }

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

    .co-trust {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 18px;
      font-size: 12px;
      color: #667085;
    }

    .co-trust i {
      color: var(--co-teal-2);
    }

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
      .checkout-progress-bar {
        padding: 26px 0 14px;
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
        left: calc(50% + 26px);
        width: calc(100% - 52px);
        height: 3px;
      }

      .checkout_left {
        padding: 22px 18px;
      }

      .checkout_right {
        padding: 22px 18px;
      }

      .checkout .btn-login {
        width: 100%;
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

          <li class="active">
            <a href="<?= site_url('checkout'); ?>">

              <span class="step-circle">
                <i class="fas fa-map-marker-alt"></i>
              </span>

              <span class="step-title">
                Delivery Address
              </span>

            </a>
          </li>

          <li class="current">
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
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <?php echo $qtyerror_row; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            }
          }
        }
        ?>
        <?php if (isset($validation['payment_method'])) { ?>
          <div class="row">
            <div class="col-md-12">
              <div class="auth-content-warning my-auto">
                <div class="alert alert-danger alert-dismissible fade show"><?php echo $validation['payment_method']; ?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>


        <div class="row">

          <div class="col-lg-7">
            <div class="row">
              <div class="col-md-12">
                <?php
                $attributes = array('class' => 'custom-form checkout', 'id' => 'loginform');
                echo form_open('checkout/payment', $attributes);
                ?>
                <div class="checkout_left">
                  <div class="deladdress_box">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <h4 class="sechead addr">Delivery Address</h4>
                      </div>
                      <div class="col-4 text-right">
                        <a href="<?php echo site_url("checkout"); ?>" class="change_btn"><i
                            class="fas fa-pen"></i> Change</a>
                      </div>
                    </div>
                    <div class="address-block">
                      <span class="addr-name"><?php echo $userdata->user_shipname; ?></span>
                      <?php if ($userdata->user_shipcompname != "") {
                        echo "<br/>" . $userdata->user_shipcompname;
                      } ?>
                      <br />
                      <?php echo $userdata->user_shipaddress; ?><?php if ($userdata->user_shipcity != "") {
                           echo ", " . $userdata->user_shipcity;
                         } ?><?php if ($userdata->user_shipstate != "") {
                            echo ", " . $userdata->state_name;
                          } ?><?php if ($userdata->user_shippincode != "") {
                             echo ", " . $userdata->user_shippincode;
                           } ?><?php if ($userdata->user_shiplandmark != "") {
                              echo "<br/><strong>Landmark:</strong> " . $userdata->user_shiplandmark;
                            } ?><?php if ($userdata->user_shipmobile != "") {
                               echo "<br/><strong>Phone:</strong> " . $userdata->user_shipmobile;
                             } ?>
                    </div>
                    <div class="row noterow">
                      <div class="col-md-8">
                        <div class="form-row">
                          <label class="form-label">Order Note </label>
                          <?php echo form_textarea(array(
                            'name' => 'order_note',
                            'id' => 'order_note',
                            'rows' => 2,
                            'class' => "form-control",
                            'placeholder' => 'Any special instructions for your order (optional)',
                            'value' => set_value('order_note')
                          ));

                          ?>
                          <?php if (isset($validation['order_note'])) { ?>
                            <div class="error"><?php echo $validation['order_note']; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="checkout_left">
                  <div class="deladdress_box">
                    <h4 class="sechead">Payment Method</h4>

                    <div class="pay-options">
                      <?php foreach ($paymethoddata as $paymethodrow) { ?>
                        <label class="pay-option">
                          <input type="radio" class="pay-input payment_method"
                            <?= set_radio('payment_method', $paymethodrow->paymethod_id) ?>
                            value="<?php echo $paymethodrow->paymethod_id; ?>" name="payment_method">
                          <span class="pay-card">
                            <span class="pay-dot"></span>
                            <span class="pay-name"><?php echo $paymethodrow->paymethod_title; ?></span>
                            <i class="fas fa-check-circle pay-check"></i>
                          </span>
                        </label>
                      <?php } ?>
                    </div>

                    <div>
                      <button type="submit" class="btn btn-primary rounded-pill btn-login btn_round mb-2">
                        <i class="fas fa-lock me-2"></i> Pay Now</button>
                      <p class="notepay">On clicking Pay Now you will be redirected to the payment gateway website</p>
                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="row">
              <div class="col-md-12">
                <div class="checkout_right">
                  <div class="order-summary">
                    <h3>Order Summary</h3>

                    <div class="co-items">
                      <?php
                      $sub_total = 0;

                      foreach ($cartdata as $cartrow) {
                        $cart_productid = $cartrow->cart_productid;
                        $customenc = service('customencscript');
                        $enc_productid = $customenc->encrypt($cart_productid, ENC_KEY_PASS);
                        $sub_total = $sub_total + $cartrow->cart_pricetotal;

                        // Product thumbnail — same source as the cart page.
                        $product_image = $cartrow->product_thumb ?? '';
                        $co_prodimg = ($product_image != "")
                          ? CUSTOM_UPLOAD_PATH . $product_image
                          : DEFAULT_PRODUCTIMG;
                        ?>
                        <div class="co-item">
                          <div class="co-thumb">
                            <a href="<?php echo site_url("product-detail/$enc_productid"); ?>" target="_blank">
                              <img src="<?php echo $co_prodimg; ?>" alt="<?php echo esc($cartrow->product_name); ?>"
                                onerror="this.onerror=null;this.src='<?php echo DEFAULT_PRODUCTIMG; ?>';">
                            </a>
                            <span class="co-qty-badge"><?php echo $cartrow->cart_qty; ?></span>
                          </div>
                          <div class="co-item-info">
                            <a class="co-name" href="<?php echo site_url("product-detail/$enc_productid"); ?>"
                              target="_blank"><?php echo $cartrow->product_name; ?></a>
                            <div class="co-meta">Qty: <?php echo $cartrow->cart_qty; ?></div>
                          </div>
                          <div class="co-line-price">₹<?php echo $cartrow->cart_pricetotal; ?></div>
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

                    <div class="co-trust">
                      <i class="fas fa-shield-alt"></i> Secure &amp; encrypted payment
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
