<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Automatic database upgrades.
 *
 * When new features need new tables/columns, the steps below run once on the
 * next page load (tracked by the "schema_version" setting), so an existing
 * database never has to be re-imported. Each step is idempotent.
 */
final class Schema
{
    public const VERSION = 2;

    public static function upgrade(): void
    {
        $current = (int) Settings::get('schema_version', '1');
        if ($current >= self::VERSION) {
            return;
        }
        try {
            if ($current < 2) {
                self::v2();
            }
            Settings::set('schema_version', (string) self::VERSION, 'system');
        } catch (\Throwable $e) {
            error_log('Schema upgrade failed: ' . $e->getMessage());
        }
    }

    private static function hasColumn(string $table, string $column): bool
    {
        return (bool) DB::value(
            'SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = :c',
            ['t' => $table, 'c' => $column]
        );
    }

    /** v2: review photos, developer role, courier tracking link. */
    private static function v2(): void
    {
        DB::pdo()->exec(
            'CREATE TABLE IF NOT EXISTS review_images (
               id INT UNSIGNED NOT NULL AUTO_INCREMENT,
               review_id INT UNSIGNED NOT NULL,
               image VARCHAR(255) NOT NULL,
               sort_order INT NOT NULL DEFAULT 0,
               created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
               PRIMARY KEY (id),
               KEY idx_review_images_review (review_id),
               CONSTRAINT fk_review_images_review FOREIGN KEY (review_id) REFERENCES reviews (id) ON DELETE CASCADE
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
        );
        DB::pdo()->exec("ALTER TABLE admins MODIFY role ENUM('developer','super_admin','manager','support') NOT NULL DEFAULT 'manager'");
        // The original installer account belongs to the website developer.
        if (!DB::value("SELECT id FROM admins WHERE role = 'developer' LIMIT 1")) {
            DB::exec("UPDATE admins SET role = 'developer' WHERE id = (SELECT id FROM (SELECT MIN(id) AS id FROM admins WHERE role = 'super_admin') t)");
        }
        if (!self::hasColumn('orders', 'tracking_url')) {
            DB::pdo()->exec('ALTER TABLE orders ADD COLUMN tracking_url VARCHAR(500) NULL AFTER tracking_number');
        }
    }
}
