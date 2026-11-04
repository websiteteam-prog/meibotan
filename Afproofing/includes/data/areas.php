<?php
/**
 * Service areas, grouped by region. Shown on the Service Areas page, the
 * homepage and in Google schema markup. Add or remove suburbs freely.
 */
defined('ROOT_PATH') || exit;

return [
    [
        'name'    => 'Northern Suburbs',
        'blurb'   => 'From Mawson Lakes to Gawler, including the Tea Tree Gully and Salisbury areas.',
        'suburbs' => ['Salisbury', 'Elizabeth', 'Mawson Lakes', 'Modbury', 'Golden Grove', 'Tea Tree Gully', 'Para Hills', 'Ingle Farm', 'Greenwith', 'Gawler'],
    ],
    [
        'name'    => 'Southern Suburbs',
        'blurb'   => 'Marion through to the Fleurieu fringe, including the coastal suburbs.',
        'suburbs' => ['Marion', 'Brighton', 'Hallett Cove', 'Reynella', 'Morphett Vale', 'Happy Valley', 'Aberfoyle Park', 'Christies Beach', 'Noarlunga', 'Seaford'],
    ],
    [
        'name'    => 'Eastern Suburbs',
        'blurb'   => 'Character homes and established streets from Norwood to the foothills.',
        'suburbs' => ['Norwood', 'Burnside', 'Kensington', 'Magill', 'Campbelltown', 'Rostrevor', 'Athelstone', 'Payneham', 'Newton', 'Glen Osmond'],
    ],
    [
        'name'    => 'Western Suburbs',
        'blurb'   => 'Coastal and inner-west suburbs from Glenelg to Port Adelaide.',
        'suburbs' => ['Glenelg', 'Henley Beach', 'Grange', 'West Lakes', 'Seaton', 'Findon', 'Woodville', 'Fulham Gardens', 'Semaphore', 'Port Adelaide'],
    ],
    [
        'name'    => 'Inner Adelaide',
        'blurb'   => 'The CBD, North Adelaide and the leafy inner-ring suburbs.',
        'suburbs' => ['Adelaide CBD', 'North Adelaide', 'Unley', 'Prospect', 'Goodwood', 'Parkside', 'Hyde Park', 'Walkerville', 'Mile End', 'Thebarton'],
    ],
    [
        'name'    => 'Adelaide Hills',
        'blurb'   => 'Hills homes that face more rain, leaf litter and moss growth.',
        'suburbs' => ['Stirling', 'Aldgate', 'Crafers', 'Bridgewater', 'Hahndorf', 'Mount Barker', 'Littlehampton', 'Woodside'],
    ],
];
