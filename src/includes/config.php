<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (getenv('APP_ENV') === 'production') {
    // Load the autoloader for Composer dependencies (e.g., phpdotenv)
    if (file_exists(__DIR__ . '../../vendor/autoload.php')) {
        require_once __DIR__ . '../../vendor/autoload.php';
    } else {
        die("Vendor autoloader not found. Please run 'composer install' in the project root.");
    }

    // Load environment variables from .env file
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    } catch (Exception $e) {
        die("Failed to load environment variables: " . $e->getMessage());
    }
}

// Define database constants from .env file with defaults
define('DB_SERVER', $_ENV['DB_SERVER'] ?? '127.0.0.1');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'cms_db');

// Connect to MySQL
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    die("Failed to connect to MySQL: " . mysqli_connect_error() . " (Error #" . mysqli_connect_errno() . ")");
}

// Set charset to utf8mb4
mysqli_set_charset($con, "utf8mb4") or die("Failed to set charset: " . mysqli_error($con));
?>