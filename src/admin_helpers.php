<?php
/**
 * Small HTML helpers for admin forms and lists (keep admin views short and consistent).
 */
declare(strict_types=1);

function adm_val(string $name, mixed $default = ''): string
{
    $old = App\Core\Session::peekFlash('old', []);
    if (array_key_exists($name, $old)) {
        return (string) $old[$name];
    }
    return (string) ($default ?? '');
}

function adm_attrs(array $attrs): string
{
    $out = '';
    foreach ($attrs as $k => $v) {
        if ($v === false || $v === null) {
            continue;
        }
        $out .= ' ' . e($k) . ($v === true ? '' : '="' . e($v) . '"');
    }
    return $out;
}

/** Text-like input with label, help text and validation error. */
function adm_input(string $name, string $label, mixed $value = '', array $o = []): string
{
    $id = $o['id'] ?? 'f_' . preg_replace('/\W+/', '_', $name);
    $type = $o['type'] ?? 'text';
    $attrs = array_merge(['type' => $type, 'id' => $id, 'name' => $name, 'value' => adm_val($name, $value), 'class' => 'form-control' . invalid($name)], $o['attrs'] ?? []);
    $html = '<div class="' . e($o['col'] ?? 'mb-3') . '">';
    if ($label !== '') {
        $html .= '<label class="form-label" for="' . e($id) . '">' . e($label) . (!empty($o['optional']) ? ' <span class="form-text">(optional)</span>' : '') . '</label>';
    }
    $input = '<input' . adm_attrs($attrs) . '>';
    if (!empty($o['prefix']) || !empty($o['suffix'])) {
        $input = '<div class="input-group">' . (!empty($o['prefix']) ? '<span class="input-group-text">' . e($o['prefix']) . '</span>' : '') . $input . (!empty($o['suffix']) ? '<span class="input-group-text">' . e($o['suffix']) . '</span>' : '') . '</div>';
    }
    $html .= $input . error_for($name);
    if (!empty($o['help'])) {
        $html .= '<div class="form-text">' . e($o['help']) . '</div>';
    }
    return $html . '</div>';
}

function adm_textarea(string $name, string $label, mixed $value = '', array $o = []): string
{
    $id = $o['id'] ?? 'f_' . preg_replace('/\W+/', '_', $name);
    $attrs = array_merge(['id' => $id, 'name' => $name, 'rows' => $o['rows'] ?? 3, 'class' => 'form-control' . invalid($name)], $o['attrs'] ?? []);
    $html = '<div class="' . e($o['col'] ?? 'mb-3') . '"><label class="form-label" for="' . e($id) . '">' . e($label) . '</label>';
    $html .= '<textarea' . adm_attrs($attrs) . '>' . e(adm_val($name, $value)) . '</textarea>' . error_for($name);
    if (!empty($o['help'])) {
        $html .= '<div class="form-text">' . e($o['help']) . '</div>';
    }
    return $html . '</div>';
}

/** @param array<string|int, string> $options value => label */
function adm_select(string $name, string $label, array $options, mixed $selected = '', array $o = []): string
{
    $id = $o['id'] ?? 'f_' . preg_replace('/\W+/', '_', $name);
    $current = adm_val($name, $selected);
    $attrs = array_merge(['id' => $id, 'name' => $name, 'class' => 'form-select' . invalid($name)], $o['attrs'] ?? []);
    $html = '<div class="' . e($o['col'] ?? 'mb-3') . '">' . ($label !== '' ? '<label class="form-label" for="' . e($id) . '">' . e($label) . '</label>' : '');
    $html .= '<select' . adm_attrs($attrs) . '>';
    if (isset($o['placeholder'])) {
        $html .= '<option value="">' . e($o['placeholder']) . '</option>';
    }
    foreach ($options as $val => $text) {
        $extra = '';
        if (is_array($text)) {
            $extra = adm_attrs($text['attrs'] ?? []);
            $text = $text['label'];
        }
        $html .= '<option value="' . e($val) . '"' . ((string) $val === $current ? ' selected' : '') . $extra . '>' . e($text) . '</option>';
    }
    $html .= '</select>' . error_for($name);
    if (!empty($o['help'])) {
        $html .= '<div class="form-text">' . e($o['help']) . '</div>';
    }
    return $html . '</div>';
}

function adm_switch(string $name, string $label, bool $checked, string $help = ''): string
{
    $id = 'f_' . preg_replace('/\W+/', '_', $name);
    $old = App\Core\Session::peekFlash('old', null);
    if (is_array($old) && $old) {
        $checked = !empty($old[$name]);
    }
    return '<div class="switch-row"><label for="' . e($id) . '"><strong>' . e($label) . '</strong>' . ($help ? '<small>' . e($help) . '</small>' : '') . '</label>'
        . '<div class="form-check form-switch m-0"><input type="hidden" name="' . e($name) . '" value="0"><input class="form-check-input" type="checkbox" role="switch" id="' . e($id) . '" name="' . e($name) . '" value="1"' . ($checked ? ' checked' : '') . '></div></div>';
}

