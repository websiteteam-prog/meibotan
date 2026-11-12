<?php
/**
 * Email content for website enquiries:
 *   enquiry_admin_email()    - the enquiry details, sent to you (config 'enquiry_to')
 *   enquiry_customer_email() - the "we've received your request" confirmation
 *
 * Each returns ['subject' => ..., 'text' => ..., 'html' => ...]. The HTML uses
 * tables and inline styles because that is what email apps understand.
 */
defined('ROOT_PATH') || exit;

const EMAIL_TEAL = '#12393e';
const EMAIL_TEAL_DEEP = '#0b2a2e';
const EMAIL_YELLOW = '#ffc20e';
const EMAIL_PAPER = '#f2f6f5';
const EMAIL_MUTED = '#4d6467';

/** First name only (used in the greeting), kept short and plain. */
function email_first_name(string $name): string
{
    $first = preg_split('/\s+/u', trim($name))[0] ?? '';
    return mb_substr($first, 0, 30) ?: 'there';
}

/** Common page wrapper: header with logo, white card, footer. */
function email_layout(string $preheader, string $content, string $footer): string
{
    $logo = absolute_url('assets/img/logo-email.png');
    $site = e(config('site_name'));
    return '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">'
        . '<title>' . $site . '</title></head>'
        . '<body style="margin:0;padding:0;background:' . EMAIL_PAPER . ';">'
        . '<div style="display:none;max-height:0;overflow:hidden;opacity:0;">' . e($preheader) . '</div>'
        . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:' . EMAIL_PAPER . ';"><tr><td align="center" style="padding:24px 12px;">'
        . '<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;font-family:Arial,Helvetica,sans-serif;color:' . EMAIL_TEAL . ';">'
        // Header
        . '<tr><td style="background:' . EMAIL_TEAL . ';border-radius:14px 14px 0 0;padding:22px 28px;border-bottom:4px solid ' . EMAIL_YELLOW . ';">'
        . '<a href="' . e(absolute_url()) . '" style="text-decoration:none;color:#ffffff;font-size:20px;font-weight:bold;">'
        . '<img src="' . e($logo) . '" width="200" alt="' . $site . '" style="display:block;border:0;width:200px;max-width:100%;height:auto;color:#ffffff;font-size:20px;font-weight:bold;"></a>'
        . '</td></tr>'
        // Content
        . '<tr><td style="background:#ffffff;padding:30px 28px;font-size:15px;line-height:1.6;">' . $content . '</td></tr>'
        // Footer
        . '<tr><td style="background:' . EMAIL_TEAL_DEEP . ';border-radius:0 0 14px 14px;padding:20px 28px;font-size:12px;line-height:1.6;color:#a9c2c4;">' . $footer . '</td></tr>'
        . '</table></td></tr></table></body></html>';
}

/** Two-column summary table (label / value). Values are already escaped HTML. */
function email_rows(array $rows): string
{
    $html = '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #d8e3e3;border-radius:10px;border-collapse:separate;overflow:hidden;">';
    $i = 0;
    foreach ($rows as $label => $value) {
        $bg = $i++ % 2 ? '#ffffff' : '#f7faf9';
        $html .= '<tr><td style="background:' . $bg . ';padding:10px 14px;width:34%;font-size:13px;font-weight:bold;color:' . EMAIL_MUTED . ';vertical-align:top;">' . e($label) . '</td>'
            . '<td style="background:' . $bg . ';padding:10px 14px;font-size:14px;color:' . EMAIL_TEAL . ';vertical-align:top;">' . $value . '</td></tr>';
    }
    return $html . '</table>';
}

function email_button(string $href, string $label, bool $primary = true): string
{
    $bg = $primary ? EMAIL_YELLOW : EMAIL_TEAL;
    $fg = $primary ? EMAIL_TEAL : '#ffffff';
    return '<a href="' . e($href) . '" style="display:inline-block;margin:6px 8px 6px 0;padding:12px 20px;border-radius:8px;background:' . $bg . ';color:' . $fg . ';font-size:15px;font-weight:bold;text-decoration:none;">' . e($label) . '</a>';
}

