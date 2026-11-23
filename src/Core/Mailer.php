<?php
declare(strict_types=1);

namespace App\Core;

/**
 * E-mail delivery with three drivers configured in Admin → Settings → Email:
 *   log  – writes messages to storage/logs/mail (development / staging)
 *   mail – PHP mail()
 *   smtp – built-in SMTP client (SSL or STARTTLS, AUTH LOGIN)
 */
final class Mailer
{
    public static function send(string $to, string $subject, string $html, ?string $replyTo = null): bool
    {
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $fromEmail = (string) setting('mail_from_address', setting('site_email', 'no-reply@localhost'));
        $fromName = (string) setting('mail_from_name', setting('site_name', 'Savié Amour'));
        $driver = (string) setting('mail_driver', 'log');
        $subject = trim(preg_replace('/[\r\n]+/', ' ', $subject));

        try {
            return match ($driver) {
                'smtp' => self::smtp($to, $subject, $html, $fromEmail, $fromName, $replyTo),
                'mail' => self::phpMail($to, $subject, $html, $fromEmail, $fromName, $replyTo),
                default => self::log($to, $subject, $html),
            };
        } catch (\Throwable $e) {
            log_message('mail-error', $to . ' | ' . $subject . ' | ' . $e->getMessage());
            return false;
        }
    }

    /** Render an e-mail template inside the branded e-mail layout and send it. */
    public static function template(string $to, string $subject, string $view, array $data = []): bool
    {
        $html = View::render('emails/' . $view, array_merge($data, ['subject' => $subject]), 'emails/layout');
        return self::send($to, $subject, $html);
    }

    private static function log(string $to, string $subject, string $html): bool
    {
        $dir = STORAGE_PATH . '/logs/mail';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        $file = $dir . '/' . date('Ymd-His') . '-' . substr(md5($to . $subject . microtime()), 0, 6) . '.html';
        file_put_contents($file, "<!-- To: {$to} | Subject: " . htmlspecialchars($subject) . " -->\n" . $html);
        log_message('mail', "LOGGED to={$to} subject={$subject}");
        return true;
    }

    private static function encodeHeader(string $text): string
    {
        return preg_match('/[^\x20-\x7E]/', $text) ? '=?UTF-8?B?' . base64_encode($text) . '?=' : $text;
    }

    private static function buildMessage(string $to, string $subject, string $html, string $fromEmail, string $fromName, ?string $replyTo): array
    {
        $boundary = 'b' . bin2hex(random_bytes(8));
        $text = trim(html_entity_decode(strip_tags(preg_replace('~<(br|/p|/tr|/h\d)[^>]*>~i', "\n", $html)), ENT_QUOTES, 'UTF-8'));
        $text = preg_replace("/\n{3,}/", "\n\n", preg_replace('/[ \t]+/', ' ', $text));
        $headers = [
            'MIME-Version: 1.0',
            'From: ' . self::encodeHeader($fromName) . ' <' . $fromEmail . '>',
            'Date: ' . date('r'),
            'Message-ID: <' . bin2hex(random_bytes(10)) . '@' . (parse_url((string) config('app_url'), PHP_URL_HOST) ?: 'localhost') . '>',
            'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
        ];
        if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
            $headers[] = 'Reply-To: ' . $replyTo;
        }
        $body = "--{$boundary}\r\nContent-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
            . chunk_split(base64_encode($text))
            . "--{$boundary}\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
            . chunk_split(base64_encode($html))
            . "--{$boundary}--\r\n";
        return [$headers, $body];
    }

    private static function phpMail(string $to, string $subject, string $html, string $fromEmail, string $fromName, ?string $replyTo): bool
    {
        [$headers, $body] = self::buildMessage($to, $subject, $html, $fromEmail, $fromName, $replyTo);
        return mail($to, self::encodeHeader($subject), $body, implode("\r\n", $headers), '-f' . $fromEmail);
    }

    private static function smtp(string $to, string $subject, string $html, string $fromEmail, string $fromName, ?string $replyTo): bool
    {
        $host = (string) setting('smtp_host');
        $port = (int) setting('smtp_port', 587);
        $enc = (string) setting('smtp_encryption', 'tls');
        $user = (string) setting('smtp_username');
        $pass = (string) setting('smtp_password');
        if ($host === '') {
            throw new \RuntimeException('SMTP host is not configured.');
        }
        $remote = ($enc === 'ssl' ? 'ssl://' : 'tcp://') . $host . ':' . $port;
        $ctx = stream_context_create(['ssl' => ['verify_peer' => true, 'verify_peer_name' => true]]);
        $fp = @stream_socket_client($remote, $errno, $errstr, 15, STREAM_CLIENT_CONNECT, $ctx);
        if (!$fp) {
            throw new \RuntimeException("SMTP connect failed: {$errstr}");
        }
        stream_set_timeout($fp, 15);
        $read = static function () use ($fp): string {
            $data = '';
            while (($line = fgets($fp, 515)) !== false) {
                $data .= $line;
                if (isset($line[3]) && $line[3] === ' ') {
                    break;
                }
            }
            return $data;
        };
        $cmd = static function (string $c, array $expect) use ($fp, $read): string {
            fwrite($fp, $c . "\r\n");
            $resp = $read();
            if (!in_array((int) substr($resp, 0, 3), $expect, true)) {
                throw new \RuntimeException('SMTP error after "' . explode(' ', $c)[0] . '": ' . trim($resp));
            }
            return $resp;
        };
        $read();
        $ehloHost = parse_url((string) config('app_url'), PHP_URL_HOST) ?: 'localhost';
        $cmd('EHLO ' . $ehloHost, [250]);
        if ($enc === 'tls') {
            $cmd('STARTTLS', [220]);
            if (!stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT)) {
                throw new \RuntimeException('Could not start TLS.');
            }
            $cmd('EHLO ' . $ehloHost, [250]);
        }
        if ($user !== '') {
            $cmd('AUTH LOGIN', [334]);
            $cmd(base64_encode($user), [334]);
            $cmd(base64_encode($pass), [235]);
        }
        $cmd('MAIL FROM:<' . $fromEmail . '>', [250]);
        $cmd('RCPT TO:<' . $to . '>', [250, 251]);
        $cmd('DATA', [354]);
        [$headers, $body] = self::buildMessage($to, $subject, $html, $fromEmail, $fromName, $replyTo);
        $headers[] = 'To: <' . $to . '>';
        $headers[] = 'Subject: ' . self::encodeHeader($subject);
        $payload = implode("\r\n", $headers) . "\r\n\r\n" . $body;
        $payload = preg_replace('/^\./m', '..', $payload);
        $cmd($payload . "\r\n.", [250]);
        $cmd('QUIT', [221]);
        fclose($fp);
        return true;
    }
}
