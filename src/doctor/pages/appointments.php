<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../services/DoctorService.php';

if (!isset($_SESSION['doctor_id'])) {
    redirect('/src/doctor/pages/login.php');
}

$doctorService = new DoctorService($con);
$appointments = $doctorService->getDoctorAppointments($_SESSION['doctor_id']);
$message = '';

if (isset($_POST['update_status'])) {
    $appointmentId = sanitize($_POST['appointment_id']);
    $status = sanitize($_POST['status']);
    if ($doctorService->updateAppointmentStatus($appointmentId, $status)) {
        $message = "Appointment status updated!";
        $appointments = $doctorService->getDoctorAppointments($_SESSION['doctor_id']);
    } else {
        $message = "Failed to update status.";
    }
}

include '../../includes/header-auth.php';
?>

<div class="container mx-auto mt-12">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">Manage Appointments</h1>

    <?php if ($message): ?>
        <div class="mb-6 p-4 <?php echo strpos($message, 'success') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> rounded-lg">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Your Appointments</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">Patient</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Time</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr class="border-b">
                        <td class="p-3"><?php echo htmlspecialchars($appointment['fullName']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($appointment['appointmentDate']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($appointment['appointmentTime']); ?></td>
                        <td class="p-3"><?php echo $appointment['doctorStatus'] ? 'Active' : 'Cancelled'; ?></td>
                        <td class="p-3">
                            <form method="POST" class="inline">
                                <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                                <select name="status" class="p-1 border rounded">
                                    <option value="1" <?php echo $appointment['doctorStatus'] ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo !$appointment['doctorStatus'] ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                                <button type="submit" name="update_status" class="ml-2 text-blue-600 hover:underline">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer-auth.php'; ?>