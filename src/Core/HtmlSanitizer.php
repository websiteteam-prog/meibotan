<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Whitelist-based HTML sanitiser for rich text entered in the admin
 * (product descriptions, CMS pages). Removes scripts, event handlers,
 * styles and javascript: URLs so stored content can't carry XSS.
 */
final class HtmlSanitizer
{
    private const TAGS = [
        'p' => [], 'br' => [], 'strong' => [], 'b' => [], 'em' => [], 'i' => [], 'u' => [],
        'ul' => [], 'ol' => [], 'li' => [], 'h2' => [], 'h3' => [], 'h4' => [], 'blockquote' => [],
        'a' => ['href', 'title', 'target', 'rel'], 'span' => [], 'hr' => [],
        'table' => [], 'thead' => [], 'tbody' => [], 'tr' => [], 'th' => [], 'td' => [],
        'img' => ['src', 'alt', 'width', 'height'],
    ];

    public static function clean(?string $html): string
    {
        $html = trim((string) $html);
        if ($html === '') {
            return '';
        }
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="UTF-8"><div id="__root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $root = $doc->getElementById('__root');
        if (!$root) {
            return e(strip_tags($html));
        }
        self::walk($root);
        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }
        return trim($out);
    }

    private static function walk(\DOMNode $node): void
    {
        for ($i = $node->childNodes->length - 1; $i >= 0; $i--) {
            $child = $node->childNodes->item($i);
            if ($child instanceof \DOMComment) {
                $node->removeChild($child);
                continue;
            }
            if (!$child instanceof \DOMElement) {
                continue;
            }
            $tag = strtolower($child->tagName);
            if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'button', 'textarea', 'select', 'link', 'meta'], true)) {
                $node->removeChild($child);
                continue;
            }
            self::walk($child);
            if (!isset(self::TAGS[$tag])) {
                // Unwrap unknown tags but keep their content.
                while ($child->firstChild) {
                    $node->insertBefore($child->firstChild, $child);
                }
                $node->removeChild($child);
                continue;
            }
            $allowed = self::TAGS[$tag];
            for ($a = $child->attributes->length - 1; $a >= 0; $a--) {
                $attr = $child->attributes->item($a);
                $name = strtolower($attr->nodeName);
                if (!in_array($name, $allowed, true)) {
                    $child->removeAttribute($attr->nodeName);
                    continue;
                }
                if (in_array($name, ['href', 'src'], true)) {
                    $v = trim($attr->nodeValue);
                    if (!preg_match('~^(https?://|/|#|mailto:|tel:)~i', $v)) {
                        $child->removeAttribute($attr->nodeName);
                    }
                }
            }
            if ($tag === 'a' && $child->getAttribute('target') === '_blank') {
                $child->setAttribute('rel', 'noopener noreferrer');
            }
        }
    }
}
