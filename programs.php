<?php
$pageTitle = 'Programs  — The Jollity Events';
$pageDesc  = 'Enriching Lives Through Meaningful Engagements! Explore Art & Craft, Hobbies & Recreation, Cognitive Games, Music & Movement, Mindfulness, Social Jollies, Digital Literacy and One-on-One programs.';
$active    = 'activities';
include 'includes/header.php';

/* ==================================================================
   ACTIVITIES PAGE
   To change any picture, just edit its image path below in $CATALOG.
   - Each category has an 'icon' image.
   - Each activity is  'Activity Name' => 'path/to/image.jpg'.
   Put your files in the images/activities/ folder (or change the paths).
   Square images (e.g. 400x400) look best — they show inside circles.
   ================================================================== */

/* Simple dummy counts for the badges until real data is available */
function dummy_count(string $name): int { return (crc32($name) % 90) + 8; }
function dummy_new(string $name): int   { return crc32($name) % 5; }

/* ---- All categories + their images ---- */
$CATALOG = [
    'art-craft' => [
        'name' => 'Art & Craft',
        'icon' => 'images/activities/art-craft.jpg',
        'emoji' => '🎨',
        'items' => [
            'Fun Painting'                  => 'images/activities/fun-painting.jpg',
            'Creative crafts'               => 'images/activities/art-craft.jpg',
            'Clay modelling'                => 'images/activities/clay-modelling.jpg',
            'Collage-making'                => 'images/activities/collage-making.jpg',
            'Scrapbooking'                  => 'images/activities/scrapbooking.jpg',
            'Gratitude tree'                => 'images/activities/gratitude-tree.jpg',
            'Small DIY projects'            => 'images/activities/diy-projects.jpg',
            'Reminiscence and Memory Boxes' => 'images/activities/memory-boxes.jpg',
        ],
    ],
    'hobbies-recreation' => [
        'name' => 'Hobbies & Recreation',
        'icon' => 'images/activities/hobbies-recreation.jpg',
        'emoji' => '🧶',
        'items' => [
            'Therapeutic Colouring' => 'images/activities/therapeutic-colouring.jpg',
            'Reading'               => 'images/activities/reading.jpg',
            'Writing & Journaling'  => 'images/activities/journaling.jpg',
            'Story Telling'         => 'images/activities/story-telling.jpg',
            'Indoor Herb Gardens'   => 'images/activities/herb-gardens.jpg',
            'Dancing'               => 'images/activities/dancing.jpg',
            'Engaging Art'          => 'images/activities/engaging-art.jpg',
            'Knitting and Crafting' => 'images/activities/knitting.jpg',
            'Drawing Activities'    => 'images/activities/drawing.jpg',
        ],
    ],
    'cognitive-games' => [
        'name' => 'Cognitive Games',
        'icon' => 'images/activities/cognitive-games.jpg',
        'emoji' => '🧩',
        'items' => [
            'Memory boosters'              => 'images/activities/memory-boosters.jpg',
            'Decision making games'        => 'images/activities/decision-games.jpg',
            'Strategy thinking games'      => 'images/activities/strategy-games.jpg',
            'Brain Stimulating activities' => 'images/activities/brain-stimulating.jpg',
            'Visual games'                 => 'images/activities/visual-games.jpg',
            'Comforting activities'        => 'images/activities/comforting.jpg',
            'Treat Trolley'                => 'images/activities/treat-trolley.jpg',
            'Physical Recreation'          => 'images/activities/physical-recreation.jpg',
        ],
    ],
    'music-movement' => [
        'name' => 'Music & Movement',
        'icon' => 'images/activities/music-movement.jpg',
        'emoji' => '🎵',
        'items' => [
            'Karaoke'                  => 'images/activities/karaoke.jpg',
            'Charades'                 => 'images/activities/charades.jpg',
            'Interactive sing-alongs'  => 'images/activities/sing-alongs.jpg',
            'Listening Sessions'       => 'images/activities/listening.jpg',
            'Jamming'                  => 'images/activities/jamming.jpg',
            'Musical Bingo'            => 'images/activities/musical-bingo.jpg',
            'Props dancing'            => 'images/activities/props-dancing.jpg',
            'Learn musical instrument' => 'images/activities/learn-instrument.jpg',
             'Musical games'            => 'images/activities/musical-games.jpg',
        ],
    ],
    'mindfulness' => [
        'name' => 'Mindfulness',
        'icon' => 'images/activities/mindfulness.jpg',
        'emoji' => '🧘',
        'items' => [
            'Meditation & Mindfulness' => 'images/activities/meditation.jpg',
            'Yoga'                     => 'images/activities/yoga.jpg',
            'Gentle Stretching'        => 'images/activities/stretching.jpg',
            'Easy Sit-down Exercises'  => 'images/activities/sit-down-exercises.jpg',
        ],
    ],
    'social-jollies' => [
        'name' => 'Social Jollies',
        'icon' => 'images/activities/social-jollies.jpg',
        'emoji' => '🌼',
        'items' => [
            'Book Club'           => 'images/activities/book-club.jpg',
            'Photo Sharing Circle' => 'images/activities/photo-sharing.jpg',
            'Reading club'        => 'images/activities/reading-club.jpg',
            'Reminiscence Group'  => 'images/activities/reminiscence-group.jpg',
            'Culinary Adventures' => 'images/activities/culinary.jpg',
            'Garden Club'         => 'images/activities/garden-club.jpg',
        ],
    ],
    'digital-literacy' => [
        'name' => 'Digital Literacy',
        'icon' => 'images/activities/digital-literacy.jpg',
        'emoji' => '💻',
        'items' => [
            'Security & Safety'      => 'images/activities/security.jpg',
            'Essential Skills'       => 'images/activities/essential-skills.jpg',
            'Entertainment & Hobbies' => 'images/activities/entertainment.jpg',
            'AI-powered tools'       => 'images/activities/ai-tools.jpg',
        ],
    ],
    'one-on-one' => [
        'name' => 'One-on-One',
        'icon' => 'images/activities/one-on-one.jpg',
        'emoji' => '🤝',
        'items' => [
            'One-on-one visits' => 'images/activities/one-on-one-visits.jpg',
        ],
    ],
];

