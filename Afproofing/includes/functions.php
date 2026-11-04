<?php
/**
 * Small helpers shared by every page.
 */
defined('ROOT_PATH') || exit;

/** Escape a value for safe output in HTML. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Read a setting from config.php using dot notation, e.g. config('address.locality'). */
function config(string $key, $default = null)
{
    $value = $GLOBALS['config'];
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

/** Root-relative link to a page, e.g. url('services/roof-painting-adelaide'). */
function url(string $path = ''): string
{
    return BASE_PATH . '/' . ltrim($path, '/');
}

/** Full URL including the domain, for canonical tags, sitemaps and schema. */
function absolute_url(string $path = ''): string
{
    return rtrim((string) config('base_url'), '/') . '/' . ltrim($path, '/');
}

/** Link to a static file with a version stamp so browsers pick up changes. */
function asset(string $path): string
{
    $file = ROOT_PATH . '/' . ltrim($path, '/');
    return url($path) . (is_file($file) ? '?v=' . filemtime($file) : '');
}

/** Inline reference to an icon in assets/img/icons.svg. */
function icon(string $name, string $class = ''): string
{
    return '<svg class="icon' . ($class !== '' ? ' ' . e($class) : '') . '" aria-hidden="true" focusable="false">'
        . '<use href="' . e(asset('assets/img/icons.svg')) . '#' . e($name) . '"></use></svg>';
}

/** Width/height attributes for an image so the browser can reserve space. */
function img_size(string $path): string
{
    $info = @getimagesize(ROOT_PATH . '/' . ltrim($path, '/'));
    return $info ? 'width="' . $info[0] . '" height="' . $info[1] . '"' : '';
}

function phone_href(): string
{
    $digits = preg_replace('/\D+/', '', (string) config('phone'));
    if (str_starts_with($digits, '0')) {
        $digits = '61' . substr($digits, 1);
    }
    return 'tel:+' . $digits;
}

function email_href(): string
{
    return 'mailto:' . config('email');
}

/** International phone format for schema markup, e.g. +61 400 000 000. */
function phone_international(): string
{
    $phone = trim((string) config('phone'));
    return str_starts_with($phone, '0') ? '+61 ' . substr($phone, 1) : $phone;
}

/** True when the current page is $path (or, with $section, any page below it). */
function is_current(string $path, bool $section = false): bool
{
    $path = trim($path, '/');
    if ($path === '') {
        return CURRENT_PATH === '' || CURRENT_PATH === 'index';
    }
    return CURRENT_PATH === $path || ($section && str_starts_with(CURRENT_PATH, $path . '/'));
}

/** Attributes for a navigation link so the current page is highlighted. */
function nav_attrs(string $path, bool $section = false): string
{
    if (is_current($path)) {
        return ' class="is-active" aria-current="page"';
    }
    return is_current($path, $section) ? ' class="is-active"' : '';
}

/** Render a template from includes/partials with the given variables. */
function partial(string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    include ROOT_PATH . '/includes/partials/' . $name . '.php';
}

function service_url(string $slug): string
{
    return url('services/' . $slug);
}

/** Gallery projects linked to a service, falling back to the first few projects. */
function gallery_for_service(string $slug, int $limit = 2): array
{
    $matches = array_values(array_filter($GLOBALS['gallery'], fn ($p) => in_array($slug, $p['services'], true)));
    return array_slice($matches ?: $GLOBALS['gallery'], 0, $limit);
}

/** Opening hours formatted for display, e.g. 7:00am – 5:00pm. */
function format_hours(string $open, string $close): string
{
    $fmt = fn ($t) => strtolower(date('g:ia', strtotime($t)));
    return $fmt($open) . ' – ' . $fmt($close);
}

// -------------------------------------------------------------------------
// Structured data (schema.org JSON-LD) for Google.
// -------------------------------------------------------------------------

function json_ld(array $data): string
{
    $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
    return '<script type="application/ld+json">' . $json . '</script>' . "\n";
}

function business_schema(): array
{
    $address = array_filter([
        '@type'           => 'PostalAddress',
        'streetAddress'   => config('address.street'),
        'addressLocality' => config('address.locality'),
        'addressRegion'   => config('address.region'),
        'postalCode'      => config('address.postcode'),
        'addressCountry'  => config('address.country'),
    ]);

    $areas = [['@type' => 'City', 'name' => 'Adelaide']];
    foreach ($GLOBALS['areas'] as $region) {
        foreach ($region['suburbs'] as $suburb) {
            $areas[] = ['@type' => 'Place', 'name' => $suburb . ' SA'];
        }
    }

    $hours = [];
    foreach (config('hours', []) as $row) {
        $hours[] = [
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => $row['days'],
            'opens'     => $row['open'],
            'closes'    => $row['close'],
        ];
    }

    $offers = [];
    foreach ($GLOBALS['services'] as $slug => $service) {
        $offers[] = [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $service['name'], 'url' => absolute_url('services/' . $slug)],
        ];
    }

    return array_filter([
        '@type'                     => 'RoofingContractor',
        '@id'                       => absolute_url('#business'),
        'name'                      => config('site_name'),
        'description'               => 'Roof restoration specialists for terracotta and concrete tiled roofs across Adelaide and surrounding suburbs.',
        'url'                       => absolute_url(),
        'telephone'                 => phone_international(),
        'email'                     => config('email'),
        'logo'                      => absolute_url('assets/img/logo.png'),
        'image'                     => absolute_url('assets/img/og-image.jpg'),
        'address'                   => $address,
        'geo'                       => ['@type' => 'GeoCoordinates', 'latitude' => config('geo.lat'), 'longitude' => config('geo.lng')],
        'areaServed'                => $areas,
        'openingHoursSpecification' => $hours,
        'hasOfferCatalog'           => ['@type' => 'OfferCatalog', 'name' => 'Roofing services', 'itemListElement' => $offers],
        'sameAs'                    => array_values(array_filter(config('social', []))),
        'taxID'                     => config('abn') ?: null,
    ]);
}

