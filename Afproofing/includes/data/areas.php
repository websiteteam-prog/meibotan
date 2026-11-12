<?php
/**
 * Service areas, grouped by region. Shown on the Service Areas page, the
 * homepage, the quote form's suburb suggestions and in Google schema markup.
 *
 * 'group' is either 'metro' (metropolitan Adelaide) or 'regional' (country
 * towns around Adelaide). These are examples, not a limit: the business also
 * travels further across South Australia. Add or remove suburbs and towns freely.
 */
defined('ROOT_PATH') || exit;

return [
    // Metropolitan Adelaide ------------------------------------------------
    [
        'name'    => 'Inner Adelaide',
        'group'   => 'metro',
        'blurb'   => 'The CBD, North Adelaide and the leafy inner-ring suburbs.',
        'suburbs' => ['Adelaide CBD', 'North Adelaide', 'Unley', 'Prospect', 'Goodwood', 'Parkside', 'Hyde Park', 'Walkerville', 'Mile End', 'Thebarton'],
    ],
    [
        'name'    => 'Northern Suburbs',
        'group'   => 'metro',
        'blurb'   => 'From Mawson Lakes to Munno Para, including the Tea Tree Gully and Salisbury areas.',
        'suburbs' => ['Salisbury', 'Elizabeth', 'Mawson Lakes', 'Modbury', 'Golden Grove', 'Tea Tree Gully', 'Para Hills', 'Ingle Farm', 'Greenwith', 'Munno Para'],
    ],
    [
        'name'    => 'Southern Suburbs',
        'group'   => 'metro',
        'blurb'   => 'Marion through to Seaford, including the coastal suburbs.',
        'suburbs' => ['Marion', 'Brighton', 'Hallett Cove', 'Reynella', 'Morphett Vale', 'Happy Valley', 'Aberfoyle Park', 'Christies Beach', 'Noarlunga', 'Seaford'],
    ],
    [
        'name'    => 'Eastern Suburbs',
        'group'   => 'metro',
        'blurb'   => 'Character homes and established streets from Norwood to the foothills.',
        'suburbs' => ['Norwood', 'Burnside', 'Kensington', 'Magill', 'Campbelltown', 'Rostrevor', 'Athelstone', 'Payneham', 'Newton', 'Glen Osmond'],
    ],
    [
        'name'    => 'Western Suburbs',
        'group'   => 'metro',
        'blurb'   => 'Coastal and inner-west suburbs from Glenelg to Port Adelaide.',
        'suburbs' => ['Glenelg', 'Henley Beach', 'Grange', 'West Lakes', 'Seaton', 'Findon', 'Woodville', 'Fulham Gardens', 'Semaphore', 'Port Adelaide'],
    ],

    // Regional areas around Adelaide ----------------------------------------
    [
        'name'    => 'Adelaide Hills',
        'group'   => 'regional',
        'blurb'   => 'Hills homes that face more rain, leaf litter and moss growth.',
        'suburbs' => ['Stirling', 'Aldgate', 'Crafers', 'Bridgewater', 'Hahndorf', 'Mount Barker', 'Littlehampton', 'Nairne', 'Woodside', 'Lobethal', 'Strathalbyn'],
    ],
    [
        'name'    => 'Gawler & Barossa',
        'group'   => 'regional',
        'blurb'   => 'Gawler, the Barossa Valley and nearby country towns to the north.',
        'suburbs' => ['Gawler', 'Lyndoch', 'Williamstown', 'Tanunda', 'Nuriootpa', 'Angaston', 'Freeling', 'Kapunda'],
    ],
    [
        'name'    => 'Fleurieu Peninsula',
        'group'   => 'regional',
        'blurb'   => 'McLaren Vale and Aldinga through to Victor Harbor and Goolwa.',
        'suburbs' => ['McLaren Vale', 'Willunga', 'Aldinga Beach', 'Sellicks Beach', 'Normanville', 'Yankalilla', 'Victor Harbor', 'Port Elliot', 'Goolwa'],
    ],
    [
        'name'    => 'Murray Bridge & Murraylands',
        'group'   => 'regional',
        'blurb'   => 'Murray Bridge and the river towns east of the Hills.',
        'suburbs' => ['Murray Bridge', 'Mannum', 'Callington', 'Monarto', 'Langhorne Creek'],
    ],
    [
        'name'    => 'Adelaide Plains',
        'group'   => 'regional',
        'blurb'   => 'The growing towns and acreage north of the city.',
        'suburbs' => ['Virginia', 'Angle Vale', 'Two Wells', 'Lewiston', 'Mallala'],
    ],
];
