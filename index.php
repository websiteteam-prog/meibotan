<?php
$pageTitle = 'The Jollity Events — Connecting, Engaging, Empowering Our Seniors!';
$pageDesc  = 'Senior engagement activities and community programs. Enrol your parents and grandparents for home or group sessions with our trained and thoughtful artists.';
$active    = '';
include 'includes/header.php';
?>

<style>
/* ===== Hero chips ===== */
.hero-chips{ display:flex; justify-content:center; gap:12px; flex-wrap:wrap; margin-bottom:22px; }
.hero-chip{ display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:999px; font-family:var(--font-display); font-weight:700; font-size:14.5px; color:#fff; border:2px solid rgba(255,255,255,0.5); background:rgba(255,255,255,0.14); box-shadow:0 6px 18px rgba(8,20,80,0.18); cursor:default; transition:all 0.35s cubic-bezier(0.22,1,0.36,1); }
.hero-chip .chip-icon{ display:inline-block; font-size:15px; transition:transform 0.35s ease; }
.hero-chip:hover{ transform:translateY(-4px) scale(1.04); background:rgba(255,255,255,0.22); }
.hero-chip:hover .chip-icon{ transform:scale(1.25) rotate(-8deg); }
.hero-chip.chip-1{ animation:chip-float 5s ease-in-out infinite; }
.hero-chip.chip-2{ animation:chip-float 5.5s ease-in-out infinite 0.4s; }
.hero-chip.chip-3{ animation:chip-float 6s ease-in-out infinite 0.8s; }
@keyframes chip-float{ 0%,100%{ transform:translateY(0); } 50%{ transform:translateY(-6px); } }
.hero-chip:hover{ animation:none; }

/* ===== Hero — Golden-Carers style: colour panel + separate photos below (faces stay visible) ===== */
.hero-gc{ position:relative; padding:16px 0 6px; }
.hero-gc > .container{ width:100%; max-width:100%; padding-left:clamp(8px,1vw,16px); padding-right:clamp(8px,1vw,16px); }
.hero-gc-panel{
  position:relative; overflow:hidden; text-align:center; color:#fff;
  background:
    radial-gradient(120% 90% at 12% 8%, rgba(255,255,255,0.18), transparent 55%),
    radial-gradient(90% 120% at 92% 100%, rgba(255,176,120,0.28), transparent 55%),
    linear-gradient(150deg,#2f5be0 0%, #5a6ff0 52%, #8b6cf0 100%);
  border-radius:30px;
  padding:58px 6% 130px;
  box-shadow:0 30px 70px rgba(30,50,140,.24);
}

/* ===== decorative rings / loops / sparkles (goldencarers-style, subtle) ===== */
.hring{ position:absolute; z-index:6; pointer-events:none; opacity:.92; }
.hring-1{ left:1%;  bottom:7%;  width:98px; }
.hring-2{ right:2%; bottom:3%;  width:74px; }
.hring-3{ left:5%;  top:11%;    width:42px; }
.hring-4{ right:5%; top:13%;    width:46px; }
.hring-5{ left:46%; bottom:-1%; width:36px; }
@media (max-width:900px){ .hring-3,.hring-4,.hring-5{ display:none; } }
@media (max-width:600px){ .hring{ display:none; } }
.hero-gc-title{ font-family:var(--font-display); font-weight:800; font-size:clamp(30px,5vw,56px); line-height:1.12; margin:0 auto 16px; max-width:820px; }
.hero-gc-title span{ color:#ffd777; }
.hero-gc-sub{ color:rgba(255,255,255,.92); font-size:clamp(15px,1.6vw,18px); max-width:640px; margin:0 auto 26px; }
.hero-gc .hero-cta{ display:flex; justify-content:center; gap:14px; flex-wrap:wrap; margin:0; }

.hero-gc-photos{ position:relative; z-index:5; margin-top:-92px; display:flex; justify-content:center; gap:22px; flex-wrap:wrap; padding:0 4%; }
.hgc-photo{ width:224px; height:168px; border-radius:22px; overflow:hidden; border:5px solid #fff; box-shadow:0 22px 46px rgba(10,20,70,.26); background:#fff; transition:transform .4s cubic-bezier(.22,1,.36,1), box-shadow .4s ease; }
.hgc-photo img{ width:100%; height:100%; object-fit:cover; display:block; transition:transform .5s ease; }
.hgc-photo:nth-child(1){ transform:rotate(-3deg); }
.hgc-photo:nth-child(2){ transform:rotate(2deg); margin-top:16px; }
.hgc-photo:nth-child(3){ transform:rotate(-2deg); }
.hgc-photo:nth-child(4){ transform:rotate(3deg); margin-top:16px; }
.hgc-photo:hover{ transform:rotate(0) translateY(-6px) scale(1.03); box-shadow:0 30px 56px rgba(10,20,70,.32); z-index:7; }
.hgc-photo:hover img{ transform:scale(1.06); }
@media (max-width:760px){
  .hero-gc-panel{ padding:46px 6% 108px; border-radius:26px; }
  .hero-gc-photos{ margin-top:-78px; gap:14px; }
  .hgc-photo{ width:150px; height:120px; }
}
@media (max-width:480px){ .hgc-photo{ width:132px; height:104px; } }

/* ===== "Our programs focus on" — professional icon cards ===== */
.foc-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:30px; max-width:1120px; margin:0 auto; }
.foc-card{ position:relative; background:#fff; border:1px solid rgba(20,30,80,.07); border-top:4px solid var(--v,#8b5cf6);
  border-radius:22px; padding:34px 26px 26px; text-align:center; box-shadow:0 14px 34px rgba(30,40,90,.07);
  transition:transform .32s cubic-bezier(.22,1,.36,1), box-shadow .32s ease; }
.foc-card:hover{ transform:translateY(-8px); box-shadow:0 26px 50px rgba(30,40,90,.14); }
.foc-ico{ width:82px; height:82px; margin:0 auto 20px; border-radius:50%; display:grid; place-items:center;
  color:var(--v); background:radial-gradient(circle at 30% 25%, #fff, transparent 60%), var(--tint,#eee);
  box-shadow:0 10px 22px rgba(20,30,80,.10), inset 0 0 0 1px rgba(255,255,255,.7); transition:transform .35s ease; }
.foc-card:hover .foc-ico{ transform:translateY(-4px) rotate(-6deg) scale(1.06); }
.foc-ico svg{ width:42px; height:42px; }
.foc-card h3{ font-family:var(--font-display); font-size:20px; font-weight:800; color:var(--navy,#1b2a52); margin:0 0 10px; letter-spacing:-.01em; }
.foc-card p{ font-size:15px; line-height:1.62; color:var(--text-light,#5b6480); margin:0 auto 18px; max-width:290px; }
.foc-more{ display:inline-flex; align-items:center; gap:9px; font-family:var(--font-display); font-weight:700; font-size:14px; color:var(--v); text-decoration:none; }
.foc-more .arw{ width:26px; height:26px; border-radius:50%; display:grid; place-items:center; color:#fff; background:var(--v); font-size:13px; transition:transform .25s ease; }
.foc-card:hover .foc-more .arw{ transform:translateX(4px); }
/* per-card accent + tint */
.fc-1{ --v:#ec4899; --tint:#ffe1ec; } .fc-2{ --v:#0d9488; --tint:#d3f1ec; }
.fc-3{ --v:#7c3aed; --tint:#e9e3ff; } .fc-4{ --v:#2563eb; --tint:#dbeafe; }
.fc-5{ --v:#d97706; --tint:#ffefc6; } .fc-6{ --v:#db2777; --tint:#ffe0ef; }
/* dashed connectors on desktop */
@media (min-width:861px){
  .foc-card:not(:nth-child(3n))::after{ content:""; position:absolute; top:50%; right:-30px; width:30px; border-top:2px dashed #d8d1ec; transform:translateY(-50%); }
  .foc-card:not(:nth-child(3n))::before{ content:"\203A"; position:absolute; top:50%; right:-15px; transform:translate(50%,-50%); width:22px; height:22px; border-radius:50%; background:#fff; color:#b6ade0; display:grid; place-items:center; font-size:13px; font-weight:700; box-shadow:0 3px 8px rgba(20,20,60,.12); border:1px solid rgba(20,30,80,.08); z-index:2; }
}
@media (max-width:860px){ .foc-grid{ grid-template-columns:repeat(2,1fr); gap:22px; } }
@media (max-width:560px){ .foc-grid{ grid-template-columns:1fr; } }

/* ===== keep eyebrow above heading ===== */
.section-head h2{ display:block; width:fit-content; max-width:100%; margin-left:auto; margin-right:auto; }

/* ===== Programs section header + cards ===== */
.programs-fresh .pf-head{ text-align:center; max-width:760px; margin:0 auto 52px; }
.programs-fresh .pf-kicker{ display:inline-flex; align-items:center; gap:8px; font-family:var(--font-display); font-weight:800; font-size:13px; letter-spacing:.16em; text-transform:uppercase; color:#fff; background:linear-gradient(135deg,#8b5cf6,#ec5da8); padding:9px 20px; border-radius:999px; box-shadow:0 8px 20px rgba(139,92,246,.30); margin-bottom:20px; }
.programs-fresh .pf-kicker .k-star{ font-size:14px; }
.programs-fresh .pf-title{ font-family:var(--font-display); font-weight:800; font-size:clamp(32px,4.8vw,54px); line-height:1.08; color:var(--navy); margin:0; }
.programs-fresh .pf-title span{ background:linear-gradient(90deg,#f09600,#ec5da8 55%,#8b5cf6); -webkit-background-clip:text; background-clip:text; color:transparent; }
.programs-fresh .pf-squiggle{ width:220px; max-width:62%; height:auto; display:block; margin:12px auto 0; }
.programs-fresh .pf-sub{ color:var(--text-light); font-size:18px; margin:18px auto 0; max-width:560px; }
.programs-fresh .pf-card{ border-radius:24px; overflow:hidden; }
.programs-fresh .pf-img{ position:relative; overflow:hidden; }
.programs-fresh .pf-img img{ transition:transform .5s ease; }
.programs-fresh .pf-card:hover .pf-img img{ transform:scale(1.07); }
.programs-fresh .pf-pill{ position:absolute; top:12px; left:12px; margin:0; z-index:2; box-shadow:0 6px 14px rgba(15,23,66,.22); }
.programs-fresh .pf-body{ display:flex; flex-direction:column; gap:8px; padding:18px 20px 20px; }
.programs-fresh .pf-body h3{ margin:0; }
.programs-fresh .pf-go{ display:inline-flex; align-items:center; gap:7px; margin-top:2px; }
.programs-fresh .pf-go::after{ content:"→"; display:grid; place-items:center; width:26px; height:26px; border-radius:50%; background:var(--v); color:#fff; font-size:14px; transition:transform .25s ease; }
.programs-fresh .pf-card:hover .pf-go::after{ transform:translateX(3px); }

/* ===== image highlight polish ===== */
.golden-blob{ overflow:hidden; }
.golden-blob img{ transition:transform .5s ease; }
.golden-media:hover .golden-blob img{ transform:scale(1.05); }

/* ===== Joy banner (wavy image) ===== */
.joy-banner{ position:relative; overflow:hidden; min-height:460px; display:flex; align-items:center; justify-content:center; text-align:center; margin:30px 0; }
.joy-bg{ position:absolute; inset:0; width:100%; height:100%; object-fit:cover; z-index:0; }
.joy-overlay{ position:absolute; inset:0; z-index:1; background:linear-gradient(180deg, rgba(8,20,60,.58), rgba(8,20,60,.40)); }
.joy-inner{ position:relative; z-index:3; max-width:760px; padding:70px 6%; }
.joy-inner h2{ color:#fff; font-size:clamp(28px,4vw,46px); font-weight:800; margin-bottom:14px; }
.joy-inner p{ color:rgba(255,255,255,.92); margin-bottom:26px; }
.joy-wave{ position:absolute; left:0; width:100%; height:56px; z-index:2; display:block; }
.joy-wave path{ fill:var(--bg, #fbf7ff); }
.joy-wave-top{ top:-1px; }
.joy-wave-bot{ bottom:-1px; transform:rotate(180deg); }
@media (max-width:640px){ .joy-banner{ min-height:380px; } .joy-inner{ padding:56px 6%; } }
</style>

  <!-- ================= Hero (colour panel + photos below) ================= -->
  <section class="hero-gc">
    <div class="container">
      <div class="hero-gc-panel">
        <div class="hero-chips">
          <span class="hero-chip chip-1"><span class="chip-icon">✿</span> Connecting</span>
          <span class="hero-chip chip-2"><span class="chip-icon">☀</span> Engaging</span>
          <span class="hero-chip chip-3"><span class="chip-icon">♥</span> Empowering</span>
        </div>

        <h1 class="hero-gc-title">Bringing joy &amp; purpose to<br><span>our Seniors, every day!</span></h1>
        <p class="hero-gc-sub">Say goodbye to boredom and loneliness. Help your Seniors explore new interests, make new friends, and enjoy their favourite hobbies through our thoughtfully curated engagement programs.</p>

        <div class="hero-cta">
          <a href="register.php" class="btn btn-accent">Register Today</a>
          <a href="programs.php" class="btn btn-outline">Explore Programs</a>
        </div>
      </div>

      <div class="hero-gc-photos">
        <div class="hgc-photo"><img src="assets/img/elder2.jpg" alt="Happy seniors connecting"></div>
        <div class="hgc-photo"><img src="assets/img/lifelong.jpg" alt="Seniors learning together"></div>
        <div class="hgc-photo"><img src="images/activities/photo-sharing.jpg" alt="Seniors sharing joyful moments"></div>
        <div class="hgc-photo"><img src="images/activities/culinary.jpg" alt="Seniors enjoying an activity"></div>
      </div>
    </div>

    <!-- decorative rings / loops / sparkles -->
    <svg class="hring hring-1" viewBox="0 0 110 80" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M6 58 C 2 30, 40 18, 52 38 C 60 52, 40 64, 36 50 C 33 40, 50 36, 60 44 C 76 56, 86 32, 104 26" stroke="#9db7ff" stroke-width="5" stroke-linecap="round"/>
    </svg>
    <svg class="hring hring-2" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M58 15 A32 32 0 1 0 66 40" stroke="#f36fb0" stroke-width="5" stroke-linecap="round"/>
    </svg>
    <svg class="hring hring-3" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M20 2 C21.5 13, 27 18.5, 38 20 C27 21.5, 21.5 27, 20 38 C18.5 27, 13 21.5, 2 20 C13 18.5, 18.5 13, 20 2Z" fill="#ffcf6b"/>
    </svg>
    <svg class="hring hring-4" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M20 2 C21.5 13, 27 18.5, 38 20 C27 21.5, 21.5 27, 20 38 C18.5 27, 13 21.5, 2 20 C13 18.5, 18.5 13, 20 2Z" fill="#ffffff" opacity=".85"/>
    </svg>
    <svg class="hring hring-5" viewBox="0 0 60 44" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M6 22 C 6 10, 26 10, 26 22 C 26 34, 8 34, 12 22 M26 22 L54 20" stroke="#12b3a6" stroke-width="4.5" stroke-linecap="round"/>
    </svg>
  </section>

  <!-- ================= Golden Years – "Who We Are" ================= -->
  <section class="section golden">
    <div class="container">

      <div class="golden-split">
        <div class="golden-copy reveal">
          <span class="golden-eyebrow">Who We Are</span>
          <h2 class="golden-title">Make the Golden years the <span class="hl">life's most rewarding years!</span></h2>
          <p class="golden-lead">Every senior deserves days filled with laughter, friendship, and fulfilment. Our thoughtfully curated engagement programs bring all of that — and more — right to their doorstep.</p>

          <ul class="golden-ticks">
            <li>Thoughtfully curated programs</li>
            <li>Home or Group sessions</li>
            <li>Trained artists</li>
            <li>A joyful community</li>
          </ul>

          <div class="golden-cta">
            <a href="register.php" class="btn btn-accent btn-lg">Register Today →</a>
          </div>
        </div>

        <div class="golden-media reveal reveal-d1">
          <div class="golden-blob">
            <img src="images/activities/culinary.jpg" alt="Seniors sharing joyful moments together">
          </div>
        </div>
      </div>

      <div class="golden-stats reveal">
        <div class="gstat"><div class="gnum" data-count="500" data-suffix="+">0</div><div class="glabel">Happy Seniors</div></div>
        <div class="gstat"><div class="gnum" data-count="30"  data-suffix="+">0</div><div class="glabel">Joyful Programs</div></div>
        <div class="gstat"><div class="gnum" data-count="70"  data-suffix="+">0</div><div class="glabel">Trained Artists</div></div>
        <div class="gstat"><div class="gnum" data-count="100" data-suffix="%">0</div><div class="glabel">Smiles Guaranteed</div></div>
      </div>
    </div>
  </section>

  <!-- ================= Programs focus (professional icon cards) ================= -->
  <section class="section">
    <div class="container">
      <div class="section-head reveal">
        <span class="section-eyebrow">Programs</span>
        <h2>Our programs <span class="hl">focus on</span></h2>
        <p>The Jollity Events are dedicated to enhancing the well-being and quality of life of seniors through thoughtfully designed Engagement programs — a welcoming space where older adults can connect, explore their interests, and stay active.</p>
      </div>
      <div class="foc-grid">

        <div class="foc-card fc-1 reveal">
          <div class="foc-ico">
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M24 12.5c-1.7-3-6.6-2.5-6.6 1.3 0 2.6 3.7 5 6.6 6.8 2.9-1.8 6.6-4.2 6.6-6.8 0-3.8-4.9-4.3-6.6-1.3Z"/>
              <circle cx="14" cy="28" r="3.1"/><circle cx="34" cy="28" r="3.1"/><circle cx="24" cy="30" r="3.5"/>
              <path d="M8 39c0-3.2 2.7-5.2 6-5.2M40 39c0-3.2-2.7-5.2-6-5.2M17 40c0-3.9 3.1-6.2 7-6.2s7 2.3 7 6.2"/>
            </svg>
          </div>
          <h3>Social Connection</h3>
          <p>Friendships, group meets and shared laughter that keep loneliness away.</p>
          <a class="foc-more" href="programs.php#social-jollies">Learn More <span class="arw">→</span></a>
        </div>

        <div class="foc-card fc-2 reveal reveal-d1">
          <div class="foc-ico">
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M24 11c-3-1.6-7 .4-7.5 3.8-2.7.3-4.6 2.4-4.6 5 0 1 .3 1.9.8 2.7-1.4 1-2.3 2.6-2.3 4.4 0 2 1.2 3.8 2.9 4.6.6 2.6 2.9 4.5 5.7 4.5 2.9 0 5-2.1 5-5V11Z"/>
              <path d="M24 11c3-1.6 7 .4 7.5 3.8 2.7.3 4.6 2.4 4.6 5 0 1-.3 1.9-.8 2.7 1.4 1 2.3 2.6 2.3 4.4 0 2-1.2 3.8-2.9 4.6-.6 2.6-2.9 4.5-5.7 4.5-2.9 0-5-2.1-5-5V11Z"/>
              <path d="M24 16v20M19.5 20.5c-2 0-3.2 1.2-3.2 2.9M28.5 20.5c2 0 3.2 1.2 3.2 2.9M18.5 28.5c-1.6 0-2.7 1-2.7 2.5M29.5 28.5c1.6 0 2.7 1 2.7 2.5"/>
            </svg>
          </div>
          <h3>Mental Stimulation</h3>
          <p>Games, puzzles and memory activities that keep minds sharp and curious.</p>
          <a class="foc-more" href="programs.php#cognitive-games">Learn More <span class="arw">→</span></a>
        </div>

        <div class="foc-card fc-3 reveal reveal-d2">
          <div class="foc-ico">
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <circle cx="24" cy="11" r="3.6"/>
              <path d="M24 15c-3.6 0-6.4 2.4-7.1 5.9M24 15c3.6 0 6.4 2.4 7.1 5.9"/>
              <path d="M12.5 34c0-4.4 5.1-7.5 11.5-7.5S35.5 29.6 35.5 34"/>
              <path d="M17 27.5c2.4 1.6 4.2 2.2 4.2 2.2M31 27.5c-2.4 1.6-4.2 2.2-4.2 2.2"/>
            </svg>
          </div>
          <h3>Physical Wellness</h3>
          <p>Gentle movement, yoga and dance for strength, balance and energy.</p>
          <a class="foc-more" href="programs.php#music-movement">Learn More <span class="arw">→</span></a>
        </div>

        <div class="foc-card fc-4 reveal">
          <div class="foc-ico">
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M24 11c-7.3 0-13 5-13 12 0 4.5 3.4 7.6 7.7 7.6 2 0 3.1-1.3 3.1-2.9 0-.8-.3-1.4-.3-2.1 0-1.4 1-2.3 2.5-2.3H28c5.6 0 9-3.4 9-8.1C37 15.7 31.4 11 24 11Z"/>
              <circle cx="18" cy="21" r="1.7"/><circle cx="24" cy="17.5" r="1.7"/><circle cx="30" cy="21" r="1.7"/>
            </svg>
          </div>
          <h3>Creative Expression</h3>
          <p>Art, craft and music sessions to spark imagination and self-expression.</p>
          <a class="foc-more" href="programs.php#art-craft">Learn More <span class="arw">→</span></a>
        </div>

        <div class="foc-card fc-5 reveal reveal-d1">
          <div class="foc-ico">
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M24 15c-3.2-2.1-7.4-3.1-11.5-3.1v20.4c4.1 0 8.3 1 11.5 3.1 3.2-2.1 7.4-3.1 11.5-3.1V11.9c-4.1 0-8.3 1-11.5 3.1Z"/>
              <path d="M24 15v20.4"/>
            </svg>
          </div>
          <h3>Lifelong Learning</h3>
          <p>New skills, digital know-how and fresh interests to explore at any age.</p>
          <a class="foc-more" href="programs.php#digital-literacy">Learn More <span class="arw">→</span></a>
        </div>

        <div class="foc-card fc-6 reveal reveal-d2">
          <div class="foc-ico">
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M24 19.5c-1.9-3.3-7.2-2.8-7.2 1.5 0 3.1 4.1 5.8 7.2 7.8 3.1-2 7.2-4.7 7.2-7.8 0-4.3-5.3-4.8-7.2-1.5Z"/>
              <path d="M13.5 29.5c-1.6 0-2.8 1.1-2.8 2.7 0 1.6 1.3 2.8 2.9 2.8H21M34.5 29.5c1.6 0 2.8 1.1 2.8 2.7 0 1.6-1.3 2.8-2.9 2.8H27"/>
              <path d="M16.5 33.5c0 2.3 3.4 4 7.5 4s7.5-1.7 7.5-4"/>
            </svg>
          </div>
          <h3>Emotional Well-being</h3>
          <p>Companionship and care that bring comfort, confidence and belonging.</p>
          <a class="foc-more" href="programs.php#mindfulness">Learn More <span class="arw">→</span></a>
        </div>

      </div>
    </div>
  </section>

  <!-- ============ Programs ============ -->
  <section class="section programs-fresh" style="padding-top:0;">
    <div class="container">
      <div class="pf-head reveal">
        <span class="pf-kicker"><span class="k-star">✦</span> Explore &amp; Enjoy</span>
        <h2 class="pf-title">Our <span>Programs</span></h2>
        <svg class="pf-squiggle" viewBox="0 0 220 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M3 9 Q 30 2, 58 9 T 113 9 T 168 9 T 217 9" stroke="url(#pfsq)" stroke-width="4.5" stroke-linecap="round"/>
          <defs><linearGradient id="pfsq" x1="0" y1="0" x2="220" y2="0" gradientUnits="userSpaceOnUse">
            <stop stop-color="#ff6b6b"/><stop offset=".5" stop-color="#ffad0d"/><stop offset="1" stop-color="#12b3a6"/>
          </linearGradient></defs>
        </svg>
        <p class="pf-sub">Bigger, brighter and hand-picked for every interest — find a favourite or discover a brand-new passion.</p>
      </div>

      <div class="pf-grid">
        <a class="pf-card v-coral reveal" href="programs.php#art-craft"><div class="pf-img"><img src="images/activities/scrapbooking.jpg" alt="Art & Craft"><span class="pf-pill">8 sessions</span></div><div class="pf-body"><h3>Art &amp; Craft</h3><span class="pf-go">Explore</span></div></a>
        <a class="pf-card v-teal reveal reveal-d1" href="programs.php#hobbies-recreation"><div class="pf-img"><img src="assets/img/hobbies.jpg" alt="Hobbies & Recreation"><span class="pf-pill">9 sessions</span></div><div class="pf-body"><h3>Hobbies &amp; Recreation</h3><span class="pf-go">Explore</span></div></a>
        <a class="pf-card v-purple reveal reveal-d2" href="programs.php#cognitive-games"><div class="pf-img"><img src="images/activities/visual-games.jpg" alt="Cognitive Games"><span class="pf-pill">8 sessions</span></div><div class="pf-body"><h3>Cognitive Games</h3><span class="pf-go">Explore</span></div></a>
        <a class="pf-card v-pink reveal" href="programs.php#music-movement"><div class="pf-img"><img src="images/activities/listening.jpg" alt="Music & Movement"><span class="pf-pill">9 sessions</span></div><div class="pf-body"><h3>Music &amp; Movement</h3><span class="pf-go">Explore</span></div></a>
        <a class="pf-card v-sky reveal reveal-d1" href="programs.php#mindfulness"><div class="pf-img"><img src="images/activities/meditation.jpg" alt="Mindfulness"><span class="pf-pill">4 sessions</span></div><div class="pf-body"><h3>Mindfulness</h3><span class="pf-go">Explore</span></div></a>
        <a class="pf-card v-lime reveal reveal-d2" href="programs.php#social-jollies"><div class="pf-img"><img src="images/activities/culinary.jpg" alt="Social Jollies"><span class="pf-pill">6 sessions</span></div><div class="pf-body"><h3>Social Jollies</h3><span class="pf-go">Explore</span></div></a>
        <a class="pf-card v-orange reveal" href="programs.php#digital-literacy"><div class="pf-img"><img src="assets/img/digital.jpg" alt="Digital Literacy"><span class="pf-pill">4 sessions</span></div><div class="pf-body"><h3>Digital Literacy</h3><span class="pf-go">Explore</span></div></a>
        <a class="pf-card v-coral reveal reveal-d1" href="programs.php#one-on-one"><div class="pf-img"><img src="assets/img/one-o-one.jpg" alt="One-on-One"><span class="pf-pill">Personalised</span></div><div class="pf-body"><h3>One-on-One</h3><span class="pf-go">Explore</span></div></a>
      </div>
    </div>
  </section>

  <!-- ============ Joy banner (wavy image) ============ -->
  <section class="joy-banner">
    <img class="joy-bg" src="images/activities/wave3.jpg" alt="Seniors enjoying a joyful moment together">
    <div class="joy-overlay"></div>

    <svg class="joy-wave joy-wave-top" viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M0 0 H1200 V30 Q1140 54 1080 34 T960 34 T840 34 T720 34 T600 34 T480 34 T360 34 T240 34 T120 34 T0 30 Z"/>
    </svg>
    <svg class="joy-wave joy-wave-bot" viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M0 0 H1200 V30 Q1140 54 1080 34 T960 34 T840 34 T720 34 T600 34 T480 34 T360 34 T240 34 T120 34 T0 30 Z"/>
    </svg>

    <div class="container joy-inner">
      <h2>Bringing joy, purpose, and companionship to their Golden Years!</h2>
      <p>Be part of this welcoming community where every smile is celebrated, every story is valued, and every senior is empowered to live with confidence, purpose, and belonging.</p>
      <a href="register.php" class="btn btn-accent">Register Now</a>
    </div>
  </section>

<script>
/* count-up stats */
(function () {
  var nums = document.querySelectorAll('.gnum');
  if (nums.length && ('IntersectionObserver' in window)) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        var el = en.target; io.unobserve(el);
        var target = +el.getAttribute('data-count');
        var suffix = el.getAttribute('data-suffix') || '';
        var dur = 1600, start = performance.now();
        (function tick(now) {
          var p = Math.min((now - start) / dur, 1);
          var eased = 1 - Math.pow(1 - p, 3);
          el.textContent = Math.round(target * eased) + suffix;
          if (p < 1) requestAnimationFrame(tick);
        })(start);
      });
    }, { threshold: 0.4 });
    nums.forEach(function (n) { io.observe(n); });
  }
})();
</script>

<?php include 'includes/footer.php'; ?>