/** Readable labels for the select fields. */
function enquiry_labels(array $data): array
{
    return [
        'service'   => service_options()[$data['service']] ?? 'Not specified',
        'roof_type' => roof_type_options()[$data['roof_type']] ?? 'Not specified',
    ];
}

/** Email sent to you with the enquiry. Reply to it to answer the customer directly. */
function enquiry_admin_email(array $data): array
{
    $labels = enquiry_labels($data);
    $phoneHref = 'tel:' . preg_replace('/[^0-9+]/', '', $data['phone']);
    $pageUrl = absolute_url(ltrim($data['page'], '/'));
    $received = date('l j F Y, g:ia');
    $first = email_first_name($data['name']);

    $subject = 'New quote request: ' . $data['name'] . ' (' . $data['suburb'] . ')';

    $text = implode("\n", [
        'New enquiry from the ' . config('site_name') . ' website',
        str_repeat('-', 48),
        'Name:       ' . $data['name'],
        'Phone:      ' . $data['phone'],
        'Email:      ' . ($data['email'] ?: '(not provided)'),
        'Suburb:     ' . $data['suburb'],
        'Service:    ' . $labels['service'],
        'Roof type:  ' . $labels['roof_type'],
        '',
        'Message:',
        $data['message'] ?: '(no message)',
        '',
        str_repeat('-', 48),
        'Sent from:  ' . $pageUrl,
        'Received:   ' . $received,
        '',
        'Reply to this email to answer ' . $first . ' directly.',
    ]);

    $rows = [
        'Name'      => e($data['name']),
        'Phone'     => '<a href="' . e($phoneHref) . '" style="color:' . EMAIL_TEAL . ';font-weight:bold;">' . e($data['phone']) . '</a>',
        'Email'     => $data['email'] !== '' ? '<a href="mailto:' . e($data['email']) . '" style="color:' . EMAIL_TEAL . ';">' . e($data['email']) . '</a>' : '(not provided)',
        'Suburb'    => e($data['suburb']),
        'Service'   => e($labels['service']),
        'Roof type' => e($labels['roof_type']),
    ];
    $message = $data['message'] !== ''
        ? '<div style="margin-top:18px;padding:14px 16px;border-left:4px solid ' . EMAIL_YELLOW . ';background:#fff6d6;border-radius:0 8px 8px 0;white-space:pre-line;">' . e($data['message']) . '</div>'
        : '<p style="margin:18px 0 0;color:' . EMAIL_MUTED . ';">No message was added.</p>';

    $buttons = email_button($phoneHref, 'Call ' . $first);
    if ($data['email'] !== '') {
        $buttons .= email_button('mailto:' . $data['email'] . '?subject=' . rawurlencode('Your roof quote request - ' . config('site_name')), 'Reply by email', false);
    }

    $content = '<p style="margin:0 0 4px;font-size:12px;font-weight:bold;letter-spacing:1.5px;text-transform:uppercase;color:#8a6500;">New website enquiry</p>'
        . '<h1 style="margin:0 0 18px;font-size:24px;line-height:1.2;color:' . EMAIL_TEAL . ';">' . e($data['name']) . ' &middot; ' . e($data['suburb']) . '</h1>'
        . email_rows($rows)
        . '<p style="margin:22px 0 4px;font-size:13px;font-weight:bold;color:' . EMAIL_MUTED . ';">Message</p>' . $message
        . '<p style="margin:24px 0 0;">' . $buttons . '</p>';

    $footer = 'Sent from <a href="' . e($pageUrl) . '" style="color:#ffc20e;">' . e($pageUrl) . '</a><br>Received ' . e($received)
        . '<br>Reply to this email to answer ' . e($first) . ' directly.';

    return [
        'subject' => $subject,
        'text'    => $text,
        'html'    => email_layout('New quote request from ' . $data['name'] . ' in ' . $data['suburb'], $content, $footer),
    ];
}

/**
 * Confirmation sent to the customer. It deliberately does not repeat their
 * free-text message, so the form can't be used to send spam to other people.
 */
