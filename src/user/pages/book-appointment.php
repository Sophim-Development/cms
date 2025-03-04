<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../services/AppointmentService.php';
require_once __DIR__ . '/../../services/SpecializationService.php';

$specService = new SpecializationService($con);
$specializations = $specService->getAllSpecializations();
$message = '';

if (isset($_SESSION['user_id'])) {
    include '../../includes/header-auth.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $appointmentService = new AppointmentService($con);
        $data = [
            'specialization' => sanitize($_POST['specialization']),
            'doctorId' => sanitize($_POST['doctorId']),
            'userId' => $_SESSION['user_id'],
            'fees' => sanitize($_POST['fees']),
            'appointmentDate' => sanitize($_POST['date']),
            'appointmentTime' => sanitize($_POST['time'])
        ];
        if ($appointmentService->createAppointment($data)) {
            $message = "Appointment booked successfully!";
        } else {
            $message = "Failed to book appointment.";
        }
    }
} else {
    include '../../includes/header-public.php';
}

?>

<div class="container mx-auto mt-12 max-w-md">
    <h1 class="text-3xl font-bold mb-6 text-blue-600 text-center">Book Appointment</h1>

    <?php if ($message): ?>
        <p class="mb-6 text-center <?php echo strpos($message, 'success') !== false ? 'text-green-500' : 'text-red-500'; ?>"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <p class="text-red-500 mb-4">Please login to book an appointment.</p>
            <a href="/src/user/pages/login.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Login Now</a>
        </div>
    <?php else: ?>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form method="POST">
                <div class="mb-4">
                    <label for="specialization" class="block text-gray-700 font-medium">Specialization</label>
                    <select name="specialization" id="specialization" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                        <?php foreach ($specializations as $spec): ?>
                            <option value="<?php echo $spec['id']; ?>"><?php echo htmlspecialchars($spec['specialization']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="doctorId" class="block text-gray-700 font-medium">Doctor</label>
                    <select name="doctorId" id="doctors" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required></select>
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 font-medium">Date</label>
                    <input type="date" id="date" name="date" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                </div>
                <div class="mb-6">
                    <label for="time" class="block text-gray-700 font-medium">Time</label>
                    <input type="time" id="time" name="time" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                </div>
                <input type="hidden" name="fees" id="fees">
                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">Book Appointment</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<script src="/public/assets/js/script.js"></script>
<?php 
if (isset($_SESSION['user_id'])) {
    include '../../includes/footer-auth.php';
} else {
    include '../../includes/footer-public.php';
}
?>