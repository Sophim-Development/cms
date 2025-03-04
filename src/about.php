<?php
require_once __DIR__ . '/includes/config.php';

if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])) {
    include 'includes/header-public.php';
} else {
    include 'includes/header-auth.php';
}
?>

<div class="container mx-auto mt-12">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">About Us</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-gray-700 mb-4">The Hospital Management System (HMS) is designed to streamline healthcare operations, replacing manual paper-based systems with an efficient digital solution.</p>
        <p class="text-gray-700">Our goal is to manage patient information, doctor schedules, appointments, and more, ensuring a seamless experience for both healthcare providers and patients.</p>
    </div>
</div>

<?php
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])) {
    include 'includes/footer-public.php';
} else {
    include 'includes/footer-auth.php';
}
?>