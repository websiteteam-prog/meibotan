<?php
/** @var array $sections */
foreach ($sections as $section) {
    $file = 'front/home/' . $section['section_key'];
    if (is_file(VIEW_PATH . '/' . $file . '.php')) {
        echo App\Core\View::partial($file, ['s' => $section]);
    }
}
