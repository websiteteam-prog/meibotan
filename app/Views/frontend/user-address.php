<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<title>
<?php if(isset($metadata['page_title'])){ echo $metadata['page_title']; } ?>
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/css/style.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/demo4.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/vendor/fontawesome-free/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/vendor/simple-line-icons/css/simple-line-icons.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/css/custom.css" />


<style type="text/css">
  .main {
    background: linear-gradient(170deg, #ECFEFF 0%, #F8FAFC 40%, #F5F8FB 100%);
  }

  .main .page-header {
    background: transparent !important;
    background-image: none !important;
    padding: 34px 0 10px;
    min-height: 0;
  }

  .main .page-header h1 {
    font-family: 'Poppins', sans-serif;
    font-size: 30px;
    font-weight: 600;
    color: #1F2937;
    margin: 6px 0 0;
  }

  .main .breadcrumb-nav .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
    justify-content: center;
  }

  .main .breadcrumb-nav .breadcrumb-item,
  .main .breadcrumb-nav .breadcrumb-item a {
    font-size: 13px;
    color: #6B7280;
    text-decoration: none;
  }

  .main .breadcrumb-nav .breadcrumb-item a:hover {
    color: #0F766E;
  }

  .main .breadcrumb-nav .breadcrumb-item.active {
    color: #0F766E;
    font-weight: 600;
  }

  .account-container {
    padding-bottom: 60px;
  }

  .dash_right {
    background: #fff;
    border: 1px solid #EEF2F7;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(15, 23, 42, .05);
    padding: 26px 26px 28px;
  }

  .acc-head {
    display: flex;
    align-items: center;
    gap: 12px;
    font-family: 'Poppins', sans-serif;
    font-size: 15px;
    font-weight: 600;
    color: #1F2937;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #EEF2F7;
  }

  .acc-head i {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #fff;
    background: linear-gradient(135deg, #14B8A6, #0F766E);
    box-shadow: 0 8px 18px rgba(15, 118, 110, .25);
  }

  .dash_right .form-label {
    font-family: 'Poppins', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
  }

  .dash_right .req {
    color: #EF4444;
  }

  .dash_right .form-control,
  .dash_right .form-select {
    height: auto;
    padding: 11px 15px;
    font-size: 14px;
    color: #1F2937;
    background-color: #FBFCFE;
    border: 1.5px solid #E4E9F1;
    border-radius: 11px;
    transition: border-color .2s, box-shadow .2s, background-color .2s;
  }

  .dash_right .form-control:focus,
  .dash_right .form-select:focus {
    border-color: #14B8A6;
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, .12);
    outline: none;
  }

  .dash_right .error {
    color: #EF4444;
    font-size: 12px;
    margin-top: 5px;
  }

  .dash_right .btn-login {
    background: linear-gradient(135deg, #14B8A6, #0F766E);
    border: none;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 15px;
    letter-spacing: .02em;
    padding: 13px 44px;
    border-radius: 50px;
    box-shadow: 0 14px 30px rgba(15, 118, 110, .30);
    transition: transform .2s, box-shadow .2s;
    margin-top: 6px;
  }

  .dash_right .btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 38px rgba(15, 118, 110, .38);
    color: #fff;
  }

  .dash_right .btn-login i {
    margin-right: 7px;
  }

  .auth-content-warning .alert {
    border-radius: 12px;
    border: none;
    font-size: 13.5px;
    font-weight: 600;
  }

  .auth-content-warning .alert-success {
    background: #DCFCE7;
    color: #15803D;
  }

  .auth-content-warning .alert-danger {
    background: #FEE2E2;
    color: #DC2626;
  }

  @media (max-width: 767px) {
    .dash_right {
      padding: 20px 16px 22px;
    }

    .dash_right .btn-login {
      width: 100%;
    }

    .main .page-header h1 {
      font-size: 24px;
    }
  }
</style>
</head>
<body>
<div class="page-wrapper">
  <?= $this->include('frontend/partials/header') ?>
  <main class="main">
  <div class="page-header">
    <div class="container d-flex flex-column align-items-center">
      <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Address </li>
          </ol>
        </div>
      </nav>
      <h1>My Address </h1>
    </div>
  </div>
  <div class="container account-container custom-account-container">
    <?php if(session()->getFlashdata('warning_error')){ ?>
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
    <?php if(session()->getFlashdata('success_msg')){ ?>
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

    <div class="row">
      <?= $this->include('frontend/partials/userdash-sidenav') ?>
      <div class="col-lg-9 order-lg-last order-1 tab-content">
        <div class="row">
          <div class="col-md-12">
            <div class="dash_right">
              <div class="acc-head"><i class="fas fa-map-marker-alt"></i> Delivery Address</div>

              <?php
              $attributes = array('class' => 'custom-form checkout_form', 'id' => 'addressform');
              echo form_open('my-address', $attributes);
              ?>
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label class="form-label">Street Address <span class="req">*</span></label>
                    <?php echo form_input(array(
                      'name' => 'user_shipaddress',
                      'id' => 'user_shipaddress',
                      'type' => 'text',
                      'class' => "form-control",
                      'value' => set_value('user_shipaddress', $userdata->user_shipaddress)
                    )); ?>
                    <?php if (isset($validation['user_shipaddress'])) { ?>
                      <div class="error"><?php echo $validation['user_shipaddress']; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label class="form-label">City <span class="req">*</span></label>
                    <?php echo form_input(array(
                      'name' => 'user_shipcity',
                      'id' => 'user_shipcity',
                      'type' => 'text',
                      'maxlength' => 400,
                      'class' => "form-control",
                      'value' => set_value('user_shipcity', $userdata->user_shipcity)
                    )); ?>
                    <?php if (isset($validation['user_shipcity'])) { ?>
                      <div class="error"><?php echo $validation['user_shipcity']; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
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
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label class="form-label">Pincode <span class="req">*</span></label>
                    <?php echo form_input(array(
                      'name' => 'user_shippincode',
                      'id' => 'user_shippincode',
                      'type' => 'text',
                      'maxlength' => 6,
                      'class' => "form-control",
                      'value' => set_value('user_shippincode', $userdata->user_shippincode)
                    )); ?>
                    <?php if (isset($validation['user_shippincode'])) { ?>
                      <div class="error"><?php echo $validation['user_shippincode']; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label class="form-label">Landmark</label>
                    <?php echo form_input(array(
                      'name' => 'user_shiplandmark',
                      'id' => 'user_shiplandmark',
                      'type' => 'text',
                      'class' => "form-control",
                      'value' => set_value('user_shiplandmark', $userdata->user_shiplandmark, false)
                    )); ?>
                    <?php if (isset($validation['user_shiplandmark'])) { ?>
                      <div class="error"><?php echo $validation['user_shiplandmark']; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label class="form-label">GSTIN Number</label>
                    <?php echo form_input(array(
                      'name' => 'user_shipgst',
                      'id' => 'user_shipgst',
                      'type' => 'text',
                      'maxlength' => 20,
                      'class' => "form-control",
                      'value' => set_value('user_shipgst', $userdata->user_shipgst)
                    )); ?>
                    <?php if (isset($validation['user_shipgst'])) { ?>
                      <div class="error"><?php echo $validation['user_shipgst']; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary rounded-pill btn-login mb-2"><i class="fas fa-check"></i> Save Address</button>
                </div>
              </div>
              <?php echo form_close(); ?>

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
