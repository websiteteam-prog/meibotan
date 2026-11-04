<?php
/**
 * Before & after gallery.
 *
 * TODO: The images below are illustrations. Replace them with photos of your
 * own completed jobs (same angle before and after, 4:3 landscape, about
 * 1200 x 900px), fill in the suburb, and set 'sample' => false.
 *
 * tags:     used by the gallery filter buttons (terracotta, concrete,
 *           ridge-capping, painting, repairs).
 * services: service page keys this project is shown on.
 */
defined('ROOT_PATH') || exit;

return [
    [
        'title' => 'Terracotta roof restoration',
        'location' => '',
        'summary' => 'Weathered, lichen-covered terracotta cleaned, ridge caps re-bedded and repointed, and the roof brought back to a rich, even colour.',
        'tags' => ['terracotta', 'ridge-capping'],
        'services' => ['roof-restoration-adelaide', 'tiled-roof-restoration-adelaide'],
        'before' => 'assets/img/gallery/project-1-before.png',
        'after' => 'assets/img/gallery/project-1-after.jpeg',
        'sample' => true,
    ],
    [
        'title' => 'Concrete tile restoration in charcoal',
        'location' => '',
        'summary' => 'Faded concrete tiles pressure cleaned, repaired, sealed and finished in a deep charcoal for a sharp, modern look.',
        'tags' => ['concrete', 'painting'],
        'services' => ['roof-restoration-adelaide', 'roof-painting-adelaide', 'tiled-roof-restoration-adelaide'],
        'before' => 'assets/img/gallery/project-2-before.png',
        'after' => 'assets/img/gallery/project-2-after.jpeg',
        'sample' => true,
    ],
    [
        'title' => 'Concrete roof clean & repaint',
        'location' => '',
        'summary' => 'Heavy lichen growth removed with a high-pressure clean, followed by sealer and premium grey-green top coats.',
        'tags' => ['concrete', 'painting'],
        'services' => ['roof-cleaning-adelaide', 'roof-painting-adelaide'],
        'before' => 'assets/img/gallery/project-3-before.jpg',
        'after' => 'assets/img/gallery/project-3-after.jpg',
        'sample' => true,
    ],
    [
        'title' => 'Ridge cap re-bedding & repointing',
        'location' => '',
        'summary' => 'Cracked, crumbling ridge mortar replaced with fresh bedding and colour-matched flexible pointing.',
        'tags' => ['terracotta', 'ridge-capping', 'repairs'],
        'services' => ['ridge-capping-adelaide', 'roof-repairs-adelaide'],
        'before' => 'assets/img/gallery/project-4-before.jpg',
        'after' => 'assets/img/gallery/project-4-after.jpg',
        'sample' => true,
    ],
    [
        'title' => 'Concrete roof restored in light grey',
        'location' => '',
        'summary' => 'A tired, lichen-covered concrete roof cleaned, repointed and coated in a light grey that reflects more summer heat.',
        'tags' => ['concrete', 'painting', 'ridge-capping'],
        'services' => ['roof-painting-adelaide', 'roof-restoration-adelaide', 'roof-cleaning-adelaide'],
        'before' => 'assets/img/gallery/project-5-before.jpg',
        'after' => 'assets/img/gallery/project-5-after.jpg',
        'sample' => true,
    ],
    [
        'title' => 'Broken tile replacement & clean',
        'location' => '',
        'summary' => 'Cracked and broken terracotta tiles replaced with matching tiles, then the whole roof cleaned to a uniform finish.',
        'tags' => ['terracotta', 'repairs'],
        'services' => ['roof-tile-replacement-adelaide', 'roof-repairs-adelaide', 'roof-cleaning-adelaide'],
        'before' => 'assets/img/gallery/project-6-before.jpg',
        'after' => 'assets/img/gallery/project-6-after.jpg',
        'sample' => true,
    ],
];
