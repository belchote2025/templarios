<?php
/**
 * Database Migration Script
 * 
 * This script runs all pending database migrations.
 */

// Load configuration
require_once __DIR__ . '/../src/config/config.php';

class MigrationRunner {
    private $pdo;
    private $migrationsTable = 'migrations';
    private $migrationsDir;
    
    public function __construct() {
        $this->migrationsDir = __DIR__ . '/migrations';
        $this->connect();
        $this->ensureMigrationsTableExists();
    }
    
    private function connect() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    private function ensureMigrationsTableExists() {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->migrationsTable}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `migration` varchar(255) NOT NULL,
            `batch` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `migration` (`migration`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->pdo->exec($sql);
    }
    
    public function runMigrations() {
        // Enable error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        echo "=== Starting Migration Process ===\n";
        echo "PHP Version: " . phpversion() . "\n";
        
        // Check if migrations directory exists and is readable
        if (!is_dir($this->migrationsDir)) {
            die("❌ Error: Migrations directory does not exist: {$this->migrationsDir}\n");
        }
        
        if (!is_readable($this->migrationsDir)) {
            die("❌ Error: Migrations directory is not readable: {$this->migrationsDir}\n");
        }
        
        // Get all migration files
        $migrationFiles = glob($this->migrationsDir . '/*.php');
        
        if (empty($migrationFiles)) {
            die("❌ Error: No migration files found in {$this->migrationsDir}\n");
        }
        
        // Sort migration files by name
        sort($migrationFiles);
        
        echo "✅ Found " . count($migrationFiles) . " migration files\n";
        
        // Get already run migrations
        try {
            $stmt = $this->pdo->query("SELECT migration FROM `{$this->migrationsTable}` ORDER BY id");
            $ranMigrations = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "✅ Found " . count($ranMigrations) . " previously run migrations\n";
        } catch (PDOException $e) {
            // If migrations table doesn't exist, create it
            if ($e->getCode() == '42S02') { // Table doesn't exist
                echo "⚠️ Migrations table does not exist. Creating it...\n";
                $this->ensureMigrationsTableExists();
                $ranMigrations = [];
            } else {
                throw $e; // Re-throw other PDO exceptions
            }
        }
        
        // Get the next batch number
        $batch = $this->getNextBatchNumber();
        $newMigrations = [];
        
        // Start transaction
        echo "\n=== Starting Transaction ===\n";
        $this->pdo->beginTransaction();
        
        
        try {
            foreach ($migrationFiles as $file) {
                $migrationName = basename($file);
                
                // Skip already run migrations
                if (in_array($migrationName, $ranMigrations)) {
                    continue;
                }
                
                // Include the migration file
                $migration = require $file;
                
                // Run the migration
                if (is_callable($migration)) {
                    $migration($this->pdo);
                    
                    // Record the migration
                    $stmt = $this->pdo->prepare("
                        INSERT INTO `{$this->migrationsTable}` (migration, batch) 
                        VALUES (?, ?)
                    ");
                    
                    $stmt->execute([$migrationName, $batch]);
                    
                    $newMigrations[] = $migrationName;
                    echo "Migrated: $migrationName\n";
                }
            }
            
            $this->pdo->commit();
            
            if (empty($newMigrations)) {
                echo "No new migrations to run.\n";
            } else {
                echo "\nSuccessfully ran " . count($newMigrations) . " migration(s).\n";
            }
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            die("Migration failed: " . $e->getMessage() . "\n");
        }
    }
    
    private function getNextBatchNumber() {
        $stmt = $this->pdo->query("SELECT MAX(batch) as max_batch FROM `{$this->migrationsTable}`");
        $result = $stmt->fetch();
        return ($result && $result['max_batch'] !== null) ? $result['max_batch'] + 1 : 1;
    }
}

// Run the migrations
$migrationRunner = new MigrationRunner();
$migrationRunner->runMigrations();
