<?php
/**
 * Savié Amour — application configuration.
 *
 * Copy this file to config/config.php (the installer does this for you)
 * and adjust the values for your environment. Everything that the store
 * owner should be able to change lives in the admin panel (Settings);
 * this file only holds server-level configuration.
 */
return [
    // Public URL of the site without trailing slash, e.g. https://www.savieamour.com
    'app_url'   => 'http://localhost:8000',

    // production | development  (development shows detailed errors)
    'app_env'   => 'production',

    // Default timezone for dates shown in the store and admin.
    'timezone'  => 'Asia/Kolkata',

    // Random 64-char string used for signing tokens. The installer generates one.
    'app_key'   => 'change-me-to-a-long-random-string',

    'db' => [
        'host'     => '127.0.0.1',
        'port'     => 3306,
        'database' => 'savie_amour',
        'username' => 'root',
        'password' => '',
        'charset'  => 'utf8mb4',
    ],

    // Session cookie settings.
    'session' => [
        'name'     => 'savie_session',
        'lifetime' => 7200,       // seconds of inactivity
        'secure'   => null,       // null = auto-detect HTTPS
    ],

    // Maximum upload size for images (bytes).
    'upload_max_bytes' => 5 * 1024 * 1024,
];
