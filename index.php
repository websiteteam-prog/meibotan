<?php
$pageTitle = 'Home';
$pageDesc = 'Kenu Biopharma — Your Ingredient Solutions Partner. Nutraceutical ingredient supplier in India.';
require_once 'includes/header.php';

/* -------- Home page data (yahin se easily edit karo) -------- */

$quickInfo = [
    ['fa-flask-vial', 'Full Portfolio', 'Collagens, enzymes, probiotics, bioactives, oleoresins and amino acids.', 'products.php'],
    ['fa-shield-halved', '99% Purity', 'Pharmaceutical-grade ingredients from certified international partners.', 'about.php'],
    ['fa-file-circle-check', 'Regulatory Ready', 'Complete import compliance, documentation and certificates handled.', 'about.php'],
    ['fa-truck-fast', 'PAN-India Delivery', 'Timely, traceable, temperature-controlled distribution across India.', 'contact.php'],
];

$commitments = [
    'Traceability from origin to delivery',
    'Clear documentation and certificates',
    'Premium quality — no matter the order size',
    'Timely communication and support',
];

/* Categories carousel — [icon, label, colorClass, slug, badge] */
$concerns = [
    ['fa-dna', 'Collagens', 'concern-1', 'collagens', ''],
    ['fa-atom', 'Enzymes', 'concern-2', 'enzymes', ''],
    ['fa-shield-virus', 'Probiotics', 'concern-3', 'probiotics', ''],
    ['fa-droplet', 'Oleoresins & Essential Oils', 'concern-5', 'oleoresins', ''],
    ['fa-leaf', 'Plant-Based Bioactives', 'concern-4', 'bio-actives', ''],
    ['fa-vial', 'Amino Acids', 'concern-6', 'amino-acids', ''],
    ['fa-mortar-pestle', 'Extracts', 'concern-7', 'extracts', ''],
];

/* Signature "We Offer" */
$offers = [
    ['fa-circle-nodes', 'Liposomal Nutraceutical Ingredients', 'offer-1'],
    ['fa-shield-heart', 'Palmitoylethanolamide (PEA)', 'offer-2'],
    ['fa-sun', 'Veg (Lichen) Sourced Vitamin D3', 'offer-3'],
    ['fa-seedling', 'Plant-Based Bioactive Molecules', 'offer-4'],
];

$steps = [
    ['fa-earth-asia', 'Worldwide Integration Network', 'We screen ingredient vendors globally on scientific credibility, certifications and manufacturing criteria.'],
    ['fa-clipboard-check', 'Qualification & Vetting', 'All suppliers are qualified — documented, audited and analysed with real samples.'],
    ['fa-file-shield', 'Regulatory Navigation', 'We handle all import compliance and documentation for smooth entry into India.'],
    ['fa-temperature-half', 'Quality-Controlled Storage', 'Controlled facilities maintain ingredient potency between receipt and dispatch.'],
    ['fa-truck-fast', 'Structured Distribution', 'Timely, traceable delivery aligned with required temperature and handling.'],
];

$counters = [
    ['fa-droplet', '99', '%', 'Ingredient Purity'],
    ['fa-atom', '10', '+', 'Bioactive Products'],
    ['fa-handshake-angle', '18', '+', 'Happy Clients'],
    ['fa-box-open', '300', '+', 'Ingredient Deliveries'],
];
?>



<!-- ============================ HERO IMAGE BANNER ============================ -->
<div class="img-hero" id="imgHero">
    <div class="ih-track" id="ihTrack">
        <div class="ih-slide active">
            <img src="assets/images/home-banner.png" alt="" onerror="this.style.display='none'">
        </div>
        <div class="ih-slide">
            <img src="assets/images/home-banner2.jpeg" alt="" onerror="this.style.display='none'">
        </div>
    </div>
    <div class="ih-arrows">
        <button class="ih-arrow" data-dir="-1" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="ih-arrow" data-dir="1" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>

<!-- ==================== PRODUCT CATEGORIES (image carousel) ================= -->
<section class="section-alt">
    <div class="container">
        <div class="cat-head">
            <div>
                <span class="eyebrow">Product Category</span>
                <h2>Ingredients by <span class="accent">Category</span></h2>
            </div>
            <!-- <div class="cat-arrows">
                <button class="cat-nav cat-prev" id="catPrev" aria-label="Previous"><i
                        class="fa-solid fa-chevron-left"></i></button>
                <button class="cat-nav cat-next" id="catNext" aria-label="Next"><i
                        class="fa-solid fa-chevron-right"></i></button>
            </div> -->
        </div>
    </div>

    <div class="cat-carousel">
        <div class="container">
            <div class="cat-track" id="catTrack">
                <?php foreach ($concerns as $c): ?>
                    <a href="products.php?cat=<?php echo $c[3]; ?>" class="concern-card">
                        <img src="assets/images/cat/<?php echo $c[3]; ?>.png" alt="<?php echo $c[1]; ?>">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ============================ OUR STORY ============================ -->
