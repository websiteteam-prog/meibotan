<?php $commfrontfunc = service('commfrontfunc'); ?>
<!-- Expose correct upload path to JS (same as cart) -->
<?php
$JS_UPLOAD_BASE = defined('CUSTOM_UPLOAD_PATH')
  ? rtrim(CUSTOM_UPLOAD_PATH, '/')
  : 'https://meibotan.com/writable';
?>
<header class="header">
  <div class="header-top">
    <div class="container">
      <div class="header-left d-none d-sm-block">
        <p class="top-message text-uppercase">FREE Returns. Standard Shipping Orders ₹99+</p>
      </div>
      <div class="header-right header-dropdowns ml-0 ml-sm-auto w-sm-100">
        <div class="header-dropdown dropdown-expanded d-none d-lg-block">
          <a href="#">Links</a>
          <div class="header-menu">
            <ul>
              <li><a href="<?php echo site_url("cart"); ?>">Cart</a></li>
              <?php if (isset($_SESSION['userid'])) { ?>
                <li><a href="<?php echo site_url("dashboard"); ?>">My Account</a></li>
              <?php } else { ?>
                <li><a href="<?php echo site_url("login"); ?>">Log In</a></li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <span class="separator"></span>
        <div class="social-icons">
          <a href="https://www.facebook.com/Meibotan9?mibextid=sCpJLy" class="social-icon social-facebook icon-facebook"
            target="_blank"></a>
          <a href="https://www.youtube.com/@MEIBOTAN" class="social-icon social-youtube icon-youtube" target="_blank">
            <i class="fab fa-youtube"></i>
          </a>
          <a href="https://www.instagram.com/meibotan_/?igsh=M2M4N2MyNWZ1cDh1&utm_source=qr"
            class="social-icon social-instagram icon-instagram" target="_blank"></a>
        </div>
      </div>
    </div>
  </div>

  <div class="header-middle sticky-header" data-sticky-options="{'mobile': true}">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="header-left col-lg-3 w-auto pl-0">
        <button class="mobile-nav-toggler mr-2" id="mobileNavToggler" type="button" aria-label="Open menu"><i
            class="fas fa-bars"></i></button>
        <a href="<?php echo site_url(); ?>" class="logo">
          <img src="<?php echo base_url(); ?>/assets/frontend/images/logo.png" alt="Meibotan" />
        </a>
      </div>

      <div class="header-right w-lg-max d-flex align-items-center justify-content-end">

        <!-- SEARCH BAR (DESKTOP) -->
        <div
          class="header-icon header-search header-search-inline header-search-category w-lg-max text-right mt-0 d-none d-lg-block">
          <a href="#" class="search-toggle" role="button"><i class="icon-search-3"></i></a>
          <form action="<?php echo site_url("search"); ?>" method="get" class="search-form">
            <div class="header-search-wrapper">
              <input type="search" class="form-control" name="s" id="s" placeholder="Search..." autocomplete="off" />
              <div class="select-custom d-none d-md-block">
                <select id="cat" name="cat">
                  <option value="All">All Categories</option>
                  <?php $searchcatdata = $commfrontfunc->geAllParentCategory();
                  foreach ($searchcatdata as $searchcatrow) { ?>
                    <option value="<?php echo $searchcatrow->category_id; ?>">-
                      <?php echo $searchcatrow->category_name; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <button class="btn icon-magnifier p-0" title="search" type="submit"></button>

              <!-- LIVE SEARCH OVERLAY -->
              <div id="search-overlay" class="so-wrap" hidden>
                <div class="so-grid">
                  <div class="so-left">
                    <div class="so-title">SUGGESTIONS</div>
                    <ul id="so-suggestions"></ul>
                  </div>
                  <div class="so-right">
                    <div class="so-title">PRODUCTS</div>
                    <ul id="so-products"></ul>
                  </div>
                </div>
                <button id="so-close" class="so-close" type="button">X</button>
              </div>
            </div>
          </form>
        </div>

        <!-- MOBILE SEARCH ICON -->
        <div class="header-icon header-search-popup d-lg-none ml-2">
          <a href="#" id="mobile-search-toggle"><i class="icon-search-3"></i></a>
        </div>

        <div class="header-contact d-none d-lg-flex pl-4 pr-4 ">
          <img alt="phone" src="<?php echo base_url(); ?>/assets/frontend/images/phone.png" width="30" height="30"
            class="pb-1" />
          <h6><span>Call us now</span><a href="tel:+917009057196" class="text-dark font1">+91-7009057196</a></h6>
        </div>

        <a href="<?php echo site_url("dashboard"); ?>" class="header-icon" title="login"><i class="icon-user-2"></i></a>
        <?php
        $side_wishcount = 0;
        if (isset($_SESSION['userid'])) {
          $wish_db = \Config\Database::connect();
          $side_wishcount = $wish_db->table('tb_favorite')->where('favorite_userid', $_SESSION['userid'])->countAllResults();
        }
        ?>
        <a href="<?php echo site_url("wishlist"); ?>" class="header-icon wish-rel" title="wishlist"><i
            class="icon-wishlist-2"></i><span id="wishCountBadge" class="wish-count"
            style="<?php echo ($side_wishcount > 0) ? '' : 'display:none;'; ?>"><?php echo $side_wishcount; ?></span></a>

        <script>
          // Initialize combined wishlist badge using server count + guest stored count
          (function () {
            try {
              var guest = parseInt(localStorage.getItem('guest_wish_count') || 0, 10) || 0;
              var badge = document.getElementById('wishCountBadge');
              if (!badge) return;
              var server = parseInt(badge.textContent || 0, 10) || 0;
              var total = server + guest;
              if (total > 0) { badge.textContent = total; badge.style.display = 'inline-block'; }
              else { badge.style.display = 'none'; }
            } catch (e) { /* ignore */ }
          })();
        </script>

        <!-- CART ICON -->
        <?php
        $side_carttype = "";
        $side_cartuserid = "";
        if (isset($_SESSION['userid'])) {
          $side_carttype = "perma";
          $side_cartuserid = $_SESSION['userid'];
        } else {
          $side_carttype = "temp";
          $side_cartuserid = session_id();
        }
        $cartlist = service('cartlist');
        $side_countitem = 0;
        $cartsitemdata = $cartlist->getAllCartItems($side_cartuserid, $side_carttype);
        $qtyret = $cartlist->getAllCartItemQty($side_cartuserid, $side_carttype);
        if ($qtyret) {
          $side_countitem = $qtyret;
        }
        ?>
        <div class="dropdown cart-dropdown">
          <!-- removed data-toggle to avoid Bootstrap dropdown interfering -->
          <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button">
            <i class="minicart-icon"></i><span class="cart-count badge-circle"><?php echo $side_countitem; ?></span>
          </a>
          <div class="cart-overlay"></div>
          <div class="dropdown-menu mobile-cart">
            <a href="#" title="Close (Esc)" class="cart-close">X</a>
            <div class="dropdownmenu-wrapper custom-scrollbar">
              <div class="dropdown-cart-header">Shopping Cart</div>
              <?php if (count($cartsitemdata) > 0) { ?>
                <div class="dropdown-cart-products">
                  <?php
                  $side_carttotal = 0;
                  foreach ($cartsitemdata as $cartsitemrow) {
                    $side_cartid = $cartsitemrow->cart_id;
                    $customenc = service('customencscript');
                    $enc_sidecartid = $customenc->encrypt($side_cartid, ENC_KEY_PASS);
                    $side_carttotal += $cartsitemrow->cart_pricetotal;
                    $side_prothumb = $cartsitemrow->product_thumb;
                    $side_cartimg = $side_prothumb ? CUSTOM_UPLOAD_PATH . $side_prothumb : DEFAULT_PRODUCTIMG;
                    ?>
                    <div class="product">
                      <figure class="product-image-container">
                        <img src="<?php echo $side_cartimg; ?>" alt="product" width="80" height="80" />
                        <a href="<?php echo site_url("cart/removeitem/$enc_sidecartid"); ?>" class="btn-remove"
                          title="Remove Product"><span>X</span></a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-title"><?php echo $cartsitemrow->product_name; ?></h4>
                        <span class="cart-product-info"><span
                            class="cart-product-qty"><?php echo $cartsitemrow->cart_qty; ?></span> ×
                          ₹<?php echo $cartsitemrow->cart_price; ?></span>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <div class="dropdown-cart-total"><span>SUBTOTAL:</span><span
                    class="cart-total-price float-right">₹<?php echo $side_carttotal; ?></span></div>
              <?php } else { ?>
                <div class="cart-empty-mini">
                  <i class="fas fa-shopping-bag"></i>
                  <p>Your cart is empty</p>
                </div>
              <?php } ?>
              <div class="dropdown-cart-action">
                <a href="<?php echo site_url("cart"); ?>" class="btn btn-gray btn-block view-cart">View Cart</a>
                <a href="<?php echo site_url("checkout"); ?>" class="btn btn-dark btn-block">Checkout</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Header Bottom -->
  <div class="header-bottom sticky-header d-none d-lg-block" style="background:#0F766E;">

    <div class="container">
      <nav class="main-nav w-100">
        <ul class="menu">
          <li class="<?= current_url() == site_url() ? 'active' : ''; ?>">
            <a href="<?= site_url(); ?>">Home</a>
          </li>
          <li class="<?= uri_string() == 'about-us' ? 'active' : ''; ?>">
            <a href="<?php echo site_url("about-us"); ?>">About Us</a>
          </li>
          <?php $hparentcatdata = $commfrontfunc->geAllParentCategory();
          usort($hparentcatdata, function ($a, $b) {
            return strcasecmp($a->category_name, $b->category_name);
          });
          ?>
          <li
            class="mega-menu-container <?= (uri_string() == 'shop' || strpos(uri_string(), 'product-category') === 0) ? 'active' : ''; ?>">

            <a href="<?= site_url('shop'); ?>" class="cat-trigger">
              Shop By Categories
              <i class="fas fa-chevron-down"></i>
            </a>

            <div class="mega-menu-list">

              <?php foreach ($hparentcatdata as $hparentcatrow) {

                $hcat_slug = $hparentcatrow->category_slug;

                if ($hcat_slug != "") {
                  ?>

                  <div class="mega-col">

                    <a href="<?php echo site_url('product-category/' . $hcat_slug); ?>" class="mega-item">

                      <?php if (!empty($hparentcatrow->category_thumbnail)) { ?>

                        <img src="<?php echo CUSTOM_UPLOAD_PATH . $hparentcatrow->category_thumbnail; ?>"
                          alt="<?php echo $hparentcatrow->category_name; ?>">

                      <?php } ?>

                      <span>
                        <?php echo $hparentcatrow->category_name; ?>
                      </span>

                    </a>

                  </div>

                <?php }
              } ?>

            </div>

          </li>
          <li class="<?= uri_string() == 'blog' ? 'active' : ''; ?>">
            <a href="<?php echo site_url("blog"); ?>">Blogs</a>
          </li>
          <li class="<?= uri_string() == 'bulk-order' ? 'active' : ''; ?>">
            <a href="<?php echo site_url("bulk-order"); ?>">Bulk Order</a>
          </li>
          <li class="<?= uri_string() == 'contact-us' ? 'active' : ''; ?>">
            <a href="<?php echo site_url("contact-us"); ?>">Contact Us</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</header>

<!-- ===================== -->
<!-- MOBILE NAV DRAWER (custom, click-to-open categories) -->
<!-- ===================== -->
<?php
// Reuse the categories loaded above; re-fetch defensively if not set.
if (!isset($hparentcatdata)) {
  $hparentcatdata = $commfrontfunc->geAllParentCategory();
  usort($hparentcatdata, function ($a, $b) {
    return strcasecmp($a->category_name, $b->category_name);
  });
}
?>
<div class="m-nav-overlay" id="mNavOverlay"></div>
<aside class="m-nav" id="mNav" aria-hidden="true">
  <div class="m-nav-head">
    <a href="<?php echo site_url(); ?>" class="m-nav-logo">
      <img src="<?php echo base_url(); ?>/assets/frontend/images/logo.png" alt="Meibotan">
    </a>
    <button type="button" class="m-nav-close" id="mNavClose" aria-label="Close menu">&times;</button>
  </div>
  <nav class="m-nav-body">
    <ul class="m-nav-list">
      <li><a href="<?php echo site_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
      <li><a href="<?php echo site_url('about-us'); ?>"><i class="fas fa-info-circle"></i> About Us</a></li>
      <li class="m-nav-acc">
        <button type="button" class="m-nav-acc-btn" aria-expanded="false">
          <span><i class="fas fa-th-large"></i> Shop By Categories</span>
          <i class="fas fa-chevron-down m-nav-caret"></i>
        </button>
        <div class="m-nav-acc-panel">
          <a href="<?php echo site_url('shop'); ?>" class="m-nav-subitem all">All Products</a>
          <?php foreach ($hparentcatdata as $hpc) {
            if ($hpc->category_slug != "") { ?>
              <a href="<?php echo site_url('product-category/' . $hpc->category_slug); ?>"
                class="m-nav-subitem"><?php echo $hpc->category_name; ?></a>
            <?php }
          } ?>
        </div>
      </li>
      <li><a href="<?php echo site_url('blog'); ?>"><i class="fas fa-blog"></i> Blogs</a></li>
      <li><a href="<?php echo site_url('bulk-order'); ?>"><i class="fas fa-box-open"></i> Bulk Order</a></li>
      <li><a href="<?php echo site_url('contact-us'); ?>"><i class="fas fa-envelope"></i> Contact Us</a></li>
    </ul>
    <div class="m-nav-foot">
      <a href="<?php echo isset($_SESSION['userid']) ? site_url('dashboard') : site_url('login'); ?>"
        class="m-nav-account">
        <i class="icon-user-2"></i> <?php echo isset($_SESSION['userid']) ? 'My Account' : 'Log In'; ?>
      </a>
      <a href="tel:+917009057196" class="m-nav-call"><i class="fas fa-phone-alt"></i> +91-7009057196</a>
    </div>
  </nav>
</aside>

<?php include(APPPATH . 'Views/frontend/mobile-search.php'); ?>

<!-- ===================== -->
<!-- LIVE SEARCH CSS -->
<!-- ===================== -->
<style>
  /* =============================================
  MEIBOTAN HEADER — BRAND PALETTE
  Primary   #0F766E | Secondary #14B8A6
  Accent    #F59E0B | Light     #ECFEFF
  Background#F8FAFC | Surface   #FFFFFF
  Text      #1F2937 | Text 2nd  #6B7280
  ============================================= */

  /* =========================
MODERN MEGA MENU — Meibotan UI v2
========================= */
  .main-nav .menu>li {
    position: relative;
  }

  .main-nav .menu>li>ul,
  .main-nav .menu>li>.dropdown-menu,
  .main-nav .menu>li>.mega-menu {
    display: none !important;
  }

  .mega-menu-container {
    position: static !important;
  }

  .mega-col {
    width: 100%;
  }

  /* HIDE BY DEFAULT */
  .mega-menu-list {
    display: none !important;
    position: absolute;
    top: 100%;
    left: 0;
    transform: none;
    width: 1180px;
    background: linear-gradient(180deg, #ffffff 0%, #F8FAFC 100%);
    padding: 28px 30px 30px;
    border-radius: 0 0 18px 18px;
    box-shadow: 0 24px 60px rgba(15, 118, 110, .18);
    border-top: 3px solid #0F766E !important;
    z-index: 99999;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px 18px;
    animation: megaFade .22s ease;
  }

  @keyframes megaFade {
    from {
      opacity: 0;
      transform: translateY(8px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* SHOW ON HOVER */
  .mega-menu-container:hover .mega-menu-list {
    display: grid !important;
  }

  /* REMOVE BULLETS */
  .mega-menu-list li {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .mega-item {
    display: flex !important;
    align-items: center;
    gap: 14px;
    padding: 10px 12px;
    border-radius: 14px;
    background: #fff;
    border: 1px solid #E2E8F0;
    text-decoration: none !important;
    transition: all .25s ease;
    position: relative;
    overflow: hidden;
  }

  /* left accent line on hover */
  .mega-item::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, #0F766E, #14B8A6);
    transform: scaleY(0);
    transition: transform .25s ease;
    border-radius: 0 4px 4px 0;
  }

  .mega-item:hover {
    background: #ECFEFF;
    border-color: rgba(20, 184, 166, .45);
    box-shadow: 0 8px 20px rgba(15, 118, 110, .14);
    transform: translateY(-2px);
  }

  .mega-item:hover::before {
    transform: scaleY(1);
  }

  .mega-item img {
    width: 54px;
    height: 54px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    background: #F8FAFC;
    padding: 3px;
    flex-shrink: 0;
    transition: transform .25s ease;
  }

  .mega-item:hover img {
    transform: scale(1.08);
  }

  .mega-item span {
    color: #1F2937;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.35;
    letter-spacing: .01em;
    transition: color .25s ease;
  }

  .mega-item:hover span {
    color: #0F766E;
  }

  .mega-menu-container>a::after {
    display: none !important;
  }

  .header-contact a,
  .header-contact a:link,
  .header-contact a:visited,
  .header-contact a:hover,
  .header-contact a:focus,
  .header-contact a:active {
    text-decoration: none !important;
  }

  .cat-trigger i {
    font-size: 12px;
    margin-left: 6px;
    transition: .3s;
  }

  .mega-menu-container:hover .cat-trigger i {
    transform: rotate(180deg);
  }

  /* MOBILE */

  @media(max-width:991px) {

    .mega-menu-list {

      display: none !important;
    }
  }

  .header-search-wrapper {
    position: relative;
  }

  .so-wrap {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #fff;
    border: 1px solid #E2E8F0;
    box-shadow: 0 12px 28px rgba(15, 118, 110, .14);
    z-index: 9999;
    margin-top: 6px;
    padding: 16px;
    border-radius: 12px;
  }

  .so-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 24px;
    align-items: start;
  }

  .so-title {
    font-size: 12px;
    letter-spacing: .08em;
    color: #0F766E;
    font-weight: 600;
    margin: 0 0 8px;
  }

  #so-suggestions,
  #so-products {
    list-style: none;
    margin: 0;
    padding: 0;
    max-height: 360px;
    overflow: auto;
  }

  #so-suggestions li {
    padding: 8px 0;
    cursor: pointer;
    border-bottom: 1px dotted #E2E8F0;
    color: #1F2937;
  }

  #so-suggestions li:hover {
    color: #0F766E;
    text-decoration: underline;
  }

  #so-products li {
    padding: 12px 0;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    gap: 12px;
    align-items: center;
  }

  #so-products a {
    display: flex;
    gap: 12px;
    align-items: center;
    text-decoration: none;
    color: inherit;
    width: 100%;
  }

  #so-products img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #E2E8F0;
    flex-shrink: 0;
  }

  #so-products .prod-info {
    flex: 1;
  }

  #so-products .prod-info div:first-child {
    font-weight: 600;
    font-size: 14px;
    color: #1F2937;
  }

  #so-products .prod-info div:last-child {
    font-size: 12px;
    color: #0F766E;
    font-weight: 600;
    margin-top: 2px;
  }

  .so-close {
    position: absolute;
    bottom: 12px;
    left: 12px;
    border: none;
    background: #fff;
    border: 1px solid #E2E8F0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    color: #6B7280;
  }

  .so-close:hover {
    background: #ECFEFF;
    border-color: #0F766E;
    color: #0F766E;
  }

  /* ===== CART SLIDE PANEL ===== */
  .cart-dropdown {
    position: relative;
  }

  /* Overlay */
  .cart-dropdown .cart-overlay {
    position: fixed;
    inset: 0;
    background: rgba(31, 41, 55, .55);
    opacity: 0;
    visibility: hidden;
    transition: opacity .2s ease;
    z-index: 1040;
    pointer-events: none;
  }

  .cart-dropdown.open .cart-overlay {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
  }

  /* Panel */
  .cart-dropdown .dropdown-menu.mobile-cart {
    position: fixed !important;
    top: 0 !important;
    right: 0 !important;
    left: auto !important;
    height: 100vh;
    width: 380px;
    max-width: 92vw;
    box-sizing: border-box;
    background: #fff;
    border: none;
    border-radius: 0;
    padding: 20px 16px 16px 16px;
    box-shadow: -12px 0 24px rgba(31, 41, 55, .2);
    z-index: 1050;
    transform: translateX(110%) !important;
    transition: transform .3s ease;
    will-change: transform;
    display: flex;
    flex-direction: column;
  }

  /* neutralize any Bootstrap .show translate3d */
  .cart-dropdown .dropdown-menu.mobile-cart.show {
    transform: translateX(110%) !important;
  }

  .cart-dropdown.open .dropdown-menu.mobile-cart {
    transform: translateX(0) !important;
  }

  /* Close */
  .cart-dropdown .cart-close {
    position: absolute;
    top: 12px;
    left: 14px;
    width: 32px;
    height: 32px;
    line-height: 30px;
    text-align: center;
    border: 1px solid #E2E8F0;
    border-radius: 50%;
    color: #1F2937;
    background: #fff;
    z-index: 2;
    font-size: 13px;
    transition: all .2s ease;
  }

  .cart-dropdown .cart-close:hover {
    border-color: #0F766E;
    color: #fff;
    background: #0F766E;
  }

  /* Cart header accent */
  .cart-dropdown .dropdown-cart-header {
    color: #1F2937;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 16px;
    letter-spacing: .02em;
    border-bottom: 2px solid #0F766E;
    padding: 0 0 12px 44px;
    margin-bottom: 4px;
  }

  /* Cart count badge — amber accent */
  .cart-dropdown .cart-count.badge-circle {
    background: #F59E0B !important;
    color: #1F2937 !important;
    font-weight: 700;
  }

  /* Scroll area */
  .cart-dropdown .dropdownmenu-wrapper {
    margin-top: 34px;
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
  }

  /* Product list (scrolls) */
  .cart-dropdown .dropdown-cart-products {
    flex: 1;
    overflow-y: auto;
    min-height: 0;
    padding-right: 4px;
    margin-bottom: 6px;
  }

  .cart-dropdown .dropdown-cart-products .product {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #F1F5F9;
  }

  .cart-dropdown .dropdown-cart-products .product-image-container {
    position: relative;
    flex: 0 0 62px;
    width: 62px;
    height: 62px;
    margin: 0;
    order: 0;
  }

  .cart-dropdown .dropdown-cart-products .product-image-container img {
    width: 62px;
    height: 62px;
    object-fit: contain;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    background: #fff;
    padding: 4px;
  }

  .cart-dropdown .dropdown-cart-products .product-details {
    flex: 1;
    order: 1;
    min-width: 0;
  }

  .cart-dropdown .dropdown-cart-products .product-title {
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #1F2937;
    margin: 0 0 4px;
    line-height: 1.35;
  }

  .cart-dropdown .dropdown-cart-products .cart-product-info {
    font-size: 12.5px;
    font-weight: 600;
    color: #6B7280;
  }

  .cart-dropdown .dropdown-cart-products .cart-product-qty {
    color: #0F766E;
  }

  .cart-dropdown .dropdown-cart-products .btn-remove {
    position: absolute;
    top: -7px;
    right: -7px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #fff;
    border: 1px solid #E2E8F0;
    color: #DC2626;
    font-size: 9px;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .2s ease;
  }

  .cart-dropdown .dropdown-cart-products .btn-remove:hover {
    background: #DC2626;
    border-color: #DC2626;
    color: #fff;
  }

  .cart-dropdown .dropdown-cart-total {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 0;
    border-top: 2px solid #EEF2F7;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 15px;
    color: #1F2937;
  }

  .cart-dropdown .dropdown-cart-total .cart-total-price {
    color: #0F766E;
    float: none !important;
  }

  .cart-dropdown .cart-empty-mini {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #98A2B3;
    padding: 40px 0;
  }

  .cart-dropdown .cart-empty-mini i {
    font-size: 40px;
    color: #CBD5E1;
    margin-bottom: 12px;
  }

  .cart-dropdown .cart-empty-mini p {
    font-size: 14px;
    font-weight: 600;
    margin: 0;
  }

  .cart-dropdown .dropdown-cart-action {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding-top: 6px;
  }

  .cart-dropdown .dropdown-cart-action .btn {
    display: block;
    width: 100%;
    text-align: center;
    padding: 12px;
    border-radius: 30px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none !important;
    transition: all .25s ease;
  }

  .cart-dropdown .dropdown-cart-action .view-cart {
    background: #fff;
    border: 1.5px solid #0F766E;
    color: #0F766E;
  }

  .cart-dropdown .dropdown-cart-action .view-cart:hover {
    background: #0F766E;
    color: #fff;
  }

  .cart-dropdown .dropdown-cart-action .btn-dark {
    background: linear-gradient(135deg, #14B8A6, #0F766E);
    border: none;
    color: #fff;
  }

  .cart-dropdown .dropdown-cart-action .btn-dark:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(15, 118, 110, .28);
    color: #fff;
  }

  body.cart-open {
    overflow: hidden;
  }

  .header-middle {
    display: flex;
    padding: 0.7rem 0;
    border-top: 1px solid #E2E8F0;
    background: #FFFFFF;
  }

  .header-middle .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .header-middle .header-left {
    flex: 0 0 auto;
  }

  .header-middle .header-right {
    flex: 1 1 auto;
    display: flex;
    align-items: center;
    justify-content: flex-end;
  }

  .header-middle .header-search-category {
    flex: 1 1 auto;
    max-width: 700px;
    margin: 0 30px;
  }

  .header-middle .header-search-category .search-form {
    width: 100%;
  }

  .header-middle .header-search-category .search-form {
    width: 100% !important;
  }

  .header-search-category .search-form {
    width: 100% !important;
  }

  .header-search-category .form-control {
    flex: 1;
    height: 58px !important;
    border: none !important;
    background: transparent !important;
    padding: 0 20px !important;
    box-shadow: none !important;
    color: #1F2937;
  }

  .header-search-category .form-control::placeholder {
    color: #6B7280;
  }

  .header-search-category .header-search-wrapper {
    display: flex !important;
    align-items: center !important;
    width: 100% !important;
    height: 58px !important;
    overflow: hidden;
    border: 1px solid #E2E8F0 !important;
    border-radius: 40px !important;
    background: #fff;
    transition: border-color .2s ease, box-shadow .2s ease;
  }

  .header-search-category .header-search-wrapper:focus-within {
    border-color: #14B8A6 !important;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, .15);
    background: #fff;
  }

  .header-search-category .select-custom {
    width: 280px !important;
    min-width: 280px !important;
    border-left: 1px solid #E2E8F0;
  }

  .header-search-category .select-custom select {
    width: 100% !important;
    height: 58px !important;
    border: none !important;
    background: transparent !important;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    padding: 0 40px 0 15px !important;
  }

  .header-search-category .btn.icon-magnifier {
    width: 46px !important;
    min-width: 46px !important;
    height: 46px !important;
    align-self: center;
    margin-right: 6px;
    border: none !important;
    border-radius: 50% !important;
    background: #0F766E !important;
    color: #fff !important;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s ease, transform .2s ease;
  }

  .header-search-category .btn.icon-magnifier:hover {
    background: #14B8A6 !important;
    color: #fff !important;
    transform: scale(1.05);
  }

  /* Header icons hover polish */
  .header-right .header-icon i {
    transition: color .2s ease;
  }

  .header-right .header-icon:hover i {
    color: #0F766E;
  }

  /* wishlist count badge */
  .header-icon.wish-rel {
    position: relative;
  }

  .wish-count {
    position: absolute;
    top: -7px;
    right: -9px;
    min-width: 18px;
    height: 18px;
    line-height: 18px;
    padding: 0 4px;
    background: #F59E0B;
    color: #1F2937;
    font-size: 10.5px;
    font-weight: 700;
    text-align: center;
    border-radius: 10px;
    display: inline-block;
  }

  /* Remove underline from all menu links */
  .main-nav .menu>li>a,
  .main-nav .menu>li>a:hover,
  .main-nav .menu>li>a:focus,
  .main-nav .menu>li>a:active,
  .main-nav .menu>li.active>a {
    text-decoration: none !important;
  }

  /* Remove any pseudo-element lines */
  .main-nav .menu>li>a:before,
  .main-nav .menu>li>a:after {
    display: none !important;
    content: none !important;
  }

  /* =========================
PREMIUM HEADER POLISH
========================= */

  /* ---- TOP BAR : brand dark (Text Primary) ---- */
  .header-top {
    background: #1F2937 !important;
    border-bottom: none !important;
  }

  .header-top .container {
    min-height: 42px;
  }

  .header-top .top-message {
    color: #ECFEFF !important;
    font-size: 11.5px;
    font-weight: 500;
    letter-spacing: .14em;
    margin: 0;
  }

  .header-top .header-dropdown>a {
    color: #6B7280 !important;
    font-size: 11.5px;
    letter-spacing: .08em;
    text-transform: uppercase;
  }

  .header-top .header-menu ul li a {
    color: #F59E0B !important;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    text-decoration: none !important;
    padding: 7px 18px;
    border-radius: 30px;
    background: #374151;
    margin-left: 8px;
    transition: all .25s ease;
  }

  .header-top .header-menu ul li a:hover {
    color: #fff !important;
    background: #F59E0B;
  }

  .header-top .separator {
    background: rgba(255, 255, 255, .2) !important;
  }

  /* Social icons — minimal outlined circles */
  .header-top .social-icons .social-icon {
    width: 30px !important;
    height: 30px !important;
    line-height: 28px !important;
    border: 1px solid rgba(255, 255, 255, .3) !important;
    border-radius: 50% !important;
    background: transparent !important;
    color: #fff !important;
    font-size: 12px !important;
    text-align: center;
    margin-left: 8px;
    transition: all .25s ease;
  }

  .header-top .social-icons .social-icon:hover {
    background: #14B8A6 !important;
    border-color: #14B8A6 !important;
    color: #fff !important;
    transform: translateY(-2px);
  }

  .header-top .social-icons .social-icon i {
    line-height: inherit;
  }

  /* ---- SEARCH : category select same bg as search ---- */
  .header-search-category .select-custom {
    background: transparent !important;
  }

  .header-search-category .select-custom select {
    background: transparent !important;
    color: #6B7280 !important;
    font-weight: 500;
    cursor: pointer;
  }

  .header-search-category .select-custom:before,
  .header-search-category .select-custom:after {
    color: #0F766E !important;
  }

  /* ---- MAIN NAV : pill style (outline on hover, fill on active) ---- */
  .header-bottom {
    box-shadow: 0 4px 14px rgba(15, 118, 110, .18);
  }

  .main-nav .menu>li {
    margin: 0 3px;
  }

  .main-nav .menu>li>a {
    display: inline-block;
    color: #fff !important;
    font-weight: 600;
    letter-spacing: .05em;
    padding: 8px 20px !important;
    margin: 9px 0;
    border-radius: 30px;
    border: 1.5px solid transparent !important;
    box-shadow: none !important;
    background: transparent !important;
    transition: all .25s ease;
  }

  /* hover = outlined pill */
  .main-nav .menu>li:hover>a {
    border-color: rgba(255, 255, 255, .75) !important;
    background: transparent !important;
    color: #fff !important;
    box-shadow: none !important;
  }

  /* active = filled pill, primary text */
  .main-nav .menu>li.active>a {
    background: #fff !important;
    color: #0F766E !important;
    border-color: #fff !important;
    box-shadow: 0 3px 10px rgba(0, 0, 0, .12) !important;
  }

  .main-nav .menu>li.active:hover>a {
    background: #fff !important;
    color: #14B8A6 !important;
  }

  /* kill any theme tip / arrow / orange notch on nav items */
  .main-nav .menu>li:before,
  .main-nav .menu>li:after,
  .main-nav .menu>li>a:before,
  .main-nav .menu>li>a:after,
  .main-nav .menu>li.active:before,
  .main-nav .menu>li.active:after,
  .main-nav .menu>li:hover:before,
  .main-nav .menu>li:hover:after {
    display: none !important;
    content: none !important;
    border: none !important;
    background: none !important;
  }

  /* ====================================
     MOBILE NAV DRAWER (custom)
     ==================================== */
  .mobile-nav-toggler {
    display: none;
    background: transparent;
    border: none;
    font-size: 22px;
    color: #0F766E;
    padding: 4px 8px;
    line-height: 1;
    cursor: pointer;
  }

  .m-nav-overlay {
    position: fixed;
    inset: 0;
    background: rgba(31, 41, 55, .55);
    opacity: 0;
    visibility: hidden;
    transition: opacity .25s ease;
    z-index: 1055;
  }

  .m-nav-overlay.open {
    opacity: 1;
    visibility: visible;
  }

  .m-nav {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 300px;
    max-width: 84vw;
    background: #fff;
    z-index: 1060;
    transform: translateX(-100%);
    transition: transform .3s ease;
    display: flex;
    flex-direction: column;
    box-shadow: 12px 0 30px rgba(31, 41, 55, .18);
  }

  .m-nav.open {
    transform: translateX(0);
  }

  .m-nav-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 18px;
    border-bottom: 1px solid #EEF2F7;
    background: linear-gradient(135deg, #ECFEFF, #F8FAFC);
  }

  .m-nav-logo img {
    height: 34px;
    width: auto;
  }

  .m-nav-close {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 1px solid #E2E8F0;
    background: #fff;
    color: #1F2937;
    font-size: 22px;
    line-height: 1;
    cursor: pointer;
    transition: all .2s ease;
  }

  .m-nav-close:hover {
    background: #0F766E;
    color: #fff;
    border-color: #0F766E;
  }

  .m-nav-body {
    flex: 1;
    overflow-y: auto;
    padding: 6px 0 20px;
  }

  .m-nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .m-nav-list>li {
    border-bottom: 1px solid #F1F5F9;
  }

  .m-nav-list>li>a,
  .m-nav-acc-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 14px 20px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #1F2937;
    text-decoration: none !important;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
  }

  .m-nav-list>li>a i {
    color: #0F766E;
    width: 18px;
    text-align: center;
    font-size: 15px;
  }

  .m-nav-list>li>a:hover,
  .m-nav-acc-btn:hover {
    background: #F6FBFA;
    color: #0F766E;
  }

  .m-nav-acc-btn {
    justify-content: space-between;
  }

  .m-nav-acc-btn>span {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .m-nav-acc-btn>span i {
    color: #0F766E;
    width: 18px;
    text-align: center;
    font-size: 15px;
  }

  .m-nav-caret {
    transition: transform .25s ease;
    color: #98A2B3 !important;
    font-size: 12px;
  }

  .m-nav-acc.open .m-nav-caret {
    transform: rotate(180deg);
  }

  .m-nav-acc-panel {
    max-height: 0;
    overflow: hidden;
    transition: max-height .35s ease;
    background: #F8FAFC;
  }

  .m-nav-acc.open .m-nav-acc-panel {
    max-height: 1600px;
  }

  .m-nav-subitem {
    display: block;
    padding: 11px 20px 11px 50px;
    font-size: 13px;
    color: #475467;
    text-decoration: none !important;
    border-top: 1px solid #EEF2F7;
    transition: all .2s ease;
  }

  .m-nav-subitem:hover {
    background: #ECFEFF;
    color: #0F766E;
    padding-left: 54px;
  }

  .m-nav-subitem.all {
    font-weight: 700;
    color: #0F766E;
  }

  .m-nav-foot {
    padding: 16px 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .m-nav-foot a {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none !important;
  }

  .m-nav-account {
    padding: 11px;
    border-radius: 30px;
    background: linear-gradient(135deg, #14B8A6, #0F766E);
    color: #fff !important;
  }

  .m-nav-call {
    color: #0F766E !important;
  }

  body.m-nav-lock {
    overflow: hidden;
  }

  /* ====================================
     MOBILE HEADER RESPONSIVE POLISH
     ==================================== */
  @media (max-width: 991px) {
    .mobile-nav-toggler {
      display: inline-flex;
      align-items: center;
    }

    .header-middle {
      padding: 10px 0;
    }

    .header-middle .header-left {
      padding-left: 0;
    }

    .header-middle .logo img {
      max-height: 42px;
      width: auto;
    }

    .header-right .header-icon {
      margin-left: 10px;
    }

    .header-right .header-icon i {
      font-size: 20px;
    }
  }

  @media (min-width: 992px) {

    .m-nav,
    .m-nav-overlay,
    .mobile-nav-toggler {
      display: none !important;
    }
  }

  @media (max-width: 575px) {
    .header-top .container {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .header-top .header-right {
      margin: 0 auto !important;
      justify-content: center;
      width: auto;
    }

    .header-top .separator {
      display: none;
    }
  }

  /* ==================================== */

  @media (max-width:768px) {
    .so-grid {
      grid-template-columns: 1fr;
    }

    .header-search-inline {
      display: none !important;
    }

    .header-search-popup {
      display: inline-block !important;
    }

    .header-search-wrapper {
      width: 100%;
    }
  }

  .dropdown-toggle::after {
    display: inline-block;
    margin-left: .255em;
    vertical-align: .255em;
    content: "";
    border-top: .3em solid;
    border-right: .3em solid transparent;
    border-bottom: 0;
    border-left: .3em solid transparent;
    display: none
  }
</style>

<!-- ===================== -->
<!-- LIVE SEARCH JS -->
<!-- ===================== -->
<script>
  (function () {
    const APP_BASE = "<?= rtrim(base_url(), '/'); ?>";
    const UPLOAD_BASE = "<?= $JS_UPLOAD_BASE ?>";               // https://meibotan.com/writable
    const FALLBACK_IMG = '<?= base_url('/assets/no-image.png'); ?>';

    const input = document.getElementById('s');
    const catSel = document.getElementById('cat');
    const wrap = document.getElementById('search-overlay');
    const ulSug = document.getElementById('so-suggestions');
    const ulProd = document.getElementById('so-products');
    const btnClose = document.getElementById('so-close');
    const mobileToggle = document.getElementById('mobile-search-toggle');

    if (!input || !wrap) return;

    let timer = null;
    const debounce = (fn, ms) => (...a) => {
      clearTimeout(timer);
      timer = setTimeout(() => fn(...a), ms);
    };

    const show = () => { wrap.hidden = false; };
    const hide = () => { wrap.hidden = true; };

    function productUrl(p) {
      return "<?= rtrim(site_url('product'), '/'); ?>/" + (p.product_slug || p.product_id);
    }

    function render(data) {
      ulSug.innerHTML = '';
      (data.suggestions || []).forEach(s => {
        const li = document.createElement('li');
        li.textContent = s;
        li.onclick = () => {
          const cat = catSel ? catSel.value : 'All';
          window.location.href = "<?= site_url('search'); ?>?s=" + encodeURIComponent(s) + "&cat=" + encodeURIComponent(cat);
        };
        ulSug.appendChild(li);
      });

      ulProd.innerHTML = '';
      (data.products || []).forEach(p => {
        let imageUrl = FALLBACK_IMG;
        if (p.product_thumb && p.product_thumb.trim() !== '') {
          const thumb = p.product_thumb.trim();
          imageUrl = thumb.startsWith('http') ? thumb : UPLOAD_BASE + '/' + thumb;
        }

        const li = document.createElement('li');
        li.innerHTML = `
        <a href="${productUrl(p)}">
          <img src="${imageUrl}"
               alt="${p.product_name || 'Product'}"
               onerror="this.src='${FALLBACK_IMG}';">
          <div class="prod-info">
            <div>${p.product_name || ''}</div>
            <div>₹ ${(Number(p.eff_price || 0)).toFixed(2)}</div>
          </div>
        </a>`;
        ulProd.appendChild(li);
      });

      if ((data.suggestions && data.suggestions.length) || (data.products && data.products.length)) {
        show();
      } else {
        hide();
      }
    }

    const runSearch = debounce(async (q) => {
      if (!q || q.length < 2) { hide(); return; }

      const cat = catSel ? catSel.value : 'All';
      const url = "<?= site_url('search/overlay'); ?>?q=" + encodeURIComponent(q) + "&cat=" + encodeURIComponent(cat);

      try {
        const res = await fetch(url, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) { hide(); return; }
        const json = await res.json();
        const data = (json && json.ok) ? json : { suggestions: json.suggestions || [], products: json.products || [] };
        render(data);
      } catch (e) {
        console.error(e);
        hide();
      }
    }, 250);

    input.addEventListener('input', e => runSearch(e.target.value));
    input.addEventListener('focus', e => { if ((e.target.value || '').length >= 2) runSearch(e.target.value); });
    if (catSel) catSel.addEventListener('change', () => { if ((input.value || '').length >= 2) runSearch(input.value); });

    btnClose.addEventListener('click', hide);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') hide(); });
    document.addEventListener('click', e => { if (!wrap.contains(e.target) && e.target !== input) hide(); });

    // Mobile search toggle
    if (mobileToggle) {
      mobileToggle.addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.querySelector('.search-form');
        if (form) form.classList.toggle('active');
        if (form && form.classList.contains('active')) {
          form.style.display = 'block';
          input.focus();
        } else if (form) {
          form.style.display = 'none';
        }
      });
    }
  })();
</script>

<!-- ===================== -->
<!-- CART SLIDE JS -->
<!-- ===================== -->
<script>
  (function () {
    const dd = document.querySelector('.cart-dropdown');
    if (!dd) return;

    const toggleBtn = dd.querySelector('.cart-toggle');
    const panel = dd.querySelector('.mobile-cart');
    const overlay = dd.querySelector('.cart-overlay');
    const closeBtn = dd.querySelector('.cart-close');

    function openCart(e) {
      if (e) e.preventDefault();
      dd.classList.add('open');
      document.body.classList.add('cart-open');
    }

    function closeCart(e) {
      if (e) e.preventDefault();
      dd.classList.remove('open');
      document.body.classList.remove('cart-open');
    }

    function stop(e) { e.stopPropagation(); }

    if (toggleBtn) { toggleBtn.addEventListener('click', openCart); }
    if (closeBtn) { closeBtn.addEventListener('click', closeCart); }
    if (overlay) { overlay.addEventListener('click', closeCart); }
    if (panel) { panel.addEventListener('click', stop); }

    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closeCart(e); } });
    document.addEventListener('click', (e) => {
      if (!dd.classList.contains('open')) return;
      if (!dd.contains(e.target)) closeCart(e);
    });
  })();
