<?php

declare(strict_types=1);

/**
 * Simple migration runner.
 *
 * Usage: php database/migrate.php
 *
 * Migrations are SQL files in database/migrations/ named with a timestamp prefix:
 *   2024_01_01_000000_create_articles_table.sql
 *
 * A `migrations` table tracks which files have already run.
 */

require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/bootstrap.php';

use App\Core\Database;

try {
    $pdo = Database::connection();
} catch (Throwable $e) {
    echo "Database connection failed: {$e->getMessage()}\n";
    exit(1);
}

// Ensure migrations tracking table exists
$pdo->exec('CREATE TABLE IF NOT EXISTS migrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL UNIQUE,
    executed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

// Get already-run migrations
$executed = $pdo->query('SELECT migration FROM migrations ORDER BY id')
    ->fetchAll(PDO::FETCH_COLUMN);

$executed = array_flip($executed);

// Scan migration files
$migrationsDir = __DIR__ . '/migrations';
$files = glob($migrationsDir . '/*.sql');
sort($files);

$ran = 0;

foreach ($files as $file) {
    $name = basename($file);

    if (isset($executed[$name])) {
        continue;
    }

    $sql = file_get_contents($file);
    if ($sql === false || trim($sql) === '') {
        echo "  SKIP  {$name} (empty)\n";
        continue;
    }

    echo "  RUN   {$name} ... ";

    try {
        $pdo->exec($sql);
        $stmt = $pdo->prepare('INSERT INTO migrations (migration) VALUES (:name)');
        $stmt->execute([':name' => $name]);
        echo "OK\n";
        $ran++;
    } catch (Throwable $e) {
        echo "FAIL: {$e->getMessage()}\n";
        exit(1);
    }
}

if ($ran === 0) {
    echo "Nothing to migrate.\n";
} else {
    echo "\n{$ran} migration(s) executed.\n";
}
