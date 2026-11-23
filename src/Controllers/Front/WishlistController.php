<?php
declare(strict_types=1);

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\Auth;
use App\Core\Http;
use App\Services\WishlistService;

final class WishlistController extends Controller
{
    public function index(): void
    {
        Http::noCache();
        $this->view('wishlist', [
            'items' => WishlistService::items((int) Auth::id()),
            'meta' => $this->meta('My wishlist', null, ['robots' => 'noindex, follow']),
        ]);
    }

    /** Non-JS fallback for removing an item. */
    public function remove(string $id): void
    {
        WishlistService::remove((int) Auth::id(), (int) $id);
        flash('success', 'Removed from your wishlist.');
        redirect('/wishlist');
    }
}
