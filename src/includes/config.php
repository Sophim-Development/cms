<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// src/includes/config.php
$host = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: 'root';
$database = getenv('DB_NAME') ?: 'hms_db';

$con = mysqli_connect($host, $username, $password, $database);
if (!$con) {
    throw new mysqli_sql_exception("Connection refused: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8mb4") or die("Failed to set charset: " . mysqli_error($con));
?>