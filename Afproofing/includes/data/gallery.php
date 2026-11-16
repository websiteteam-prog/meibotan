<?php
/**
 * Before & after gallery projects.
 *
 * Shown on the Gallery page (all projects), the homepage (first 2) and the
 * service pages (projects listed for that service).
 *
 * To add a project, copy one block and change:
 *   title     what was done (used to describe the photos for Google and screen readers)
 *   location  suburb, e.g. 'Glenelg' (optional)
 *   services  service pages this project appears on (keys from includes/data/services.php)
 *   before    photo before the work
 *   after     photo after the work, taken from the same angle
 *
 * Photos: 4:3 landscape, about 1200 x 900px, saved in assets/img/gallery/.
 */
defined('ROOT_PATH') || exit;

return [
    [
        'title'    => 'Terracotta roof restoration',
        'location' => '',
        'services' => ['roof-restoration-adelaide', 'tiled-roof-restoration-adelaide'],
        'before'   => 'assets/img/gallery/project-1-before.png',
        'after'    => 'assets/img/gallery/project-1-after.jpeg',
    ],
    [
        'title'    => 'Concrete tile restoration in charcoal',
        'location' => '',
        'services' => ['roof-restoration-adelaide', 'roof-painting-adelaide', 'tiled-roof-restoration-adelaide'],
        'before'   => 'assets/img/gallery/project-2-before.png',
        'after'    => 'assets/img/gallery/project-2-after.jpeg',
    ],
    [
        'title'    => 'Concrete roof clean & repaint',
        'location' => '',
        'services' => ['roof-cleaning-adelaide', 'roof-painting-adelaide'],
        'before'   => 'assets/img/gallery/project-3-before.jpg',
        'after'    => 'assets/img/gallery/project-3-after.jpg',
    ],
    [
        'title'    => 'Ridge cap re-bedding & repointing',
        'location' => '',
        'services' => ['ridge-capping-adelaide', 'roof-repairs-adelaide'],
        'before'   => 'assets/img/gallery/project-4-before.jpg',
        'after'    => 'assets/img/gallery/project-4-after.jpg',
    ],
    [
        'title'    => 'Concrete roof restored in light grey',
        'location' => '',
        'services' => ['roof-painting-adelaide', 'roof-restoration-adelaide', 'roof-cleaning-adelaide'],
        'before'   => 'assets/img/gallery/project-5-before.jpg',
        'after'    => 'assets/img/gallery/project-5-after.jpg',
    ],
    [
        'title'    => 'Broken tile replacement & clean',
        'location' => '',
        'services' => ['roof-tile-replacement-adelaide', 'roof-repairs-adelaide', 'roof-cleaning-adelaide'],
        'before'   => 'assets/img/gallery/project-6-before.jpg',
        'after'    => 'assets/img/gallery/project-6-after.jpg',
    ],
];
