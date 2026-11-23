<?php
declare(strict_types=1);

namespace App\Core;

/**
 * PHP template renderer. Views live in /views and receive $data as variables.
 * A view can be wrapped in a layout which receives the rendered view as $content.
 */
final class View
{
    private static array $shared = [];

    public static function share(string $key, mixed $value): void
    {
        self::$shared[$key] = $value;
    }

    public static function render(string $view, array $data = [], ?string $layout = null): string
    {
        $content = self::renderFile($view, $data);
        if ($layout === null) {
            return $content;
        }
        return self::renderFile($layout, array_merge($data, ['content' => $content]));
    }

    public static function partial(string $view, array $data = []): string
    {
        return self::renderFile($view, $data);
    }

    private static function renderFile(string $view, array $data): string
    {
        $file = VIEW_PATH . '/' . $view . '.php';
        if (!is_file($file)) {
            throw new \RuntimeException("View not found: {$view}");
        }
        extract(array_merge(self::$shared, $data), EXTR_SKIP);
        ob_start();
        try {
            include $file;
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }
        return (string) ob_get_clean();
    }
}
