<?php
/**
 * Scheduled maintenance — run every 15 minutes:
 *   * /15 * * * * php /path/to/site/bin/cron.php >/dev/null 2>&1
 *
 * - Cancels online-payment orders left unpaid for 2+ hours (returns their stock).
 * - Removes expired password-reset and remember-me tokens and old login attempts.
 * - Deletes abandoned guest carts older than 30 days.
 */
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit('CLI only');
}
require dirname(__DIR__) . '/src/bootstrap.php';

use App\Core\DB;

$cancelled = App\Services\OrderService::cancelStaleUnpaid(2);
DB::exec('DELETE FROM password_resets WHERE expires_at < NOW()');
DB::exec('DELETE FROM customer_remember_tokens WHERE expires_at < NOW()');
DB::exec('DELETE FROM login_attempts WHERE attempted_at < NOW() - INTERVAL 1 DAY');
$carts = DB::exec('DELETE FROM carts WHERE customer_id IS NULL AND COALESCE(updated_at, created_at) < NOW() - INTERVAL 30 DAY');
echo date('c') . " cron: cancelled {$cancelled} unpaid order(s), removed {$carts} stale guest cart(s)\n";
