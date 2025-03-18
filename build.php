<?php
// build.php
$routes = [
  '/' => 'index.php',
  'about' => 'about.php',
  'contact' => 'contact.php',
  'services' => 'service.php',
  'logout' => 'logout.php',
  'user/login' => 'user/pages/login.php',
  'user/book-appointment' => 'user/pages/book-appointment.php',
  'user/register' => 'user/pages/register.php',
  'user/get_doctors' => 'user/pages/get_doctors.php',
  'admin/login' => 'admin/pages/login.php',
  'admin/dashboard' => 'admin/pages/dashboard.php',
  'admin/manage-doctors' => 'admin/pages/manage-doctors.php',
  'doctor/login' => 'doctor/pages/login.php',
  'doctor/dashboard' => 'doctor/pages/dashboard.php',
  'doctor/appointments' => 'doctor/pages/appointments.php',
];

mkdir('dist', 0777, true);
mkdir('dist/assets', 0777, true);

foreach ($routes as $route => $file) {
  $path = trim($route, '/');
  $outputFile = $path ? "dist/{$path}.html" : "dist/index.html";
  $dir = dirname($outputFile);
  if ($dir !== '.' && !file_exists($dir)) {
    mkdir($dir, 0777, true);
  }
  $content = shell_exec("php public/index.php {$route}");
  file_put_contents($outputFile, $content ?: '<h1>Page not found!</h1>');
}

exec('cp -r public/assets/* dist/assets/');
echo "Build completed. Files are in dist/";
