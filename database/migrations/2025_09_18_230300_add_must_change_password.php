<?php

return function($pdo) {
    try {
        echo "\n=== Ensure users.must_change_password column exists ===\n";

        $schema = defined('DB_NAME') ? DB_NAME : getenv('DB_NAME');

        // Check if users table exists
        $stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :schema AND TABLE_NAME = 'users'");
        $stmt->execute([':schema' => $schema]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row || (int)$row['cnt'] === 0) {
            echo "- Table 'users' does not exist. Skipping.\n";
            return;
        }

        // Check if column exists
        $stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = :schema AND TABLE_NAME = 'users' AND COLUMN_NAME = 'must_change_password'");
        $stmt->execute([':schema' => $schema]);
        $col = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($col && (int)$col['cnt'] > 0) {
            echo "- Column 'must_change_password' already exists.\n";
        } else {
            $pdo->exec("ALTER TABLE `users` ADD COLUMN `must_change_password` TINYINT(1) NOT NULL DEFAULT 0 AFTER `password`");
            echo "✅ Added column 'must_change_password' to 'users'\n";
        }

        echo "\n✅ Migration completed successfully.\n";
    } catch (PDOException $e) {
        echo "\n❌ Migration failed: " . $e->getMessage() . "\n";
        throw $e;
    }
};
