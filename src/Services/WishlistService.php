<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Auth;
use App\Core\DB;
use App\Core\Session;

final class WishlistService
{
    private static ?array $ids = null;

    /** Product ids in the logged-in customer's wishlist. */
    public static function ids(): array
    {
        if (self::$ids === null) {
            $cid = Auth::id();
            self::$ids = $cid ? array_map('intval', DB::column('SELECT product_id FROM wishlist WHERE customer_id = :c', ['c' => $cid])) : [];
        }
        return self::$ids;
    }

    public static function count(): int
    {
        return count(self::ids());
    }

    /** @return bool true when the product is now in the wishlist */
    public static function toggle(int $customerId, int $productId): bool
    {
        $exists = DB::value('SELECT id FROM wishlist WHERE customer_id = :c AND product_id = :p', ['c' => $customerId, 'p' => $productId]);
        if ($exists) {
            DB::delete('wishlist', 'id = :id', ['id' => $exists]);
            self::$ids = null;
            return false;
        }
        self::add($customerId, $productId);
        return true;
    }

    public static function add(int $customerId, int $productId): void
    {
        // INSERT IGNORE + unique key prevents duplicates even on double clicks.
        DB::exec('INSERT IGNORE INTO wishlist (customer_id, product_id, created_at) VALUES (:c, :p, NOW())', ['c' => $customerId, 'p' => $productId]);
        self::$ids = null;
    }

    public static function remove(int $customerId, int $productId): void
    {
        DB::delete('wishlist', 'customer_id = :c AND product_id = :p', ['c' => $customerId, 'p' => $productId]);
        self::$ids = null;
    }

    /** Remember a product a guest tried to save; added after they sign in. */
    public static function setPending(int $productId): void
    {
        Session::put('pending_wishlist', $productId);
    }

    public static function processPending(int $customerId): void
    {
        $pid = (int) Session::pull('pending_wishlist', 0);
        if ($pid > 0 && DB::value('SELECT id FROM products WHERE id = :id AND is_active = 1', ['id' => $pid])) {
            self::add($customerId, $pid);
            $name = (string) DB::value('SELECT name FROM products WHERE id = :id', ['id' => $pid]);
            flash('success', '“' . $name . '” has been added to your wishlist.');
        }
        self::$ids = null;
    }

    /** Full wishlist rows (decorated products). */
    public static function items(int $customerId): array
    {
        $ids = DB::column('SELECT product_id FROM wishlist WHERE customer_id = :c ORDER BY created_at DESC', ['c' => $customerId]);
        return ProductService::byIds($ids, 100);
    }
}
