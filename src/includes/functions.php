<?php
require_once __DIR__ . '/config.php'; 

function redirect($url)
{
    header("Location: $url");
    exit();
}

function sanitize($data)
{
    $con = getDbConnection();
    return mysqli_real_escape_string($con, htmlspecialchars(trim($data)));
}

/**
 * Get the database connection (optional, for better encapsulation)
 * @return mysqli|null
 */
function getDbConnection()
{
    global $con;
    return $con;
}