/* Count total activities (for the "All" tab) */
$totalItems = 0;
foreach ($CATALOG as $cat) {
    $totalItems += count($cat['items']);
}

/* Rotating spotlight pool for the 4th hero image slot (name shown over the photo) */
$spotlightPool = ['Jamming Session', 'Karaoke Night', 'Musical Bingo', 'Sing-Along Circle'];

/* Short one-line taglines shown beside each category heading */
$CATALOG_TAGLINE = [
    'art-craft'          => 'Hands-on creativity that sparks joy and pride in every finished piece.',
    'hobbies-recreation' => 'Simple, familiar pastimes that bring comfort and quiet satisfaction.',
    'cognitive-games'     => 'Playful challenges that keep the mind sharp and engaged.',
    'music-movement'      => 'Rhythm, song and gentle movement to lift the mood instantly.',
    'mindfulness'         => 'Calm, grounding practices for body and mind.',
    'social-jollies'      => 'Shared moments that build friendship and belonging.',
    'digital-literacy'    => 'Confidence with everyday tech, taught patiently and simply.',
    'one-on-one'          => 'Personal, focused time tailored to individual interests.',
];
?>

<style>
/* ================= Activities page styles (self-contained) ================= */
.crumb-bar { display: flex; align-items: center; gap: 8px; font-size: 13.5px; font-weight: 600; color: var(--text-light); padding: 16px 4px 4px; }
.crumb-bar a { color: var(--text-light); transition: color 0.2s ease; }
.crumb-bar a:hover { color: var(--primary); }
.crumb-bar .sep { opacity: 0.6; }
.crumb-bar .here { color: var(--primary); }

/* ---------- Category tabs: colorful, icon-forward ---------- */
.ftab-bar { display: flex; gap: 10px; flex-wrap: wrap; padding: 18px 0 6px; }
.ftab-wrap { position: relative; flex: 0 0 auto; opacity: 0; transform: translateY(12px); animation: tab-rise 0.5s ease forwards; }
.ftab-wrap:nth-child(1) { animation-delay: 0.02s; }
.ftab-wrap:nth-child(2) { animation-delay: 0.08s; }
.ftab-wrap:nth-child(3) { animation-delay: 0.14s; }
.ftab-wrap:nth-child(4) { animation-delay: 0.20s; }
.ftab-wrap:nth-child(5) { animation-delay: 0.26s; }
.ftab-wrap:nth-child(6) { animation-delay: 0.32s; }
.ftab-wrap:nth-child(7) { animation-delay: 0.38s; }
.ftab-wrap:nth-child(8) { animation-delay: 0.44s; }
.ftab-wrap:nth-child(9) { animation-delay: 0.50s; }
@keyframes tab-rise { to { opacity: 1; transform: translateY(0); } }
.ftab {
  position: relative;
  display: flex; align-items: center; gap: 10px;
  background: #fff; border: 2px solid var(--border); border-radius: 14px;
  padding: 8px 34px 8px 8px; min-width: auto; width: 100%; cursor: pointer;
  font-family: var(--font-display); text-align: left;
  transition: border-color 0.2s ease, background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
  overflow: visible;
}
.ftab::before {
  content: ""; position: absolute; inset: 0; opacity: 0;
  background: linear-gradient(135deg, var(--primary-tint), transparent 65%);
  transition: opacity 0.2s ease; border-radius: inherit;
}
.ftab:hover { border-color: var(--primary-soft); transform: translateY(-2px); box-shadow: var(--shadow-sm); }
.ftab:hover::before { opacity: 1; }
.ftab.active { background: var(--primary-tint); border-color: var(--primary); transform: translateY(-1px); box-shadow: var(--shadow-sm); }

