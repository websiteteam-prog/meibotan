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

  /* Page header — remove theme's blue banner image */
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
    padding: 24px;
  }

  /* Wishlist table */
  .custom_favoritelist {
    margin: 0;
    width: 100%;
  }

  .custom_favoritelist thead th {
    background: #F8FAFC !important;
    border: none !important;
    font-family: 'Poppins', sans-serif;
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: .04em;
    color: #6B7280;
    font-weight: 700;
    padding: 13px 14px;
    vertical-align: middle;
  }

  .custom_favoritelist tbody td {
    border: none !important;
    border-top: 1px solid #F1F5F9 !important;
    padding: 14px;
    vertical-align: middle;
    font-size: 13px;
    color: #475467;
  }

  .custom_favoritelist tbody tr:first-child td {
    border-top: none !important;
  }

  .custom_favoritelist tbody tr:hover td {
    background: #F9FCFC;
  }

  /* Product cell */
  .wl-prod {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .wl-thumb {
    flex: 0 0 52px;
    width: 52px;
    height: 52px;
    border-radius: 10px;
    border: 1px solid #E2E8F0;
    background: #fff;
    overflow: hidden;
    display: block;
  }

  .wl-thumb img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 3px;
  }

  .wl-name {
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    font-weight: 600;
    color: #1F2937 !important;
    text-decoration: none !important;
    line-height: 1.35;
  }

  .wl-name:hover {
    color: #0F766E !important;
  }

  .wl-sku {
    font-size: 12.5px;
    color: #6B7280;
    text-decoration: none !important;
  }

  a.wl-sku:hover {
    color: #0F766E;
  }

  .wl-price {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    color: #0F766E;
    font-size: 14px;
  }

  .wl-price del {
    font-size: 12px;
    font-weight: 500;
    color: #98A2B3;
    margin-left: 6px;
  }

  /* Remove button */
  .wl-remove {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #FEF2F2;
    border: 1px solid #FECACA;
    color: #DC2626 !important;
    font-size: 13px;
    text-decoration: none !important;
    transition: all .2s ease;
  }

  .wl-remove:hover {
    background: #DC2626;
    border-color: #DC2626;
    color: #fff !important;
  }

  /* Flash */
  .auth-content-success .alert {
    border-radius: 12px;
    border: none;
    background: #DCFCE7;
    color: #15803D;
    font-size: 13.5px;
    font-weight: 600;
  }

  /* Empty state */
  .wl-empty {
    text-align: center;
    padding: 50px 20px;
  }

  .wl-empty i {
    font-size: 44px;
    color: #CBD5E1;
    margin-bottom: 14px;
  }

  .wl-empty p {
    font-size: 15px;
    font-weight: 600;
    color: #6B7280;
    margin: 0 0 18px;
  }

  .wl-empty .btn-shop {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 26px;
    border-radius: 30px;
    background: linear-gradient(135deg, #14B8A6, #0F766E);
    color: #fff !important;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none !important;
    transition: all .25s ease;
  }

  .wl-empty .btn-shop:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(15, 118, 110, .28);
  }

  /* ===== Mobile: table -> stacked cards ===== */
  @media (max-width: 767px) {
    .dash_right {
      padding: 16px 14px 18px;
    }

    .custom_favoritelist thead {
      display: none;
    }

    .custom_favoritelist,
    .custom_favoritelist tbody,
    .custom_favoritelist tr,
    .custom_favoritelist td {
      display: block;
      width: 100%;
    }

    .custom_favoritelist tbody tr {
      background: #fff;
      border: 1px solid #EEF2F7;
      border-radius: 14px;
      box-shadow: 0 2px 10px rgba(15, 23, 42, .05);
      padding: 6px 16px;
      margin-bottom: 14px;
    }

    .custom_favoritelist tbody td {
      border: none !important;
      border-top: 1px solid #F4F6F9 !important;
      padding: 11px 0 !important;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      text-align: right;
    }

    .custom_favoritelist tbody tr td:first-child {
      border-top: none !important;
    }

    .custom_favoritelist tbody td::before {
      content: attr(data-label);
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: .03em;
      color: #6B7280;
      flex: 0 0 34%;
      text-align: left;
    }

    .wl-prod {
      justify-content: flex-end;
      text-align: right;
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
            <li class="breadcrumb-item active" aria-current="page">My Wishlist </li>
          </ol>
        </div>
      </nav>
      <h1>My Wishlist</h1>
    </div>
  </div>
  <div class="container account-container custom-account-container">
    <div class="row">
      <?= $this->include('frontend/partials/userdash-sidenav') ?>
      <div class="col-lg-9 order-lg-last order-1 tab-content">
        <div class="row">
          <div class="col-md-12">
            <div class="dash_right">
            <?php if(session()->getFlashdata('success_msg')){  ?>
        <div class="row">
          <div class="col-12">
            <div class="auth-content-success my-auto">
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?=  session()->getFlashdata('success_msg'); ?>

              </div>
            </div>
          </div>
        </div>
        <?php }  ?>
              <div class="row">
                <div class="col-md-12">
                  <?php if(count($favoritedata) > 0){ ?>
                        	<table style="width:100%" class="table custom_favoritelist">
                            <thead>
  <tr>
    <th width="46%">Product Name</th>
    <th width="22%">SKU</th>
    <th width="17%">Price</th>
     <th width="8%" align="center">Action</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($favoritedata as $favoriterow){
		$customenc=service('customencscript');
		$product_slug=$favoriterow->product_slug;
		$price=0;
		$product_price=$favoriterow->product_price;
		$product_saleprice=$favoriterow->product_saleprice;
		if($product_saleprice>0){
			$price=$product_saleprice;
		}else{
			$price=$product_price;
		}
		$favorite_id=$favoriterow->favorite_id;

			$enc_favoriteid=$customenc->encrypt($favorite_id,ENC_KEY_PASS);

		// product thumbnail (same source as cart)
		$wl_thumb = !empty($favoriterow->product_thumb) ? CUSTOM_UPLOAD_PATH . $favoriterow->product_thumb : DEFAULT_PRODUCTIMG;
  ?>
  <tr>
    <td data-label="Product">
      <div class="wl-prod">
        <a href="<?php echo site_url("product/$product_slug"); ?>" class="wl-thumb" target="_blank">
          <img src="<?php echo $wl_thumb; ?>" alt="<?php echo esc($favoriterow->product_name); ?>"
            onerror="this.onerror=null;this.src='<?php echo DEFAULT_PRODUCTIMG; ?>';">
        </a>
        <a href="<?php echo site_url("product/$product_slug"); ?>" class="wl-name" target="_blank"><?php echo $favoriterow->product_name; ?></a>
      </div>
    </td>
    <td data-label="SKU"><a href="<?php echo site_url("product/$product_slug"); ?>" class="wl-sku" target="_blank"><?php echo $favoriterow->product_sku; ?></a></td>
    <td data-label="Price">
      <span class="wl-price">₹<?php echo $price; ?><?php if($product_saleprice>0 && $product_price>$product_saleprice){ ?><del>₹<?php echo $product_price; ?></del><?php } ?></span>
    </td>
    <td data-label="Action" align="center"><a class="wl-remove" href="<?php echo site_url("wishlist/remove/$enc_favoriteid"); ?>" title="Remove"><i class="fas fa-trash"></i></a></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
                  <?php }else{ ?>
                    <div class="wl-empty">
                      <i class="far fa-heart"></i>
                      <p>Your wishlist is empty.</p>
                      <a class="btn-shop" href="<?php echo site_url('shop'); ?>"><i class="fas fa-shopping-bag"></i> Start Shopping</a>
                    </div>
                  <?php } ?>
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
