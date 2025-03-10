<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php'; // For potential redirect()
require_once dirname(__DIR__, 2) . '/services/AdminService.php';

if (!isset($_SESSION['admin_id'])) {
    redirect('/admin/login');
}

$adminService = new AdminService($con);
$doctors = $adminService->getAllDoctors();
$message = '';

if (isset($_POST['delete_doctor'])) {
    $doctorId = sanitize($_POST['doctor_id']);
    if ($adminService->deleteDoctor($doctorId)) {
        $message = "Doctor deleted successfully!";
        $doctors = $adminService->getAllDoctors();
    } else {
        $message = "Failed to delete doctor.";
    }
}

include dirname(__DIR__, 2) . '/includes/header-auth.php';
?>

<div class="container mx-auto mt-12">
  <h1 class="text-3xl font-bold mb-6 text-blue-600">Manage Doctors</h1>

  <?php if ($message): ?>
  <div
    class="mb-6 p-4 <?php echo strpos($message, 'success') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> rounded-lg">
    <?php echo $message; ?>
  </div>
  <?php endif; ?>

  <div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-semibold mb-4">Registered Doctors</h2>
    <table class="w-full border-collapse">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-3 text-left">Name</th>
          <th class="p-3 text-left">Specialization</th>
          <th class="p-3 text-left">Fees</th>
          <th class="p-3 text-left">Email</th>
          <th class="p-3 text-left">Contact</th>
          <th class="p-3 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($doctors)): ?>
        <tr>
          <td colspan="6" class="p-3 text-center text-gray-500">No doctors found.</td>
        </tr>
        <?php else: ?>
        <?php foreach ($doctors as $doctor): ?>
        <tr class="border-b">
          <td class="p-3"><?php echo htmlspecialchars($doctor['doctorName']); ?></td>
          <td class="p-3"><?php echo htmlspecialchars($doctor['spec_name']); ?></td>
          <td class="p-3"><?php echo htmlspecialchars($doctor['docFees']); ?></td>
          <td class="p-3"><?php echo htmlspecialchars($doctor['docEmail']); ?></td>
          <td class="p-3"><?php echo htmlspecialchars($doctor['contactno']); ?></td>
          <td class="p-3">
            <form method="POST" class="inline"
              onsubmit="return confirm('Are you sure you want to delete this doctor?');">
              <input type="hidden" name="doctor_id" value="<?php echo $doctor['id']; ?>">
              <button type="submit" name="delete_doctor" class="text-red-600 hover:underline">Delete</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer-auth.php'; ?>