</script>

<!-- ===================== -->
<!-- MOBILE NAV DRAWER JS -->
<!-- ===================== -->
<script>
  (function () {
    const toggler = document.getElementById('mobileNavToggler');
    const nav = document.getElementById('mNav');
    const overlay = document.getElementById('mNavOverlay');
    const closeBtn = document.getElementById('mNavClose');
    if (!toggler || !nav) return;

    function openNav(e) {
      if (e) e.preventDefault();
      nav.classList.add('open');
      overlay.classList.add('open');
      document.body.classList.add('m-nav-lock');
      nav.setAttribute('aria-hidden', 'false');
    }

    function closeNav(e) {
      if (e) e.preventDefault();
      nav.classList.remove('open');
      overlay.classList.remove('open');
      document.body.classList.remove('m-nav-lock');
      nav.setAttribute('aria-hidden', 'true');
    }

    toggler.addEventListener('click', openNav);
    if (closeBtn) closeBtn.addEventListener('click', closeNav);
    if (overlay) overlay.addEventListener('click', closeNav);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeNav(); });

    // Accordion — categories show only on click
    nav.querySelectorAll('.m-nav-acc-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        const acc = btn.parentElement;
        const expanded = acc.classList.toggle('open');
        btn.setAttribute('aria-expanded', String(expanded));
      });
    });
  })();
</script>
