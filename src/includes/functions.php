<?php
// Utility functions (can be expanded)
function redirect($url) {
    header("Location: $url");
    exit();
}

function sanitize($data) {
    global $con;
    return mysqli_real_escape_string($con, htmlspecialchars(trim($data)));
}
?>