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
       ABOUT HERO
       ========================================= */
    .about-hero {
        position: relative;
        min-height: 420px;
        display: flex;
        align-items: center;
        overflow: hidden;
    }
    .about-hero-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .about-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, rgba(10,46,43,.90) 0%, rgba(15,118,110,.78) 100%);
    }
    .about-hero .container {
        position: relative;
        z-index: 2;
        padding: 90px 15px;
        text-align: center;
    }
    .about-hero-badge {
        display: inline-block;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(94,234,212,.5);
        color: #5EEAD4;
        padding: 7px 18px;
        border-radius: 30px;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: .04em;
        margin-bottom: 18px;
    }
    .about-hero-title {
        font-size: 44px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 14px;
        line-height: 1.2;
    }
    .about-hero-title span { color: #5EEAD4; }
    .about-hero-sub {
        color: rgba(236,254,255,.85);
        font-size: 15px;
        max-width: 600px;
        margin: 0 auto 20px;
        line-height: 1.7;
    }
    .about-breadcrumb a {
        color: #5EEAD4;
        text-decoration: none;
        font-weight: 600;
        font-size: 13.5px;
    }
    .about-breadcrumb span {
        color: #fff;
        font-size: 13.5px;
    }
    .about-breadcrumb i {
        font-size: 10px;
        margin: 0 10px;
        color: rgba(255,255,255,.55);
    }
    @media(max-width:767px) {
        .about-hero { min-height: 300px; }
        .about-hero .container { padding: 55px 20px; }
        .about-hero-title { font-size: 28px; }
        .about-hero-sub { font-size: 13.5px; }
    }

    /* =========================================
       SHARED SECTION HEADING (matches homepage)
       ========================================= */
    .section-heading {
        font-size: 40px;
        font-weight: 600;
        color: #1F2937;
        line-height: 1.2;
        margin-bottom: 20px;
    }
    .section-heading span { color: #0F766E; }
    .section-sub {
        color: #6B7280;
        font-size: 14.5px;
        max-width: 640px;
        margin: 0 auto 40px;
        line-height: 1.75;
    }
    @media(max-width:767px) {
        .section-heading { font-size: 1.9rem; margin-bottom: 14px; }
        .section-sub { font-size: 13px; margin-bottom: 28px; }
    }

    /* =========================================
       WHY CHOOSE US
       ========================================= */
    .why-us-section {
        padding: 70px 0;
        margin-top: 0;
        background: linear-gradient(160deg, #ECFEFF 0%, #F8FAFC 55%, #E6F7F4 100%);
    }
    .why-video-wrap {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 45px rgba(15,118,110,.18);
        max-width: 460px;
        margin: 0 auto;
    }
    .why-video-wrap video {
        width: 100%;
        height: auto;
        display: block;
    }
    .why-card {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        background: #fff;
        border-radius: 16px;
        padding: 18px 20px;
        margin-bottom: 16px;
        box-shadow: 0 8px 22px rgba(15,118,110,.08);
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .why-card:last-child { margin-bottom: 0; }
    .why-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 32px rgba(15,118,110,.15);
    }
    .why-icon {
        flex-shrink: 0;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, #14B8A6, #0F766E);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .why-icon i { color: #fff; font-size: 19px; }
    .why-card h4 {
        font-size: 17px;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 6px;
    }
    .why-card p {
        font-size: 13.5px;
        color: #6B7280;
        line-height: 1.65;
        margin: 0;
    }
    @media(max-width:767px) {
        .why-us-section { padding: 45px 15px; }
        .why-video-wrap { max-width: 280px; }
        .why-card { padding: 14px 16px; gap: 12px; }
        .why-icon { width: 42px; height: 42px; }
        .why-icon i { font-size: 15px; }
        .why-card h4 { font-size: 15px; }
        .why-card p { font-size: 12.5px; }
    }

    /* =========================================
       PHARMACY / SERVICE STRIP
       ========================================= */
    .pharmacy-section { padding: 70px 0; background: #fff; }
    .pharmacy-item { display: flex; gap: 18px; margin-bottom: 30px; }
    .pharmacy-item:last-child { margin-bottom: 0; }
    .pharmacy-icon {
        flex-shrink: 0;
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #E6F7F4;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pharmacy-icon img { width: 34px; height: 34px; object-fit: contain; }
    .pharmacy-item h4 { font-size: 17px; font-weight: 700; color: #1F2937; margin-bottom: 6px; }
    .pharmacy-item p { font-size: 13.5px; color: #6B7280; line-height: 1.7; margin: 0; }
    .pharmacy-video-wrap {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 14px 34px rgba(15,118,110,.14);
    }
    .pharmacy-video-wrap video { width: 100%; height: auto; display: block; }
    @media(max-width:767px) {
        .pharmacy-section { padding: 45px 15px; }
        .pharmacy-item { margin-bottom: 22px; gap: 14px; }
        .pharmacy-icon { width: 52px; height: 52px; }
        .pharmacy-icon img { width: 26px; height: 26px; }
        .pharmacy-item h4 { font-size: 15px; }
        .pharmacy-item p { font-size: 12.5px; }
        .pharmacy-video-wrap { margin-top: 25px; }
    }

    /* =========================================
       HISTORY / TIMELINE
       ========================================= */
    .history-section { padding: 70px 0; background: #F8FAFC; }
    .history-img {
        width: 100%;
        max-width: 480px;
        height: auto;
        border-radius: 20px;
        box-shadow: 0 20px 45px rgba(15,118,110,.15);
        display: block;
        margin: 0 auto 25px;
    }
    .timeline {
        position: relative;
        padding-left: 28px;
        border-left: 3px solid rgba(15,118,110,.22);
    }
    .timeline-item { position: relative; padding-bottom: 28px; }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -34px;
        top: 4px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #0F766E;
        border: 3px solid #F8FAFC;
        box-shadow: 0 0 0 3px rgba(15,118,110,.25);
    }
    .timeline-item h5 { color: #0F766E; font-weight: 700; font-size: 16px; margin-bottom: 6px; }
    .timeline-item p { color: #6B7280; font-size: 13.5px; line-height: 1.7; margin: 0; }
    @media(max-width:767px) {
        .history-section { padding: 45px 15px; }
        .history-img { max-width: 100%; margin-bottom: 30px; }
        .timeline { padding-left: 22px; }
        .timeline-item::before { left: -28px; }
    }

    /* =========================================
       CORE VALUES
       ========================================= */
    .values-section { padding: 70px 0; background: #fff; text-align: center; }
    .value-card { padding: 15px; }
    .value-icon {
        width: 74px;
        height: 74px;
        border-radius: 50%;
        background: #E6F7F4;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        transition: transform .3s ease;
    }
    .value-card:hover .value-icon { transform: scale(1.08); }
    .value-icon img { width: 36px; height: 36px; object-fit: contain; }
    .value-card h5 { font-weight: 700; color: #1F2937; font-size: 16px; margin-bottom: 8px; }
    .value-card p { color: #6B7280; font-size: 13px; line-height: 1.6; margin: 0; }
    @media(max-width:767px) {
        .values-section { padding: 45px 15px; }
        .value-icon { width: 62px; height: 62px; }
        .value-icon img { width: 30px; height: 30px; }
        .value-card h5 { font-size: 14.5px; }
        .value-card p { font-size: 12px; }
    }

    /* =========================================
       STATS
       ========================================= */
    .stats-section { padding: 70px 15px; text-align: center; background: #F8FAFC; }
    .stats-section h2 { font-size: 34px; font-weight: 600; color: #1F2937; margin-bottom: 14px; }
    .stats-section > .container > p { color: #6B7280; font-size: 14px; max-width: 640px; margin: 0 auto 30px; }
    .stat-box {
        background: linear-gradient(135deg, #14B8A6, #0F766E);
        color: #fff;
        padding: 28px 16px;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(15,118,110,.2);
        transition: transform .3s ease;
    }
    .stat-box:hover { transform: translateY(-6px); }
    .stat-number { font-size: 2.1rem; font-weight: 700; }
    .stat-box .stat-label { font-size: 13px; opacity: .9; margin-top: 4px; }
    @media(max-width:767px) {
        .stats-section { padding: 45px 15px; }
        .stats-section h2 { font-size: 1.9rem; }
        .stat-number { font-size: 1.6rem; }
    }

</style>
</head>
<body>
<div class="page-wrapper">
  <?= $this->include('frontend/partials/header') ?>

  <main>

    <!-- ABOUT HERO -->
    <section class="about-hero">
        <img src="<?php echo base_url(); ?>/assets/frontend/images/meibotan-about-us11.jpg" class="about-hero-img" alt="About Meibotan">
        <div class="about-hero-overlay"></div>
        <div class="container">
            <span class="about-hero-badge">A Fido Pharma Venture</span>
            <h1 class="about-hero-title">About <span>Meibotan</span></h1>
            <p class="about-hero-sub">Where age-old wellness traditions meet modern scientific innovation — crafted with purity, integrity and care.</p>
            <nav class="about-breadcrumb">
                <a href="<?php echo base_url(); ?>">Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>About Us</span>
            </nav>
        </div>
    </section>

    <!-- WHY CHOOSE US -->
    <section class="why-us-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="why-video-wrap">
                        <video autoplay muted loop playsinline>
                            <source src="<?php echo base_url(); ?>/assets/frontend/images/video_reel.mp4" type="video/mp4">
                        </video>
                    </div>
                </div>
                <div class="col-lg-7">
                    <h2 class="section-heading">Why Choose <span>Us?</span></h2>
                    <div class="why-card">
                        <div class="why-icon"><i class="fas fa-flask"></i></div>
                        <div>
                            <h4>Science Meets Tradition</h4>
                            <p>We combine the richness of Indian wellness heritage with contemporary scientific methods to develop products that deliver real, measurable benefits.</p>
                        </div>
                    </div>
                    <div class="why-card">
                        <div class="why-icon"><i class="fas fa-capsules"></i></div>
                        <div>
                            <h4>Diverse, Purposeful Product Range</h4>
                            <p>From daily multivitamins and protein powders to probiotics and cosmetic skincare, our products are designed to support a wide range of health goals — all in one place.</p>
                        </div>
                    </div>
                    <div class="why-card">
                        <div class="why-icon"><i class="fas fa-award"></i></div>
                        <div>
                            <h4>Quality Without Compromise</h4>
                            <p>Manufactured under strict quality control standards, every Meibotan product goes through rigorous testing to ensure purity, safety and effectiveness.</p>
                        </div>
                    </div>
                    <div class="why-card">
                        <div class="why-icon"><i class="fas fa-lightbulb"></i></div>
                        <div>
                            <h4>Innovation-Driven Approach</h4>
                            <p>Our in-house R&amp;D ensures that we are always a step ahead — creating formulations that are relevant, result-oriented and backed by science.</p>
                        </div>
                    </div>
                    <div class="why-card">
                        <div class="why-icon"><i class="fas fa-heart"></i></div>
                        <div>
                            <h4>Customer-First Philosophy</h4>
                            <p>We listen, we learn and we adapt. Your health goals are at the centre of everything we do, and our team is always available to help you make informed choices.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PHARMACY MADE EASY -->
    <section class="pharmacy-section">
        <div class="container">
            <h2 class="section-heading text-center">Pharmacy Has Never <span>Been This Easy</span></h2>
            <div class="row align-items-center mt-4">
                <div class="col-lg-6">
                    <div class="pharmacy-item">
                        <div class="pharmacy-icon">
                            <img src="<?php echo base_url(); ?>/assets/frontend/images/icon.png" alt="Saving made simple">
                        </div>
                        <div>
                            <h4>Saving made simple</h4>
                            <p>We partner with leading insurance providers to help you save more. You can also access exclusive discounts on selected medications — no extra cost, no hidden charges.</p>
                        </div>
                    </div>
                    <div class="pharmacy-item">
                        <div class="pharmacy-icon">
                            <img src="<?php echo base_url(); ?>/assets/frontend/images/manage-icon.jpg" alt="We handle everything">
                        </div>
                        <div>
                            <h4>We handle everything</h4>
                            <p>From transferring prescriptions to reminding you when it's time to refill — we make the entire process effortless, so you never miss a dose.</p>
                        </div>
                    </div>
                    <div class="pharmacy-item">
                        <div class="pharmacy-icon">
                            <img src="<?php echo base_url(); ?>/assets/frontend/images/delivery-icon.png" alt="Delivered to your doorstep">
                        </div>
                        <div>
                            <h4>Delivered to your doorstep</h4>
                            <p>Your prescriptions are packed discreetly and shipped securely — track your order every step of the way, and say goodbye to long pharmacy lines.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="pharmacy-video-wrap">
                        <video controls width="100%">
                            <source src="<?php echo base_url(); ?>/assets/frontend/images/video2.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HISTORY / TIMELINE -->
    <section class="history-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                    <h2 class="section-heading">Inspired by Traditions, <span>Perfected by Innovation</span></h2>
                    <img src="<?php echo base_url(); ?>/assets/frontend/images/meibotan-about.jpg" class="history-img" alt="Meibotan Journey">
                </div>
                <div class="col-lg-6">
                    <div class="timeline">
                        <div class="timeline-item">
                            <h5>2019</h5>
                            <p>Laid the foundation with extensive market research, supplier scouting, and product feasibility studies to validate the concept.</p>
                        </div>
                        <div class="timeline-item">
                            <h5>2020</h5>
                            <p>Initiated product development and began rigorous testing to ensure safety, efficacy, and compliance with health standards.</p>
                        </div>
                        <div class="timeline-item">
                            <h5>2021</h5>
                            <p>Collaborated with healthcare experts to refine formulations by blending traditional Indian remedies with modern science.</p>
                        </div>
                        <div class="timeline-item">
                            <h5>2022</h5>
                            <p>Launched our first batch of nutraceuticals and supplements, building strong partnerships across supply chains.</p>
                        </div>
                        <div class="timeline-item">
                            <h5>2023</h5>
                            <p>Expanded the portfolio with probiotics, enzymes, and whey protein — entering new retail and distribution networks.</p>
                        </div>
                        <div class="timeline-item">
                            <h5>2024</h5>
                            <p>Strengthened our brand presence with cosmetic product launches and committed to driving innovation for holistic wellness.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CORE VALUES -->
    <section class="values-section">
        <div class="container">
            <h2 class="section-heading">Our Core <span>Values</span></h2>
            <div class="row mt-4">
                <div class="col-6 col-md-3 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <img src="https://cdn-icons-png.flaticon.com/512/3209/3209265.png" alt="Innovation">
                        </div>
                        <h5>Innovation</h5>
                        <p>Bringing modern techniques to traditional wisdom</p>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <img src="https://cdn-icons-png.flaticon.com/512/2976/2976323.png" alt="Transparency">
                        </div>
                        <h5>Transparency</h5>
                        <p>Clean labels, honest claims and tested formulations</p>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <img src="https://cdn-icons-png.flaticon.com/512/2906/2906275.png" alt="Trust">
                        </div>
                        <h5>Trust</h5>
                        <p>Book lab tests online for hassle-free, home sample collection service. Get reports online.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <img src="https://cdn-icons-png.flaticon.com/512/2983/2983543.png" alt="Customer-Centricity">
                        </div>
                        <h5>Customer-Centricity</h5>
                        <p>Understanding and addressing the unique needs of every individual</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS -->
    <section class="stats-section">
        <div class="container">
            <h2>Let's Medical Check Up With Us</h2>
            <p>Ensure your health is in top condition with our comprehensive medical check-up services. Trust our expert team for accurate assessments and personalized care.</p>
            <div class="row mt-4">
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-box">
                        <div class="stat-number">830+</div>
                        <div class="stat-label">Happy Patient</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-box">
                        <div class="stat-number">30+</div>
                        <div class="stat-label">Expert Doctor</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-box">
                        <div class="stat-number">45</div>
                        <div class="stat-label">Years Experiences</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-box">
                        <div class="stat-number">35+</div>
                        <div class="stat-label">Total Branches</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  </main>

  <?= $this->include('frontend/partials/footer') ?>
</div>
<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
<script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/optional/isotope.pkgd.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/plugins.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.appear.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/main.min.js"></script>
</body>
</html>
