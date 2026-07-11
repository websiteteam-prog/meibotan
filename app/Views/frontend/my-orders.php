<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php if(isset($metadata['page_title'])){ echo $metadata['page_title']; } ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>/assets/frontend/images/icons/favicon.png">
    <script>
        WebFontConfig = {
            google: { families: ['Noto+Sans:300,400,600,700,800', 'Poppins:300,400,500,600,700,800', 'Playfair+Display:900', 'Shadows+Into+Light:400'] }
        };
        (function (d) {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = '<?php echo base_url(); ?>/assets/frontend/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/bootstrap.min.css">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/demo7.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/vendor/fontawesome-free/css/all.min.css">

    <style type="text/css">
      .main {
        background: linear-gradient(170deg, #ECFEFF 0%, #F8FAFC 42%, #F5F8FB 100%);
        padding-bottom: 60px;
      }

      .main .container {
        max-width: 1180px;
      }

      /* Breadcrumb / heading */
      .breadcrumb-nav {
        padding: 26px 0 4px;
      }

      .breadcrumb-nav .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
      }

      .breadcrumb-nav .breadcrumb-item,
      .breadcrumb-nav .breadcrumb-item a {
        font-size: 13px;
        color: #6B7280;
        text-decoration: none;
      }

      .breadcrumb-nav .breadcrumb-item a:hover {
        color: #0F766E;
      }

      .breadcrumb-nav .breadcrumb-item.active {
        color: #0F766E;
        font-weight: 600;
      }

      .orders-title {
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: 600;
        color: #1F2937;
        margin: 4px 0 20px;
      }

      /* Orders card + table */
      .order-card {
        background: #fff;
        border: 1px solid #EEF2F7;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(15, 23, 42, .05);
        padding: 8px 16px;
        overflow: hidden;
      }

      .table-order {
        margin: 0;
        width: 100%;
      }

      .table-order thead th {
        background: #F8FAFC !important;
        border: none !important;
        font-family: 'Poppins', sans-serif;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #6B7280;
        font-weight: 700;
        padding: 14px 12px;
        vertical-align: middle;
      }

      .table-order tbody td {
        border: none !important;
        border-top: 1px solid #F1F5F9 !important;
        padding: 16px 12px;
        vertical-align: middle;
        font-size: 13px;
        color: #475467;
      }

      .table-order tbody tr:first-child td {
        border-top: none !important;
      }

      .table-order tbody tr:hover td {
        background: #F9FCFC;
      }

      .order-id-val {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #0F766E;
      }

      .order-amt-val {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #1F2937;
      }

      .order-qty-val {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 26px;
        height: 26px;
        padding: 0 8px;
        border-radius: 20px;
        background: #ECFEFF;
        color: #0F766E;
        font-weight: 700;
        font-size: 12.5px;
      }

      /* Items with thumbnails */
      .order-items {
        display: flex;
        flex-direction: column;
        gap: 9px;
      }

      .order-item-line {
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .order-item-thumb {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        border-radius: 9px;
        border: 1px solid #E2E8F0;
        background: #fff;
        object-fit: contain;
        padding: 3px;
      }

      .order-item-name {
        font-size: 12.5px;
        color: #1F2937;
        line-height: 1.35;
      }

      .order-item-name b {
        color: #0F766E;
        font-weight: 700;
      }

      /* Status badge */
      .order-status-badge {
        display: inline-block;
        padding: 5px 13px;
        border-radius: 30px;
        font-family: 'Poppins', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: .02em;
        white-space: nowrap;
        background: #EEF2F7;
        color: #475467;
      }

      .order-status-badge.st-success {
        background: #DCFCE7;
        color: #15803D;
      }

      .order-status-badge.st-danger {
        background: #FEE2E2;
        color: #DC2626;
      }

      .order-status-badge.st-warning {
        background: #FEF3C7;
        color: #B45309;
      }

      .order-status-badge.st-info {
        background: #E0F2FE;
        color: #0369A1;
      }

      /* View button */
      .order-view-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 30px;
        background: linear-gradient(135deg, #14B8A6, #0F766E);
        color: #fff !important;
        font-family: 'Poppins', sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none !important;
        transition: all .2s ease;
      }

      .order-view-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 16px rgba(15, 118, 110, .25);
        color: #fff !important;
      }

      /* Empty state */
      .orders-empty {
        text-align: center;
        padding: 60px 20px;
      }

      .orders-empty i {
        font-size: 46px;
        color: #CBD5E1;
        margin-bottom: 16px;
      }

      .orders-empty p {
        font-size: 15px;
        font-weight: 600;
        color: #6B7280;
        margin: 0 0 18px;
      }

      .orders-empty .btn-shop {
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

      .orders-empty .btn-shop:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(15, 118, 110, .28);
      }

      /* ===== Mobile: table -> stacked cards ===== */
      @media (max-width: 767px) {
        .order-card {
          background: transparent;
          border: none;
          box-shadow: none;
          padding: 0;
        }

        .table-order thead {
          display: none;
        }

        .table-order,
        .table-order tbody,
        .table-order tr,
        .table-order td {
          display: block;
          width: 100%;
        }

        .table-order tbody tr {
          background: #fff;
          border: 1px solid #EEF2F7;
          border-radius: 14px;
          box-shadow: 0 2px 10px rgba(15, 23, 42, .05);
          padding: 6px 16px;
          margin-bottom: 14px;
        }

        .table-order tbody td {
          border: none !important;
          border-top: 1px solid #F4F6F9 !important;
          padding: 11px 0 !important;
          display: flex;
          align-items: flex-start;
          justify-content: space-between;
          gap: 12px;
          text-align: right;
        }

        .table-order tbody tr td:first-child {
          border-top: none !important;
        }

        .table-order tbody td::before {
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

        .order-items-cell {
          flex-direction: column;
          text-align: left;
        }

        .order-items-cell::before {
          margin-bottom: 8px;
        }

        .order-items {
          width: 100%;
        }

        .orders-title {
          font-size: 20px;
        }
      }
    </style>
</head>

<body>
    <div class="page-wrapper">

	<?= $this->include('frontend/partials/header') ?>

         <main class="main">
				<div class="container">
                  <nav aria-label="breadcrumb" class="breadcrumb-nav">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"> <a href="<?php echo site_url(); ?>"> <i class="icon-home"></i> Home</a> </li>
                      <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                    </ol>
                  </nav>

                  <h1 class="orders-title">My Orders</h1>

                    <div class="row">
                    	<div class="col-md-12">
                          <div class="order-card">
							<table class="table table-order text-left" style="width:100%;">
										<thead>
											<tr>
												<th width="10%" class="order-id">Order Id</th>
												<th width="13%" class="order-date">Date</th>
                                                <th width="34%" class="order-id">Items</th>
                                                <th width="11%" class="order-date">Total Qty</th>
                                                 <th width="13%" class="order-date">Total Amount</th>
												<th width="12%" class="order-status">Status</th>
												<th width="7%" align="center" class="order-action">View</th>
											</tr>
										</thead>
										<tbody>

											<?php
											if(count($orderdata)>0){
											$commfrontfunc = service('commfrontfunc');
											foreach($orderdata as $orderrow){
												$customenc=service('customencscript');
												$order_id=$orderrow->order_id;
												$enc_orderid=$customenc->encrypt($order_id,ENC_KEY_PASS);

												// status badge colour
												$st = strtolower($orderrow->orderstatus_title);
												$stclass = '';
												if (strpos($st,'deliver')!==false || strpos($st,'complet')!==false || strpos($st,'success')!==false) {
													$stclass = 'st-success';
												} elseif (strpos($st,'cancel')!==false || strpos($st,'reject')!==false || strpos($st,'fail')!==false || strpos($st,'return')!==false) {
													$stclass = 'st-danger';
												} elseif (strpos($st,'pending')!==false || strpos($st,'process')!==false || strpos($st,'hold')!==false || strpos($st,'placed')!==false) {
													$stclass = 'st-warning';
												} elseif (strpos($st,'ship')!==false || strpos($st,'transit')!==false || strpos($st,'dispatch')!==false) {
													$stclass = 'st-info';
												}
												 ?>
											<tr>
                                            	<td data-label="Order Id" align="center"><span class="order-id-val">#<?php echo $orderrow->order_id; ?></span></td>
                                                <td data-label="Date"><?php echo date('M d, Y',strtotime($orderrow->order_punch_datetime)); ?></td>
                                                <td data-label="Items" class="order-items-cell">
                                                  <div class="order-items">
                                                    <?php
                                                    $order_cartitem=$orderrow->order_cartitem;
                                                    $cartitems=unserialize($order_cartitem);
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
                                                        <div class="order-item-line">
                                                          <img class="order-item-thumb" src="<?php echo $line_imgurl; ?>"
                                                            alt="<?php echo esc($cartrow['pro_name']); ?>"
                                                            onerror="this.onerror=null;this.src='<?php echo DEFAULT_PRODUCTIMG; ?>';">
                                                          <span class="order-item-name"><?php echo $cartrow['pro_name']; ?> <b>&times; <?php echo $cartrow['pro_qty']; ?></b></span>
                                                        </div>
                                                      <?php
                                                      }
                                                    }
                                                    ?>
                                                  </div>
                                                </td>
                                              <td data-label="Total Qty"><span class="order-qty-val"><?php echo $orderrow->order_cartitemcount; ?></span></td>
                                                <td data-label="Total Amount"><span class="order-amt-val"><?php echo "$".$orderrow->order_amt_total; ?></span></td>
                                                <td data-label="Status"><span class="order-status-badge <?php echo $stclass; ?>"><?php echo $orderrow->orderstatus_title; ?></span></td>
                                                <td data-label="View" align="center"><a class="order-view-btn" href="<?php echo site_url("view-order/$enc_orderid"); ?>"><i class="fas fa-eye"></i> View</a></td>
                                            </tr>

                                            <?php
                                            	}
											}else{?>
                                            <tr>
												<td class="text-center p-0" colspan="7">
													<div class="orders-empty">
														<i class="fas fa-box-open"></i>
														<p>No order has been made yet.</p>
														<a class="btn-shop" href="<?php echo site_url('shop'); ?>"><i class="fas fa-shopping-bag"></i> Start Shopping</a>
													</div>
												</td>
											</tr>
                                            <?php  } ?>

										</tbody>
									</table>
                          </div>
						</div>

                    </div>
                </div>
        </main>
		<?= $this->include('frontend/partials/footer') ?>

    </div>

	<?= $this->include('frontend/partials/mobile-menu') ?>

    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
    <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/frontend/js/plugins.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.appear.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/frontend/js/main.min.js"></script>
</body>

</html>
