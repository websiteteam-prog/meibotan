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
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/vendor/fontawesome-free/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/css/style.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/demo4.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/css/custom.css" />
<style type="text/css">

    body { background-color: #fff; }

    /* =========================================
       HERO IMAGE (unchanged behaviour, simple)
       ========================================= */
    .contact-hero { width: 100%; line-height: 0; }
    .contact-hero img { width: 100%; height: auto; display: block; }

    /* =========================================
       SECTION EYEBROW / HEADING (matches About page)
       ========================================= */
    .section-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #E6F7F4;
        border: 1px solid rgba(15,118,110,.18);
        color: #0F766E;
        padding: 7px 20px;
        border-radius: 30px;
        margin-bottom: 16px;
    }
    .section-eyebrow i { font-size: 10px; color: #F59E0B; }
    .section-eyebrow span {
        font-family: 'Oswald', sans-serif;
        text-transform: uppercase;
        letter-spacing: .12em;
        font-size: 11.5px;
        font-weight: 700;
        color: #0F766E;
    }
    .section-heading {
        font-family: 'Poppins', sans-serif;
        font-size: 32px;
        font-weight: 600;
        color: #1F2937;
        line-height: 1.25;
        margin-bottom: 10px;
    }
    .section-heading span { color: #0F766E; }
    @media(max-width:767px) {
        .section-heading { font-size: 1.6rem; }
        .section-eyebrow { padding: 6px 16px; margin-bottom: 12px; }
        .section-eyebrow span { font-size: 10px; letter-spacing: .1em; }
    }

    /* =========================================
       CONTACT SECTION
       ========================================= */
    .contact-section {
        padding: 60px 0 70px;
        background: linear-gradient(160deg, #ECFEFF 0%, #F8FAFC 55%, #E6F7F4 100%);
    }
    .contact-us-container { max-width: 1140px; }

    .contact_note {
        line-height: 1.7;
        color: #6B7280;
        font-size: 13.5px;
        margin-bottom: 22px;
    }

    /* -- info card -- */
    .contact-info-card,
    .contact-form-card {
        background: #fff;
        border-radius: 20px;
        padding: 34px 30px;
        height: 100%;
        box-shadow: 0 12px 32px rgba(15,118,110,.08);
    }

    .office_location {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }
    .office_location:last-child { margin-bottom: 0; }
    .office_location .office-icon {
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #14B8A6, #0F766E);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .office_location .office-icon i { color: #fff; font-size: 17px; }
    .office_location h4 {
        margin-bottom: 8px;
        font-size: 16px;
        font-weight: 700;
        color: #1F2937;
    }
    .office_location p {
        margin-bottom: 6px;
        font-size: 13.5px;
        color: #6B7280;
        line-height: 1.7;
    }
    .office_location p:last-child { margin-bottom: 0; }
    .office_location p span { font-weight: 600; color: #1F2937; }

    /* -- form card -- */
    .contact-form-card p.form-note {
        color: #6B7280;
        font-size: 13.5px;
        line-height: 1.7;
        margin-bottom: 24px;
    }
    .contact-form-card .form-label {
        font-weight: 600;
        font-size: 13.5px;
        color: #1F2937;
        margin-bottom: 6px;
    }
    .contact-form-card .req { color: #F59E0B; }
    .contact-form-card .form-control {
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 11px 14px;
        font-size: 13.5px;
        transition: border-color .25s ease, box-shadow .25s ease;
    }
    .contact-form-card .form-control:focus {
        border-color: #14B8A6;
        box-shadow: 0 0 0 3px rgba(20,184,166,.15);
        outline: none;
    }
    .contact-form-card .error {
        color: #DC2626;
        font-size: 12.5px;
        margin-top: 5px;
    }
    .contact-form-card .btn.btn-dark {
        background: linear-gradient(135deg, #14B8A6, #0F766E);
        border: none;
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        padding: 12px 34px;
        border-radius: 30px;
        transition: all .3s ease;
    }
    .contact-form-card .btn.btn-dark:hover {
        background: #F59E0B;
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(245,158,11,.3);
    }

    @media(max-width:991px) {
        .contact-info-card { margin-bottom: 24px; }
    }
    @media(max-width:767px) {
        .contact-section { padding: 40px 15px 50px; }
        .contact-info-card, .contact-form-card { padding: 24px 20px; border-radius: 16px; }
    }

    /* =========================================
       MAP SECTION
       ========================================= */
    #contact-map { padding: 0 0 70px; background: #fff; }
    .contact-map-card {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 12px 32px rgba(15,118,110,.1);
        max-width: 1140px;
        margin: 0 auto;
    }
    @media(max-width:767px) {
        #contact-map { padding-bottom: 45px; }
        .contact-map-card { border-radius: 14px; }
    }

</style>
</head>
<body>
<div class="page-wrapper">
<?= $this->include('frontend/partials/header') ?>
<main class="main">
     <div class="contact-hero">
      <img src="<?php echo base_url(); ?>/assets/frontend/images/contacthand.jpg" alt="Contact Meibotan" class="d-none d-md-block">
      <img src="<?php echo base_url(); ?>/assets/frontend/images/contactmobile.jpg" alt="Contact Meibotan" class="d-block d-md-none">
  </div>

  <section class="contact-section">
    <div class="container contact-us-container">
   <?php if(session()->getFlashdata('success_msg')){ ?>
               <div class="row mt-2">
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
      <div class="col-lg-6 mb-4 mb-lg-0">
        <div class="contact-info-card">
        <div class="section-eyebrow"><i class="fas fa-leaf"></i><span>Get In Touch</span></div>
        <h2 class="section-heading">Contact <span>Information</span></h2>
        <p class="contact_note">Multi-line telephone hotline daily<br/>
          08:00am – 09:00pm</p>

        <div class="office_location">
          <div class="office-icon"><i class="fas fa-building"></i></div>
          <div>
            <p><b>FIDO PHARMA LLC</b> <br>16192 Coastal Highway Lewes DE 19958 (USA)</p>
          </div>
        </div>

        <div class="office_location">
          <div class="office-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div>
            <h4>India Office</h4>
            <p><span>Call:</span> +91-7009057196<br/>
              <span>Email:</span> support@meibotan.com</p>
            <p>Plot No. 108, Global Industrial Park Barwala, Panchkula (HR) - 134118</p>
          </div>
        </div>
        <!-- <div class="office_location">
          <h4>Canada Office</h4>
          <p>
            <span>Email:</span> support@meibotan.ca</p>
          <p>13142, 108 Avenue, Surrey Postal/ZIP :- V3T 2J1</p>
        </div>
        <div class="office_location">
          <h4>UK Office</h4>
          <p>
            <span>Email:</span> support@meibotan.co.uk</p>
          <p>New Cut Rd, St Davids, Swansea SA1 2DN</p>
        </div> -->
        </div>
      </div>
      <div class="col-lg-6">
        <div class="contact-form-card">
        <div class="section-eyebrow"><i class="fas fa-leaf"></i><span>Send a Message</span></div>
        <h2 class="section-heading">Get In <span>Touch</span></h2>
        <p class="form-note">Got any problems with purchase? Wanna ask for a piece of advice or leave a suggestion? Don't hesitate and write to our Email!</p>
        <?php
            $attributes=array('class' => 'custom-form ', 'id' => 'loginform');
            echo form_open('contact-us', $attributes);
            ?>
        <div class="row">
          <div class="col-lg-6">
            <div>
              <div class="mb-3">
                <label  class="form-label">Your Name <span class="req">*</span></label>
                <?php echo form_input ( array(
                'name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'class' => "form-control",
                'value' => set_value( 'name')));

                ?>
                <?php if(isset($validation['name'])){ ?>
                <div class="error"><?php echo $validation['name']; ?></div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div>
              <div class="mb-3">
                <label  class="form-label">Your E-mail <span class="req">*</span></label>
                <?php echo form_input ( array(
                'name' => 'user_email',
                'id' => 'user_email',
                'type' => 'text',
                'maxlength' => 400,
                'class' => "form-control",
                'value' => set_value( 'user_email') ) );

                ?>
                <?php if(isset($validation['user_email'])){ ?>
                <div class="error"><?php echo $validation['user_email']; ?></div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div>
              <div class="mb-3">
                <label  class="form-label">Your Message <span class="req">*</span></label>
                <?php echo form_textarea( array(
                'name' => 'message',
                'id' => 'message',
                'rows' =>2,
                'maxlength' => 400,
                'class' => "form-control",
                'value' => set_value( 'message') ) );

                ?>
                <?php if(isset($validation['message'])){ ?>
                <div class="error"><?php echo $validation['message']; ?></div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="">
              <button type="submit" class="btn btn-dark font-weight-normal">Submit</button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
  </section>

  <section id="contact-map">
  <div class="container">
  <div class="section-eyebrow"><i class="fas fa-leaf"></i><span>Find Us</span></div>
  <h2 class="section-heading">Our <span>Location</span></h2>
  </div>
  <div class="container">
  <div class="contact-map-card">
  <div style="width: 100%; height: 400px;">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3433.1046639338793!2d76.8726342151311!3d30.65208079603061!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390fef17b6e92211%3A0x8fe8c1aa1061de94!2sGlobal%20Industrial%20Park%2C%20Barwala%2C%20Haryana%20134118!5e0!3m2!1sen!2sin!4v1712733121451!5m2!1sen!2sin"
      width="100%"
      height="100%"
      style="border:0;"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>
  </div>
  </div>
</section>
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
