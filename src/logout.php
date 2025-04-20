<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

// Ensure no output is sent before headers
ob_start();

// Destroy the session
session_destroy();

// Clear all cookies with proper path and flags
if (!empty($_COOKIE)) {
    foreach ($_COOKIE as $cookie_name => $cookie_value) {
        // Delete cookie by setting an expired time
        // Match the path, domain, secure, and httponly flags
        setcookie($cookie_name, '', time() - 3600, '/', '', false, false);
    }
}

// Clear the session cookie explicitly (e.g., PHPSESSID)
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

// Redirect to the homepage
redirect('/');

// Fallback redirect in case redirect() fails
header('Location: /');
exit();

// Flush output buffer
ob_end_flush();