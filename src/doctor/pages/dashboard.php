<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../services/DoctorService.php';

if (!isset($_SESSION['doctor_id'])) {
    redirect('/src/doctor/pages/login.php');
}

$doctorService = new DoctorService($con);
$appointments = $doctorService->getDoctorAppointments($_SESSION['doctor_id']);

include '../../includes/header-auth.php';
?>

<div class="container mx-auto mt-12">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">Doctor Dashboard</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Your Appointments</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">Patient</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Time</th>
                    <th class="p-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr class="border-b">
                        <td class="p-3"><?php echo htmlspecialchars($appointment['fullName']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($appointment['appointmentDate']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($appointment['appointmentTime']); ?></td>
                        <td class="p-3"><?php echo $appointment['doctorStatus'] ? 'Active' : 'Cancelled'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer-auth.php'; ?>