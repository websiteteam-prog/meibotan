<?php $dash_cur = uri_string(); ?>
<div class="sidebar widget widget-dashboard mb-lg-0 mb-3 col-lg-3 order-0">
  <div class="row">
    <div class="col-md-12">
      <div class="dash_sidebar">

        <!-- Mobile toggle (only shows on mobile) -->
        <button type="button" class="dash-side-toggle" id="dashSideToggle" aria-expanded="false"
          aria-controls="dashSideNav">
          <span><i class="fas fa-user-circle"></i> My Account</span>
          <i class="fas fa-chevron-down dash-side-caret"></i>
        </button>

        <div class="dash-side-collapse" id="dashSideNav">
          <h2 class="text-uppercase dash-side-title">My Account</h2>
          <ul class="nav nav-tabs list flex-column mb-0" role="tablist">
            <li class="nav-item">
              <a class="nav-link <?= $dash_cur == 'dashboard' ? 'active' : ''; ?>"
                href="<?php echo site_url("dashboard"); ?>" title="Dashboard"><i class="fas fa-th-large"></i>
                Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $dash_cur == 'my-orders' ? 'active' : ''; ?>"
                href="<?php echo site_url("my-orders"); ?>" title="Orders"><i class="fas fa-box"></i> My Orders</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $dash_cur == 'wishlist' ? 'active' : ''; ?>"
                href="<?php echo site_url("wishlist"); ?>" title="Wishlist"><i class="fas fa-heart"></i> My Wishlist</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url("my-orders"); ?>" title="My Address"><i
                  class="fas fa-map-marker-alt"></i> My Address</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $dash_cur == 'my-account' ? 'active' : ''; ?>"
                href="<?php echo site_url("my-account"); ?>" title="Account Details"><i class="fas fa-user"></i> Account
                Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $dash_cur == 'change-password' ? 'active' : ''; ?>"
                href="<?php echo site_url("change-password"); ?>" title="Change Password"><i class="fas fa-lock"></i>
                Change Password</a>
            </li>
            <li class="nav-item">
              <a class="nav-link dash-logout-link" href="<?php echo site_url("logout"); ?>"><i
                  class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  /* ===== Dashboard sidebar (brand) ===== */
  .dash_sidebar {
    background: #fff;
    border: 1px solid #EEF2F7;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(15, 23, 42, .05);
    overflow: hidden;
  }

  .dash-side-title {
    font-family: 'Poppins', sans-serif;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: .05em;
    color: #1F2937;
    margin: 0;
    padding: 18px 20px;
    border-bottom: 2px solid #0F766E;
  }

  .dash_sidebar .nav.list {
    padding: 10px;
  }

  .dash_sidebar .nav-item {
    border: none;
    margin: 0;
  }

  .dash_sidebar .nav-tabs {
    border: none;
  }

  .dash_sidebar .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    margin: 2px 0;
    border: none;
    border-radius: 10px;
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    font-weight: 600;
    color: #475467;
    text-decoration: none !important;
    transition: all .2s ease;
  }

  .dash_sidebar .nav-link i {
    width: 18px;
    text-align: center;
    font-size: 14px;
    color: #98A2B3;
    transition: color .2s ease;
  }

  .dash_sidebar .nav-link:hover {
    background: #F6FBFA;
    color: #0F766E;
  }

  .dash_sidebar .nav-link:hover i {
    color: #0F766E;
  }

  .dash_sidebar .nav-link.active {
    background: linear-gradient(135deg, #14B8A6, #0F766E);
    color: #fff;
    box-shadow: 0 8px 18px rgba(15, 118, 110, .22);
  }

  .dash_sidebar .nav-link.active i {
    color: #fff;
  }

  .dash_sidebar .nav-link.dash-logout-link {
    color: #DC2626;
  }

  .dash_sidebar .nav-link.dash-logout-link i {
    color: #DC2626;
  }

  .dash_sidebar .nav-link.dash-logout-link:hover {
    background: #FEF2F2;
    color: #DC2626;
  }

  /* toggle hidden on desktop */
  .dash-side-toggle {
    display: none;
  }

  /* ===== Mobile: toggle + slide-open ===== */
  @media (max-width: 991px) {
    .dash-side-title {
      display: none;
    }

    .dash-side-toggle {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      padding: 15px 18px;
      background: linear-gradient(135deg, #ECFEFF, #F8FAFC);
      border: none;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      font-weight: 700;
      color: #1F2937;
    }

    .dash-side-toggle>span {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .dash-side-toggle>span i {
      color: #0F766E;
      font-size: 18px;
    }

    .dash-side-caret {
      color: #0F766E;
      font-size: 13px;
      transition: transform .3s ease;
    }

    .dash-side-toggle[aria-expanded="true"] .dash-side-caret {
      transform: rotate(180deg);
    }

    .dash-side-collapse {
      max-height: 0;
      overflow: hidden;
      transition: max-height .35s ease;
    }

    .dash-side-collapse.open {
      max-height: 640px;
    }

    .dash_sidebar .nav.list {
      padding: 8px 10px 12px;
    }
  }
</style>

<script>
  (function () {
    var toggle = document.getElementById('dashSideToggle');
    var panel = document.getElementById('dashSideNav');
    if (!toggle || !panel) return;
    toggle.addEventListener('click', function () {
      var open = panel.classList.toggle('open');
      toggle.setAttribute('aria-expanded', String(open));
    });
  })();
</script>
