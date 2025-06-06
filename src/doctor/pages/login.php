<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php'; // For redirect()
require_once dirname(__DIR__, 2) . '/services/DoctorService.php';

if (isset($_COOKIE['doctor_id'])) {
    redirect('/doctor/dashboard');
}

$doctorService = new DoctorService($con);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $doctor = $doctorService->doctorLogin($email, $password);

    if ($doctor) {
        $_COOKIE['doctor_id'] = $doctor['id'];
        redirect('/doctor/dashboard');
    } else {
        $message = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS - Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link href="/assets/css/style.css" rel="stylesheet">
    <script src="/assets/js/script.js" defer></script>
</head>
  <div class="container mx-auto mt-12 max-w-md">
    <div class="bg-white p-8 rounded-lg shadow-lg">
      <h1 class="text-2xl font-bold mb-6 text-center text-green-600">Doctor Login</h1>

      <?php if ($message): ?>
      <p class="text-red-500 mb-4 text-center"><?php echo $message; ?></p>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-medium">Email</label>
          <input type="email" id="email" name="email"
            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
        </div>
        <div class="mb-6">
          <label for="password" class="block text-gray-700 font-medium">Password</label>
          <input type="password" id="password" name="password"
            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
        </div>
        <button type="submit"
          class="w-full bg-green-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">Login</button>
      </form>
    </div>
  </div>

</body>
</html>