<?php
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
  'user/appointment-history' => 'user/pages/appointment_history.php',
  'user/appointment-history?id=' => 'user/pages/appointment_history.php',
  'user/medical-history' => 'user/pages/medical_history.php',
  'user/appointment?id=/details' => 'user/pages/appointment_details.php',
  'user/appointment?id=/edit' => 'user/pages/appointment_edit.php',
  'user/appointment?id=/delete' => 'user/pages/appointment_delete.php',
  'user/appointment?id=/cancel' => 'user/pages/appointment_cancel.php',
  'user/appointment?id=/confirm' => 'user/pages/appointment_confirm.php',
  'user/appointment?id=/reschedule' => 'user/pages/appointment_reschedule.php',
  'user/appointment?id=/prescription' => 'user/pages/appointment_prescription.php',
  'user/appointment?id=/prescription/add' => 'user/pages/appointment_prescription_add.php',
  'user/appointment?id=/prescription/edit' => 'user/pages/appointment_prescription_edit.php',
  'user/appointment?id=/prescription/delete' => 'user/pages/appointment_prescription_delete.php',
  'user/appointment?id=/prescription/view' => 'user/pages/appointment_prescription_view.php',
  'user/appointment?id=/prescription/download' => 'user/pages/appointment_prescription_download.php',
  'user/register' => 'user/pages/register.php',
  'user/get_doctors' => 'user/pages/get_doctors.php',
  'doctor/login' => 'doctor/pages/login.php',
  'doctor/dashboard/overview' => 'doctor/pages/index.php',
  'doctor/dashboard/reports' => 'doctor/pages/reports.php',
  'doctor/dashboard/statistics' => 'doctor/pages/statistics.php',
  'doctor/dashboard/patient/add' => 'doctor/pages/patient_add.php',
  'doctor/dashboard/patient/edit' => 'doctor/pages/patient_edit.php',
  'doctor/dashboard/patient/list' => 'doctor/pages/patient_list.php',
  'doctor/dashboard/patient?id=/details' => 'doctor/pages/patient_details.php',
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