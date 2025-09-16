<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Output buffering
ob_start();

echo "Starting database connection test...\n";

try {
    // Load config
    $configPath = __DIR__ . '/../src/config/config.php';
    if (!file_exists($configPath)) {
        throw new Exception("Config file not found at: $configPath");
    }
    require_once $configPath;

    // Check if constants are defined
    if (!defined('DB_HOST') || !defined('DB_NAME') || !defined('DB_USER')) {
        throw new Exception("Database configuration constants are not properly defined in config.php");
    }

    // Test database connection
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    echo "Attempting to connect with DSN: $dsn\n";
    echo "Using username: " . DB_USER . "\n";
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Successfully connected to the database!\n\n";
    
    // Check if migrations table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'migrations'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Migrations table exists.\n";
    } else {
        echo "⚠️ Migrations table does not exist. It will be created when you run migrations.\n";
    }
    
    // List all tables
    echo "\n📋 Existing tables in the database:\n";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "No tables found in the database.\n";
    } else {
        foreach ($tables as $table) {
            echo "- $table\n";
        }
    }
    
    // Test creating a test table
    echo "\n🧪 Testing table creation...\n";
    $testTable = "test_table_" . time();
    $pdo->exec("CREATE TABLE IF NOT EXISTS `$testTable` (id INT AUTO_INCREMENT PRIMARY KEY, test VARCHAR(50))");
    echo "✅ Successfully created test table: $testTable\n";
    
    // Clean up
    $pdo->exec("DROP TABLE IF EXISTS `$testTable`");
    echo "✅ Cleaned up test table.\n";
    
} catch (PDOException $e) {
    echo "\n❌ PDO Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
    
    // Check for common connection issues
    if ($e->getCode() == 2002) {
        echo "\n⚠️ Could not connect to the database server. Please check if the MySQL server is running.\n";
    } elseif ($e->getCode() == 1045) {
        echo "\n⚠️ Access denied. Please check your database username and password in config.php\n";
    } elseif ($e->getCode() == 1049) {
        echo "\n⚠️ Database does not exist. Please create the database: " . DB_NAME . "\n";
    }
    
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
}

// Flush output buffer
ob_end_flush();
