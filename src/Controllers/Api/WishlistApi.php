<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Auth;
use App\Core\DB;
use App\Services\WishlistService;

final class WishlistApi
{
    /**
     * Toggle a product in the wishlist. Guests receive 401 and the product is
     * remembered so it can be added automatically right after they sign in.
     */
    public function toggle(): void
    {
        $productId = input_int('product_id');
        $product = DB::one('SELECT id, name FROM products WHERE id = :id AND is_active = 1', ['id' => $productId]);
        if (!$product) {
            json_response(['ok' => false, 'message' => 'This product is no longer available.'], 404);
        }
        $customerId = Auth::id();
        if (!$customerId) {
            WishlistService::setPending($productId);
            json_response(['ok' => false, 'auth' => false, 'message' => 'Please sign in to save your favourites.'], 401);
        }
        $added = WishlistService::toggle($customerId, $productId);
        json_response([
            'ok' => true,
            'in_wishlist' => $added,
            'wishlist_count' => WishlistService::count(),
            'message' => $added ? '“' . $product['name'] . '” saved to your wishlist.' : 'Removed from your wishlist.',
        ]);
    }
}
