<?php
// session_start();

// Get and normalize the request URI
$path = trim($_SERVER['REQUEST_URI'], '/');
$path = strtok($path, '?');

$routes = [
  '/' => 'index.php',
  'about' => 'about.php',
  'contact' => 'contact.php',
  'services' => 'service.php',
  'logout'=> 'logout.php',
  'user/login' => 'user/pages/login.php',
  'user/reset-password' => 'user/pages/reset_password.php',
  'user/forgot-password' => 'user/pages/forgot_password.php',
  'user/dashboard' => 'user/pages/index.php',
  'user/book-appointment' => 'user/pages/book_appointment.php',
  'user/register' => 'user/pages/register.php',
  'user/get_doctors' => 'user/pages/get_doctors.php',
  'admin/login' => 'admin/pages/login.php',
  'admin/dashboard' => 'admin/pages/dashboard.php',
  'admin/manage-doctors' => 'admin/pages/manage_doctors.php',
  'doctor/login' => 'doctor/pages/login.php',
  'doctor/dashboard' => 'doctor/pages/dashboard.php',
  'doctor/appointments' => 'doctor/pages/appointments.php',
];

// Default to index.php if no match
$file = 'index.php';
foreach ($routes as $route => $srcFile) {
  if ($path === $route) {
    $file = $srcFile;
    break;
  }
}

// Construct the full path to the file in src/
$srcPath = __DIR__ . '/../src/' . $file;

// Check if the file exists before including it
if (file_exists($srcPath)) {
  require_once $srcPath;
} else {
  // Fallback to 404 or custom error page
  http_response_code(404);
  echo "Page not found!";
}