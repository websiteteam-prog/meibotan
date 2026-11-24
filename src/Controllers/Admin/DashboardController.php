<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\DB;
use App\Core\Settings;
use App\Services\Razorpay;

final class DashboardController extends Controller
{
    public function index(): void
    {
        $valid = "status NOT IN ('cancelled','refunded')";
        $stats = [
            'sales' => (float) DB::value("SELECT COALESCE(SUM(total),0) FROM orders WHERE {$valid}"),
            'sales_month' => (float) DB::value("SELECT COALESCE(SUM(total),0) FROM orders WHERE {$valid} AND created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')"),
            'sales_last_month' => (float) DB::value("SELECT COALESCE(SUM(total),0) FROM orders WHERE {$valid} AND created_at >= DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01') AND created_at < DATE_FORMAT(NOW(), '%Y-%m-01')"),
            'orders' => (int) DB::value('SELECT COUNT(*) FROM orders'),
            'orders_today' => (int) DB::value('SELECT COUNT(*) FROM orders WHERE DATE(created_at) = CURDATE()'),
            'customers' => (int) DB::value('SELECT COUNT(*) FROM customers'),
            'customers_month' => (int) DB::value("SELECT COUNT(*) FROM customers WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')"),
            'products' => (int) DB::value('SELECT COUNT(*) FROM products'),
            'products_active' => (int) DB::value('SELECT COUNT(*) FROM products WHERE is_active = 1'),
            'pending' => (int) DB::value("SELECT COUNT(*) FROM orders WHERE status IN ('pending','processing','confirmed')"),
            'completed' => (int) DB::value("SELECT COUNT(*) FROM orders WHERE status = 'delivered'"),
            'shipped' => (int) DB::value("SELECT COUNT(*) FROM orders WHERE status = 'shipped'"),
            'aov' => (float) DB::value("SELECT COALESCE(AVG(total),0) FROM orders WHERE {$valid}"),
        ];

        // Sales over the last 30 days.
        $rows = DB::all("SELECT DATE(created_at) AS d, SUM(total) AS t, COUNT(*) AS c FROM orders WHERE {$valid} AND created_at >= CURDATE() - INTERVAL 29 DAY GROUP BY DATE(created_at)");
        $byDay = array_column($rows, null, 'd');
        $series = [];
        for ($i = 29; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-{$i} days"));
            $series[] = ['date' => $d, 'total' => (float) ($byDay[$d]['t'] ?? 0), 'count' => (int) ($byDay[$d]['c'] ?? 0)];
        }

        $threshold = (int) Settings::get('low_stock_threshold', 5);
        $lowStock = DB::all(
            "SELECT p.id, p.name, p.image, p.sku, NULL AS variant, p.stock_qty AS qty FROM products p
             WHERE p.is_active = 1 AND p.stock_qty <= :t1 AND NOT EXISTS (SELECT 1 FROM product_variants v WHERE v.product_id = p.id AND v.is_active = 1)
             UNION ALL
             SELECT p.id, p.name, COALESCE(v.image, p.image), COALESCE(v.sku, p.sku), v.name, v.stock_qty FROM product_variants v INNER JOIN products p ON p.id = v.product_id
             WHERE p.is_active = 1 AND v.is_active = 1 AND v.stock_qty <= :t2
             ORDER BY qty ASC LIMIT 10",
            ['t1' => $threshold, 't2' => $threshold]
        );

        $this->admin('dashboard', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'stats' => $stats,
            'series' => $series,
            'recent' => DB::all('SELECT * FROM orders ORDER BY created_at DESC LIMIT 8'),
            'best' => DB::all(
                "SELECT p.id, p.name, p.image, p.sku, SUM(oi.quantity) AS qty, SUM(oi.line_total) AS revenue
                 FROM order_items oi INNER JOIN orders o ON o.id = oi.order_id INNER JOIN products p ON p.id = oi.product_id
                 WHERE o.{$valid} GROUP BY p.id, p.name, p.image, p.sku ORDER BY qty DESC LIMIT 5"
            ) ?: DB::all('SELECT id, name, image, sku, sold_count AS qty, NULL AS revenue FROM products ORDER BY sold_count DESC LIMIT 5'),
            'statusCounts' => array_column(DB::all('SELECT status, COUNT(*) AS c FROM orders GROUP BY status'), 'c', 'status'),
            'lowStock' => $lowStock,
            'threshold' => $threshold,
            'checklist' => array_filter([
                password_verify('ChangeMe@2026', (string) (admin_user()['password_hash'] ?? '')) ? ['You are still using the default admin password from the SQL import — change it now.', 'admin/profile'] : null,
                Settings::get('mail_driver', 'log') === 'log' ? ['E-mails are in “log” mode — configure SMTP so customers receive order e-mails.', 'admin/settings?tab=email'] : null,
                !Razorpay::enabled() ? ['Online payments are off — add your Razorpay keys to accept UPI and cards.', 'admin/settings?tab=payment'] : null,
                (int) DB::value("SELECT COUNT(*) FROM products WHERE image LIKE 'products/demo-%'") > 0 ? ['Demo products and images are still live — replace them with your real catalogue.', 'admin/products'] : null,
            ]),
            'unpaidStale' => (int) DB::value("SELECT COUNT(*) FROM orders WHERE payment_method = 'razorpay' AND payment_status <> 'paid' AND status = 'pending' AND created_at < NOW() - INTERVAL 2 HOUR"),
        ]);
    }
}
