<!-- <?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 2) . '/services/AppointmentService.php';
require_once dirname(__DIR__, 2) . '/services/SpecializationService.php';
require_once dirname(__DIR__, 2) . '/services/UserService.php';

// Check if user is logged in
if (!isset($_COOKIE['user_id'])) {
    redirect('/user/login');
}

// Check user role
if (!isset($_COOKIE['role']) || $_COOKIE['role'] !== 'patient') {
    if ($_COOKIE['role'] === 'doctor') {
        redirect('/doctor/dashboard');
    } else {
        session_unset();
        session_destroy();
        redirect('/user/login');
    }
}

$specService = new SpecializationService($con);
$specializations = $specService->getAllSpecializations();
$appointmentService = new AppointmentService($con);
$userService = new UserService($con);
$message = '';

// Fetch user details
$user = $userService->getUserById($_COOKIE['user_id']);
if (!$user) {
    session_unset();
    session_destroy();
    redirect('/user/login');
}

// Fetch user's appointments
$userAppointments = $appointmentService->getUserAppointments($_COOKIE['user_id']);

// Handle form submission for booking a new appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['specialization'])) {
    $data = [
        'user_id' => $_COOKIE['user_id'],
        'specialization_id' => sanitize($_POST['specialization']),
        'doctor_id' => sanitize($_POST['doctorId']),
        'appointment_date' => sanitize($_POST['date']),
        'appointment_time' => sanitize($_POST['time']),
        'fees' => sanitize($_POST['fees']),
        'status' => 'pending'
    ];

    if ($appointmentService->createAppointment($data)) {
        $message = "Appointment booked successfully!";
        // Refresh the appointment list
        $userAppointments = $appointmentService->getUserAppointments($_COOKIE['user_id']);
    } else {
        $message = "Failed to book appointment. Please try again.";
    }
}

// Handle appointment deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_appointment'])) {
    $appointmentId = sanitize($_POST['appointment_id']);
    if ($appointmentService->deleteAppointment($appointmentId, $_COOKIE['user_id'])) {
        $message = "Appointment deleted successfully!";
        // Refresh the appointment list
        $userAppointments = $appointmentService->getUserAppointments($_COOKIE['user_id']);
    } else {
        $message = "Failed to delete appointment.";
    }
}

include_once dirname(__DIR__, 2) . '/includes/header-auth.php';
include_once dirname(__DIR__, 2) . '/includes/user_sidebar.php';
?>

<!-- Booking Modal -->
<div id="booking-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
        <button id="close-booking-modal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
        <h3 class="text-xl font-bold mb-4">Book New Appointment</h3>
        <form method="POST">
            <div class="mb-4">
                <label for="specialization" class="block text-gray-700 font-medium">Specialization</label>
                <select name="specialization" id="specialization"
                        class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                    <?php foreach ($specializations as $spec): ?>
                        <option value="<?php echo $spec['id']; ?>"><?php echo htmlspecialchars($spec['specialization']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="doctorId" class="block text-gray-700 font-medium">Doctor</label>
                <select name="doctorId" id="doctors"
                        class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required></select>
            </div>
            <div class="mb-4">
                <label for="date" class="block text-gray-700 font-medium">Date</label>
                <input type="date" id="date" name="date"
                       class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <div class="mb-6">
                <label for="time" class="block text-gray-700 font-medium">Time</label>
                <input type="time" id="time" name="time"
                       class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <input type="hidden" name="fees" id="fees">
            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">
                Book Appointment
            </button>
        </form>
    </div>
</div> -->