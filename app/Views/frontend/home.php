<?php $commfrontfunc = service('commfrontfunc'); ?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title><?php if (isset($metadata['page_title'])) {
    echo $metadata['page_title'];
  } ?></title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="Ankush Sharma" />

  <!-- Favicon -->
  <!--<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>/assets/frontend/images/favicon.png" />-->
  <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>/assets/frontend/images/favicon.ico" />
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
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/css/modal-video.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  <style>
    /* prevent any stray wide element from causing a horizontal scroll on mobile
       (scoped to body so a sticky/fixed header partial is unaffected) */
    body {
      max-width: 100%;
      overflow-x: hidden;
    }

    img {
      max-width: 100%;
    }

    .carousel-item {
      transition: transform 1s ease-in-out;
    }

    .carousel-inner {
      overflow: hidden;
    }

    .carousel-item img {
      object-fit: contain;
      /* or 'cover' depending on your layout */
      max-height: 100%;
    }



    /* Heading */
    .wellness-heading {
      font-size: 26px;
      font-weight: 600;
      color: #333;
    }

    .wellness-section {
      background-color: rgb(223, 245, 242);
    }

    /* Images */
    .wellness-img {
      width: 100%;
      max-width: 280px;
      height: 280px;
      border-radius: 50%;
      margin-left: 70px;
      object-fit: cover;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Dashed line */
    .wellness-line {
      border-top: 2px dashed #00796b;
      width: 60%;
      margin: 0 auto;
    }

    /* Button */
    .wellness-btn {
      display: inline-block;
      background: #F59E0B;
      color: #fff !important;
      padding: 13px 28px;
      border-radius: 30px;
      font-weight: 600;
      font-size: 14px;
      text-decoration: none !important;
      transition: all .3s ease;
      margin-top: 20px;
    }

    .wellness-btn:hover {
      background: #14B8A6;
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(15, 118, 110, .3);
    }

    /* wellness section — mobile: center circular images, scale down type */
    @media(max-width:767px) {
      .wellness-section.py-5 {
        margin-top: 0;
      }

      .wellness-img {
        margin: 0 auto;
        max-width: 200px;
        height: 200px;
      }

      .wellness-heading {
        font-size: 19px;
      }

      .wellness-line {
        width: 80%;
      }
    }


    /* =========================================
   INTRO WRAP : range + welcome (shared gradient)
   ========================================= */
    .intro-wrap {
      background: linear-gradient(160deg, #ECFEFF 0%, #F8FAFC 50%, #E6F7F4 100%);
      overflow: hidden;
    }


    /* =========================================
   PRODUCT RANGE — FLOATING ICON CARDS
   ========================================= */
    .range-section {
      background: transparent;
      padding: 0 0 45px;
    }

    .range-card {
      position: relative;
      background: #FFFFFF;
      border-radius: 20px;
      padding: 52px 20px 28px;
      text-align: center;
      height: 100%;
      margin-top: 38px;
      box-shadow: 0 10px 30px rgba(15, 118, 110, .10);
      transition: transform .3s ease, box-shadow .3s ease;
    }

    .range-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 18px 40px rgba(15, 118, 110, .18);
    }

    /* floating icon badge on top */
    .range-icon {
      position: absolute;
      top: -34px;
      left: 50%;
      transform: translateX(-50%);
      width: 68px;
      height: 68px;
      border-radius: 50%;
      background: linear-gradient(135deg, #14B8A6, #0F766E);
      border: 4px solid #F8FAFC;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 20px rgba(15, 118, 110, .35);
      transition: transform .3s ease;
    }

    .range-card:hover .range-icon {
      transform: translateX(-50%) scale(1.1);
    }

    .range-icon i {
      color: #fff;
      font-size: 24px;
    }

    .range-card h5 {
      font-size: 17px;
      font-weight: 700;
      color: #1F2937;
      margin-bottom: 10px;
    }

    .range-card p {
      font-size: 13.5px;
      color: #6B7280;
      line-height: 1.65;
      margin: 0;
    }

    @media(max-width:767px) {
      .range-section {
        padding: 0 0 25px;
      }

      .range-card {
        padding: 44px 14px 22px;
        margin-top: 34px;
        border-radius: 16px;
      }

      .range-icon {
        width: 58px;
        height: 58px;
        top: -29px;
      }

      .range-icon i {
        font-size: 20px;
      }

      .range-card h5 {
        font-size: 14.5px;
      }

      .range-card p {
        font-size: 12px;
      }
    }


    /* =========================================
   WELCOME HERO
   ========================================= */
    .welcome-hero {
      background: transparent;
      padding: 30px 0 0;
      overflow: hidden;
    }

    .welcome-badge {
      display: inline-block;
      background: #fff;
      color: #0F766E;
      border: 1px solid rgba(20, 184, 166, .4);
      padding: 7px 18px;
      border-radius: 30px;
      font-size: 12.5px;
      font-weight: 600;
      letter-spacing: .04em;
      margin-bottom: 20px;
    }

    .welcome-text h1 {
      font-size: 40px;
      font-weight: 600;
      color: #1F2937;
      line-height: 1.2;
      margin-bottom: 18px;
    }

    .welcome-text h1 span {
      color: #0F766E;
    }

    .welcome-text p {
      font-size: 15px;
      color: #6B7280;
      line-height: 1.75;
      margin-bottom: 26px;
      max-width: 520px;
    }

    .welcome-btn {
      display: inline-block;
      background: #F59E0B;
      color: #fff !important;
      padding: 13px 28px;
      border-radius: 30px;
      font-weight: 600;
      font-size: 14px;
      text-decoration: none !important;
      transition: all .3s ease;
    }

    .welcome-btn i {
      margin-left: 8px;
      font-size: 12px;
    }

    .welcome-btn:hover {
      background: #14B8A6;
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(15, 118, 110, .3);
    }

    .welcome-trust {
      display: flex;
      gap: 34px;
      margin-top: 34px;
      padding-top: 24px;
      border-top: 1px solid rgba(20, 184, 166, .25);
      width: 68%;
    }

    .trust-item {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .trust-item i {
      font-size: 22px;
      color: #0F766E;
    }

    .trust-item span {
      font-size: 12.5px;
      font-weight: 600;
      color: #1F2937;
      line-height: 1.3;
    }

    .welcome-product {
      position: relative;
      z-index: 1;
      max-width: 100%;
      height: auto;
      filter: drop-shadow(0 20px 35px rgba(15, 118, 110, .28));

    }


    @media(max-width:767px) {
      .welcome-hero {
        padding: 45px 20px;
      }

      .welcome-text h1 {
        font-size: 1.9rem;
      }

      .welcome-text p {
        font-size: 14px;
      }

      .welcome-trust {
        gap: 18px;
        flex-wrap: wrap;
        width: 100%;
        justify-content: center;
      }

      .trust-item i {
        font-size: 18px;
      }

      .trust-item span {
        font-size: 11.5px;
      }

      .welcome-visual {
        padding: 24px;
      }

      .welcome-product {
        max-width: 240px;
      }
    }


    .stats-section {
      text-align: center;
      padding: 50px 0;
    }

    body {
      background-color: white;
    }

    /* =========================================
   CONSUMER STUDIES
   ========================================= */
    .consumer-studies {
      padding: 70px 0;
      background: #F8FAFC;
      text-align: center;
    }

    .cs-badge {
      display: inline-block;
      background: #fff;
      color: #0F766E;
      border: 1px solid rgba(20, 184, 166, .4);
      padding: 7px 18px;
      border-radius: 30px;
      font-size: 12.5px;
      font-weight: 600;
      letter-spacing: .04em;
      margin-bottom: 18px;
    }

    .consumer-studies .section-heading {
      margin-bottom: 42px;
    }

    .cs-card {
      background: #fff;
      border: 1px solid #E2E8F0;
      border-radius: 18px;
      padding: 38px 26px 30px;
      height: 100%;
      transition: all .3s ease;
    }

    .cs-card:hover {
      transform: translateY(-6px);
      border-color: rgba(20, 184, 166, .5);
      box-shadow: 0 16px 34px rgba(15, 118, 110, .15);
    }

    .cs-icon {
      width: 68px;
      height: 68px;
      border-radius: 50%;
      background: linear-gradient(135deg, #14B8A6, #0F766E);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 22px;
      box-shadow: 0 8px 20px rgba(15, 118, 110, .3);
      transition: transform .3s ease;
    }

    .cs-card:hover .cs-icon {
      transform: scale(1.08);
    }

    .cs-icon i {
      color: #fff;
      font-size: 26px;
    }

    .cs-card h5 {
      font-size: 17px;
      font-weight: 700;
      color: #1F2937;
      margin-bottom: 12px;
    }

    .cs-card p {
      font-size: 13.5px;
      color: #6B7280;
      line-height: 1.75;
      margin: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .consumer-studies {
        padding: 45px 0;
      }

      .consumer-studies .section-heading {
        margin-bottom: 28px;
      }

      .cs-card {
        margin-bottom: 20px;
        padding: 32px 20px 26px;
      }

      .cs-icon {
        width: 58px;
        height: 58px;
        margin-bottom: 16px;
      }

      .cs-icon i {
        font-size: 22px;
      }
    }

    .carousel-item img {
      width: 100px;
      height: auto;
      margin: 0 auto;
      /*margin-top:20px;*/
    }

    .py-5 {
      padding-top: 3rem !important;
      padding-bottom: 3rem !important;
      margin-top: 30px;
    }

    .product-section {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .product-card {
      text-align: center;
      padding: 20px;
      border-radius: 10px;
      background: #ffffff;
      box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .product-card img {
      max-width: 100%;
      border-radius: 10px;
      transition: transform 0.3s ease-in-out;
      width: 300px;
    }

    .product-card:hover img {
      transform: scale(1.05);
    }

    .product-card h5 {
      margin-top: 10px;
      font-weight: bold;
    }

    .product-card p {
      margin-bottom: 10px;
      color: #6c757d;
    }

    .add-to-cart {
      display: block;
      margin-top: 10px;
      width: 100%;
      border-radius: 5px;
    }

    .filter-links a {
      text-decoration: none;
      margin: 0 10px;
      color: black;
    }

    .filter-links a.active {
      font-weight: bold;
      text-decoration: underline;
      color: black;
    }

    @media (max-width: 768px) {
      .filter-links {
        display: none;
      }

      .dropdown-filter {
        display: block;
      }
    }

    @media (min-width: 769px) {
      .dropdown-filter {
        display: none;
      }
    }

    .testimonial-card {
      background: #ffffff;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      height: 100%;
    }

    .testimonial-rating {
      color: #f8c22c;
      font-size: 1.2rem;
    }

    .testimonial-avatar {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 50%;
    }

    .testimonial-name {
      font-weight: bold;
      margin-bottom: 0;
    }

    .testimonial-date {
      color: #6c757d;
      font-size: 0.9rem;
    }

    .testimonial-section {
      background: #f1f9ff;
    }

    .carousel-control-prev-icon {
      margin-right: 140px;
    }

    .carousel-control-next-icon {
      margin-left: 140px;
    }

    /* mobile: keep the slider arrows inside the viewport */
    @media (max-width: 767px) {
      .carousel-control-prev-icon {
        margin-right: 0;
      }

      .carousel-control-next-icon {
        margin-left: 0;
      }
    }


    /* =========================================
   SHOP BY CATEGORY
   ========================================= */
    .featured-products {
      background: #fff;
      padding: 65px 0;
    }

    /* heading — welcome hero jaisa font style */
    .section-heading {
      font-size: 40px;
      font-weight: 600;
      color: #1F2937;
      line-height: 1.2;
      text-transform: none;
      letter-spacing: 0;
      margin-bottom: 45px;
    }

    .section-heading span {
      color: #0F766E;
    }

    .sbc-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(245, 158, 11, .12);
      border: 1px solid rgba(245, 158, 11, .35);
      color: #F59E0B;
      padding: 7px 20px;
      border-radius: 30px;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      margin-bottom: 14px;
    }

    /* circle categories slider */
    .sbc-slider {
      position: relative;
      padding: 0 8px;
    }

    .sbc-row {
      display: flex;
      gap: 30px;
      overflow-x: auto;
      scroll-behavior: smooth;
      scroll-snap-type: x mandatory;
      padding: 8px 4px 14px;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
    }

    .sbc-row::-webkit-scrollbar {
      display: none;
    }

    .sbc-item {
      flex: 0 0 auto;
      width: 138px;
      scroll-snap-align: start;
      text-decoration: none !important;
      text-align: center;
    }

    .sbc-img {
      display: block;
      width: 118px;
      height: 118px;
      margin: 0 auto 12px;
      border-radius: 50%;
      overflow: hidden;
      border: 3px solid #fff;
      box-shadow: 0 6px 18px rgba(15, 118, 110, .14);
      outline: 2px solid transparent;
      outline-offset: 3px;
      transition: all .3s ease;
      background: #F8FAFC;
    }

    .sbc-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform .35s ease;
    }

    .sbc-item:hover .sbc-img {
      outline-color: #14B8A6;
      box-shadow: 0 12px 26px rgba(15, 118, 110, .25);
      transform: translateY(-4px);
    }

    .sbc-item:hover .sbc-img img {
      transform: scale(1.1);
    }

    .sbc-name {
      display: block;
      font-size: 13.5px;
      font-weight: 600;
      color: #1F2937;
      line-height: 1.3;
      transition: color .25s ease;
    }

    .sbc-item:hover .sbc-name {
      color: #0F766E;
    }

    .sbc-count {
      display: block;
      font-size: 11.5px;
      color: #6B7280;
      margin-top: 3px;
    }

    .sbc-arrow {
      position: absolute;
      top: 52px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 1px solid #E2E8F0;
      background: #fff;
      color: #0F766E;
      font-size: 13px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 5;
      box-shadow: 0 6px 16px rgba(15, 118, 110, .16);
      transition: all .25s ease;
    }

    .sbc-arrow:hover {
      background: #0F766E;
      border-color: #0F766E;
      color: #fff;
    }

    .sbc-prev {
      left: -10px;
    }

    .sbc-next {
      right: -10px;
    }

    @media(max-width:767px) {
      .sbc-row {
        gap: 16px;
      }

      .sbc-item {
        width: 100px;
      }

      .sbc-img {
        width: 84px;
        height: 84px;
        margin-bottom: 9px;
      }

      .sbc-name {
        font-size: 12px;
      }

      .sbc-count {
        font-size: 10.5px;
      }

      .sbc-arrow {
        width: 32px;
        height: 32px;
        font-size: 11px;
        top: 36px;
      }

      .sbc-prev {
        left: -2px;
      }

      .sbc-next {
        right: -2px;
      }
    }

    .carousel-slider {
      position: relative;
      overflow: hidden;
    }

    .carousel-track {
      display: flex;
      transition: transform 0.5s ease-in-out;
    }

    .carousel-item-custom {
      flex: 0 0 33.3333%;
      box-sizing: border-box;
      padding: 15px;
    }

    /* category card */
    .product-block {
      text-align: center;
      background: #fff;
      border: 1px solid #E2E8F0;
      border-radius: 18px;
      padding: 16px 14px 20px;
      height: 100%;
      transition: all .3s ease;
    }

    .product-block:hover {
      transform: translateY(-6px);
      border-color: rgba(20, 184, 166, .5);
      box-shadow: 0 16px 34px rgba(15, 118, 110, .15);
    }

    .product-block img {
      max-width: 100%;
      height: auto;
      border-radius: 12px;
      transition: transform .3s ease;
    }

    .product-block:hover img {
      transform: scale(1.04);
    }

    .product-title {
      font-weight: 600;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #1F2937;
      margin-top: 14px;
      padding-bottom: 12px;
      position: relative;
      transition: color .3s ease;
    }

    /* teal underline accent */
    .product-title::after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 34px;
      height: 3px;
      border-radius: 3px;
      background: linear-gradient(90deg, #14B8A6, #0F766E);
      transition: width .3s ease;
    }

    .product-block:hover .product-title {
      color: #0F766E;
    }

    .product-block:hover .product-title::after {
      width: 60px;
    }

    /* ===== CATEGORY SLIDER ARROWS ===== */
    .cat-slider {
      position: relative;
      padding: 0 10px;
    }

    .cat-arrow {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 46px;
      height: 46px;
      border-radius: 50%;
      border: 1px solid #E2E8F0;
      background: #fff;
      color: #0F766E;
      font-size: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 5;
      box-shadow: 0 6px 18px rgba(15, 118, 110, .15);
      transition: all .25s ease;
    }

    .cat-arrow:hover {
      background: #0F766E;
      border-color: #0F766E;
      color: #fff;
      box-shadow: 0 10px 24px rgba(15, 118, 110, .3);
    }

    .cat-arrow-prev {
      left: -8px;
    }

    .cat-arrow-next {
      right: -8px;
    }

    @media(max-width:767px) {
      .cat-arrow {
        width: 38px;
        height: 38px;
        font-size: 13px;
      }

      .cat-arrow-prev {
        left: 0;
      }

      .cat-arrow-next {
        right: 0;
      }
    }

    @media (max-width: 768px) {
      .carousel-item-custom {
        flex: 0 0 100%;
      }

      .section-heading {
        font-size: 1.9rem;
        margin-bottom: 30px;
      }

      .featured-products {
        padding: 45px 0;
      }
    }

    .carousel-dots {
      text-align: center;
      margin-top: 20px;
      font-size: 10px;

    }

    .carousel-dot {
      display: inline-block;
      width: 12px;
      height: 12px;
      background-color: #ccc;
      margin: 0 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .carousel-dot.active {
      background-color: #0F766E;
    }




    .testimonials {
      padding: 60px 0;
      background: linear-gradient(160deg, #ECFEFF 0%, #F8FAFC 50%, #E6F7F4 100%);
    }

    .testimonials h3 {
      font-weight: 700;
      font-size: 28px;
      margin-bottom: 40px;
    }

    .testimonial-wrapper {
      position: relative;
      overflow: hidden;
    }

    .testimonial-track {
      display: flex;
      transition: transform 0.5s ease-in-out;
    }

    .testimonial-item {
      flex: 0 0 33.3333%;
      box-sizing: border-box;
      padding: 15px;
    }

    .testimonial-box {
      background: #f8f9fa;
      border-radius: 15px;
      padding: 30px 20px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .testimonial-img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 15px;
    }

    .testimonial-text {
      font-size: 14px;
      color: #555;
      margin-bottom: 10px;
    }

    .testimonial-author {
      font-weight: bold;
      color: #000;
      margin-bottom: 5px;
    }

    .testimonial-rating i {
      color: #ffc107;
      font-size: 16px;
    }

    @media (max-width: 768px) {
      .testimonial-item {
        flex: 0 0 100%;
      }
    }

    .carousel-dots {
      text-align: center;
      margin-top: 20px;
    }

    .carousel-dot {
      display: inline-block;
      width: 40px;
      height: 4px;
      background-color: #ccc;
      margin: 0 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .carousel-dot.active {
      background-color: #0F766E;
    }

    element.style {}

    .carousel-indicators [data-bs-target] {
      box-sizing: content-box;
      flex: 0 1 auto;
      width: 30px;
      height: 3px;
      padding: 0;
      margin-right: 3px;
      margin-left: 3px;
      text-indent: -999px;
      cursor: pointer;
      background-color: black;
      background-clip: padding-box;
      border: 0;
      border-top: 10px solid transparent;
      border-bottom: 10px solid transparent;
      opacity: .5;
      transition: opacity .6s ease;
      /* color: black; */
    }

    .product-block a {
      text-decoration: none;
    }





    .custom-banner-slider {
      position: relative;
      width: 100%;
      overflow: hidden;
    }

    /* =====================================
       HERO SLIDER — MINIMAL PAGINATION
       (neutral white, har banner pe clean)
    ===================================== */
    .custom-banner-slider .carousel-indicators {
      bottom: 22px;
      gap: 9px;
      margin: 0;
      align-items: center;
    }

    .custom-banner-slider .carousel-indicators [data-bs-target] {
      width: 8px;
      height: 8px;
      margin: 0;
      padding: 0;
      border: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, .55);
      opacity: 1;
      text-indent: 0;
      box-shadow: 0 1px 3px rgba(0, 0, 0, .35);
      transition: width .35s ease, background-color .35s ease;
    }

    .custom-banner-slider .carousel-indicators [data-bs-target]:hover {
      background: rgba(255, 255, 255, .85);
    }

    .custom-banner-slider .carousel-indicators .active {
      width: 26px;
      border-radius: 50px;
      background: #ffffff;
      box-shadow: 0 1px 4px rgba(0, 0, 0, .45);
    }

    @media (max-width: 767px) {
      .custom-banner-slider .carousel-indicators {
        bottom: 12px;
        gap: 7px;
      }

      .custom-banner-slider .carousel-indicators [data-bs-target] {
        width: 7px;
        height: 7px;
      }

      .custom-banner-slider .carousel-indicators .active {
        width: 22px;
      }
    }

    .custom-carousel-item {
      transition: transform 0.6s ease-in-out;
    }

    /* full-width hero image — render at its natural aspect ratio on every
       screen size instead of a fixed 1000px height (which stretched/cropped
       the mobile banner) */
    .custom-banner-image {
      display: block;
      width: 100%;
      height: auto;
      object-fit: cover;
      image-rendering: auto;
      backface-visibility: hidden;
      transform: translateZ(0);
    }

    .award-section {
      margin: 30px;
    }

    .award-card {
      position: relative;
      background: #fff;
      border-radius: 20px;
      padding: 50px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    .award-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, #F59E0B, #14B8A6, #0F766E);
    }

    .award-image {
      overflow: hidden;
      border-radius: 16px;
    }

    .award-image img {
      width: 100%;
      border-radius: 16px;
      transition: .4s ease;
    }

    .award-image:hover img {
      transform: scale(1.05);
    }

    .award-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(245, 158, 11, .12);
      border: 1px solid rgba(245, 158, 11, .4);
      color: #B45309;
      padding: 8px 18px;
      border-radius: 30px;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: .03em;
      margin-bottom: 18px;
    }

    .award-badge i {
      color: #F59E0B;
    }

    .award-content h3 {
      font-size: 30px;
      font-weight: 700;
      color: #222;
      line-height: 1.3;
      margin-bottom: 20px;
    }

    .award-content p {
      font-size: 16px;
      color: #666;
      line-height: 1.8;
      margin-bottom: 30px;
    }

    .award-btn {
      display: inline-block;
      background: #F59E0B;
      color: #fff;
      padding: 14px 30px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      transition: .3s ease;
      font-size: 13px;
    }

    .award-btn:hover {
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(42, 157, 143, .3);
      background: linear-gradient(135deg, #2a9d8f, #1d6fa5);
    }

    @media(max-width:768px) {
      .award-section {
        margin: 15px;
      }

      .award-card {
        padding: 25px;
      }

      .award-content {
        margin-top: 25px;
        text-align: center;
      }

      .award-content h3 {
        font-size: 24px;
      }

      .award-content h2 {
        font-size: 28px;
      }

      .award-content p {
        font-size: 14.5px;
        line-height: 1.7;
      }
    }

    /* =========================================
   INSIDE EVERY DOSE — dark feature section
   ========================================= */
    .dose-section {
      position: relative;
      background: linear-gradient(160deg, #0A2E2B 0%, #0D3B37 55%, #0F766E 140%);
      padding: 70px 0 60px;
      overflow: hidden;
    }

    /* big watermark text */
    .dose-watermark {
      position: absolute;
      bottom: -26px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 170px;
      font-weight: 800;
      letter-spacing: .05em;
      color: rgba(255, 255, 255, .04);
      white-space: nowrap;
      pointer-events: none;
      line-height: 1;
    }

    .dose-head {
      position: relative;
      z-index: 1;
      margin-bottom: 40px;
    }

    .dose-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(245, 158, 11, .12);
      border: 1px solid rgba(245, 158, 11, .35);
      color: #F59E0B;
      padding: 7px 20px;
      border-radius: 30px;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      margin-bottom: 14px;
    }

    .dose-badge i {
      font-size: 11px;
    }

    .dose-head h2 {
      font-size: 38px;
      font-weight: 600;
      color: #fff;
      margin-bottom: 14px;
    }

    .dose-head p {
      font-size: 14.5px;
      color: rgba(236, 254, 255, .75);
      max-width: 560px;
      margin: 0 auto;
      line-height: 1.7;
    }

    .dose-grid {
      position: relative;
      z-index: 1;
    }

    /* feature item */
    .dose-item {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      margin-bottom: 34px;
    }

    /* left column: text right-aligned, icon on right */
    .dose-left {
      text-align: right;
      justify-content: flex-end;
    }

    .dose-icon {
      flex-shrink: 0;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: rgba(245, 158, 11, .14);
      border: 1px solid rgba(245, 158, 11, .45);
      color: #F59E0B;
      font-size: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .3s ease;
    }

    .dose-item:hover .dose-icon {
      background: #F59E0B;
      color: #0A2E2B;
      transform: scale(1.08);
    }

    .dose-text h6 {
      color: #fff;
      font-size: 15.5px;
      font-weight: 700;
      margin-bottom: 6px;
    }

    .dose-text p {
      color: rgba(236, 254, 255, .65);
      font-size: 12.5px;
      line-height: 1.6;
      margin: 0;
      max-width: 240px;
    }

    .dose-left .dose-text p {
      margin-left: auto;
    }

    /* center visual — circle bg + separate hand/product layer */
    .dose-visual {
      position: relative;
      display: inline-block;
      width: 320px;
      height: 400px;
      max-width: 100%;
    }

    /* round clipped image behind */
    .dose-circle {
      position: absolute;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 300px;
      height: 300px;
      border-radius: 50%;
      overflow: hidden;
      border: 6px solid rgba(20, 184, 166, .25);
      box-shadow: 0 0 60px rgba(20, 184, 166, .35);
    }

    .dose-circle img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }


    element.style {}

    .dose-product {
      position: absolute;
      bottom: -66px;
      left: 50%;
      transform: translateX(-50%);
      width: 427px;
      max-width: none;
      z-index: 2;
      filter: drop-shadow(0 25px 45px rgba(0, 0, 0, .5));
    }

    /* ===== TABLET ===== */
    @media(max-width:991px) {
      .dose-head h2 {
        font-size: 30px;
      }

      .dose-watermark {
        font-size: 110px;
      }

      /* stack: image top, features below in normal left-align */
      .dose-left {
        text-align: left;
        justify-content: flex-start;
        flex-direction: row-reverse;
      }

      .dose-left .dose-text p {
        margin-left: 0;
      }

      .dose-visual {
        width: 260px;
        height: 330px;
        margin-bottom: 30px;
      }

      .dose-circle {
        width: 240px;
        height: 240px;
      }

      .dose-product {
        width: 200px;
      }

      .dose-item {
        margin-bottom: 24px;
      }

      .dose-text p {
        max-width: 100%;
      }
    }

    /* ===== MOBILE ===== */
    @media(max-width:767px) {
      .dose-section {
        padding: 50px 0 40px;
      }

      .dose-head h2 {
        font-size: 1.7rem;
      }

      .dose-head p {
        font-size: 13px;
        padding: 0 10px;
      }

      .dose-watermark {
        font-size: 64px;
        bottom: -8px;
      }

      .dose-visual {
        width: 220px;
        height: 280px;
      }

      .dose-circle {
        width: 200px;
        height: 200px;
      }

      .dose-product {
        width: 240px;
        margin-bottom: 45px;
      }

      .dose-icon {
        width: 38px;
        height: 38px;
        font-size: 14px;
      }

      .dose-text h6 {
        font-size: 14px;
      }

      .dose-text p {
        font-size: 12px;
      }
    }


    /* =========================================
   HOME CATEGORY ROWS — product carousels
   ========================================= */
    .home-cats {
      background: #F8FAFC;
      padding: 60px 0 30px;
    }

    .hc-block {
      margin-bottom: 48px;
    }

    .hc-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 22px;
    }

    .hc-title {
      font-size: 26px;
      font-weight: 600;
      color: #1F2937;
      margin: 0;
      position: relative;
      padding-left: 14px;
    }

    .hc-title::before {
      content: "";
      position: absolute;
      left: 0;
      top: 4px;
      bottom: 4px;
      width: 4px;
      border-radius: 4px;
      background: linear-gradient(180deg, #14B8A6, #0F766E);
    }

    .hc-viewall {
      font-size: 13.5px;
      font-weight: 600;
      color: #0F766E !important;
      text-decoration: none !important;
      border: 1px solid rgba(20, 184, 166, .45);
      padding: 8px 18px;
      border-radius: 30px;
      transition: all .25s ease;
      white-space: nowrap;
    }

    .hc-viewall i {
      font-size: 11px;
      margin-left: 5px;
    }

    .hc-viewall:hover {
      background: #0F766E;
      color: #fff !important;
      border-color: #0F766E;
    }

    /* slider wrapper with arrows */
    .hc-slider {
      position: relative;
    }

    .hc-row {
      display: flex;
      gap: 18px;
      overflow-x: auto;
      scroll-snap-type: x mandatory;
      scroll-behavior: smooth;
      padding: 6px 2px 10px;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
    }

    .hc-row::-webkit-scrollbar {
      display: none;
    }

    .hc-arrow {
      position: absolute;
      top: 42%;
      transform: translateY(-50%);
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 1px solid #E2E8F0;
      background: #fff;
      color: #0F766E;
      font-size: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 5;
      box-shadow: 0 6px 18px rgba(15, 118, 110, .18);
      transition: all .25s ease;
    }

    .hc-arrow:hover {
      background: #0F766E;
      border-color: #0F766E;
      color: #fff;
    }

    .hc-prev {
      left: -14px;
    }

    .hc-next {
      right: -14px;
    }

    /* product card */
    .hc-card {
      flex: 0 0 calc(25% - 14px);
      min-width: 240px;
      scroll-snap-align: start;
      background: #fff;
      border: 1px solid #E2E8F0;
      border-radius: 18px;
      position: relative;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      transition: all .3s ease;
    }

    .hc-card:hover {
      transform: translateY(-5px);
      border-color: rgba(20, 184, 166, .5);
      box-shadow: 0 16px 34px rgba(15, 118, 110, .15);
    }

    /* discount badge */
    .hc-off {
      position: absolute;
      top: 12px;
      left: 12px;
      background: #F59E0B;
      color: #1F2937;
      font-size: 11.5px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 20px;
      z-index: 3;
    }

    /* wishlist heart */
    .hc-wish {
      position: absolute;
      top: 12px;
      right: 12px;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #fff;
      border: 1px solid #E2E8F0;
      color: #6B7280;
      font-size: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 3;
      text-decoration: none !important;
      box-shadow: 0 4px 10px rgba(15, 118, 110, .1);
      transition: all .25s ease;
    }

    .hc-wish:hover {
      background: #0F766E;
      border-color: #0F766E;
      color: #fff;
      transform: scale(1.1);
    }

    /* clickable main area */
    .hc-main {
      display: block;
      padding: 14px 14px 0;
      text-decoration: none !important;
      color: inherit;
      flex: 1;
    }

    .hc-img {
      height: 185px;
      background: #F8FAFC;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px;
      margin-bottom: 12px;
      overflow: hidden;
    }

    .hc-img img {
      max-height: 100%;
      max-width: 100%;
      object-fit: contain;
      transition: transform .3s ease;
    }

    .hc-card:hover .hc-img img {
      transform: scale(1.06);
    }

    .hc-name {
      font-size: 13.5px;
      font-weight: 600;
      color: #1F2937;
      line-height: 1.45;
      margin: 0 0 8px;
      min-height: 39px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .hc-price {
      margin-bottom: 12px;
    }

    .hc-price .new {
      font-size: 17px;
      font-weight: 700;
      color: #0F766E;
      margin-right: 8px;
    }

    .hc-price .old {
      font-size: 13px;
      color: #6B7280;
      text-decoration: line-through;
    }

    /* add to cart button */
    .hc-actions {
      padding: 0 14px 16px;
    }

    .hc-cart {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      background: #F59E0B;
      color: #fff !important;
      font-size: 13.5px;
      font-weight: 600;
      padding: 11px 0;
      border-radius: 30px;
      text-decoration: none !important;
      transition: all .25s ease;
    }

    .hc-cart i {
      font-size: 13px;
    }

    .hc-cart:hover {
      background: #0F766E;
      box-shadow: 0 8px 20px rgba(15, 118, 110, .3);
    }

    /* TABLET */
    @media(max-width:991px) {
      .hc-card {
        flex: 0 0 calc(33.333% - 12px);
        min-width: 225px;
      }
    }

    /* MOBILE */
    @media(max-width:767px) {
      .home-cats {
        padding: 40px 0 15px;
      }

      .hc-title {
        font-size: 20px;
      }

      .hc-viewall {
        font-size: 12px;
        padding: 6px 14px;
      }

      .hc-card {
        flex: 0 0 74%;
        min-width: 0;
      }

      .hc-img {
        height: 160px;
      }

      .hc-block {
        margin-bottom: 35px;
      }

      .hc-arrow {
        width: 36px;
        height: 36px;
        font-size: 12px;
      }

      .hc-prev {
        left: -4px;
      }

      .hc-next {
        right: -4px;
      }
    }

    /* ===== TOAST + WISHLIST ACTIVE ===== */
    .mb-toast {
      position: fixed;
      bottom: 24px;
      left: 50%;
      transform: translateX(-50%) translateY(20px);
      background: #0F766E;
      color: #fff;
      padding: 12px 24px;
      border-radius: 30px;
      font-size: 14px;
      font-weight: 600;
      z-index: 999999;
      opacity: 0;
      transition: all .3s ease;
      box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
      white-space: nowrap;
      max-width: 92vw;
    }

    .mb-toast i {
      margin-right: 6px;
    }

    .mb-toast.show {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }

    .mb-toast.err {
      background: #B91C1C;
    }

    .hc-wish.active {
      background: #0F766E;
      border-color: #0F766E;
      color: #fff;
    }

    .hc-cart.loading,
    .hc-wish.loading {
      opacity: .6;
      pointer-events: none;
    }

    /* =========================================
   BRAND TRUST STRIP — certifications
   (classic, no hover/scroll animation)
   ========================================= */
    .brand-trust-section {
      padding: 55px 0;
      background: #fff;
      border-top: 1px solid #E9EDF1;
      text-align: center;
    }

    .brand-trust-eyebrow {
      display: inline-block;
      background: #fff;
      color: #0F766E;
      border: 1px solid rgba(20, 184, 166, .4);
      padding: 7px 18px;
      border-radius: 30px;
      font-size: 12.5px;
      font-weight: 600;
      letter-spacing: .04em;
      margin-bottom: 20px;
    }

    .brand-trust-eyebrow span {
      font-family: 'Oswald', sans-serif;
      text-transform: uppercase;
      letter-spacing: .12em;
      font-size: 11.5px;
      font-weight: 700;
      color: #0F766E;
    }

    .brand-trust-title {
      font-size: 26px;
      font-weight: 600;
      color: #1F2937;
      margin-bottom: 34px;
    }

    .brand-trust-row {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
    }

    .brand-trust-item {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0 44px;
      border-right: 1px solid #E2E8F0;
    }

    .brand-trust-item:last-child {
      border-right: none;
    }

    .brand-trust-item img {
      max-height: 72px;
      width: auto;
    }

    @media(max-width:767px) {
      .brand-trust-section {
        padding: 40px 0;
      }

      .brand-trust-title {
        font-size: 19px;
        margin-bottom: 24px;
        padding: 0 15px;
      }

      .brand-trust-row {
        justify-content: space-around;
      }

      .brand-trust-item {
        flex: 0 0 50%;
        padding: 14px 10px;
        border-right: none;
        border-bottom: 1px solid #E2E8F0;
      }

      .brand-trust-item:nth-child(odd) {
        border-right: 1px solid #E2E8F0;
      }

      .brand-trust-item img {
        max-height: 52px;
      }
    }

    /* =========================================
   WHY CHOOSE MEIBOTAN — image banner CTA
   ========================================= */
    .why-cta {
      position: relative;
      padding: 90px 0;
      background-image: linear-gradient(90deg, rgba(10, 46, 43, .92) 0%, rgba(10, 46, 43, .88) 38%, rgba(10, 46, 43, .5) 52%, rgba(10, 46, 43, 0) 66%, rgba(10, 46, 43, 0) 100%),
        url('<?php echo base_url(); ?>/assets/frontend/images/Call-to-action-banner-Meibotan.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      overflow: hidden;
    }

    .why-cta-inner {
      max-width: 640px;
    }

    .why-cta-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(245, 158, 11, .16);
      border: 1px solid rgba(245, 158, 11, .5);
      color: #FBBF24;
      padding: 7px 18px;
      border-radius: 30px;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      margin-bottom: 18px;
    }

    .why-cta h2 {
      font-size: 40px;
      font-weight: 700;
      color: #fff;
      line-height: 1.2;
      margin-bottom: 10px;
    }

    .why-cta h2 span {
      display: block;
      font-size: 26px;
      font-weight: 600;
      color: #ECFEFF;
      margin-top: 4px;
    }

    .why-cta-pills {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin: 26px 0 22px;
    }

    .why-cta-pills span {
      display: inline-block;
      background: rgba(255, 255, 255, .1);
      border: 1px solid rgba(255, 255, 255, .35);
      color: #fff;
      padding: 9px 20px;
      border-radius: 30px;
      font-size: 13.5px;
      font-weight: 600;
      backdrop-filter: blur(2px);
    }

    .why-cta-note {
      font-size: 11.5px;
      color: rgba(236, 254, 255, .65);
      line-height: 1.6;
      max-width: 480px;
      margin-bottom: 28px;
    }

    .why-cta-btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: #F59E0B;
      color: #fff !important;
      padding: 14px 32px;
      border-radius: 30px;
      font-weight: 700;
      font-size: 14px;
      text-decoration: none !important;
      transition: all .3s ease;
    }

    .why-cta-btn:hover {
      background: #fff;
      color: #0F766E !important;
      transform: translateY(-2px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, .3);
    }

    @media(max-width:767px) {
      .why-cta {
        padding: 50px 0;
        text-align: center;
        background-image: linear-gradient(180deg, rgba(10, 46, 43, .92) 0%, rgba(10, 46, 43, .88) 100%),
          url('<?php echo base_url(); ?>/assets/frontend/images/Call-to-action-banner-Meibotan.png');
      }

      .why-cta-inner {
        max-width: 100%;
      }

      .why-cta h2 {
        font-size: 28px;
      }

      .why-cta h2 span {
        font-size: 19px;
      }

      .why-cta-pills {
        justify-content: center;
        margin: 20px 0 18px;
      }

      .why-cta-pills span {
        font-size: 12px;
        padding: 8px 16px;
      }

      .why-cta-note {
        margin-left: auto;
        margin-right: auto;
      }
    }

    /* =========================================
   TESTIMONIALS — redesigned
   ========================================= */
    .testimonials {
      padding: 75px 0;
      background: linear-gradient(160deg, #ECFEFF 0%, #F8FAFC 50%, #E6F7F4 100%);
      text-align: center;
    }

    .tm-badge {
      display: inline-block;
      background: #fff;
      color: #0F766E;
      border: 1px solid rgba(20, 184, 166, .4);
      padding: 7px 18px;
      border-radius: 30px;
      font-size: 12.5px;
      font-weight: 600;
      letter-spacing: .04em;
      margin-bottom: 16px;
    }

    .testimonials .section-heading {
      margin-bottom: 46px;
    }

    .testimonial-Slider {
      overflow: hidden;
    }

    .testimonial-box {
      position: relative;
      background: #fff;
      border: 1px solid #E2E8F0;
      border-radius: 18px;
      padding: 34px 26px 28px;
      box-shadow: 0 10px 26px rgba(15, 118, 110, .08);
      height: 100%;
      transition: all .3s ease;
    }

    .testimonial-box:hover {
      transform: translateY(-6px);
      border-color: rgba(20, 184, 166, .5);
      box-shadow: 0 18px 38px rgba(15, 118, 110, .16);
    }

    .testimonial-quote {
      position: absolute;
      top: 18px;
      right: 22px;
      font-size: 34px;
      color: rgba(20, 184, 166, .18);
      line-height: 1;
    }

    .testimonial-rating {
      color: #F59E0B;
      font-size: 13px;
      margin-bottom: 14px;
    }

    .testimonial-text {
      font-size: 14px;
      color: #4B5563;
      line-height: 1.75;
      margin-bottom: 22px;
      min-height: 96px;
    }

    .testimonial-person {
      display: flex;
      align-items: center;
      gap: 12px;
      padding-top: 18px;
      border-top: 1px solid #EEF2F6;
      width: 100%;
    }

    .testimonial-img {
      width: 46px;
      height: 46px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fff;
      box-shadow: 0 0 0 2px rgba(20, 184, 166, .4);
    }

    .testimonial-meta {
      text-align: left;
    }

    .testimonial-author {
      font-weight: 700;
      color: #1F2937;
      font-size: 14px;
      line-height: 1.3;
    }

    .testimonial-role {
      font-size: 11.5px;
      color: #9CA3AF;
    }

    @media (max-width: 768px) {
      .testimonials {
        padding: 50px 0;
      }

      .testimonials .section-heading {
        margin-bottom: 28px;
      }

      .testimonial-item {
        flex: 0 0 100%;
      }

      .testimonial-box {
        padding: 28px 22px 22px;
      }

      .testimonial-text {
        min-height: 0;
      }
    }

    .carousel-dots {
      text-align: center;
      margin-top: 26px;
    }

    .carousel-dot {
      display: inline-block;
      width: 26px;
      height: 4px;
      border-radius: 3px;
      background-color: #D1D5DB;
      margin: 0 4px;
      cursor: pointer;
      transition: background-color 0.3s, width .3s;
    }

    .carousel-dot.active {
      background-color: #0F766E;
      width: 36px;
    }
  </style>


</head>

<body>
  <!--<div class="page-wrapper">-->
  <?= $this->include('frontend/partials/header') ?>

  <!-- HERO BANNER SLIDER -->
  <div id="customBannerSlider" class="carousel slide carousel-fade custom-banner-slider" data-bs-ride="carousel"
    data-bs-interval="3000">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#customBannerSlider" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#customBannerSlider" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#customBannerSlider" data-bs-slide-to="2"></button>
      <!--<button type="button" data-bs-target="#customBannerSlider" data-bs-slide-to="3"></button>-->
      <button type="button" data-bs-target="#customBannerSlider" data-bs-slide-to="3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active custom-carousel-item">
        <img src="<?php echo base_url(); ?>/assets/frontend/images/hero-banner1.jpeg"
          class="d-none d-md-block w-100 custom-banner-image" alt="Slide 1">
        <img src="<?php echo base_url(); ?>/assets/frontend/images/hero-banner1-mobile.jpeg"
          class="d-block d-md-none w-100 custom-banner-image" alt="Slide 1 Mobile">
      </div>

      <div class="carousel-item custom-carousel-item">
        <img src="<?php echo base_url(); ?>/assets/frontend/images/hero-banner2.jpeg"
          class="d-none d-md-block w-100 custom-banner-image" alt="Slide 2">
        <img src="<?php echo base_url(); ?>/assets/frontend/images/hero-banner2-mobile.jpeg"
          class="d-block d-md-none w-100 custom-banner-image" alt="Slide 2 Mobile">
      </div>
      <!--<div class="carousel-item custom-carousel-item">-->
      <!--    <img src="<?php echo base_url(); ?>/assets/frontend/images/9mb-L-Salivarius-web-banner.jpg" class="d-none d-md-block w-100 custom-banner-image" alt="Slide 3">-->
      <!--    <img src="<?php echo base_url(); ?>/assets/frontend/images/9mb-L-Salivarius-web-banner-mobile.jpg" class="d-block d-md-none w-100 custom-banner-image" alt="Slide 3 Mobile">-->
      <!--</div>-->
      <div class="carousel-item custom-carousel-item">
        <img src="<?php echo base_url(); ?>/assets/frontend/images/hero-banner3.jpeg"
          class="d-none d-md-block w-100 custom-banner-image" alt="Slide 3">
        <img src="<?php echo base_url(); ?>/assets/frontend/images/hero-banner3-mobile.jpeg"
          class="d-block d-md-none w-100 custom-banner-image" alt="Slide 3 Mobile">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#customBannerSlider" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#customBannerSlider" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
  </div>

  <!-- INTRO WRAP : range cards + welcome hero (shared gradient bg) -->
  <section class="intro-wrap">

    <!-- PRODUCT RANGE — FLOATING ICON CARDS -->
    <div class="range-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-6 col-lg-3 mb-4 mb-lg-0">
            <div class="range-card">
              <div class="range-icon"><i class="fas fa-heartbeat"></i></div>
              <h5>Overall Wellness</h5>
              <p>Nutraceuticals thoughtfully crafted to support your everyday health, energy and a balanced lifestyle.
              </p>
            </div>
          </div>
          <div class="col-6 col-lg-3 mb-4 mb-lg-0">
            <div class="range-card">
              <div class="range-icon"><i class="fas fa-capsules"></i></div>
              <h5>Digestive Health</h5>
              <p>Advanced probiotic and enzyme blends that keep your gut happy and improve nutrient absorption.</p>
            </div>
          </div>
          <div class="col-6 col-lg-3 mb-4 mb-lg-0">
            <div class="range-card">
              <div class="range-icon"><i class="fas fa-dumbbell"></i></div>
              <h5>Muscle &amp; Fitness</h5>
              <p>High-quality whey protein and amino acids for strength, stamina and faster post-workout recovery.</p>
            </div>
          </div>
          <div class="col-6 col-lg-3 mb-4 mb-lg-0">
            <div class="range-card">
              <div class="range-icon"><i class="fas fa-leaf"></i></div>
              <h5>Immunity &amp; Energy</h5>
              <p>Herbal vitamins and supplements that strengthen natural defenses and keep you active all day.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- WELCOME HERO — Meibotan -->
    <div class="welcome-hero">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 welcome-text">
            <span class="welcome-badge">A Fido Pharma Venture</span>
            <h1>Welcome to Meibotan,<br><span>Science Meets Tradition.</span></h1>
            <p>At Meibotan, we believe true wellness comes from balance — a perfect synergy between age-old traditions
              and
              modern science. From nutraceuticals, enzymes and probiotics to whey proteins, cosmetics and dietary
              supplements, every formulation is designed with purity, innovation and integrity.</p>
            <a href="https://www.meibotan.com/about-us" class="welcome-btn">Explore Products <i
                class="fas fa-arrow-right"></i></a>
            <div class="welcome-trust">
              <div class="trust-item"><i class="fas fa-microscope"></i><span>Clinically<br>Researched</span></div>
              <div class="trust-item"><i class="fas fa-flask"></i><span>Science<br>Backed</span></div>
              <div class="trust-item"><i class="fas fa-award"></i><span>Quality<br>Assured</span></div>
            </div>
          </div>
          <div class="col-lg-6 text-center mt-5 mt-lg-0">
            <div class="welcome-visual">
              <span class="ring"></span>
              <img src="<?php echo base_url(); ?>/assets/frontend/images/home-about.png" alt="Meibotan Probiotics"
                class="welcome-product">
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>

  <!-- SHOP BY CATEGORY : circle style with product counts -->
  <?php
  // categories (same source as mega menu) + per-category product count
  $sbc_cats = $commfrontfunc->geAllParentCategory();
  usort($sbc_cats, function ($a, $b) {
    return strcasecmp($a->category_name, $b->category_name);
  });

  $sbc_db = \Config\Database::connect();
  $sbc_rows = $sbc_db->table('tb_products')
    ->select('product_category')
    ->where('product_status', 1)
    ->get()->getResult();

  $sbc_counts = [];
  foreach ($sbc_rows as $sbc_r) {
    $sbc_ids = array_filter(array_map('trim', explode(',', (string) $sbc_r->product_category)));
    foreach ($sbc_ids as $sbc_cid) {
      $sbc_cid = (int) $sbc_cid;
      if ($sbc_cid > 0) {
        $sbc_counts[$sbc_cid] = ($sbc_counts[$sbc_cid] ?? 0) + 1;
      }
    }
  }
  ?>
  <section class="featured-products text-center">
    <div class="container">
      <span class="sbc-badge">Our Categories</span>
      <h3 class="section-heading">Shop By <span>Category</span></h3>
      <div class="sbc-slider">
        <button type="button" class="sbc-arrow sbc-prev" data-dir="-1" aria-label="Previous">
          <i class="fas fa-chevron-left"></i>
        </button>
        <div class="sbc-row" id="sbcRow">
          <?php foreach ($sbc_cats as $sbc_cat) {
            if ($sbc_cat->category_slug == '') {
              continue;
            }
            $sbc_pcount = $sbc_counts[$sbc_cat->category_id] ?? 0;
            if ($sbc_pcount <= 0) {
              continue;
            }
            $sbc_img = (!empty($sbc_cat->category_thumbnail)) ? CUSTOM_UPLOAD_PATH . $sbc_cat->category_thumbnail : DEFAULT_PRODUCTIMG;
            ?>
            <a href="<?php echo site_url('product-category/' . $sbc_cat->category_slug); ?>" class="sbc-item">
              <span class="sbc-img">
                <img src="<?php echo $sbc_img; ?>" alt="<?php echo $sbc_cat->category_name; ?>" loading="lazy">
              </span>
              <span class="sbc-name"><?php echo $sbc_cat->category_name; ?></span>
              <span class="sbc-count"><?php echo $sbc_pcount; ?> Products</span>
            </a>
          <?php } ?>
        </div>
        <button type="button" class="sbc-arrow sbc-next" data-dir="1" aria-label="Next">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>
  </section>

  <script>
    // Shop By Category — arrows scroll the circle row
    (function () {
      var row = document.getElementById('sbcRow');
      if (!row) return;
      document.querySelectorAll('.sbc-arrow').forEach(function (btn) {
        btn.addEventListener('click', function () {
          var item = row.querySelector('.sbc-item');
          if (!item) return;
          var step = (item.offsetWidth + 30) * 3;
          row.scrollBy({ left: step * parseInt(btn.dataset.dir, 10), behavior: 'smooth' });
        });
      });
    })();
  </script>

  <!-- ============================================
       HOME CATEGORY ROWS : product carousels (DB)
       ============================================ -->
  <?php
  // only these categories are highlighted as home rows (in this order)
  $homeCatSlugs = ['gummies', 'kids', 'skin-products', 'sachet', 'supplements'];

  $hc_db = \Config\Database::connect();
  $homeCatData = [];
  foreach ($homeCatSlugs as $hc_slug) {
    $hc_cat = $hc_db->table('tb_category')
      ->where('category_slug', $hc_slug)
      ->where('category_status', 1)
      ->get()->getRow();
    if (!$hc_cat) {
      continue;
    }

    $hc_prods = $hc_db->table('tb_products')
      ->where('product_status', 1)
      ->where("FIND_IN_SET(" . (int) $hc_cat->category_id . ", product_category) >", 0)
      ->orderBy('product_id', 'DESC')
      ->limit(20)
      ->get()->getResult();

    if (count($hc_prods) > 0) {
      $homeCatData[] = ['cat' => $hc_cat, 'products' => $hc_prods];
    }
  }
  ?>
  <?php if (count($homeCatData) > 0) { ?>
    <section class="home-cats">
      <div class="container">
        <?php foreach ($homeCatData as $hcRow) {
          $hcCat = $hcRow['cat']; ?>
          <div class="hc-block">
            <div class="hc-head">
              <h4 class="hc-title"><?php echo $hcCat->category_name; ?></h4>
              <a href="<?php echo site_url('product-category/' . $hcCat->category_slug); ?>" class="hc-viewall">
                View All <i class="fas fa-arrow-right"></i>
              </a>
            </div>
            <div class="hc-slider">
              <button type="button" class="hc-arrow hc-prev" data-dir="-1" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
              </button>
              <div class="hc-row">
                <?php foreach ($hcRow['products'] as $hcP) {
                  $hc_img = (!empty($hcP->product_thumb)) ? CUSTOM_UPLOAD_PATH . $hcP->product_thumb : DEFAULT_PRODUCTIMG;
                  $hc_url = site_url('product/' . ($hcP->product_slug ? $hcP->product_slug : $hcP->product_id));
                  $hc_mrp = (float) $hcP->product_price;
                  $hc_sale = (float) $hcP->product_saleprice;
                  $hc_hasoff = ($hc_sale > 0 && $hc_sale < $hc_mrp);
                  $hc_off = $hc_hasoff ? round((($hc_mrp - $hc_sale) / $hc_mrp) * 100) : 0;
                  ?>
                  <div class="hc-card">
                    <?php if ($hc_hasoff) { ?>
                      <span class="hc-off"><?php echo $hc_off; ?>% OFF</span>
                    <?php } ?>
                    <a href="javascript:;" class="hc-wish" data-pid="<?php echo $hcP->product_id; ?>" title="Add to Wishlist">
                      <i class="far fa-heart"></i>
                    </a>
                    <a href="<?php echo $hc_url; ?>" class="hc-main">
                      <div class="hc-img">
                        <img src="<?php echo $hc_img; ?>" alt="<?php echo $hcP->product_name; ?>" loading="lazy">
                      </div>
                      <h6 class="hc-name"><?php echo $hcP->product_name; ?></h6>
                      <div class="hc-price">
                        <?php if ($hc_hasoff) { ?>
                          <span class="new">₹<?php echo $hc_sale; ?></span>
                          <span class="old">₹<?php echo $hc_mrp; ?></span>
                        <?php } else { ?>
                          <span class="new">₹<?php echo $hc_mrp; ?></span>
                        <?php } ?>
                      </div>
                    </a>
                    <div class="hc-actions">
                      <a href="javascript:;" class="hc-cart" data-pid="<?php echo $hcP->product_id; ?>">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                      </a>
                    </div>
                  </div>
                <?php } ?>
              </div>
              <button type="button" class="hc-arrow hc-next" data-dir="1" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
              </button>
            </div>
          </div>
        <?php } ?>
      </div>
    </section>

    <script>
      // Category product carousels — arrows scroll the row card-by-card
      document.querySelectorAll('.hc-slider').forEach(function (slider) {
        var row = slider.querySelector('.hc-row');
        if (!row) return;
        slider.querySelectorAll('.hc-arrow').forEach(function (btn) {
          btn.addEventListener('click', function () {
            var card = row.querySelector('.hc-card');
            if (!card) return;
            var step = card.offsetWidth + 18;
            row.scrollBy({ left: step * parseInt(btn.dataset.dir, 10), behavior: 'smooth' });
          });
        });
      });

      // ===== AJAX ADD TO CART / WISHLIST + TOAST =====
      var MB_AJAX = "<?= rtrim(site_url('ajaxcart'), '/'); ?>";

      function mbToast(msg, ok) {
        var t = document.createElement('div');
        t.className = 'mb-toast' + (ok ? '' : ' err');
        t.innerHTML = (ok ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-exclamation-circle"></i> ') + msg;
        document.body.appendChild(t);
        requestAnimationFrame(function () { t.classList.add('show'); });
        setTimeout(function () {
          t.classList.remove('show');
          setTimeout(function () { t.remove(); }, 300);
        }, 2500);
      }

      document.addEventListener('click', function (e) {
        var cartBtn = e.target.closest('.hc-cart');
        if (cartBtn && cartBtn.dataset.pid) {
          e.preventDefault();
          mbAddToCart(cartBtn);
          return;
        }
        var wishBtn = e.target.closest('.hc-wish');
        if (wishBtn && wishBtn.dataset.pid) {
          e.preventDefault();
          mbAddToWish(wishBtn);
        }
      });

      function mbAddToCart(btn) {
        if (btn.classList.contains('loading')) return;
        btn.classList.add('loading');
        fetch(MB_AJAX + '/add/' + btn.dataset.pid, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
          .then(function (r) { return r.json(); })
          .then(function (d) {
            btn.classList.remove('loading');
            if (d.ok) {
              // update header count
              document.querySelectorAll('.cart-count').forEach(function (el) { el.textContent = d.cartcount; });
              // update mini-cart dropdown contents if backend returned HTML
              try {
                if (typeof d.mini !== 'undefined') {
                  var box = document.querySelector('.dropdown-cart-products');
                  var wrapper = document.querySelector('.dropdownmenu-wrapper');
                  if (box) {
                    box.innerHTML = d.mini || '';
                  } else if (wrapper) {
                    // insert products + subtotal block
                    var html = '';
                    html += '<div class="dropdown-cart-products">' + (d.mini || '') + '</div>';
                    html += '<div class="dropdown-cart-total"><span>SUBTOTAL:</span><span class="cart-total-price float-right">₹' + (d.subtotal || 0) + '</span></div>';
                    // try to insert before existing action block
                    var action = wrapper.querySelector('.dropdown-cart-action');
                    if (action) { action.insertAdjacentHTML('beforebegin', html); } else { wrapper.insertAdjacentHTML('beforeend', html); }
                  } else {
                    var subtotal = document.querySelector('.cart-total-price');
                    if (subtotal) { subtotal.textContent = '₹' + (d.subtotal || 0); }
                  }
                  var subtotal = document.querySelector('.cart-total-price');
                  if (subtotal) { subtotal.textContent = '₹' + (d.subtotal || 0); }
                }
              } catch (e) { }

              mbToast(d.message, true);
            } else {
              mbToast(d.message || 'Something went wrong', false);
            }
          })
          .catch(function () { btn.classList.remove('loading'); mbToast('Network error, try again', false); });
      }

      function mbAddToWish(btn) {
        if (btn.classList.contains('loading')) return;
        btn.classList.add('loading');
        fetch(MB_AJAX + '/wish/' + btn.dataset.pid, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
          .then(function (r) { return r.json(); })
          .then(function (d) {
            btn.classList.remove('loading');
            if (d.ok) {
              var badge = document.getElementById('wishCountBadge');
              if (badge) { badge.textContent = d.wishcount; badge.style.display = 'inline-block'; }
              var ic = btn.querySelector('i');
              if (ic) { ic.classList.remove('far'); ic.classList.add('fas'); }
              btn.classList.add('active');
              mbToast(d.message, true);
              try { localStorage.removeItem('guest_wish_count'); } catch (e) { }
            } else if (d.login) {
              try {
                var guest = parseInt(localStorage.getItem('guest_wish_count') || 0, 10) || 0;
                guest = guest + 1;
                localStorage.setItem('guest_wish_count', guest);
                var badge = document.getElementById('wishCountBadge');
                if (badge) {
                  var current = parseInt(badge.textContent || 0, 10) || 0;
                  badge.textContent = current + 1;
                  badge.style.display = 'inline-block';
                }
              } catch (e) { }
              mbToast(d.message, false);
            } else {
              mbToast(d.message || 'Something went wrong', false);
            }
          })
          .catch(function () { btn.classList.remove('loading'); mbToast('Network error, try again', false); });
      }
    </script>
  <?php } ?>

  <!-- INSIDE EVERY DOSE — dark feature section -->
  <section class="dose-section">
    <span class="dose-watermark">MEIBOTAN</span>
    <div class="container">

      <div class="dose-head text-center">
        <span class="dose-badge"><i class="fas fa-seedling"></i><span>Science-Backed Formulas</span></span>
        <h2>Wellness Inside Every Dose</h2>
        <p>Every Meibotan formulation blends clinically studied probiotics, herbal extracts and essential nutrients to
          support gut health, immunity and everyday vitality.</p>
      </div>

      <div class="row align-items-center dose-grid">

        <!-- LEFT FEATURES -->
        <div class="col-lg-4 order-2 order-lg-1">
          <div class="dose-item dose-left">
            <div class="dose-text">
              <h6>Clinically Studied Strains</h6>
              <p>CSIR-IMTECH researched probiotic strains for proven digestive support</p>
            </div>
            <span class="dose-icon"><i class="fas fa-microscope"></i></span>
          </div>
          <div class="dose-item dose-left">
            <div class="dose-text">
              <h6>High CFU Potency</h6>
              <p>Billions of live cultures per dose to restore healthy gut balance</p>
            </div>
            <span class="dose-icon"><i class="fas fa-dna"></i></span>
          </div>
          <div class="dose-item dose-left">
            <div class="dose-text">
              <h6>Lactoferrin &amp; DHA</h6>
              <p>Advanced nutrients supporting immunity, brain and overall growth</p>
            </div>
            <span class="dose-icon"><i class="fas fa-shield-alt"></i></span>
          </div>
        </div>

        <!-- CENTER IMAGE : circle clip + separate hand/product -->
        <div class="col-lg-4 order-1 order-lg-2 text-center">
          <div class="dose-visual">
            <span class="dose-circle">
              <img src="<?php echo base_url(); ?>/assets/frontend/images/home-cta-bg.webp" alt="">
            </span>
            <img src="<?php echo base_url(); ?>/assets/frontend/images/home-ctafront.png" alt="Meibotan Product"
              class="dose-product">
          </div>
        </div>

        <!-- RIGHT FEATURES -->
        <div class="col-lg-4 order-3">
          <div class="dose-item">
            <span class="dose-icon"><i class="fas fa-leaf"></i></span>
            <div class="dose-text">
              <h6>Herbal Extracts</h6>
              <p>Traditional Indian botanicals standardized for purity and potency</p>
            </div>
          </div>
          <div class="dose-item">
            <span class="dose-icon"><i class="fas fa-flask"></i></span>
            <div class="dose-text">
              <h6>Digestive Enzymes</h6>
              <p>Enzyme blends that improve nutrient absorption and digestion</p>
            </div>
          </div>
          <div class="dose-item">
            <span class="dose-icon"><i class="fas fa-award"></i></span>
            <div class="dose-text">
              <h6>GMP Certified Quality</h6>
              <p>Manufactured under ISO, GMP, HACCP and FSSAI certified standards</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- BRAND TRUST STRIP — certifications (classic, static, no animation) -->
  <section class="brand-trust-section">
    <div class="container">
      <div class="brand-trust-eyebrow"><span>Certified Excellence</span></div>
      <h2 class="brand-trust-title">Recognized and Certified by Leading Authorities</h2>
      <div class="brand-trust-row">
        <div class="brand-trust-item">
          <img src="<?php echo base_url(); ?>/assets/frontend/images/ISO.jpg" alt="ISO 9001:2015 Certified">
        </div>
        <div class="brand-trust-item">
          <img src="<?php echo base_url(); ?>/assets/frontend/images/GMP.jpg" alt="GMP Quality Certified">
        </div>
        <div class="brand-trust-item">
          <img src="<?php echo base_url(); ?>/assets/frontend/images/HACCP.jpg" alt="HACCP Certified">
        </div>
        <div class="brand-trust-item">
          <img src="<?php echo base_url(); ?>/assets/frontend/images/Fssai.jpg" alt="FSSAI Certified">
        </div>
      </div>
    </div>
  </section>

  <section class="wellness-section py-5">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-4 text-center mb-4 mb-md-0">
          <img src="<?php echo base_url(); ?>/assets/frontend/images/24x7-meibotan.jpg.jpeg" alt="Hair Care"
            class="wellness-img">
        </div>
        <div class="col-md-4 text-center">
          <div class="wellness-line mb-3"></div>
          <h1 class="wellness-heading mb-3 fs-10">Probiotics support gut health and boost immunity.</h1>
          <div class="wellness-line mb-3"></div>
          <a href="https://www.meibotan.com/shop" class="btn wellness-btn">Get Started →</a>
        </div>
        <div class="col-md-4 text-center mt-4 mt-md-0 ml-10">
          <img src="<?php echo base_url(); ?>/assets/frontend/images/Gummies.jpg.jpeg" alt="Skin Wellness"
            class="wellness-img">
        </div>
      </div>
    </div>
  </section>

  <section class="consumer-studies">
    <div class="container">
      <span class="cs-badge">Real Results</span>
      <h2 class="section-heading">Consumer <span>Studies</span></h2>
      <div class="row justify-content-center">
        <!-- Card 1 -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4 mb-lg-0">
          <div class="cs-card">
            <div class="cs-icon"><i class="fas fa-seedling"></i></div>
            <h5>Gut Health Improvement</h5>
            <p>Maintains a healthy balance of gut bacteria with advanced probiotic blends designed for better digestion
              and nutrient absorption.</p>
          </div>
        </div>
        <!-- Card 2 -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4 mb-lg-0">
          <div class="cs-card">
            <div class="cs-icon"><i class="fas fa-dumbbell"></i></div>
            <h5>Muscle Recovery &amp; Strength</h5>
            <p>Supports post-workout recovery and muscle building with high-quality whey protein, essential amino acids,
              improved stamina, and faster muscle repair.</p>
          </div>
        </div>
        <!-- Card 3 -->
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="cs-card">
            <div class="cs-icon"><i class="fas fa-heart"></i></div>
            <h5>Immunity Boost Support</h5>
            <p>A powerful mix of traditional herbs and modern nutrients that helps strengthen your body's natural
              defenses, boost daily energy levels.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="award-section py-5">
    <div class="container">
      <div class="award-card">
        <div class="row align-items-center">

          <!-- Left Image -->
          <div class="col-lg-5">
            <div class="award-image">
              <img src="<?php echo base_url(); ?>/assets/frontend/images/fido2026.png"
                alt="Probiotics Company of the Year 2026">
            </div>
          </div>

          <!-- Right Content -->
          <div class="col-lg-7">
            <div class="award-content">
              <span class="award-badge"><i class="fas fa-trophy"></i> Award 2026</span>

              <h3>
                Probiotics Company of the Year 2026
              </h3>

              <p>
                We are proud to be named Probiotics Company of the Year 2026, a recognition of our commitment to setting
                new benchmarks in probiotic innovation and quality. This achievement reinforces our passion for
                delivering trusted, science-backed solutions that contribute to healthier communities worldwide.
              </p>

              <a href="<?php echo base_url(); ?>/assets/frontend/images/Company of the Year - June - 2026 - siliconindia Magazine.pdf"
                target="_blank" class="award-btn">
                View Detail <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- WHY CHOOSE MEIBOTAN — full-width image CTA banner -->
  <section class="why-cta">
    <div class="container">
      <div class="why-cta-inner">
        <span class="why-cta-eyebrow"><i class="fas fa-check-circle"></i> Why Meibotan</span>
        <h2>Your Trusted Partner in Everyday Wellness</h2>
        <div class="why-cta-pills">
          <span>No Harmful Additives</span>
          <span>Clinically Studied</span>
          <span>GMP &amp; FSSAI Certified</span>

        </div>
        <p class="why-cta-note">
          *Formulated with scientifically studied probiotic strains, manufactured under ISO, GMP, HACCP and FSSAI
          certified facilities. Free from harmful fillers and artificial additives.
        </p>
        <a href="https://www.meibotan.com/shop" class="why-cta-btn">
          Shop Now <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </section>

  <section class="testimonials text-center">
    <div class="container">
      <span class="tm-badge">Customer Love</span>
      <h3 class="section-heading">What Our <span>Customers Say</span></h3>
      <div class="testimonial-Slider">
        <div class="testimonial-track" id="testimonialTrack">
          <!-- Testimonial 1 -->
          <div class="testimonial-item">
            <div class="testimonial-box">
              <span class="testimonial-quote"><i class="fas fa-quote-right"></i></span>
              <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                  class="fas fa-star"></i><i class="far fa-star"></i>
              </div>
              <div class="testimonial-text">"I've been using MEIBOTAN's multivitamins for 3 months now, and I feel more
                energized than ever. Love the quality!"</div>
              <div class="testimonial-person">
                <img src="<?php echo base_url(); ?>/assets/frontend/images/user.webp" alt="Priya Sharma"
                  class="testimonial-img" />
                <div class="testimonial-meta">
                  <div class="testimonial-author">Priya Sharma</div>
                  <div class="testimonial-role">Verified Buyer</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Testimonial 2 -->
          <div class="testimonial-item">
            <div class="testimonial-box">
              <span class="testimonial-quote"><i class="fas fa-quote-right"></i></span>
              <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                  class="fas fa-star-half-alt"></i><i class="far fa-star"></i>
              </div>
              <div class="testimonial-text">"Finally found a supplement brand I can trust. Clean ingredients, no side
                effects, and fast results!"</div>
              <div class="testimonial-person">
                <img src="<?php echo base_url(); ?>/assets/frontend/images/user.webp" alt="Rahul Verma"
                  class="testimonial-img" />
                <div class="testimonial-meta">
                  <div class="testimonial-author">Rahul Verma</div>
                  <div class="testimonial-role">Verified Buyer</div>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item">
            <div class="testimonial-box">
              <span class="testimonial-quote"><i class="fas fa-quote-right"></i></span>
              <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                  class="fas fa-star-half-alt"></i><i class="far fa-star"></i>
              </div>
              <div class="testimonial-text">"Their Vitamin D and Omega-3 combo has done wonders for my immunity. Highly
                recommend!"</div>
              <div class="testimonial-person">
                <img src="<?php echo base_url(); ?>/assets/frontend/images/user.webp" alt="Vikas"
                  class="testimonial-img" />
                <div class="testimonial-meta">
                  <div class="testimonial-author">Vikas</div>
                  <div class="testimonial-role">Verified Buyer</div>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item">
            <div class="testimonial-box">
              <span class="testimonial-quote"><i class="fas fa-quote-right"></i></span>
              <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                  class="fas fa-star-half-alt"></i><i class="far fa-star"></i>
              </div>
              <div class="testimonial-text">"Excellent packaging, fast shipping, and top-quality supplements. MEIBOTAN
                has become my go-to!"</div>
              <div class="testimonial-person">
                <img src="<?php echo base_url(); ?>/assets/frontend/images/user.webp" alt="Aman"
                  class="testimonial-img" />
                <div class="testimonial-meta">
                  <div class="testimonial-author">Aman</div>
                  <div class="testimonial-role">Verified Buyer</div>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item">
            <div class="testimonial-box">
              <span class="testimonial-quote"><i class="fas fa-quote-right"></i></span>
              <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                  class="fas fa-star-half-alt"></i><i class="far fa-star"></i>
              </div>
              <div class="testimonial-text">"I appreciate the transparency and natural ingredients. MEIBOTAN stands out
                in a crowded market."</div>
              <div class="testimonial-person">
                <img src="<?php echo base_url(); ?>/assets/frontend/images/user.webp" alt="Neha"
                  class="testimonial-img" />
                <div class="testimonial-meta">
                  <div class="testimonial-author">Neha</div>
                  <div class="testimonial-role">Verified Buyer</div>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item">
            <div class="testimonial-box">
              <span class="testimonial-quote"><i class="fas fa-quote-right"></i></span>
              <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                  class="fas fa-star-half-alt"></i><i class="far fa-star"></i>
              </div>
              <div class="testimonial-text">"The sleep support formula actually works! I wake up feeling refreshed
                instead of groggy."</div>
              <div class="testimonial-person">
                <img src="<?php echo base_url(); ?>/assets/frontend/images/user.webp" alt="Raman"
                  class="testimonial-img" />
                <div class="testimonial-meta">
                  <div class="testimonial-author">Raman</div>
                  <div class="testimonial-role">Verified Buyer</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Testimonial 3 -->
          <div class="testimonial-item">
            <div class="testimonial-box">
              <span class="testimonial-quote"><i class="fas fa-quote-right"></i></span>
              <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                  class="fas fa-star"></i><i class="fas fa-star"></i>
              </div>
              <div class="testimonial-text">"Best supplements ever! Helped me with my fitness goals in no time."</div>
              <div class="testimonial-person">
                <img src="<?php echo base_url(); ?>/assets/frontend/images/user.webp" alt="Sneha Kapoor"
                  class="testimonial-img" />
                <div class="testimonial-meta">
                  <div class="testimonial-author">Sneha Kapoor</div>
                  <div class="testimonial-role">Verified Buyer</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Add More if needed -->
        </div>

        <!-- Dots -->
        <div class="carousel-dots" id="testimonialDots"></div>
      </div>
    </div>
  </section>

  <script>
    const testimonialTrack = document.getElementById('testimonialTrack');
    const testimonialItems = document.querySelectorAll('.testimonial-item');
    const testimonialDotsContainer = document.getElementById('testimonialDots');

    let tItemsPerView = window.innerWidth < 768 ? 1 : 3;
    let tCurrentIndex = 0;
    const tTotalItems = testimonialItems.length;
    let tMaxIndex = tTotalItems - tItemsPerView;

    // Create Dots
    function buildTestimonialDots() {
      testimonialDotsContainer.innerHTML = '';
      tMaxIndex = tTotalItems - tItemsPerView;
      const tTotalDots = tMaxIndex + 1;
      for (let i = 0; i < tTotalDots; i++) {
        const dot = document.createElement('span');
        dot.classList.add('carousel-dot');
        if (i === tCurrentIndex) dot.classList.add('active');
        dot.dataset.index = i;
        dot.addEventListener('click', () => {
          tCurrentIndex = i;
          updateTestimonialSlider();
          resetTestimonialAutoSlide();
        });
        testimonialDotsContainer.appendChild(dot);
      }
    }
    buildTestimonialDots();

    function updateTestimonialSlider() {
      const testimonialDots = document.querySelectorAll('#testimonialDots .carousel-dot');
      const itemWidth = testimonialItems[0].offsetWidth;
      testimonialTrack.style.transform = `translateX(-${tCurrentIndex * itemWidth}px)`;

      testimonialDots.forEach(dot => dot.classList.remove('active'));
      if (testimonialDots[tCurrentIndex]) {
        testimonialDots[tCurrentIndex].classList.add('active');
      }
    }

    function testimonialAutoSlide() {
      tCurrentIndex = (tCurrentIndex + 1) > tMaxIndex ? 0 : tCurrentIndex + 1;
      updateTestimonialSlider();
    }

    let testimonialAutoInterval = setInterval(testimonialAutoSlide, 3000);

    function resetTestimonialAutoSlide() {
      clearInterval(testimonialAutoInterval);
      testimonialAutoInterval = setInterval(testimonialAutoSlide, 3000);
    }

    window.addEventListener('resize', () => {
      const newPerView = window.innerWidth < 768 ? 1 : 3;
      if (newPerView !== tItemsPerView) {
        tItemsPerView = newPerView;
        if (tCurrentIndex > tTotalItems - tItemsPerView) {
          tCurrentIndex = Math.max(0, tTotalItems - tItemsPerView);
        }
        buildTestimonialDots();
      }
      updateTestimonialSlider();
    });

    window.onload = updateTestimonialSlider;
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

  <?= $this->include('frontend/partials/footer') ?>

  <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
  <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/frontend/js/optional/isotope.pkgd.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/frontend/js/plugins.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.appear.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/frontend/js/main.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery-modal-video.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!--
<script>
  $(".js-video-button").modalVideo({
    youtube:{
      controls:0,
      nocookie: true
    }
  });
</script>
-->

</body>

</html>
