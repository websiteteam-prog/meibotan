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

  /* Page header */
  .main .page-header {
    background: transparent;
    padding: 34px 0 6px;
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

  /* Right content card */
  .dash_right {
    background: #fff;
    border: 1px solid #EEF2F7;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(15, 23, 42, .05);
    padding: 26px 26px 30px;
  }

  /* Welcome bar */
  .dash-welcome {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    padding: 18px 20px;
    border-radius: 14px;
    background: linear-gradient(135deg, #ECFDF5, #E6F7F4);
    border: 1px solid rgba(15, 118, 110, .16);
    margin-bottom: 26px;
  }

  .dash-welcome-left {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .dash-welcome-avatar {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    flex: 0 0 54px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #fff;
    background: linear-gradient(135deg, #14B8A6, #0F766E);
    box-shadow: 0 8px 18px rgba(15, 118, 110, .25);
  }

  .dash-welcome-text span {
    display: block;
    font-size: 12.5px;
    color: #6B7280;
    letter-spacing: .02em;
  }

  .dash-welcome-text h3 {
    font-family: 'Poppins', sans-serif;
    font-size: 19px;
    font-weight: 600;
    color: #1F2937;
    margin: 2px 0 0;
    text-transform: capitalize;
  }

  .dash-logout-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #0F766E;
    background: #fff;
    border: 1.5px solid rgba(15, 118, 110, .3);
    padding: 9px 20px;
    border-radius: 30px;
    text-decoration: none !important;
    transition: all .25s ease;
  }

  .dash-logout-btn:hover {
    background: #0F766E;
    color: #fff;
    border-color: #0F766E;
  }

  /* Feature cards */
  .dash-cards {
    margin-left: -8px;
    margin-right: -8px;
  }

  .dash-cards>[class*="col-"] {
    padding: 8px;
  }

  .dashboard-content .feature-box {
    background: #fff;
    border: 1px solid #EEF2F7;
    border-radius: 16px;
    padding: 28px 14px 24px;
    box-shadow: 0 2px 10px rgba(15, 23, 42, .04);
    transition: all .28s ease;
    height: 100%;
  }

  .dashboard-content a {
    text-decoration: none !important;
  }

  .dashboard-content a:hover .feature-box {
    transform: translateY(-5px);
    border-color: rgba(20, 184, 166, .4);
    box-shadow: 0 16px 32px rgba(15, 118, 110, .14);
  }

  .dashboard-content .feature-box i {
    width: 66px;
    height: 66px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #0F766E;
    background: linear-gradient(135deg, #ECFEFF, #E6F7F4);
    border: 1px solid rgba(15, 118, 110, .15);
    margin-bottom: 16px;
    transition: all .28s ease;
  }

  .dashboard-content a:hover .feature-box i {
    background: linear-gradient(135deg, #14B8A6, #0F766E);
    color: #fff;
    transform: scale(1.06);
  }

  .dashboard-content .feature-box-content h3 {
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    font-weight: 600;
    letter-spacing: .04em;
    color: #1F2937;
    margin: 0;
  }

  /* Responsive */
  @media (max-width: 575px) {
    .dash_right {
      padding: 18px 16px 22px;
    }

    .dash-welcome {
      justify-content: center;
      text-align: center;
    }

    .dash-welcome-left {
      flex-direction: column;
      text-align: center;
    }

    .dash-logout-btn {
      width: 100%;
      justify-content: center;
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
            <li class="breadcrumb-item active" aria-current="page">My Dashboard </li>
          </ol>
        </div>
      </nav>
      <h1>My Dashboard </h1>
    </div>
  </div>
  <div class="container account-container custom-account-container">
				<div class="row">


                         <?= $this->include('frontend/partials/userdash-sidenav') ?>

					<div class="col-lg-9 order-lg-last order-1 tab-content">
							<div class="row">
                            	<div class="col-md-12">
                                	<div class="dash_right">
							<div class="dashboard-content">
								<div class="dash-welcome">
									<div class="dash-welcome-left">
										<div class="dash-welcome-avatar"><i class="fas fa-user"></i></div>
										<div class="dash-welcome-text">
											<span>Welcome back,</span>
											<h3><?php echo $userdata->user_name; ?></h3>
										</div>
									</div>
									<a href="<?php echo site_url("logout"); ?>" class="dash-logout-btn"><i class="fas fa-sign-out-alt"></i> Log out</a>
								</div>
									<div class="row row-lg dash-cards">
									<div class="col-6 col-md-4">
                                    <a href="<?php echo site_url("my-orders"); ?>">
										<div class="feature-box text-center pb-4">
											<i
													class="sicon-social-dropbox"></i>
											<div class="feature-box-content">
												<h3>ORDERS</h3>
											</div>
										</div>

                                        </a>
									</div>
								<div class="col-6 col-md-4">

                                    <a href=" <?php echo site_url("my-account"); ?>">
										<div class="feature-box text-center pb-4">
											<i class="icon-user-2"></i>
											<div class="feature-box-content p-0">
												<h3>ACCOUNT DETAILS</h3>
											</div>
										</div>
                                        </a>
									</div>
<!--
									<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="wishlist.html"><i class="sicon-heart"></i></a>
											<div class="feature-box-content">
												<h3>WISHLIST</h3>
											</div>
										</div>
									</div>-->

									<div class="col-6 col-md-4">
                                    <a href="<?php echo site_url("logout"); ?>">
										<div class="feature-box text-center pb-4">
											<i class="sicon-logout"></i>
											<div class="feature-box-content">
												<h3>LOGOUT</h3>
											</div>
										</div>
                                        </a>
									</div>
								</div><!-- End .row -->
							</div>
                            		</div>
                            	</div>
                                </div>


					</div><!-- End .tab-content -->
				</div><!-- End .row -->
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
