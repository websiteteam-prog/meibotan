<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;

abstract class Controller
{
    /** Render a storefront view inside the front layout. */
    protected function view(string $view, array $data = []): void
    {
        echo View::render('front/' . $view, $data, 'layouts/front');
    }

    /** Render an admin view inside the admin layout. */
    protected function admin(string $view, array $data = []): void
    {
        echo View::render('admin/' . $view, $data, 'layouts/admin');
    }

    protected function meta(string $title, ?string $description = null, array $extra = []): array
    {
        $site = (string) setting('site_name', 'Savié Amour');
        return array_merge([
            'title' => str_contains($title, $site) ? $title : $title . ' | ' . $site,
            'description' => $description ?? (string) setting('meta_description', ''),
        ], $extra);
    }
}
