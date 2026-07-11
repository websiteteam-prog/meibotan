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

  /* Section header */
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

  /* Form */
  .dash_right form.custom-form {
    max-width: 580px;
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

  .dash_right .form-control {
    height: auto;
    padding: 11px 15px;
    font-size: 14px;
    color: #1F2937;
    background-color: #FBFCFE;
    border: 1.5px solid #E4E9F1;
    border-radius: 11px;
    transition: border-color .2s, box-shadow .2s, background-color .2s;
  }

  .dash_right .form-control:focus {
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

  /* Password show/hide */
  .pw-wrap {
    position: relative;
  }

  .pw-wrap .form-control {
    padding-right: 46px;
  }

  .pw-toggle {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
    width: 34px;
    height: 34px;
    border: none;
    background: transparent;
    color: #98A2B3;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: color .2s ease;
  }

  .pw-toggle:hover {
    color: #0F766E;
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

  /* Flash */
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
            <li class="breadcrumb-item active" aria-current="page">Change Password </li>
          </ol>
        </div>
      </nav>
      <h1>Change Password </h1>
    </div>
  </div>
  			<div class="container account-container custom-account-container">
            <?php if(session()->getFlashdata('warning_error')){ ?>
          <div class="row">
            <div class="col-lg-12">
              <div class="auth-content-warning my-auto">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?=  session()->getFlashdata('warning_error'); ?>
                </div>
              </div>
            </div>
          </div>
          <?php }  ?>
          <?php if(session()->getFlashdata('success_msg')){ ?>
          <div class="row">
            <div class="col-lg-12">
              <div class="auth-content-warning my-auto">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?=  session()->getFlashdata('success_msg'); ?>
                </div>
              </div>
            </div>
          </div>
          <?php }  ?>


				<div class="row">


                         <?= $this->include('frontend/partials/userdash-sidenav') ?>

					<div class="col-lg-9 order-lg-last order-1 tab-content">
								<div class="row">
                                	<div class="col-md-12">
							<div class="dash_right">
                            <div class="acc-head"><i class="fas fa-lock"></i> Change Password</div>
                           		 <?php

            $attributes=array('class' => 'custom-form ', 'id' => 'loginform');
            echo form_open('change-password', $attributes);
            ?>
          <div class="row">
            <div class="col-lg-12">
              <div>
                <div class="mb-3">
                  <label  class="form-label">Current password <span class="req">*</span></label>
                  <div class="pw-wrap">
                  <?php echo form_input ( array(
                'name' => 'current_password',
                'id' => 'current_password',
                'type' => 'password',
                'maxlength' => 400,
                'class' => "form-control",
                'value' => set_value( 'current_password')));

                ?>
                  <button type="button" class="pw-toggle" data-target="current_password" tabindex="-1"><i class="far fa-eye"></i></button>
                  </div>
                  <?php if(isset($validation['current_password'])){ ?>
                  <div class="error"><?php echo $validation['current_password']; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div>
                <div class="mb-3">
                  <label  class="form-label">New Password <span class="req">*</span></label>
                  <div class="pw-wrap">
                  <?php echo form_input ( array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'maxlength' => 400,
                'class' => "form-control",
                'value' => set_value( 'password')));

                ?>
                  <button type="button" class="pw-toggle" data-target="password" tabindex="-1"><i class="far fa-eye"></i></button>
                  </div>
                  <?php if(isset($validation['password'])){ ?>
                  <div class="error"><?php echo $validation['password']; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div>
                <div class="mb-3">
                  <label  class="form-label">Confirm New Password <span class="req">*</span></label>
                  <div class="pw-wrap">
                  <?php echo form_input ( array(
                'name' => 'con_password',
                'id' => 'con_password',
                'type' => 'password',
                'maxlength' => 400,
                'class' => "form-control",
                'value' => set_value( 'con_password')));

                ?>
                  <button type="button" class="pw-toggle" data-target="con_password" tabindex="-1"><i class="far fa-eye"></i></button>
                  </div>
                  <?php if(isset($validation['con_password'])){ ?>
                  <div class="error"><?php echo $validation['con_password']; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>




          <div class="row">
            <div class="col-md-12">
              <div class="">
                <button type="submit" class="btn btn-primary rounded-pill btn-login  mb-2"><i class="fas fa-shield-alt"></i> Submit</button>
              </div>
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
<script>
  (function () {
    document.querySelectorAll('.pw-toggle').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var inp = document.getElementById(btn.getAttribute('data-target'));
        if (!inp) return;
        var show = inp.type === 'password';
        inp.type = show ? 'text' : 'password';
        var icon = btn.querySelector('i');
        if (icon) { icon.className = show ? 'far fa-eye-slash' : 'far fa-eye'; }
      });
    });
  })();
</script>
</body>
</html>
