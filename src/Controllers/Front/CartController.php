<?php
declare(strict_types=1);

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\Http;
use App\Services\CartService;
use App\Services\ProductService;

final class CartController extends Controller
{
    public function index(): void
    {
        Http::noCache();
        $items = CartService::items();
        $totals = CartService::totals();
        $exclude = array_column($items, 'product_id');
        $suggestions = array_values(array_filter(
            ProductService::list([], 'bestselling', 8),
            static fn($p) => !in_array((int) $p['id'], $exclude, true)
        ));
        $this->view('cart', [
            'items' => $items,
            'totals' => $totals,
            'suggestions' => array_slice($suggestions, 0, 4),
            'meta' => $this->meta('Your shopping bag', null, ['robots' => 'noindex, follow']),
            'bodyClass' => 'page-cart',
        ]);
    }
}
