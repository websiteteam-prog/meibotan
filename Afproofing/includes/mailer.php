<?php
/**
 * Sends email through your own mailbox (SMTP) or through PHP's mail().
 *
 * Settings live in includes/config.php ('mail_transport' and 'smtp').
 * No external libraries: a small SMTP client with SSL, STARTTLS and login
 * (AUTH PLAIN / LOGIN), which is all GoDaddy, Microsoft 365 and cPanel need.
 */
defined('ROOT_PATH') || exit;

/**
 * Send one email. Returns true on success.
 *
 * $msg keys: to, to_name, subject, text, html, reply_to, reply_to_name.
 * Errors are written to storage/mail-errors.log (never the password).
 */
function send_mail(array $msg): bool
{
    $from = (string) config('mail_from');
    $fromName = (string) ($msg['from_name'] ?? config('mail_from_name', config('site_name')));
    $to = (string) ($msg['to'] ?? '');

    if (!filter_var($to, FILTER_VALIDATE_EMAIL) || !filter_var($from, FILTER_VALIDATE_EMAIL)) {
        mail_log_error('Invalid "to" or "mail_from" address.', $to);
        return false;
    }

    [$headers, $body] = mail_build($msg, $from, $fromName);
    $transport = config('mail_transport', 'mail');
    static $smtpFailed = false; // once SMTP fails, don't make the visitor wait for it again

    if ($transport === 'smtp' && !$smtpFailed) {
        try {
            smtp_send(config('smtp', []), $from, $to, $headers, $body, (string) $msg['subject']);
            return true;
        } catch (Throwable $e) {
            $smtpFailed = true;
            mail_log_error('SMTP: ' . $e->getMessage(), $to);
            if (!config('mail_fallback', true)) {
                return false;
            }
            // Fall through and try PHP's mail() so the enquiry isn't lost.
        }
    } elseif ($transport === 'smtp' && !config('mail_fallback', true)) {
        return false;
    }

    $ok = php_mail_send($from, $to, $headers, $body, (string) $msg['subject']);
    if (!$ok) {
        mail_log_error('PHP mail() returned false.', $to);
    }
    return $ok;
}

/** Build the headers and a multipart (plain text + HTML) body. */
function mail_build(array $msg, string $from, string $fromName): array
{
    $boundary = 'b' . bin2hex(random_bytes(12));
    $domain = substr(strrchr($from, '@') ?: '@localhost', 1);

    $headers = [
        'Date'         => date('r'),
        'From'         => mail_address($from, $fromName),
        'To'           => mail_address((string) $msg['to'], (string) ($msg['to_name'] ?? '')),
        'Message-ID'   => '<' . bin2hex(random_bytes(16)) . '@' . $domain . '>',
        'MIME-Version' => '1.0',
        'Content-Type' => 'multipart/alternative; boundary="' . $boundary . '"',
    ];
    if (!empty($msg['reply_to']) && filter_var($msg['reply_to'], FILTER_VALIDATE_EMAIL)) {
        $headers['Reply-To'] = mail_address((string) $msg['reply_to'], (string) ($msg['reply_to_name'] ?? ''));
    }

    $part = fn (string $type, string $content) =>
        "--$boundary\r\n"
        . "Content-Type: $type; charset=UTF-8\r\n"
        . "Content-Transfer-Encoding: base64\r\n\r\n"
        . rtrim(chunk_split(base64_encode($content), 76, "\r\n")) . "\r\n";

    $body = "This is a multi-part message in MIME format.\r\n\r\n"
        . $part('text/plain', (string) ($msg['text'] ?? ''))
        . $part('text/html', (string) ($msg['html'] ?? nl2br(e((string) ($msg['text'] ?? '')))))
        . "--$boundary--\r\n";

    return [$headers, $body];
}

/** "Name" <address>, with the name safely encoded. */
function mail_address(string $email, string $name = ''): string
{
    $name = trim(preg_replace('/[\r\n"<>]+/', ' ', $name) ?? '');
    return $name === '' ? $email : mb_encode_mimeheader($name, 'UTF-8', 'B') . ' <' . $email . '>';
}

function mail_subject(string $subject): string
{
    return mb_encode_mimeheader(preg_replace('/[\r\n]+/', ' ', $subject) ?? '', 'UTF-8', 'B');
}

/** Send with PHP's mail() (the web host's own mail server). */
function php_mail_send(string $from, string $to, array $headers, string $body, string $subject): bool
{
    unset($headers['To']); // mail() adds To and Subject itself
    $lines = [];
    foreach ($headers as $name => $value) {
        $lines[] = "$name: $value";
    }
    return @mail($to, mail_subject($subject), $body, implode("\r\n", $lines), '-f' . $from);
}

/**
 * Send through an SMTP server (e.g. your GoDaddy mailbox).
 *
 * @throws RuntimeException with the server's reply when something fails.
 */
