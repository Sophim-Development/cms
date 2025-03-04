<?php
require_once __DIR__ . '/includes/config.php';

if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])) {
    include 'includes/header-public.php';
} else {
    include 'includes/header-auth.php';
}
?>

<div class="container mx-auto mt-12">
    <h1 class="text-4xl font-bold mb-6 text-blue-600 text-center">Welcome to Hospital Management System</h1>
    <p class="text-lg text-gray-700 mb-8 text-center">Providing quality healthcare services since 2025.</p>
    <div class="flex justify-center space-x-4">
        <a href="/src/user/pages/book-appointment.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Book an Appointment</a>
        <a href="/src/about.php" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">Learn More</a>
    </div>
</div>

<?php
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])) {
    include 'includes/footer-public.php';
} else {
    include 'includes/footer-auth.php';
}
?>