function enquiry_customer_email(array $data): array
{
    $labels = enquiry_labels($data);
    $first = email_first_name($data['name']);
    $site = (string) config('site_name');
    $phone = (string) config('phone');
    $phoneHref = phone_href();

    $subject = 'We\'ve received your quote request | ' . $site;

    $text = implode("\n", [
        'Hi ' . $first . ',',
        '',
        'Thanks for contacting ' . $site . '. We\'ve received your request for a free roof inspection and quote.',
        'We\'ll be in touch shortly to book a time that suits you.',
        '',
        'Your request',
        '- Service:   ' . $labels['service'],
        '- Suburb:    ' . $data['suburb'],
        '- Roof type: ' . $labels['roof_type'],
        '- Phone:     ' . $data['phone'],
        '',
        'What happens next',
        '1. We call you to talk about your roof and book a time.',
        '2. We inspect your roof for free and show you what we find.',
        '3. You get a clear, itemised quote. No pressure, no obligation.',
        '',
        'Need us sooner? Call ' . $phone . '.',
        '',
        'Thanks,',
        'The ' . $site . ' team',
        'Restoring Roofs. Protecting Homes.',
        absolute_url(),
        '',
        'You received this email because a quote was requested on our website with this address. If that wasn\'t you, you can ignore it.',
    ]);

    $step = fn (string $n, string $title, string $body) =>
        '<tr><td style="width:40px;vertical-align:top;padding:0 0 14px;">'
        . '<div style="width:30px;height:30px;line-height:30px;border-radius:15px;background:' . EMAIL_YELLOW . ';color:' . EMAIL_TEAL . ';text-align:center;font-weight:bold;">' . $n . '</div></td>'
        . '<td style="vertical-align:top;padding:4px 0 14px;"><strong>' . e($title) . '</strong><br><span style="color:' . EMAIL_MUTED . ';">' . e($body) . '</span></td></tr>';

    $content = '<h1 style="margin:0 0 12px;font-size:26px;line-height:1.2;color:' . EMAIL_TEAL . ';">Thanks, ' . e($first) . '!</h1>'
        . '<p style="margin:0 0 20px;">We&rsquo;ve received your request for a <strong>free roof inspection and quote</strong>. We&rsquo;ll be in touch shortly to book a time that suits you.</p>'
        . '<p style="margin:0 0 8px;font-size:13px;font-weight:bold;letter-spacing:1px;text-transform:uppercase;color:#8a6500;">Your request</p>'
        . email_rows([
            'Service'   => e($labels['service']),
            'Suburb'    => e($data['suburb']),
            'Roof type' => e($labels['roof_type']),
            'Phone'     => e($data['phone']),
        ])
        . '<p style="margin:26px 0 12px;font-size:13px;font-weight:bold;letter-spacing:1px;text-transform:uppercase;color:#8a6500;">What happens next</p>'
        . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0">'
        . $step('1', 'We call you', 'We talk about your roof and book a time to visit.')
        . $step('2', 'Free roof inspection', 'We check your tiles, ridge capping and pointing, and show you what we find.')
        . $step('3', 'Your itemised quote', 'A clear quote with exactly what is included. No pressure, no obligation.')
        . '</table>'
        . '<div style="margin-top:12px;padding:18px 20px;border-radius:10px;background:' . EMAIL_PAPER . ';">'
        . '<strong>Need us sooner?</strong> Give us a call and we&rsquo;ll help straight away.<br>'
        . email_button($phoneHref, 'Call ' . $phone) . '</div>'
        . '<p style="margin:26px 0 0;">Thanks,<br><strong>The ' . e($site) . ' team</strong><br>'
        . '<span style="font-size:13px;font-weight:bold;letter-spacing:1px;text-transform:uppercase;color:#8a6500;">Restoring Roofs. Protecting Homes.</span></p>';

    $footer = '<a href="' . e(absolute_url()) . '" style="color:#ffc20e;font-weight:bold;">' . e(rtrim(preg_replace('#^https?://#', '', absolute_url()), '/')) . '</a>'
        . ' &middot; <a href="' . e($phoneHref) . '" style="color:#ffc20e;">' . e($phone) . '</a>'
        . ' &middot; Servicing Adelaide &amp; regional South Australia'
        . '<br><br>You received this email because a quote was requested on our website with this address. If that wasn&rsquo;t you, you can ignore it.';

    return [
        'subject' => $subject,
        'text'    => $text,
        'html'    => email_layout('Thanks ' . $first . ', we\'ve received your quote request.', $content, $footer),
    ];
}
