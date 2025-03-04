<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../services/AdminService.php';

if (!isset($_SESSION['admin_id'])) {
    redirect('/src/admin/pages/login.php');
}

$adminService = new AdminService($con);
$doctors = $adminService->getAllDoctors();

include '../../includes/header-auth.php';
?>

<div class="container mx-auto mt-12">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">Admin Dashboard</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Registered Doctors</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Specialization</th>
                    <th class="p-3 text-left">Fees</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($doctors as $doctor): ?>
                    <tr class="border-b">
                        <td class="p-3"><?php echo htmlspecialchars($doctor['doctorName']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($doctor['spec_name']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($doctor['docFees']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer-auth.php'; ?>