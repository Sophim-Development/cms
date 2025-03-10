<?php
require_once __DIR__ . '/includes/config.php';

if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])) {
    include __DIR__ . '/includes/header-public.php';
} else {
    include __DIR__ . '/includes/header-auth.php';
}
?>

<div class="container mx-auto mt-12">
    <h1 class="text-3xl font-bold mb-6 text-blue-600 text-center">Welcome to Hospital Management System</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-gray-700 mb-4">The Hospital Management System (HMS) is designed to streamline healthcare operations,
            replacing manual paper-based systems with an efficient digital solution. Our goal is to manage patient
            information, doctor schedules, appointments, and more, ensuring a seamless experience for both healthcare
            providers and patients.</p>
        <p class="text-gray-700">Explore our services, book appointments, or contact us for more information.</p>
    </div>

    <!-- Login Buttons for Unauthenticated Users -->
    <?php if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])): ?>
        <div class="mt-8 text-center space-y-4">
            <a href="/admin/login"
                class="block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition text-center">Admin Login</a>
            <a href="/doctor/login"
                class="block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition text-center">Doctor
                Login</a>
            <a href="/user/login"
                class="block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition text-center">Patient
                Login</a>
        </div>
    <?php endif; ?>
</div>

<?php
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])) {
    include __DIR__ . '/includes/footer-public.php';
} else {
    include __DIR__ . '/includes/footer-auth.php';
}
?>