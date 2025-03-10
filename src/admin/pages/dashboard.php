<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php'; // For potential redirect()
require_once dirname(__DIR__, 2) . '/services/AdminService.php';

if (!isset($_SESSION['admin_id'])) {
    redirect('/admin/login');
}

$adminService = new AdminService($con);
$doctors = $adminService->getAllDoctors();

include dirname(__DIR__, 2) . '/includes/header-auth.php';
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

<?php include dirname(__DIR__, 2) . '/includes/footer-auth.php'; ?>