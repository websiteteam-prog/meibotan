<?php $commfrontfunc=service('commfrontfunc'); ?>
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

  /* Action buttons (track / invoice) */
  .vo-actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
  }

  .vo-actions .link_track {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    border-radius: 30px;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none !important;
    transition: all .25s ease;
  }

  .vo-track-btn {
    background: linear-gradient(135deg, #14B8A6, #0F766E);
    color: #fff !important;
    border: none;
  }

  .vo-track-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 16px rgba(15, 118, 110, .25);
  }

  .vo-invoice-btn {
    background: #fff;
    color: #0F766E !important;
    border: 1.5px solid rgba(15, 118, 110, .35);
  }

  .vo-invoice-btn:hover {
    background: #0F766E;
    color: #fff !important;
  }

  .vo-trackno {
    width: 100%;
    font-size: 12.5px;
    font-style: italic;
    color: #6B7280;
    margin: 2px 0 0;
  }

  /* Invoice card */
  .vo-invoice {
    border: 1px solid #EEF2F7;
    border-radius: 14px;
    overflow: hidden;
  }

  .vo-inv-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    flex-wrap: wrap;
    padding: 20px 24px;
    background: linear-gradient(135deg, #ECFDF5, #E6F7F4);
    border-bottom: 1px solid #EEF2F7;
  }

  .vo-inv-head .vo-inv-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    font-weight: 600;
    color: #1F2937;
    margin: 0;
  }

  .vo-inv-head .vo-inv-title i {
    color: #0F766E;
  }

  .vo-order-id {
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 700;
    color: #0F766E;
    background: #fff;
    border: 1px solid rgba(15, 118, 110, .18);
    padding: 6px 16px;
    border-radius: 30px;
  }

  .vo-body {
    padding: 22px 24px 24px;
  }

  /* Address / meta grids */
  .vo-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
  }

  .vo-box {
    background: #F9FBFD;
    border: 1px solid #EEF2F7;
    border-radius: 12px;
    padding: 16px 18px;
  }

  .vo-label {
    font-family: 'Poppins', sans-serif;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: .05em;
    text-transform: uppercase;
    color: #0F766E;
    margin: 0 0 8px;
  }

  .vo-box p {
    font-size: 13px;
    color: #475467;
    line-height: 1.6;
    margin: 0 0 6px;
  }

  .vo-box p:last-child {
    margin-bottom: 0;
  }

  .vo-box strong {
    color: #1F2937;
  }

  .vo-divider {
    height: 1px;
    background: #EEF2F7;
    margin: 20px 0;
  }

  /* Order summary */
  .vo-summary-title {
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: .03em;
    text-transform: uppercase;
    color: #1F2937;
    margin: 0 0 14px;
  }

  .vo-table-wrap {
    border: 1px solid #EEF2F7;
    border-radius: 12px;
    overflow: hidden;
  }

  .vo-table {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
  }

  .vo-table thead th {
    background: #F8FAFC;
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .04em;
    color: #6B7280;
    font-weight: 700;
    padding: 12px 16px;
    text-align: left;
  }

  .vo-table thead th.vo-th-price {
    text-align: right;
    width: 130px;
  }

  .vo-table tbody td,
  .vo-table tbody th {
    padding: 14px 16px;
    border-top: 1px solid #F1F5F9;
    font-size: 13px;
    color: #475467;
    vertical-align: middle;
    font-weight: 400;
  }

  .vo-item {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .vo-item-thumb {
    width: 44px;
    height: 44px;
    flex: 0 0 44px;
    border-radius: 9px;
    border: 1px solid #E2E8F0;
    background: #fff;
    object-fit: contain;
    padding: 3px;
  }

  .vo-item-name {
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #1F2937;
    margin: 0 0 2px;
    line-height: 1.3;
  }

  .vo-item-name span {
    color: #0F766E;
  }

  .vo-item-sku {
    font-size: 11.5px;
    color: #98A2B3;
    margin: 0;
  }

  .vo-price {
    text-align: right;
    font-weight: 600;
    color: #1F2937;
    white-space: nowrap;
  }

  .vo-table .vo-subtotal-row th,
  .vo-table .vo-subtotal-row td {
    text-align: right;
    font-weight: 600;
    color: #475467;
  }

  .vo-table .vo-total-row th {
    text-align: right;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    color: #1F2937;
  }

  .vo-table .vo-total-row td {
    text-align: right;
  }

  .vo-total-amt {
    font-family: 'Poppins', sans-serif;
    font-size: 19px;
    font-weight: 700;
    color: #0F766E;
    display: block;
  }

  .vo-gst-note {
    font-size: 11px;
    font-weight: 500;
    color: #6B7280;
  }

  /* Print button */
  .vo-print {
    display: flex;
    justify-content: flex-end;
    margin-top: 18px;
  }

  .vo-print-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 24px;
    border-radius: 30px;
    border: none;
    background: linear-gradient(135deg, #14B8A6, #0F766E);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all .25s ease;
  }

  .vo-print-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(15, 118, 110, .28);
  }

  /* Responsive */
  @media (max-width: 767px) {
    .dash_right {
      padding: 16px 14px 18px;
    }

    .vo-grid {
      grid-template-columns: 1fr;
    }

    .vo-inv-head {
      padding: 16px 18px;
    }

    .vo-body {
      padding: 18px 16px;
    }

    .vo-table thead {
      display: none;
    }

    .vo-table,
    .vo-table tbody,
    .vo-table tr,
    .vo-table td,
    .vo-table th {
      display: block;
      width: 100%;
    }

    .vo-table tbody tr {
      border-top: 1px solid #F1F5F9;
      padding: 6px 14px;
    }

    .vo-table tbody td,
    .vo-table tbody th {
      border: none !important;
      padding: 7px 0;
    }

    .vo-table tbody td.vo-price,
    .vo-table .vo-subtotal-row th,
    .vo-table .vo-subtotal-row td,
    .vo-table .vo-total-row th,
    .vo-table .vo-total-row td {
      text-align: left;
    }

    .vo-table tbody tr th[scope="row"]:first-child {
      display: none;
    }

    .main .page-header h1 {
      font-size: 24px;
    }
  }

  @media print {
    .vo-actions,
    .vo-print,
    #scroll-top {
      display: none !important;
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
            <li class="breadcrumb-item active" aria-current="page">View Orders </li>
          </ol>
        </div>
      </nav>
      <h1>View Orders </h1>
    </div>
  </div>
  <div class="container account-container custom-account-container">
    <div class="row">
      <?= $this->include('frontend/partials/userdash-sidenav') ?>
      <div class="col-lg-9 order-lg-last order-1 tab-content">
        <div class="row">
          <div class="col-md-12">
            <div class="dash_right">

              <?php if($orderdata->order_tracklink!="" || $orderdata->order_invoiceid!=""){ ?>
              <div class="vo-actions">
                <?php if($orderdata->order_tracklink!=""){ ?>
                  <a href="<?php echo $orderdata->order_tracklink; ?>" target="_blank" class="link_track vo-track-btn"><i class="fas fa-truck"></i> Track Your Order</a>
                <?php } ?>
                <?php if($orderdata->order_invoiceid!=""){
                    $customenc=service('customencscript');
                    $enc_invoiceid=$customenc->encrypt($orderdata->order_invoiceid,ENC_KEY_PASS);
                  ?>
                  <a href="<?php echo site_url("invoice/$enc_invoiceid"); ?>" target="_blank" class="link_track vo-invoice-btn"><i class="fas fa-receipt"></i> View Invoice</a>
                <?php } ?>
                <?php if($orderdata->order_tracklink!="" && $orderdata->order_trackno!=""){ ?>
                  <span class="vo-trackno">Tracking No: <?php echo $orderdata->order_trackno; ?></span>
                <?php } ?>
              </div>
              <?php } ?>

              <div id="printarea" class="vo-invoice">
                <div class="vo-inv-head">
                  <h4 class="vo-inv-title"><i class="fas fa-file-invoice"></i> Order Details</h4>
                  <span class="vo-order-id">Order #<?php echo $orderdata->order_id; ?></span>
                </div>

                <div class="vo-body">
                  <div class="vo-grid">
                    <div class="vo-box">
                      <div class="vo-label">Billing Information</div>
                      <p>
                        <strong><?php echo $orderdata->order_billing_name; ?></strong><br/>
                        <?php $order_billing_companyname=$orderdata->order_billing_companyname; if($order_billing_companyname!=""){ echo $order_billing_companyname."<br/>"; } ?>
                        <?php if($orderdata->order_billing_address!=""){
                            echo  $orderdata->order_billing_address;
                          }
                          if($orderdata->order_billing_city!=""){
                            echo ", ".$orderdata->order_billing_city;
                          }
                          if($orderdata->order_billing_state!=""){
                            $staterow=$commfrontfunc->getPerState($orderdata->order_billing_state);
                            echo ", ".$staterow->state_name;
                          }
                          if($orderdata->order_billing_country!=""){
                            $countryrow=$commfrontfunc->getPerCountry($orderdata->order_billing_country);
                            echo ", ".$countryrow->country_name;
                          }
                          echo "-".$orderdata->order_billing_pincode;
                          ?>
                      </p>
                      <?php if($orderdata->order_billing_gst!=""){ ?>
                      <p><strong>GSTIN:</strong> <?php echo $orderdata->order_billing_gst; ?><br/><strong>State/UT Code:</strong> <?php echo $orderdata->order_billing_statecode; ?></p>
                      <?php } ?>
                    </div>

                    <div class="vo-box">
                      <div class="vo-label">Shipping Information</div>
                      <p>
                        <strong><?php echo $orderdata->order_shipping_name; ?></strong><br/>
                        <?php $order_shipping_companyname=$orderdata->order_shipping_companyname; if($order_shipping_companyname!=""){ echo $order_shipping_companyname."<br/>"; } ?>
                        <?php if($orderdata->order_shipping_address!=""){
                            echo  $orderdata->order_shipping_address;
                          }
                          if($orderdata->order_shipping_city!=""){
                            echo ", ".$orderdata->order_shipping_city;
                          }
                          if($orderdata->state_name!=""){
                            echo ", ".$orderdata->state_name;
                          }
                          if($orderdata->country_name!=""){
                            echo ", ".$orderdata->country_name;
                          }
                          echo "-".$orderdata->order_shipping_pincode;
                          if($orderdata->order_shipping_landmark!=""){
                            echo "<br/>Landmark: ".$orderdata->order_shipping_landmark;
                          }
                          ?>
                      </p>
                      <p><strong>Contact Number:</strong> <?php echo $orderdata->order_shipping_contactno; ?></p>
                    </div>
                  </div>

                  <div class="vo-divider"></div>

                  <div class="vo-grid">
                    <div class="vo-box">
                      <div class="vo-label">Order On Date</div>
                      <p><?php echo date('F d, Y',strtotime($orderdata->order_punch_datetime)); ?></p>
                    </div>
                    <div class="vo-box">
                      <div class="vo-label">Payment Detail</div>
                      <p><strong>Method:</strong> <?php echo $orderdata->paymethod_title; ?></p>
                    </div>
                  </div>

                  <div class="vo-divider"></div>

                  <h5 class="vo-summary-title">Order Summary</h5>
                  <div class="vo-table-wrap">
                    <table class="vo-table">
                      <thead>
                        <tr>
                          <th style="width:60px;">No.</th>
                          <th>Item</th>
                          <th class="vo-th-price">Price</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $order_cartitem=$orderdata->order_cartitem;
                        $cartitems=unserialize($order_cartitem);
                        $pro_sr=1;
                        foreach ($cartitems as $cartrow){
                          if(isset($cartrow['pro_name'])){

                            // resolve product image (best-effort, same style as checkout)
                            $line_img = '';
                            foreach (['pro_thumb','pro_image','pro_thumbnail','pro_photo','product_thumb'] as $ik) {
                              if (!empty($cartrow[$ik])) { $line_img = $cartrow[$ik]; break; }
                            }
                            if ($line_img === '') {
                              foreach (['pro_id','pro_proid','pro_productid','product_id','cart_productid'] as $idk) {
                                if (!empty($cartrow[$idk])) {
                                  $pp = $commfrontfunc->getPerProduct($cartrow[$idk]);
                                  if ($pp && !empty($pp->product_thumb)) { $line_img = $pp->product_thumb; }
                                  break;
                                }
                              }
                            }
                            $line_imgurl = ($line_img !== '')
                              ? ((strpos($line_img,'http')===0) ? $line_img : CUSTOM_UPLOAD_PATH . $line_img)
                              : DEFAULT_PRODUCTIMG;
                          ?>
                        <tr>
                          <th scope="row"><?php echo $pro_sr; ?></th>
                          <td>
                            <div class="vo-item">
                              <img class="vo-item-thumb" src="<?php echo $line_imgurl; ?>" alt="<?php echo esc($cartrow['pro_name']); ?>"
                                onerror="this.onerror=null;this.src='<?php echo DEFAULT_PRODUCTIMG; ?>';">
                              <div>
                                <h5 class="vo-item-name"><?php echo $cartrow['pro_name']; ?> <span>&times; <?php echo $cartrow['pro_qty']; ?></span></h5>
                                <?php if(!empty($cartrow['pro_sku'])){ ?>
                                  <p class="vo-item-sku">SKU: <?php echo $cartrow['pro_sku']; ?></p>
                                <?php } ?>
                              </div>
                            </div>
                          </td>
                          <td class="vo-price"><?php echo "₹".$cartrow['pro_price']; ?></td>
                        </tr>
                        <?php
                            $pro_sr++;
                          }
                        } ?>
                        <tr class="vo-subtotal-row">
                          <th scope="row" colspan="2">Sub Total</th>
                          <td><?php echo "₹".$orderdata->order_amt_itemtotal; ?></td>
                        </tr>
                        <tr class="vo-total-row">
                          <th scope="row" colspan="2">Total</th>
                          <td>
                            <span class="vo-total-amt">₹<?php echo $orderdata->order_amt_total; ?></span>
                            <span class="vo-gst-note">incl. ₹<?php echo $orderdata->order_gst; ?> GST</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="vo-print d-print-none">
                <button onclick="printDiv('printarea')" class="vo-print-btn"><i class="fa fa-print"></i> Print</button>
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
<script>
function printDiv(printarea) {
  var printContents = document.getElementById(printarea).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}
</script>
</body>
</html>