function website_schema(): array
{
    return [
        '@type'     => 'WebSite',
        '@id'       => absolute_url('#website'),
        'url'       => absolute_url(),
        'name'      => config('site_name'),
        'publisher' => ['@id' => absolute_url('#business')],
        'inLanguage' => 'en-AU',
    ];
}

/** @param array $crumbs list of [name, path] pairs, excluding Home. */
function breadcrumb_schema(array $crumbs): array
{
    $items = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => absolute_url()]];
    foreach ($crumbs as $i => [$name, $path]) {
        $items[] = ['@type' => 'ListItem', 'position' => $i + 2, 'name' => $name, 'item' => absolute_url($path)];
    }
    return ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
}

function faq_schema(array $faqs): array
{
    return [
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(fn ($f) => [
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], $faqs),
    ];
}

// -------------------------------------------------------------------------
// Enquiry form helpers.
// -------------------------------------------------------------------------

/** Secret used to sign form tokens; created automatically on first use. */
function form_secret(): string
{
    static $secret = null;
    if ($secret !== null) {
        return $secret;
    }
    $file = ROOT_PATH . '/storage/.form-secret';
    $secret = is_file($file) ? trim((string) file_get_contents($file)) : '';
    if (strlen($secret) < 32) {
        $secret = bin2hex(random_bytes(32));
        if (@file_put_contents($file, $secret, LOCK_EX) === false) {
            // Storage isn't writable: fall back to a stable, install-specific value.
            $secret = hash('sha256', ROOT_PATH . php_uname('n') . config('base_url'));
        }
    }
    return $secret;
}

/** Signed timestamp that proves a form came from this site and wasn't filled in by a bot instantly. */
function form_token(): string
{
    $time = (string) time();
    return $time . '.' . hash_hmac('sha256', $time, form_secret());
}

function verify_form_token(string $token, int $minAge = 2, int $maxAge = 86400): bool
{
    [$time, $signature] = array_pad(explode('.', $token, 2), 2, '');
    if (!ctype_digit($time) || !hash_equals(hash_hmac('sha256', $time, form_secret()), $signature)) {
        return false;
    }
    $age = time() - (int) $time;
    return $age >= $minAge && $age <= $maxAge;
}

/** Fetch (and clear) errors saved after a form submission without JavaScript. */
function flash_pull(): array
{
    if (session_status() === PHP_SESSION_NONE && isset($_COOKIE[session_name()])) {
        session_start();
    }
    if (empty($_SESSION['enquiry_flash'])) {
        return [];
    }
    $flash = $_SESSION['enquiry_flash'];
    unset($_SESSION['enquiry_flash']);
    return $flash;
}

/** Previously submitted value for a field in the given form. */
function old(string $form, string $field, string $default = ''): string
{
    $flash = $GLOBALS['flash'];
    return ($flash['form'] ?? '') === $form ? (string) ($flash['old'][$field] ?? $default) : $default;
}

/** Validation message for a field in the given form, if any. */
function field_error(string $form, string $field): string
{
    $flash = $GLOBALS['flash'];
    return ($flash['form'] ?? '') === $form ? (string) ($flash['errors'][$field] ?? '') : '';
}

/** Choices offered in the enquiry form's "service" dropdown. */
function service_options(): array
{
    $options = array_map(fn ($s) => $s['name'], $GLOBALS['services']);
    $options['not-sure'] = 'Not sure, I need advice';
    return $options;
}

function roof_type_options(): array
{
    return ['terracotta' => 'Terracotta tiles', 'concrete' => 'Concrete tiles', 'not-sure' => 'Not sure'];
}
