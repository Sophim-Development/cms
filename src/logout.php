<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

ob_start();

// Destroy the session
session_destroy();

// Clear all cookies with proper path and flags
if (!empty($_COOKIE)) {
    foreach ($_COOKIE as $cookie_name => $cookie_value) {
        setcookie($cookie_name, '', time() - 3600, '/', '', false, false);
    }
}
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 3600,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}
redirect('/');

// Fallback redirect in case redirect() fails
header('Location: /');
exit();

ob_end_flush();