/** Single image upload with live preview of the current image. */
function adm_image(string $name, string $label, ?string $current = null, array $o = []): string
{
    $html = '<div class="' . e($o['col'] ?? 'mb-3') . '">' . ($label !== '' ? '<label class="form-label">' . e($label) . '</label>' : '');
    $html .= '<div class="img-drop' . (!empty($o['small']) ? ' small' : '') . '">';
    if ($current) {
        $html .= '<img src="' . e(upload_url($current, '600')) . '" alt="" data-preview="' . e($o['preview_key'] ?? $name) . '">';
    } elseif (!empty($o['preview_key'])) {
        $html .= '<img alt="" hidden data-preview="' . e($o['preview_key']) . '">';
    }
    $html .= '<input type="file" name="' . e($name) . '" accept="image/jpeg,image/png,image/webp,image/gif">';
    $html .= '<div class="hint">' . icon('upload', 'ic-sm') . '<span>' . e($o['hint'] ?? ($current ? 'Click or drop to replace' : 'Click or drop an image')) . '</span></div></div>';
    if (!empty($o['removable']) && $current) {
        $html .= '<label class="form-text d-inline-flex gap-1 mt-1"><input type="checkbox" name="remove_' . e($name) . '" value="1"> Remove image</label>';
    }
    $html .= error_for($name);
    if (!empty($o['help'])) {
        $html .= '<div class="form-text">' . e($o['help']) . '</div>';
    }
    return $html . '</div>';
}

/** Minimal rich-text editor (contenteditable synced to a hidden textarea). */
function adm_rte(string $name, string $label, ?string $value, array $o = []): string
{
    $v = adm_val($name, $value);
    $btn = static fn($cmd, $txt, $val = null, $title = '') => '<button type="button" data-cmd="' . $cmd . '"' . ($val ? ' data-val="' . $val . '"' : '') . ' title="' . e($title ?: $txt) . '">' . $txt . '</button>';
    $bar = $btn('bold', '<b>B</b>', null, 'Bold') . $btn('italic', '<i>I</i>', null, 'Italic') . $btn('underline', '<u>U</u>', null, 'Underline')
        . '<span class="sep"></span>' . $btn('formatBlock', 'H2', 'h2', 'Heading') . $btn('formatBlock', 'H3', 'h3', 'Subheading') . $btn('formatBlock', '¶', 'p', 'Paragraph')
        . '<span class="sep"></span>' . $btn('insertUnorderedList', '• List', null, 'Bulleted list') . $btn('insertOrderedList', '1. List', null, 'Numbered list')
        . $btn('createLink', 'Link', null, 'Insert link') . $btn('removeFormat', 'Clear', null, 'Clear formatting') . '<span class="sep"></span>' . $btn('source', '&lt;/&gt;', null, 'Edit HTML');
    return '<div class="' . e($o['col'] ?? 'mb-3') . '"><label class="form-label">' . e($label) . '</label>'
        . '<div class="rte" data-rte><div class="rte-bar">' . $bar . '</div>'
        . '<div class="rte-area" contenteditable="true">' . $v . '</div>'
        . '<textarea class="rte-src" name="' . e($name) . '">' . e($v) . '</textarea></div>'
        . (!empty($o['help']) ? '<div class="form-text">' . e($o['help']) . '</div>' : '') . '</div>';
}

function adm_badge(string $status): string
{
    return '<span class="badge-a s-' . e($status) . '">' . e(status_label($status)) . '</span>';
}

function adm_pager(App\Core\Paginator $p, string $path): string
{
    $html = '<div class="pager-a"><span class="info">Showing ' . $p->from() . '–' . $p->to() . ' of ' . $p->total . '</span>';
    if ($p->pages > 1) {
        if ($p->page > 1) {
            $html .= '<a href="' . e(query_url(['page' => $p->page - 1], $path)) . '" aria-label="Previous">' . icon('chevron-left', 'ic-sm') . '</a>';
        }
        foreach ($p->window(2) as $n) {
            if ($n === '…') {
                $html .= '<span class="px-1">…</span>';
            } elseif ($n === $p->page) {
                $html .= '<span class="cur">' . $n . '</span>';
            } else {
                $html .= '<a href="' . e(query_url(['page' => $n], $path)) . '">' . $n . '</a>';
            }
        }
        if ($p->hasMore()) {
            $html .= '<a href="' . e(query_url(['page' => $p->page + 1], $path)) . '" aria-label="Next">' . icon('chevron-right', 'ic-sm') . '</a>';
        }
    }
    return $html . '</div>';
}

/** Page header with title (+ italic accent), subtitle and action buttons. */
function adm_head(string $title, string $sub = '', string $actions = '', ?array $crumb = null): string
{
    $html = '<div class="page-head"><div>';
    if ($crumb) {
        $html .= '<a class="crumb" href="' . e(url($crumb[1])) . '">' . icon('arrow-left', 'ic-sm') . ' ' . e($crumb[0]) . '</a>';
    }
    $html .= '<h1>' . $title . '</h1>' . ($sub !== '' ? '<p>' . e($sub) . '</p>' : '') . '</div>';
    if ($actions !== '') {
        $html .= '<div class="actions">' . $actions . '</div>';
    }
    return $html . '</div>';
}

/** Small POST button form (delete/toggle) with CSRF token. */
function adm_post_button(string $path, string $label, string $class = 'btn-a sm light', ?string $confirm = null, string $title = ''): string
{
    return '<form method="post" action="' . e(url($path)) . '"' . ($confirm ? ' data-confirm="' . e($confirm) . '"' : '') . '>' . csrf_field()
        . '<button type="submit" class="' . e($class) . '"' . ($title ? ' title="' . e($title) . '" aria-label="' . e($title) . '"' : '') . '>' . $label . '</button></form>';
}

/** Send a CSV download. */
function csv_download(string $filename, array $header, iterable $rows): never
{
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF");
    fputcsv($out, $header);
    foreach ($rows as $r) {
        // Neutralise spreadsheet formula injection.
        fputcsv($out, array_map(static fn($v) => is_string($v) && preg_match('/^[=+\-@]/', $v) ? "'" . $v : $v, $r));
    }
    fclose($out);
    exit;
}
