<?php
/**
 * Handles quote/enquiry form submissions.
 *
 * Validates the input, filters spam (hidden honeypot field, signed timestamp
 * and a per-IP rate limit), emails the enquiry to config('enquiry_to') and
 * keeps a backup copy in storage/enquiries.log.
 *
 * Responds with JSON for JavaScript submissions; otherwise redirects to the
 * thank-you page, or back to the form with errors.
 */
require_once __DIR__ . '/includes/bootstrap.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: ' . url('contact'), true, 303);
    exit;
}

$wantsJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

/** Single-line text: strip control characters (including line breaks) and limit length. */
function clean_line($value, int $max): string
{
    $value = is_string($value) ? $value : '';
    $value = preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $value) ?? '';
    return mb_substr(trim(preg_replace('/\s+/u', ' ', $value) ?? ''), 0, $max);
}

/** Multi-line text: keep line breaks, strip other control characters. */
function clean_text($value, int $max): string
{
    $value = is_string($value) ? str_replace("\r\n", "\n", $value) : '';
    $value = preg_replace('/[\x00-\x09\x0B-\x1F\x7F]/u', '', $value) ?? '';
    return mb_substr(trim($value), 0, $max);
}

function respond(bool $ok, string $message, array $errors = [], array $old = [], string $formId = 'quote'): void
{
    global $wantsJson;

    if ($wantsJson) {
        http_response_code($ok ? 200 : 422);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        echo json_encode([
            'ok'       => $ok,
            'message'  => $message,
            'errors'   => (object) $errors,
            'redirect' => $ok ? url('thank-you') : null,
        ]);
        exit;
    }

    if ($ok) {
        header('Location: ' . url('thank-you'), true, 303);
        exit;
    }

    // No JavaScript: remember the errors and input, then send the visitor back to the form.
    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off']);
        session_start();
    }
    $_SESSION['enquiry_flash'] = ['form' => $formId, 'message' => $message, 'errors' => $errors, 'old' => $old];

    $back = (string) ($_POST['page'] ?? '/contact');
    if (!preg_match('#^/[a-z0-9/-]*$#', $back)) {
        $back = '/contact';
    }
    header('Location: ' . url($back) . '#' . $formId . '-form', true, 303);
    exit;
}

/** Allow a limited number of submissions per IP address within the configured window. */
function rate_limited(): bool
{
    $limit = config('rate_limit', ['max' => 5, 'window' => 3600]);
    $dir = ROOT_PATH . '/storage/ratelimit';
    if (!is_dir($dir) && !@mkdir($dir, 0755, true)) {
        return false;
    }
    $file = $dir . '/' . hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? '') . form_secret()) . '.json';
    $now = time();
    $handle = @fopen($file, 'c+');
    if (!$handle) {
        return false;
    }
    flock($handle, LOCK_EX);
    $hits = json_decode((string) stream_get_contents($handle), true) ?: [];
    $hits = array_values(array_filter($hits, fn ($t) => is_int($t) && $t > $now - $limit['window']));
    $blocked = count($hits) >= $limit['max'];
    if (!$blocked) {
        $hits[] = $now;
        ftruncate($handle, 0);
        rewind($handle);
        fwrite($handle, json_encode($hits));
    }
    flock($handle, LOCK_UN);
    fclose($handle);
    return $blocked;
}