.ftab-emoji {
  position: relative; z-index: 1;
  width: 32px; height: 32px; min-width: 32px; min-height: 32px; flex-shrink: 0; border-radius: 50%;
  display: flex; align-items: center; justify-content: center; font-size: 15px; line-height: 1;
  background: var(--primary-tint);
  border: 2px dashed var(--primary-soft);
  box-sizing: border-box;
  transition: transform 0.3s ease, background 0.3s ease;
}
.ftab.active .ftab-emoji { background: var(--primary); transform: rotate(-8deg) scale(1.05); border-style: solid; border-color: var(--primary); }
.ftab-wrap:nth-child(3n+1) .ftab-emoji { background: var(--mint, #e2f6ef); }
.ftab-wrap:nth-child(3n+2) .ftab-emoji { background: var(--blush, #ffe6ec); }
.ftab-wrap:nth-child(3n+3) .ftab-emoji { background: var(--cream, #fff3d6); }
.ftab.active .ftab-emoji { background: var(--primary) !important; }

.ftab-text { position: relative; z-index: 1; display: flex; align-items: center; gap: 7px; min-width: 0; }
.ftab .ft-count {
  display: inline-flex; align-items: center; justify-content: center; font-size: 10.5px; font-weight: 800;
  color: #fff; background: var(--primary); border-radius: 999px; padding: 1px 7px; width: fit-content; flex-shrink: 0;
}
.ftab.active .ft-count { background: var(--accent-dark, var(--primary-dark)); }
.ftab .ft-name { font-weight: 700; font-size: 13px; color: var(--navy); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.ft-caret {
  position: absolute; top: 50%; right: 10px; transform: translateY(-50%);
  width: 26px; height: 26px; border: none; border-radius: 50%;
  background: var(--primary-tint); color: var(--primary-dark);
  font-size: 12px; line-height: 1; cursor: pointer; display: grid; place-items: center;
  transition: transform 0.3s ease, background 0.3s ease, color 0.3s ease; z-index: 2;
}
.ft-caret:hover { background: #dfe7ff; }
.ftab-wrap.open .ft-caret { transform: translateY(-50%) rotate(180deg); background: var(--primary); color: #fff; }

.ftab-drop {
  position: absolute; top: calc(100% + 8px); left: 0; min-width: 280px;
  max-height: 50vh; overflow-y: auto; background: #ffffff; border-radius: 18px;
  box-shadow: 0 18px 45px rgba(8, 20, 60, 0.22), 0 4px 14px rgba(8, 20, 60, 0.12);
  padding: 10px; display: none; z-index: 500;
  border: 1px solid var(--border);
  isolation: isolate;
}
.ftab-drop.flip { left: auto; right: 0; }
.ftab-wrap.open .ftab-drop { display: block; animation: pop-up 0.2s ease; }
.ftab-wrap.open { z-index: 450; }

.fd-row {
  display: flex; align-items: center; gap: 11px; width: 100%; padding: 8px 10px;
  border: none; border-radius: 12px; background: none; cursor: pointer;
  font-family: var(--font-body); transition: background 0.2s ease;
}
.fd-row:hover { background: var(--primary-tint); }
.fd-row img { width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0; object-fit: cover; }
.fd-row .fd-name { flex: 1; text-align: left; font-weight: 700; font-size: 13.5px; color: var(--navy); }
.fd-row .fd-count { font-size: 12.5px; font-weight: 700; color: var(--primary); }
.fd-row .fd-new { font-size: 11px; font-weight: 800; background: var(--mint, #e2f6ef); color: #1d6a58; border-radius: 999px; padding: 2px 7px; }

.grid-toolbar { display: flex; align-items: center; justify-content: flex-end; gap: 14px; flex-wrap: wrap; margin: 14px 0 30px; }
.grid-sort {
  font-family: var(--font-display); font-weight: 700; font-size: 14px; color: var(--navy);
  background: #fff; border: 2px solid var(--border); border-radius: 999px;
  padding: 10px 38px 10px 20px; cursor: pointer; outline: none; appearance: none;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23084EC7' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 16px center;
  transition: border-color 0.2s ease;
}
.grid-sort:hover, .grid-sort:focus { border-color: var(--primary-soft); }

.pgrid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 44px 24px; }
/* premium photo cards (no more circles) */
.pcard{
  display:block; background:#fff; border-radius:22px; overflow:hidden;
  box-shadow:var(--shadow-sm); border:1.5px solid var(--border); text-align:left;
  transition:transform .3s ease, box-shadow .3s ease, border-color .3s ease;
}
.pcard.hide{ display:none; }
.pcard:hover{ transform:translateY(-6px); box-shadow:var(--shadow-lg); border-color:var(--primary-soft); }
.pcard .pimg{
  position:relative; width:100%; aspect-ratio:4/3; margin:0;
  border:none; border-radius:0; box-shadow:none; overflow:hidden;
}
.pcard .pimg img{ width:100%; height:100%; object-fit:cover; transition:transform .5s ease; }
.pcard:hover .pimg img{ transform:scale(1.07); }
.pcard h3{ font-size:18px; font-weight:800; color:var(--navy); margin:0; padding:16px 18px 18px; line-height:1.3; }

.cta-inline { margin: 50px 0; }
.cta-band.slim { padding: 46px 8%; }

.grid-empty { text-align: center; color: var(--text-light); padding: 40px 0; display: none; font-weight: 600; }
.grid-empty.on { display: block; }

/* ---------- Category sections: full-width intro on top, BIG 3-up card grid below ---------- */
.cat-section {
  display: block;                       /* full-width layout (like reference) */
  padding: 44px 0;
  border-top: 1px dashed var(--border);
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.5s ease, transform 0.5s ease;
}
.cat-section.in-view { opacity: 1; transform: translateY(0); }
.cat-section:first-child { border-top: none; padding-top: 8px; }
.cat-section.hide { display: none; }

.cat-section-head { display: flex; flex-direction: row; align-items: center; gap: 18px; margin-bottom: 30px; }
.cat-section-icon {
  width: 64px; height: 64px; border-radius: 50%; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center; font-size: 28px;
  background: var(--primary-tint); border: 2px dashed var(--primary-soft);
  opacity: 0; transform: scale(0.5) rotate(-15deg);
  transition: opacity 0.5s ease, transform 0.5s ease;
}
.cat-section.in-view .cat-section-icon { opacity: 1; transform: scale(1) rotate(0deg); }
.cat-section:nth-child(3n+1) .cat-section-icon { background: var(--mint, #e2f6ef); }
.cat-section:nth-child(3n+2) .cat-section-icon { background: var(--blush, #ffe6ec); }
.cat-section:nth-child(3n+3) .cat-section-icon { background: var(--cream, #fff3d6); }
.cat-section-copy h3 {
  font-size: 28px; font-weight: 800; color: var(--navy); margin: 2px 0 6px;
  opacity: 0; transform: translateX(-14px);
  transition: opacity 0.5s ease 0.1s, transform 0.5s ease 0.1s;
}
.cat-section.in-view .cat-section-copy h3 { opacity: 1; transform: translateX(0); }
.cat-section-copy p {
  font-size: 14.5px; color: var(--text-light); line-height: 1.55; max-width: 640px;
  opacity: 0; transform: translateX(-14px);
  transition: opacity 0.5s ease 0.2s, transform 0.5s ease 0.2s;
}
.cat-section.in-view .cat-section-copy p { opacity: 1; transform: translateX(0); }

.cat-section-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);   /* BIG cards, 3 across full width */
  gap: 34px 28px;
}

@media (max-width: 900px) {
  .cat-section-head { flex-direction: row; align-items: center; }
  .cat-section-copy p { max-width: none; }
  .cat-section-grid { grid-template-columns: repeat(2, 1fr); gap: 26px 22px; }
}
@media (max-width: 560px) {
  .cat-section { padding: 30px 0; }
  .cat-section-head { gap: 12px; margin-bottom: 20px; }
  .cat-section-copy h3 { font-size: 22px; }
  .cat-section-grid { grid-template-columns: 1fr; gap: 24px; }   /* one BIG image per row on phones */
}

/* ================= Colorful "Enriching Lives" intro hero ================= */
.act-hero-wrap { position: relative; }

.act-hero {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
  align-items: center;
  padding: 12px 0 12px;
  position: relative;
}

.act-hero-copy h1 {
  font-size: clamp(30px, 4vw, 46px);
  font-weight: 800;
  margin-bottom: 16px;
}
.act-hero-copy h1 .hl-accent { color: var(--accent-dark); }
.act-hero-copy p { color: var(--text); margin-bottom: 12px; max-width: 540px; }
.act-hero-copy .signoff {
  font-family: var(--font-display);
  font-weight: 700;
  color: var(--navy);
  margin-top: 12px;
}

.act-hero-visual {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 18px;
  position: relative;
}

/* ---- decorative background stickers around the hero visual ---- */
.deco-sticker {
  position: absolute;
  pointer-events: none;
  opacity: 0.55;
  z-index: 0;
  animation: sticker-float 5s ease-in-out infinite;
}
.deco-sticker.d1 { top: -34px; left: -18px; width: 46px; animation-delay: 0s; }
.deco-sticker.d2 { top: 12%; right: -28px; width: 34px; animation-delay: 1.2s; }
.deco-sticker.d3 { bottom: -22px; left: 30%; width: 30px; animation-delay: 0.6s; }
.deco-sticker.d4 { bottom: 18%; right: -22px; width: 26px; animation-delay: 2s; }
.deco-sticker.d5 { top: 40%; left: -30px; width: 22px; animation-delay: 1.6s; }
@keyframes sticker-float {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  50% { transform: translateY(-10px) rotate(6deg); }
}

/* ---- organic blob frame wrapping the hero visual ---- */
.act-shots-frame {
  position: relative;
  border-radius: 42% 58% 61% 39% / 46% 41% 59% 54%;
  padding: 22px;
  background: linear-gradient(150deg, var(--primary-tint) 0%, var(--mint, #e2f6ef) 55%, var(--cream, #fff3d6) 100%);
  box-shadow: var(--shadow-lg);
  border: 3px dashed rgba(255,255,255,0.8);
  animation: frame-morph 9s ease-in-out infinite;
}
@keyframes frame-morph {
  0%, 100% { border-radius: 42% 58% 61% 39% / 46% 41% 59% 54%; }
  50% { border-radius: 58% 42% 40% 60% / 55% 60% 40% 45%; }
}

.act-blobs {
  display: flex;
  flex-direction: column;
  gap: 18px;
  align-items: center;
}
.act-blob {
  width: 84px;
  height: 84px;
  border-radius: 40% 60% 55% 45% / 50% 45% 55% 50%;
  display: grid;
  place-items: center;
  font-size: 30px;
  animation: blob-float 6s ease-in-out infinite;
  box-shadow: var(--shadow-sm);
  border: 2.5px dashed rgba(255,255,255,0.7);
}
.act-blob.ab1 { background: var(--lavender); animation-delay: 0s; }
.act-blob.ab2 { background: var(--mint); animation-delay: 1s; border-radius: 55% 45% 40% 60% / 45% 55% 45% 55%; }
.act-blob.ab3 { background: var(--blush); animation-delay: 2s; border-radius: 60% 40% 45% 55% / 55% 50% 50% 45%; }
.act-blob.ab4 { background: var(--cream); animation-delay: 1.6s; border-radius: 45% 55% 60% 40% / 50% 45% 55% 50%; }

.act-shots {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  grid-template-rows: repeat(2, 1fr);
  gap: 16px;
  position: relative;
  z-index: 1;
}
.act-shots .shot {
  width: 100%;
  aspect-ratio: 1 / 1;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: var(--shadow-md);
  transition: transform 0.35s ease;
  position: relative;
}
.act-shots .shot-tall {
  aspect-ratio: auto;
  height: 100%;
  border-radius: 30px;
}
/* two tall shots side by side on the left, two stacked squares on the right */
.act-shots .shot-tall:nth-child(1) { grid-column: 1; grid-row: 1 / 3; }
.act-shots .shot-tall:nth-child(2) { grid-column: 2; grid-row: 1 / 3; }
.act-shots .shot:nth-child(3) { grid-column: 3; grid-row: 1; }
.act-shots .shot:nth-child(4) { grid-column: 3; grid-row: 2; }

.act-shots .shot img { width: 100%; height: 100%; object-fit: cover; }
.act-shots .shot:hover { transform: translateY(-4px); }
.act-shots .shot.accent-yellow { background: var(--accent); }

/* ---- Innovative treatment for the 4th (spotlight) shot: dashed ring + rotating name badge, content/image unchanged ---- */
.shot-spotlight {
  outline: 3px dashed var(--accent, #ffb020);
  outline-offset: 4px;
}
.shot-spotlight::after {
  content: "";
  position: absolute; inset: 0;
  background: linear-gradient(180deg, transparent 55%, rgba(8,20,60,0.72) 100%);
  pointer-events: none;
}
.shot-spotlight:hover { transform: translateY(-4px) rotate(-1.5deg); }
.spotlight-badge {
  position: absolute; left: 8px; right: 8px; bottom: 8px; z-index: 2;
  display: flex; align-items: center; gap: 6px;
  font-family: var(--font-display); font-weight: 800; font-size: 11.5px; color: #fff;
  line-height: 1.15;
}
.spotlight-dot {
  width: 7px; height: 7px; border-radius: 50%; background: var(--accent, #ffb020);
  box-shadow: 0 0 0 3px rgba(255,255,255,0.25);
  animation: pulse-dot 1.6s ease-in-out infinite;
  flex-shrink: 0;
}
@keyframes pulse-dot { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(0.75); } }


@media (max-width: 640px) {
  .act-shots { grid-template-columns: 1fr 1fr; }
  .act-shots .shot-tall:nth-child(2) { grid-column: 2; }
  .act-shots .shot:nth-child(3) { grid-column: 1; grid-row: 3; }
  .act-shots .shot:nth-child(4) { grid-column: 2; grid-row: 3; }
}

@media (max-width: 1020px) {
  .act-hero { grid-template-columns: 1fr; }
  .act-hero-visual { order: -1; }
}
@media (max-width: 640px) {
  .act-blobs { flex-direction: row; }
  .act-hero-visual { flex-direction: column; }
}

/* ---------- Animated "Explore Each Category" heading ---------- */
.cat-heading-reveal { text-align: center; }
.cat-heading-reveal h2 { display: inline-flex; gap: 12px; flex-wrap: wrap; justify-content: center; }
.cat-heading-word {
  display: inline-block;
  opacity: 0;
  transform: translateY(18px);
  animation: word-rise 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}
.cat-heading-word:nth-child(1) { animation-delay: 0.05s; }
.cat-heading-word:nth-child(2) { animation-delay: 0.18s; }
.cat-heading-word:nth-child(3) { animation-delay: 0.31s; }
@keyframes word-rise {
  to { opacity: 1; transform: translateY(0); }
}
.cat-heading-underline {
  display: block; width: 160px; height: 12px; margin: 4px auto 0;
  opacity: 0; animation: underline-draw 0.5s ease forwards; animation-delay: 0.5s;
}
@keyframes underline-draw {
  from { opacity: 0; transform: scaleX(0.4); }
  to { opacity: 1; transform: scaleX(1); }
}

@media (max-width: 1020px) {
  .pgrid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 860px) {
  .ftab-bar {
    flex-wrap: nowrap; overflow-x: auto; padding-bottom: 12px;
    scroll-snap-type: x proximity; -webkit-overflow-scrolling: touch;
    scrollbar-width: none; -ms-overflow-style: none;
  }
  .ftab-bar::-webkit-scrollbar { display: none; }
  .ftab-wrap { scroll-snap-align: start; }
  .ftab-drop { position: fixed; left: 4%; right: 4%; min-width: 0; max-height: 55vh; }
  .pgrid { grid-template-columns: repeat(2, 1fr); gap: 34px 16px; }
  .stat-strip { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
  .grid-toolbar { flex-direction: column; align-items: stretch; }
  .grid-sort { width: 100%; }
}
/* ===== Category picker — bigger, colourful cards (beeparty tiles + goldencarers clarity) ===== */
/* ===== Category filter pills — clean & premium ===== */
.cat-picker{ display:flex; flex-wrap:wrap; justify-content:center; gap:12px; padding:24px 0 12px; }
.catchip{
  --cc:#084ec7; --ccs:#eef2ff;
  display:inline-flex; align-items:center; gap:11px;
  background:#fff; border:2px solid var(--border); border-radius:999px;
  padding:8px 18px 8px 9px; cursor:pointer; font-family:var(--font-display);
  transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease, background .2s ease;
}
.catchip:hover{ transform:translateY(-3px); box-shadow:var(--shadow-sm); border-color:var(--cc); }
.catchip.active{ background:var(--cc); border-color:var(--cc); box-shadow:0 8px 20px rgba(8,20,60,.18); }
.cc-ico{
  width:40px; height:40px; min-width:40px; border-radius:50%;
  display:grid; place-items:center; font-size:19px; line-height:1; background:var(--ccs);
}
.catchip.active .cc-ico{ background:rgba(255,255,255,.22); }
.cc-name{ font-size:16.5px; font-weight:800; color:var(--navy); white-space:nowrap; }
.catchip.active .cc-name{ color:#fff; }
.cc-count{ font-size:13px; font-weight:800; color:#fff; background:var(--cc); border-radius:999px; padding:2px 10px; }
.catchip.active .cc-count{ background:rgba(255,255,255,.28); color:#fff; }

/* one colour per pill */
.cat-picker .catchip:nth-child(1){ --cc:#8b5cf6; --ccs:#efe9ff; }
.cat-picker .catchip:nth-child(2){ --cc:#ff6b6b; --ccs:#ffe6e3; }
.cat-picker .catchip:nth-child(3){ --cc:#12b3a6; --ccs:#d7f5f0; }
.cat-picker .catchip:nth-child(4){ --cc:#7c5cf0; --ccs:#ebe7ff; }
.cat-picker .catchip:nth-child(5){ --cc:#f0850f; --ccs:#fff0d6; }
.cat-picker .catchip:nth-child(6){ --cc:#ec5da8; --ccs:#ffe3f1; }
.cat-picker .catchip:nth-child(7){ --cc:#2fa9df; --ccs:#ddf0fd; }
.cat-picker .catchip:nth-child(8){ --cc:#2fae5a; --ccs:#dcf5e5; }
.cat-picker .catchip:nth-child(9){ --cc:#ff8a3d; --ccs:#ffece0; }

@media (max-width:640px){
  .cat-picker{ justify-content:flex-start; flex-wrap:nowrap; overflow-x:auto; padding-bottom:8px; }
  .cat-picker::-webkit-scrollbar{ display:none; }
  .catchip{ flex:0 0 auto; }
}

/* ===== Joy banner (wavy image) — same as index.php ===== */
.joy-banner{
  position:relative; overflow:hidden;
  width:100vw; max-width:100vw;
  margin:40px calc(50% - 50vw);   /* breaks out of the container → full width */
  min-height:400px;
  display:flex; align-items:center; justify-content:center; text-align:center;
  border-radius:0;                /* edge-to-edge, no rounded corners */
}
.joy-bg{ position:absolute; inset:0; width:100%; height:100%; object-fit:cover; z-index:0; }
.joy-overlay{ position:absolute; inset:0; z-index:1; background:linear-gradient(180deg, rgba(8,20,60,.58), rgba(8,20,60,.40)); }
.joy-inner{ position:relative; z-index:3; max-width:760px; padding:60px 6%; }
.joy-inner h2{ color:#fff; font-size:clamp(26px,3.6vw,40px); font-weight:800; margin-bottom:14px; }
.joy-inner p{ color:rgba(255,255,255,.92); margin-bottom:26px; }
.joy-wave{ position:absolute; left:0; width:100%; height:56px; z-index:2; display:block; }
.joy-wave path{ fill:var(--bg, #fbf7ff); }
.joy-wave-top{ top:-1px; }
.joy-wave-bot{ bottom:-1px; transform:rotate(180deg); }
@media (max-width:640px){ .joy-banner{ min-height:340px; } .joy-inner{ padding:46px 6%; } }
</style>

  <!-- ================= Category pills (premium) ================= -->
  <div class="container">
    <div class="cat-picker" id="ftab-bar">
      <button class="catchip active" data-cat="all">
        <span class="cc-ico">✨</span>
        <span class="cc-name">All</span>
        <span class="cc-count"><?php echo $totalItems; ?></span>
      </button>
<?php foreach ($CATALOG as $slug => $cat) : ?>
      <button class="catchip" data-cat="<?php echo $slug; ?>">
        <span class="cc-ico"><?php echo $cat['emoji']; ?></span>
        <span class="cc-name"><?php echo htmlspecialchars($cat['name']); ?></span>
        <span class="cc-count"><?php echo count($cat['items']); ?></span>
      </button>
<?php endforeach; ?>
    </div>

    <div class="crumb-bar">
      <a href="index.php">Home</a>
      <span class="sep">›</span>
      <span class="here">Programs</span>
    </div>
  </div>

  <!-- ================= Page heading + intro (colorful hero) ================= -->
  <section class="section-tight" style="padding-top: 12px;">
    <div class="container">

      <div class="act-hero">
        <div class="act-hero-copy">
          <h1>Enriching Lives Through <span class="hl-accent">Meaningful Engagements!</span></h1>
          <p>Growing older is not about slowing down—it's about embracing new opportunities, nurturing relationships, and finding joy in everyday moments. Our elder engagement activities are thoughtfully designed to promote physical wellness, mental stimulation, emotional well-being, and meaningful social connections.</p>
          <p>Whether it's discovering a new hobby, reconnecting with old passions, or simply sharing laughter with friends, each activity encourages seniors to remain active, confident, and connected to the community.</p>
          <p class="signoff">With The Jollity Events, it is more than just a pastime—it's an opportunity to laugh, learn, connect, and create lasting memories!</p>
          <div class="hero-cta" style="justify-content: flex-start; margin-top: 22px; margin-bottom: 0;">
            <a href="register.php" class="btn btn-accent">Register Now</a>
          </div>
        </div>

        <div class="act-hero-visual">
          <div class="act-blobs">
            <div class="act-blob ab1">🎨</div>
            <div class="act-blob ab2">🎵</div>
            <div class="act-blob ab3">🧘</div>
            <div class="act-blob ab4">🌼</div>
          </div>

          <div class="act-shots-frame">
            <!-- floating hand-drawn stickers, decorative only -->
            <svg class="deco-sticker d1" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M20 4 L23 16 L35 20 L23 24 L20 36 L17 24 L5 20 L17 16 Z" stroke="var(--accent, #ffb020)" stroke-width="2" stroke-linejoin="round"/>
            </svg>
            <svg class="deco-sticker d2" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="20" cy="20" r="9" stroke="var(--primary)" stroke-width="2.5"/>
              <circle cx="20" cy="20" r="3" fill="var(--primary)"/>
            </svg>
            <svg class="deco-sticker d3" viewBox="0 0 40 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M2 18 C 8 4, 16 4, 20 14 C 24 4, 32 4, 38 18" stroke="var(--primary)" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
            <svg class="deco-sticker d4" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="15" cy="15" r="12" stroke="var(--accent, #ffb020)" stroke-width="2"/>
            </svg>
            <svg class="deco-sticker d5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 2 L14 10 L22 12 L14 14 L12 22 L10 14 L2 12 L10 10 Z" fill="var(--primary-tint)" stroke="var(--primary)" stroke-width="1.5"/>
            </svg>

            <div class="act-shots">
              <div class="shot shot-tall">
                <img src="images/activities/dancing.jpg" alt="Group enjoying a dance activity" loading="lazy">
              </div>
              <div class="shot shot-tall">
                <img src="images/activities/comforting.jpg" alt="Group doing yoga" loading="lazy">
              </div>
              <div class="shot">
                <img src="images/activities/art-craft.jpg" alt="Painting activity" loading="lazy">
              </div>
              <!-- 4th shot: same image/content, innovative rotating spotlight treatment -->
              <div class="shot shot-spotlight" id="spotlight-shot">
                <img src="images/activities/karaoke.jpg" alt="Group singing together" loading="lazy">
                <span class="spotlight-badge"><span class="spotlight-dot"></span><span id="spotlight-text">Jamming Session</span></span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= Section heading (animated reveal) ================= -->
      <div class="section-head cat-heading-reveal" style="margin: 34px auto 6px;">
        <h2>
          <span class="cat-heading-word">Explore</span>
          <span class="cat-heading-word">Each</span>
          <span class="cat-heading-word hl-accent">Category</span>
        </h2>
        <svg class="cat-heading-underline" viewBox="0 0 220 14" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M2 9 Q 55 -2, 110 8 T 218 6" fill="none" stroke="var(--accent, #ffb020)" stroke-width="3" stroke-linecap="round"/>
        </svg>
      </div>

      <!-- ================= Category sections ================= -->
      <div id="cat-sections">
<?php
$catIndex = 0;
foreach ($CATALOG as $slug => $cat) :
    $catIndex++;
?>
        <section class="cat-section" id="sec-<?php echo $slug; ?>" data-cat="<?php echo $slug; ?>">
          <div class="cat-section-head">
            <div class="cat-section-icon"><?php echo $cat['emoji']; ?></div>
            <div class="cat-section-copy">
              <h3><?php echo htmlspecialchars($cat['name']); ?></h3>
              <p><?php echo htmlspecialchars($CATALOG_TAGLINE[$slug] ?? ''); ?></p>
            </div>
          </div>

          <div class="cat-section-grid">
<?php foreach ($cat['items'] as $item => $img) : ?>
            <a class="pcard" href="register.php?activity=<?php echo urlencode($cat['name']); ?>"
               data-cat="<?php echo $slug; ?>" data-title="<?php echo htmlspecialchars(strtolower($item)); ?>">
              <div class="pimg"><img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($item); ?>" loading="lazy"></div>
              <h3><?php echo htmlspecialchars($item); ?></h3>
            </a>
<?php endforeach; ?>
          </div>
        </section>

<?php if ($catIndex === 4) : ?>
        <section class="joy-banner cta-inline">
          <img class="joy-bg" src="images/activities/wave3.jpg" alt="Seniors enjoying a joyful activity together">
          <div class="joy-overlay"></div>

          <svg class="joy-wave joy-wave-top" viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M0 0 H1200 V30 Q1140 54 1080 34 T960 34 T840 34 T720 34 T600 34 T480 34 T360 34 T240 34 T120 34 T0 30 Z"/>
          </svg>
          <svg class="joy-wave joy-wave-bot" viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M0 0 H1200 V30 Q1140 54 1080 34 T960 34 T840 34 T720 34 T600 34 T480 34 T360 34 T240 34 T120 34 T0 30 Z"/>
          </svg>

          <div class="joy-inner">
            <h2>Ready to join or want to explore first?</h2>
            <p>Enrol your Parents and Grand-parents for Home or Group sessions with our trained and thoughtful artists.</p>
            <a href="register.php" class="btn btn-accent">Register Now</a>
          </div>
        </section>
<?php endif; ?>
<?php endforeach; ?>
      </div>

      <div class="grid-empty" id="grid-empty">No activities found in this category.</div>
    </div>
  </section>

  <!-- ================= CTA band ================= -->
  <section class="section-tight">
    <div class="container">
      <section class="joy-banner reveal">
        <img class="joy-bg" src="images/activities/wave3.jpg" alt="Seniors laughing and connecting together">
        <div class="joy-overlay"></div>

        <svg class="joy-wave joy-wave-top" viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M0 0 H1200 V30 Q1140 54 1080 34 T960 34 T840 34 T720 34 T600 34 T480 34 T360 34 T240 34 T120 34 T0 30 Z"/>
        </svg>
        <svg class="joy-wave joy-wave-bot" viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M0 0 H1200 V30 Q1140 54 1080 34 T960 34 T840 34 T720 34 T600 34 T480 34 T360 34 T240 34 T120 34 T0 30 Z"/>
        </svg>

        <div class="joy-inner">
          <h2>With The Jollity Events, it's an opportunity to laugh, learn, connect, and create lasting memories!</h2>
          <a href="register.php" class="btn btn-accent">Register Now</a>
        </div>
      </section>
    </div>
  </section>

<script>
/* ================= Activities page behaviour (self-contained) ================= */
(function () {
  var sections = Array.prototype.slice.call(document.querySelectorAll(".cat-section"));
  if (!sections.length) return;

  var empty = document.getElementById("grid-empty");
  var tabs = Array.prototype.slice.call(document.querySelectorAll(".catchip"));
  var state = { cat: "all" };

  function applySections() {
    var anyVisible = false;
    sections.forEach(function (sec) {
      var match = state.cat === "all" || sec.dataset.cat === state.cat;
      sec.classList.toggle("hide", !match);
      if (match) anyVisible = true;
    });
    if (empty) empty.classList.toggle("on", !anyVisible);
  }

  function selectCat(cat, opts) {
    opts = opts || {};
    state.cat = cat;
    tabs.forEach(function (t) { t.classList.toggle("active", t.dataset.cat === cat); });
    applySections();
    if (opts.scroll !== false && cat !== "all") {
      var target = document.getElementById("sec-" + cat);
      if (target) setTimeout(function () { target.scrollIntoView({ behavior: "smooth", block: "start" }); }, 80);
    }
  }

  tabs.forEach(function (t) {
    t.addEventListener("click", function () { selectCat(t.dataset.cat); });
  });

  function closeDrops() {
    document.querySelectorAll(".ftab-wrap.open").forEach(function (w) {
      w.classList.remove("open");
      var caret = w.querySelector(".ft-caret");
      if (caret) caret.setAttribute("aria-expanded", "false");
    });
  }

  document.querySelectorAll(".ft-caret").forEach(function (caret) {
    caret.addEventListener("click", function (e) {
      e.stopPropagation();
      var wrap = caret.closest(".ftab-wrap");
      var wasOpen = wrap.classList.contains("open");
      closeDrops();
      if (wasOpen) return;
      wrap.classList.add("open");
      caret.setAttribute("aria-expanded", "true");

      var drop = wrap.querySelector(".ftab-drop");
      if (!drop) return;
      if (window.innerWidth <= 860) {
        drop.style.top = wrap.getBoundingClientRect().bottom + 8 + "px";
      } else {
        drop.style.top = "";
        drop.classList.remove("flip");
        if (drop.getBoundingClientRect().right > window.innerWidth - 12) drop.classList.add("flip");
      }
    });
  });

  document.addEventListener("click", function (e) {
    if (!e.target.closest(".ftab-wrap")) closeDrops();
  });
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closeDrops();
  });

  document.querySelectorAll(".fd-row").forEach(function (row) {
    row.addEventListener("click", function () {
      closeDrops();
      var cat = row.dataset.cat;
      selectCat(cat, { scroll: false });
      var item = row.dataset.item;
      var target = null;
      if (item) {
        var sec = document.getElementById("sec-" + cat);
        if (sec) {
          var card = sec.querySelector('.pcard[data-title="' + item.toLowerCase().replace(/"/g, '\\"') + '"]');
          target = card || sec;
        }
      } else {
        target = document.getElementById("sec-" + cat);
      }
      if (target) setTimeout(function () { target.scrollIntoView({ behavior: "smooth", block: "center" }); }, 120);
    });
  });

  function applyCatalogHash() {
    var id = window.location.hash.replace("#", "");
    if (id && tabs.some(function (t) { return t.dataset.cat === id; })) selectCat(id);
  }
  window.addEventListener("hashchange", applyCatalogHash);
  applySections();
  applyCatalogHash();

  /* ---- Fade sections in as they scroll into view ---- */
  var sectionObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add("in-view");
        sectionObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12, rootMargin: "0px 0px -60px 0px" });
  sections.forEach(function (sec) { sectionObserver.observe(sec); });

  /* ---- Rotating "Today's Spotlight" label on the 4th hero shot (image/content unchanged) ---- */
  var spotlightText = document.getElementById("spotlight-text");
  if (spotlightText) {
    var pool = <?php echo json_encode($spotlightPool); ?>;
    var idx = 0;
    setInterval(function () {
      idx = (idx + 1) % pool.length;
      spotlightText.style.opacity = "0";
      setTimeout(function () {
        spotlightText.textContent = pool[idx];
        spotlightText.style.opacity = "1";
      }, 250);
    }, 2600);
    spotlightText.style.transition = "opacity 0.25s ease";
  }
})();
</script>

<?php include 'includes/footer.php'; ?>
