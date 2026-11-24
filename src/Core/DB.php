<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOStatement;
use Throwable;

/**
 * Thin PDO wrapper. Every query uses prepared statements with bound
 * parameters — never interpolate user input into SQL strings.
 */
final class DB
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            $c = config('db');
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $c['host'],
                (int) ($c['port'] ?? 3306),
                $c['database'],
                $c['charset'] ?? 'utf8mb4'
            );
            try {
                self::$pdo = new PDO($dsn, $c['username'], $c['password'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::ATTR_STRINGIFY_FETCHES  => false,
                ]);
            } catch (\PDOException $e) {
                self::connectionHelp($e, $c);
            }
            $offset = (new \DateTime())->format('P');
            self::$pdo->exec("SET time_zone = '{$offset}', sql_mode = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION'");
        }
        return self::$pdo;
    }

    /** Explain a failed database connection in plain words (instead of a blank error page). */
    private static function connectionHelp(\PDOException $e, array $c): never
    {
        if (PHP_SAPI === 'cli') {
            throw $e;
        }
        error_log('DB connection failed: ' . $e->getMessage());
        $msg = $e->getMessage();
        $db = (string) $c['database'];
        $fix = '<p>Open <code>config/config.php</code> and check the <code>db</code> section.</p>';
        if (str_contains($msg, '1049') || stripos($msg, 'Unknown database') !== false) {
            $title = 'Database “' . $db . '” was not found';
            $list = [];
            try {
                $tmp = new PDO(sprintf('mysql:host=%s;port=%d;charset=utf8mb4', $c['host'], (int) ($c['port'] ?? 3306)), $c['username'], $c['password']);
                $list = array_values(array_diff($tmp->query('SHOW DATABASES')->fetchAll(PDO::FETCH_COLUMN), ['information_schema', 'mysql', 'performance_schema', 'sys', 'phpmyadmin', 'test']));
            } catch (\Throwable) {
            }
            $fix = '<p>In <code>config/config.php</code>, set <code>\'database\' =&gt; \'…\'</code> to the exact name of the database you created in phpMyAdmin.</p>'
                . ($list ? '<p>Databases found on this server: <strong>' . e(implode(', ', $list)) . '</strong></p>' : '<p>No databases were found — create one in phpMyAdmin and import <code>database/savie_amour_full.sql</code> into it.</p>');
        } elseif (str_contains($msg, '1045') || stripos($msg, 'Access denied') !== false) {
            $title = 'MySQL username or password is wrong';
            $fix = '<p>In <code>config/config.php</code>, fix <code>\'username\'</code> and <code>\'password\'</code>. On XAMPP the defaults are <code>root</code> and an empty password <code>\'\'</code>.</p>';
        } elseif (str_contains($msg, '2002') || stripos($msg, 'refused') !== false || stripos($msg, 'No such file') !== false) {
            $title = 'MySQL is not running';
            $fix = '<p>Start <strong>MySQL</strong> in the XAMPP Control Panel (or your hosting panel), then refresh this page. Also check <code>\'host\'</code> (<code>127.0.0.1</code> or <code>localhost</code>) and <code>\'port\'</code> (usually 3306) in <code>config/config.php</code>.</p>';
        } else {
            $title = 'Could not connect to the database';
        }
        setup_error_page($title, $fix . '<p style="color:#6c6260;font-size:13px;margin-bottom:0">Technical detail: ' . e($msg) . '</p>');
    }

    public static function setPdo(PDO $pdo): void
    {
        self::$pdo = $pdo;
    }

    public static function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = self::pdo()->prepare($sql);
        foreach ($params as $key => $value) {
            $param = is_int($key) ? $key + 1 : (str_starts_with((string) $key, ':') ? $key : ':' . $key);
            $type = match (true) {
                is_int($value)  => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                $value === null => PDO::PARAM_NULL,
                default         => PDO::PARAM_STR,
            };
            $stmt->bindValue($param, $value, $type);
        }
        $stmt->execute();
        return $stmt;
    }

    /** @return array<int, array<string, mixed>> */
    public static function all(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll();
    }

    public static function one(string $sql, array $params = []): ?array
    {
        $row = self::query($sql, $params)->fetch();
        return $row === false ? null : $row;
    }

    public static function value(string $sql, array $params = []): mixed
    {
        $v = self::query($sql, $params)->fetchColumn();
        return $v === false ? null : $v;
    }

    /** @return array<int, mixed> */
    public static function column(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function exec(string $sql, array $params = []): int
    {
        return self::query($sql, $params)->rowCount();
    }

    public static function insert(string $table, array $data): int
    {
        self::assertIdentifier($table);
        $cols = array_keys($data);
        array_walk($cols, [self::class, 'assertIdentifier']);
        $sql = sprintf(
            'INSERT INTO `%s` (`%s`) VALUES (%s)',
            $table,
            implode('`, `', $cols),
            implode(', ', array_map(static fn($c) => ':' . $c, $cols))
        );
        self::query($sql, $data);
        return (int) self::pdo()->lastInsertId();
    }

    /**
     * UPDATE helper. $where is a SQL fragment using named params, e.g. "id = :id".
     */
    public static function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        self::assertIdentifier($table);
        $sets = [];
        $params = [];
        foreach ($data as $col => $val) {
            self::assertIdentifier($col);
            $sets[] = "`{$col}` = :set_{$col}";
            $params['set_' . $col] = $val;
        }
        $sql = sprintf('UPDATE `%s` SET %s WHERE %s', $table, implode(', ', $sets), $where);
        return self::exec($sql, array_merge($params, $whereParams));
    }

    public static function delete(string $table, string $where, array $params = []): int
    {
        self::assertIdentifier($table);
        return self::exec("DELETE FROM `{$table}` WHERE {$where}", $params);
    }

    /**
     * Run a callback inside a transaction; rolls back on any exception.
     * @template T
     * @param callable(): T $callback
     * @return T
     */
    public static function transaction(callable $callback): mixed
    {
        $pdo = self::pdo();
        if ($pdo->inTransaction()) {
            return $callback();
        }
        $pdo->beginTransaction();
        try {
            $result = $callback();
            $pdo->commit();
            return $result;
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    /** Build "IN (:p0, :p1)" placeholders for an array, merging params. */
    public static function in(array $values, array &$params, string $prefix = 'in'): string
    {
        if (!$values) {
            return '(NULL)';
        }
        $keys = [];
        foreach (array_values($values) as $i => $v) {
            $k = $prefix . $i;
            $keys[] = ':' . $k;
            $params[$k] = $v;
        }
        return '(' . implode(', ', $keys) . ')';
    }

    private static function assertIdentifier(string $name): void
    {
        if (!preg_match('/^[A-Za-z0-9_]+$/', $name)) {
            throw new \InvalidArgumentException('Invalid SQL identifier: ' . $name);
        }
    }
}