<div>
    <div class="container split">
        <div class="story-media">
            <div class="story-panel"><i class="fa-solid fa-microscope"></i></div>
            <div class="story-badge"><strong>99%</strong><span>Pure Ingredients</span></div>
        </div>
        <div>
            <span class="eyebrow">Why Brands Choose Kenu</span>
            <h2>We Bring <span class="accent">Nature + Science + Quality</span> Together</h2>
            <p>Maintaining ingredient stability during movement and storage is critical. Kenu Biopharma tackles
                this with a regulated, quality-oriented supply system — sourcing 99% pure ingredients and
                collaborating with certified international partners who meet pharmaceutical-grade standards.</p>
            <ul class="commit-list">
                <?php foreach ($commitments as $c): ?>
                    <li><span class="check"></span>
                        <?php echo $c; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="about.php" class="btn btn-primary">More About Us <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
</div>

<!-- ==================== CTA IMAGE BANNER (full-width, image only — no text) ==================== -->
<section class="cta-image-section">
    <a href="contact.php" class="cta-image">
        <img src="assets/images/cta-banner.png" alt="Kenu Biopharma">
    </a>
</section>

<!-- ========================= QUICK-INFO BOXES ========================= -->
<section>
    <div class="container quick-info">
        <div class="grid-4">
            <?php foreach ($quickInfo as $q): ?>
                <div class="info-box">
                    <div class="icon-tile"><i class="fa-solid <?php echo $q[0]; ?>"></i></div>
                    <h3><?php echo $q[1]; ?></h3>
                    <p><?php echo $q[2]; ?></p>
                    <a href="<?php echo $q[3]; ?>" class="text-link">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ============================= WE OFFER ============================ -->
<section>
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow">We Offer</span>
            <h2>Signature <span class="accent">Products</span></h2>
            <p>Our most requested ingredients — trusted by innovators, delivered with accountability.</p>
        </div>
        <div class="offer-grid">
            <?php foreach ($offers as $o): ?>
                <a href="exclusive-products.php" class="offer-card <?php echo $o[2]; ?>">
                    <i class="fa-solid <?php echo $o[0]; ?> offer-icon"></i>
                    <div class="offer-content">
                        <h3><?php echo $o[1]; ?></h3>
                        <span class="offer-arrow"><i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================ HOW WE WORK ========================== -->
<section class="section-alt">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow">How We Work</span>
            <h2>A Process Based on <span class="accent">Precision</span>, Not Speed</h2>
            <p>Every stage is planned, recorded and controlled — from identifying a possible ingredient to final
                delivery.</p>
        </div>
        <div class="steps">
            <?php $n = 1;
            foreach ($steps as $st): ?>
                <div class="step-card">
                    <div class="step-top">
                        <span class="step-num"><?php echo sprintf('%02d', $n); ?></span>
                        <span class="step-ic"><i class="fa-solid <?php echo $st[0]; ?>"></i></span>
                    </div>
                    <h3><?php echo $st[1]; ?></h3>
                    <p><?php echo $st[2]; ?></p>
                </div>
                <?php $n++; endforeach; ?>
        </div>
    </div>
</section>

<!-- ======================= AT A GLANCE (counters) ==================== -->
<section>
    <div class="container">
        <div class="counters-band">
            <div class="section-head center" style="margin-bottom:34px;">
                <h2>Kenu Biopharma <span class="accent">At A Glance</span></h2>
            </div>
            <div class="counters-grid">
                <?php foreach ($counters as $c): ?>
                    <div class="counter-item">
                        <div class="counter-icon"><i class="fa-solid <?php echo $c[0]; ?>"></i></div>
                        <div>
                            <strong><span data-count="<?php echo $c[1]; ?>"
                                    data-suffix="<?php echo $c[2]; ?>">0</span></strong>
                            <p><?php echo $c[3]; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ============================= CTA BAND ============================ -->
<section style="padding-top:0;">
    <div class="container">
        <div class="cta-band">
            <div>
                <h2>Let's build your next formulation together</h2>
                <p>Tell us what you're formulating — we'll help you source the right ingredient, at the right purity.
                </p>
            </div>
            <a href="contact.php" class="btn"><i class="fa-regular fa-paper-plane"></i> Enquire Now</a>
        </div>
    </div>
</section>

<!-- ==================== HERO SLIDER JS (banner ke liye) ==================== -->
<script>
    (function () {
        var track = document.getElementById('ihTrack'); if (!track) return;
        var slides = [].slice.call(track.children),
            arrows = document.querySelectorAll('#imgHero .ih-arrow'),
            hero = document.getElementById('imgHero'),
            idx = 0, timer, total = slides.length;

        function go(n) {
            idx = (n + total) % total;
            track.style.transform = 'translateX(' + (-idx * 100) + '%)';
            slides.forEach(function (s, i) { s.classList.toggle('active', i === idx); });
            play();
        }
        function play() { if (total > 1) { clearInterval(timer); timer = setInterval(function () { go(idx + 1); }, 5000); } }

        arrows.forEach(function (b) { b.addEventListener('click', function () { go(idx + parseInt(b.dataset.dir, 10)); }); });
        hero.addEventListener('mouseenter', function () { clearInterval(timer); });
        hero.addEventListener('mouseleave', play);

        var x0 = null;
        track.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
        track.addEventListener('touchend', function (e) { if (x0 === null) return; var dx = e.changedTouches[0].clientX - x0; if (Math.abs(dx) > 40) go(idx + (dx < 0 ? 1 : -1)); x0 = null; });
        play();
    })();
</script>

<?php require_once 'includes/footer.php'; ?>
