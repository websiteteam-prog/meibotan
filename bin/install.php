<?php
/**
 * Savié Amour installer (CLI).
 *
 *   php bin/install.php                       interactive set-up
 *   php bin/install.php --fresh --demo        drop all tables, recreate, load demo content
 *   php bin/install.php --admin-email=a@b.com --admin-password=Secret123 --admin-name="Store Owner"
 *
 * Options:
 *   --fresh            Drop existing tables first (DESTROYS DATA)
 *   --demo             Load demo catalogue, banners, pages and settings
 *   --no-interaction   Never prompt; use config/config.php and given options
 */
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit('Run this script from the command line.');
}

$root = dirname(__DIR__);
$opts = getopt('', ['fresh', 'demo', 'no-interaction', 'admin-email:', 'admin-password:', 'admin-name:', 'app-url:', 'db-host:', 'db-name:', 'db-user:', 'db-pass:']);
$interactive = !isset($opts['no-interaction']);

function ask(string $q, string $default = '', bool $interactive = true): string
{
    if (!$interactive) {
        return $default;
    }
    $suffix = $default !== '' ? " [{$default}]" : '';
    $answer = readline($q . $suffix . ': ');
    return ($answer === false || trim($answer) === '') ? $default : trim($answer);
}

echo "\n  Savié Amour — installer\n  -----------------------\n\n";

// 1. Configuration file -------------------------------------------------------
$configFile = $root . '/config/config.php';
if (!is_file($configFile)) {
    $sample = file_get_contents($root . '/config/config.sample.php');
    $appUrl = $opts['app-url'] ?? ask('Site URL', 'http://localhost:8000', $interactive);
    $host = $opts['db-host'] ?? ask('Database host', '127.0.0.1', $interactive);
    $name = $opts['db-name'] ?? ask('Database name', 'savie_amour', $interactive);
    $user = $opts['db-user'] ?? ask('Database user', 'root', $interactive);
    $pass = $opts['db-pass'] ?? ask('Database password', '', $interactive);
    $replace = [
        "'http://localhost:8000'" => var_export(rtrim($appUrl, '/'), true),
        "'change-me-to-a-long-random-string'" => var_export(bin2hex(random_bytes(32)), true),
        "'host'     => '127.0.0.1'" => "'host'     => " . var_export($host, true),
        "'database' => 'savie_amour'" => "'database' => " . var_export($name, true),
        "'username' => 'root'" => "'username' => " . var_export($user, true),
        "'password' => ''" => "'password' => " . var_export($pass, true),
    ];
    file_put_contents($configFile, strtr($sample, $replace));
    echo "  ✓ Created config/config.php\n";
}

$config = require $configFile;
$db = $config['db'];

// 2. Database -----------------------------------------------------------------
try {
    $pdo = new PDO(sprintf('mysql:host=%s;port=%d;charset=utf8mb4', $db['host'], $db['port'] ?? 3306), $db['username'], $db['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . str_replace('`', '', $db['database']) . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $pdo->exec('USE `' . str_replace('`', '', $db['database']) . '`');
} catch (PDOException $e) {
    fwrite(STDERR, "  ✗ Database connection failed: {$e->getMessage()}\n");
    exit(1);
}

if (isset($opts['fresh'])) {
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    foreach ($pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN) as $t) {
        $pdo->exec('DROP TABLE IF EXISTS `' . $t . '`');
    }
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    echo "  ✓ Dropped existing tables\n";
}

$schema = file_get_contents($root . '/database/schema.sql');
$schema = preg_replace('/^\s*--.*$/m', '', $schema);
foreach (array_filter(array_map('trim', explode(";\n", $schema))) as $sql) {
    $pdo->exec($sql);
}
echo "  ✓ Database tables ready\n";
$pdo->exec("INSERT INTO settings (`key`, `value`, `group`, updated_at) VALUES ('schema_version', '2', 'system', NOW()) ON DUPLICATE KEY UPDATE `value` = GREATEST(`value`, '2')");

// Boot the application now that config + tables exist.
require $root . '/src/bootstrap.php';
App\Core\DB::setPdo($pdo);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// 3. Demo content -------------------------------------------------------------
$hasProducts = (int) App\Core\DB::value('SELECT COUNT(*) FROM products') > 0;
$loadDemo = isset($opts['demo']) || (!$hasProducts && strtolower(ask('Load demo catalogue and content? (y/n)', 'y', $interactive)) === 'y');
if ($loadDemo) {
    if ($hasProducts) {
        echo "  • Products already exist — skipping demo content (use --fresh to reset)\n";
    } else {
        (require $root . '/database/seed.php')();
        echo "  ✓ Demo content loaded\n";
    }
}

// 4. Admin account -------------------------------------------------------------
$adminCount = (int) App\Core\DB::value('SELECT COUNT(*) FROM admins');
if ($adminCount === 0 || isset($opts['admin-email'])) {
    $email = strtolower($opts['admin-email'] ?? ask('Admin e-mail', 'admin@savieamour.com', $interactive));
    $name = $opts['admin-name'] ?? ask('Admin name', 'Store Owner', $interactive);
    $password = $opts['admin-password'] ?? '';
    while (strlen($password) < 8) {
        if (!$interactive) {
            fwrite(STDERR, "  ✗ Provide --admin-password (8+ characters)\n");
            exit(1);
        }
        $password = ask('Admin password (8+ characters)', '', true);
    }
    $existing = App\Core\DB::value('SELECT id FROM admins WHERE email = :e', ['e' => $email]);
    if ($existing) {
        App\Core\DB::update('admins', ['password_hash' => password_hash($password, PASSWORD_DEFAULT), 'is_active' => 1], 'id = :id', ['id' => $existing]);
        echo "  ✓ Updated admin {$email}\n";
    } else {
        $role = $adminCount === 0 ? 'developer' : 'super_admin';
        App\Core\DB::insert('admins', ['name' => $name, 'email' => $email, 'password_hash' => password_hash($password, PASSWORD_DEFAULT), 'role' => $role, 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')]);
        echo "  ✓ Created " . ($role === 'developer' ? 'developer (full access)' : 'store owner') . " account {$email}\n";
    }
}

foreach (['storage/logs', 'storage/cache', 'public/uploads'] as $dir) {
    if (!is_writable($root . '/' . $dir)) {
        echo "  ! Make {$dir} writable by the web server\n";
    }
}

echo "\n  All set. Storefront: {$config['app_url']}  ·  Admin: {$config['app_url']}/admin\n\n";
