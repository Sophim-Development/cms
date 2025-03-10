<?php
require_once __DIR__ . '/includes/config.php';

if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])) {
    include 'includes/header-public.php';
} else {
    include 'includes/header-auth.php';
}
?>

<div class="container mx-auto mt-12 max-w-md">
    <h1 class="text-3xl font-bold mb-6 text-blue-600 text-center">Contact Us</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-gray-700 mb-4">Address: St.60 Restaurant & Pub, Cambodia</p>
        <p class="text-gray-700 mb-4">Email: <a href="mailto:cam.hospital@gmail.com" class="text-blue-600 hover:underline">cam.hospital@gmail.com</a></p>
        <p class="text-gray-700">Phone: 60331205</p>
    </div>
</div>

<?php
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])) {
    include 'includes/footer-public.php';
} else {
    include 'includes/footer-auth.php';
}
?>