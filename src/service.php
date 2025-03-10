<?php
require_once __DIR__ . '/includes/config.php';

if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])) {
    include __DIR__ . '/includes/header-public.php';
} else {
    include __DIR__ . '/includes/header-auth.php';
}
?>

<div class="container mx-auto mt-12">
  <h1 class="text-3xl font-bold mb-6 text-blue-600">Our Services</h1>
  <div class="bg-white p-6 rounded-lg shadow-lg">
    <p class="text-gray-700 mb-4">The Hospital Management System (HMS) offers a wide range of services to enhance
      healthcare delivery and patient care. Our services include:</p>
    <ul class="list-disc list-inside text-gray-700">
      <li>Appointment Scheduling and Management</li>
      <li>Patient Registration and Records Management</li>
      <li>Doctor Availability and Consultation Services</li>
      <li>Administrative Oversight for Hospital Operations</li>
      <li>Specialized Medical Care Coordination</li>
    </ul>
    <p class="mt-4 text-gray-700">Contact us to learn more about how HMS can support your healthcare needs or to
      schedule a consultation with our specialists.</p>
  </div>
</div>

<?php
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])) {
    include __DIR__ . '/includes/footer-public.php';
} else {
    include __DIR__ . '/includes/footer-auth.php';
}
?>