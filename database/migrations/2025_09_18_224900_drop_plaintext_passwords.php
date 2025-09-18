<?php

return function($pdo) {
    try {
        echo "\n=== Drop plaintext/temporary password columns if they exist ===\n";

        // Helper to check if a column exists in a table
        $columnExists = function($table, $column) use ($pdo) {
            $sql = "SELECT COUNT(*) AS cnt
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_SCHEMA = :schema
                      AND TABLE_NAME = :table
                      AND COLUMN_NAME = :column";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':schema' => defined('DB_NAME') ? DB_NAME : getenv('DB_NAME'),
                ':table' => $table,
                ':column' => $column,
            ]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row && (int)$row['cnt'] > 0;
        };

        $tables = ['users', 'usuarios'];
        $columnsToDrop = ['password_plain', 'temp_password', 'temp_password_created'];

        foreach ($tables as $table) {
            // Verify table exists first
            $stmt = $pdo->prepare("SELECT COUNT(*) AS cnt
                                   FROM INFORMATION_SCHEMA.TABLES
                                   WHERE TABLE_SCHEMA = :schema AND TABLE_NAME = :table");
            $stmt->execute([
                ':schema' => defined('DB_NAME') ? DB_NAME : getenv('DB_NAME'),
                ':table' => $table,
            ]);
            $tbl = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$tbl || (int)$tbl['cnt'] === 0) {
                echo "- Table '{$table}' does not exist. Skipping.\n";
                continue;
            }

            foreach ($columnsToDrop as $col) {
                if ($columnExists($table, $col)) {
                    $sql = "ALTER TABLE `{$table}` DROP COLUMN `{$col}`";
                    $pdo->exec($sql);
                    echo "✅ Dropped column '{$col}' from '{$table}'\n";
                } else {
                    echo "- Column '{$col}' not found in '{$table}'.\n";
                }
            }
        }

        echo "\n✅ Migration completed: insecure password columns removed (if present).\n";
    } catch (PDOException $e) {
        echo "\n❌ Migration failed: " . $e->getMessage() . "\n";
        throw $e;
    }
};
