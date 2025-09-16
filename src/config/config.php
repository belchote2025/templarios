<?php
// Prevent output before session start
ob_start();

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'mariscales_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application paths
define('BASE_PATH', dirname(dirname(__DIR__)));
define('APP_ROOT', dirname(dirname(__DIR__)) . '/public');
define('URL_ROOT', 'http://localhost/prueba-php/public');

// Application settings
define('SITE_NAME', 'Filá Mariscales de Caballeros Templarios de Elche');
define('APP_VERSION', '1.0.0');

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Timezone
date_default_timezone_set('Europe/Madrid');

// Autoload classes
spl_autoload_register(function($className) {
    $paths = [
        dirname(__DIR__) . "/models/",
        dirname(__DIR__) . "/controllers/"
    ];
    
    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Helper functions
require_once 'helpers.php';