function smtp_send(array $cfg, string $from, string $to, array $headers, string $body, string $subject): void
{
    $host = (string) ($cfg['host'] ?? '');
    $port = (int) ($cfg['port'] ?? 465);
    $encryption = strtolower((string) ($cfg['encryption'] ?? 'ssl'));
    $timeout = (int) ($cfg['timeout'] ?? 15);
    if ($host === '') {
        throw new RuntimeException('No SMTP host set in config.php.');
    }

    $tls = [
        'verify_peer'      => (bool) ($cfg['verify_peer'] ?? true),
        'verify_peer_name' => (bool) ($cfg['verify_peer'] ?? true),
        'peer_name'        => $host,
        'SNI_enabled'      => true,
    ];
    $context = stream_context_create(['ssl' => $tls]);
    $address = ($encryption === 'ssl' ? 'ssl://' : 'tcp://') . $host . ':' . $port;

    $socket = @stream_socket_client($address, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $context);
    if (!$socket) {
        throw new RuntimeException("Could not connect to $host:$port ($errstr).");
    }
    stream_set_timeout($socket, $timeout);

    try {
        smtp_expect($socket, [220]);
        $ehloName = preg_replace('/[^a-z0-9.-]/i', '', (string) ($_SERVER['SERVER_NAME'] ?? '')) ?: 'localhost';
        $capabilities = smtp_command($socket, "EHLO $ehloName", [250]);

        if ($encryption === 'tls') {
            smtp_command($socket, 'STARTTLS', [220]);
            $method = STREAM_CRYPTO_METHOD_TLS_CLIENT;
            if (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')) {
                $method |= STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
            }
            if (defined('STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT')) {
                $method |= STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT;
            }
            if (!@stream_socket_enable_crypto($socket, true, $method)) {
                throw new RuntimeException('STARTTLS failed (could not start an encrypted connection).');
            }
            $capabilities = smtp_command($socket, "EHLO $ehloName", [250]);
        }

        $user = (string) ($cfg['username'] ?? '');
        $pass = (string) ($cfg['password'] ?? '');
        if ($user !== '') {
            if ($pass === '') {
                throw new RuntimeException('SMTP password is empty in config.php.');
            }
            if (preg_match('/AUTH[ =][^\r\n]*\bPLAIN\b/i', $capabilities)) {
                smtp_command($socket, 'AUTH PLAIN ' . base64_encode("\0$user\0$pass"), [235], true);
            } else {
                smtp_command($socket, 'AUTH LOGIN', [334]);
                smtp_command($socket, base64_encode($user), [334], true);
                smtp_command($socket, base64_encode($pass), [235], true);
            }
        }

        smtp_command($socket, "MAIL FROM:<$from>", [250]);
        smtp_command($socket, "RCPT TO:<$to>", [250, 251]);
        smtp_command($socket, 'DATA', [354]);

        $lines = [];
        foreach ($headers as $name => $value) {
            $lines[] = "$name: $value";
        }
        $lines[] = 'Subject: ' . mail_subject($subject);
        $data = implode("\r\n", $lines) . "\r\n\r\n" . $body;
        $data = preg_replace('/(?<!\r)\n/', "\r\n", $data);           // normalise line endings
        $data = preg_replace('/^\./m', '..', $data);                  // dot-stuffing
        fwrite($socket, $data . "\r\n.\r\n");
        smtp_expect($socket, [250]);

        @fwrite($socket, "QUIT\r\n");
    } finally {
        fclose($socket);
    }
}

/** Send a command and check the reply code. Returns the full reply. */
function smtp_command($socket, string $command, array $codes, bool $secret = false): string
{
    fwrite($socket, $command . "\r\n");
    return smtp_expect($socket, $codes, $secret ? '[login details]' : $command);
}

function smtp_expect($socket, array $codes, string $after = 'connect'): string
{
    $reply = '';
    while (($line = fgets($socket, 1024)) !== false) {
        $reply .= $line;
        if (strlen($line) < 4 || $line[3] !== '-') {
            break; // last line of a (multi-line) reply
        }
    }
    $code = (int) substr($reply, 0, 3);
    if (!in_array($code, $codes, true)) {
        $meta = stream_get_meta_data($socket);
        $why = $reply === '' ? (!empty($meta['timed_out']) ? 'timed out' : 'no reply') : trim($reply);
        throw new RuntimeException("Unexpected reply after $after: $why");
    }
    return $reply;
}

function mail_log_error(string $error, string $to = ''): void
{
    $line = json_encode(['time' => date('c'), 'to' => $to, 'error' => $error], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    @file_put_contents(ROOT_PATH . '/storage/mail-errors.log', $line . "\n", FILE_APPEND | LOCK_EX);
}
