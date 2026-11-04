<?php
/**
 * AF Prestige Roofing: site settings.
 *
 * Everything on the website (header, footer, contact page, Google schema
 * markup and enquiry emails) reads from this file, so update it once and the
 * whole site follows. Values marked TODO must be checked before going live.
 */
defined('ROOT_PATH') || exit;

return [
    'site_name'  => 'AF Prestige Roofing',
    'tagline'    => 'Premium Roof Restoration in Adelaide',
    'base_url'   => 'https://afproofing.com.au', // No trailing slash.

    // ---------------------------------------------------------------------
    // Contact details. TODO: replace the phone number with your real one.
    // ---------------------------------------------------------------------
    'phone' => '0400 000 000',
    'email' => 'info@afproofing.com.au',

    // Where website enquiries are delivered (can differ from the public email).
    'enquiry_to' => 'info@afproofing.com.au',
    // Sender address for enquiry emails. Use an address on your own domain so
    // the emails pass SPF/DKIM checks and don't land in spam.
    'mail_from'  => 'website@afproofing.com.au',

    // Shown in the footer and schema when filled in.
    'abn'     => '', // e.g. '12 345 678 901'
    'licence' => '', // e.g. 'BLD 123456'

    // Leave 'street' empty to operate as a service-area business (recommended
    // if customers don't visit you). Must match your Google Business Profile.
    'address' => [
        'street'   => '',
        'locality' => 'Adelaide',
        'region'   => 'SA',
        'postcode' => '',
        'country'  => 'AU',
    ],
    'geo' => ['lat' => -34.9285, 'lng' => 138.6007],

    // How far from the Adelaide CBD you travel for work (in km). Used in the
    // service-area wording across the site and in the Google schema markup.
    'service_radius_km' => 100,

    // TODO: confirm your opening hours (used on the contact page and in schema).
    'hours' => [
        ['label' => 'Monday – Friday', 'days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'], 'open' => '07:00', 'close' => '17:00'],
        ['label' => 'Saturday', 'days' => ['Saturday'], 'open' => '08:00', 'close' => '12:00'],
    ],
    'hours_note' => 'Sunday: closed',

    // Social profiles: links appear in the footer once filled in.
    'social' => [
        'facebook'  => '',
        'instagram' => '',
        'google'    => '', // Your Google Business Profile / Maps URL.
    ],
    // "Write a review" link from your Google Business Profile.
    'google_review_url' => '',

    // Analytics & Search Console (optional).
    'ga4_id'                   => '', // e.g. 'G-XXXXXXXXXX'
    'google_site_verification' => '',

    // Enquiry form.
    'log_enquiries' => true,                         // Keep a backup copy in /storage.
    'rate_limit'    => ['max' => 5, 'window' => 3600], // Max submissions per IP per window (seconds).
];