function log_enquiry(array $data, string $status): void
{
    if (!config('log_enquiries')) {
        return;
    }
    $line = json_encode(['time' => date('c'), 'status' => $status] + $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    @file_put_contents(ROOT_PATH . '/storage/enquiries.log', $line . "\n", FILE_APPEND | LOCK_EX);
}

function send_enquiry_email(array $data): bool
{
    if (IS_DEV) {
        return true; // Local development server: enquiries are only logged.
    }

    $services = service_options();
    $roofTypes = roof_type_options();
    $subject = 'New quote request: ' . $data['name'] . ' (' . $data['suburb'] . ')';

    $body = implode("\n", [
        'New enquiry from the ' . config('site_name') . ' website',
        str_repeat('-', 48),
        'Name:       ' . $data['name'],
        'Phone:      ' . $data['phone'],
        'Email:      ' . ($data['email'] ?: '(not provided)'),
        'Suburb:     ' . $data['suburb'],
        'Service:    ' . ($services[$data['service']] ?? 'Not specified'),
        'Roof type:  ' . ($roofTypes[$data['roof_type']] ?? 'Not specified'),
        '',
        'Message:',
        $data['message'] ?: '(no message)',
        '',
        str_repeat('-', 48),
        'Sent from:  ' . absolute_url(ltrim($data['page'], '/')),
        'Received:   ' . date('l j F Y, g:ia'),
    ]);

    $headers = [
        'From'         => mb_encode_mimeheader(config('site_name') . ' Website', 'UTF-8', 'B') . ' <' . config('mail_from') . '>',
        'MIME-Version' => '1.0',
        'Content-Type' => 'text/plain; charset=UTF-8',
        'X-Mailer'     => 'PHP/' . PHP_VERSION,
    ];
    if ($data['email'] !== '') {
        $headers['Reply-To'] = $data['email'];
    }

    return mail(
        (string) (config('enquiry_to') ?: config('email')),
        mb_encode_mimeheader($subject, 'UTF-8', 'B'),
        $body,
        $headers,
        '-f' . config('mail_from')
    );
}

// ---------------------------------------------------------------------------

$formId = preg_replace('/[^a-z0-9-]/', '', strtolower((string) ($_POST['form_id'] ?? ''))) ?: 'quote';

$data = [
    'name'      => clean_line($_POST['name'] ?? '', 80),
    'phone'     => clean_line($_POST['phone'] ?? '', 20),
    'email'     => clean_line($_POST['email'] ?? '', 120),
    'suburb'    => clean_line($_POST['suburb'] ?? '', 60),
    'service'   => clean_line($_POST['service'] ?? '', 60),
    'roof_type' => clean_line($_POST['roof_type'] ?? '', 20),
    'message'   => clean_text($_POST['message'] ?? '', 2000),
    'page'      => clean_line($_POST['page'] ?? '/', 120),
];

// Spam traps: bots fill in the hidden field. Pretend it worked so they move on.
if (clean_line($_POST['website'] ?? '', 200) !== '') {
    respond(true, 'Thanks! Your request has been sent.');
}

$phoneHelp = 'call us on ' . config('phone') . '.';

if (!verify_form_token((string) ($_POST['token'] ?? ''))) {
    respond(false, 'This form has expired. Please refresh the page and try again, or ' . $phoneHelp, [], $data, $formId);
}

$errors = [];
if (mb_strlen($data['name']) < 2) {
    $errors['name'] = 'Please enter your name.';
}
$digits = preg_replace('/\D+/', '', $data['phone']);
if (strlen($digits) < 8 || strlen($digits) > 12) {
    $errors['phone'] = 'Please enter a valid phone number.';
}
if ($data['email'] !== '' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
}
if (mb_strlen($data['suburb']) < 2) {
    $errors['suburb'] = 'Please enter your suburb.';
}
if ($data['service'] !== '' && !array_key_exists($data['service'], service_options())) {
    $data['service'] = '';
}
if ($data['roof_type'] !== '' && !array_key_exists($data['roof_type'], roof_type_options())) {
    $data['roof_type'] = '';
}

if ($errors) {
    respond(false, 'Please check the highlighted fields.', $errors, $data, $formId);
}

if (rate_limited()) {
    respond(false, "We've received several requests from you already. To speak to us now, " . $phoneHelp, [], $data, $formId);
}

$sent = send_enquiry_email($data);
log_enquiry($data, IS_DEV ? 'dev-not-emailed' : ($sent ? 'sent' : 'mail-failed'));

if (!$sent) {
    respond(false, 'Sorry, we couldn\'t send your request just now. To get your free quote, ' . $phoneHelp, [], $data, $formId);
}

respond(true, 'Thanks! Your request has been sent.');
