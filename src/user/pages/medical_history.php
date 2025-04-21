<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 2) . '/services/UserService.php';

$userService = new UserService($con);
$user = $userService->getUserById($_COOKIE['user_id']);
if (!$user) {
    session_unset();
    session_destroy();
    redirect('/user/login');
}
if (!isset($_COOKIE['user_id'])) {
    redirect('/user/login');
}

// Get all histories for this user
$histories = $userService->getMedicalHistoryByUserId($user['id']);
if (!$histories) {
    $histories = [];
}

// include header and sidebar
include_once dirname(__DIR__, 2) . '/includes/header-auth.php';
include_once dirname(__DIR__, 2) . '/includes/user_sidebar.php';
?>
<!-- Header -->
<div class="header p-4 flex justify-between items-center">
    <div class="md:hidden">
        <button id="menu-toggle" class="text-teal-500 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>
    <h2 class="text-2xl font-bold">Medical History</h2>
    <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
</div>

<!-- Main Content -->
<div class="main-content p-4 md:p-6">
  <div class="p-4">
      <div class="bg-white p-4 rounded shadow">
          <div class="mb-4 flex justify-between items-center">
              <form method="get" class="flex items-center gap-2">
                  <label for="filter-date" class="text-gray-600">Filter by date:</label>
                  <input type="date" name="date" id="filter-date" value="<?= $_GET['date'] ?? '' ?>" class="border rounded px-2 py-1">
                  <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Filter</button>
                  <button class="bg-red-500 text-white px-3 py-1 rounded">
                    <a href="/user/medical-history">Clear</a>
                  </button>
              </form>
              <div>
                  <a href="?sort=asc" class="text-blue-500 mr-2">Oldest First</a>
                  <a href="?sort=desc" class="text-blue-500">Newest First</a>
              </div>
          </div>

          <table class="min-w-full text-sm text-left">
              <thead>
                  <tr class="bg-gray-100">
                      <th class="px-4 py-2">#</th>
                      <th class="px-4 py-2">Date</th>
                      <th class="px-4 py-2">Doctor</th>
                      <th class="px-4 py-2">Specialty</th>
                      <th class="px-4 py-2">Status</th>
                      <th class="px-4 py-2">Actions</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  // Filtering
                  if (isset($_GET['date']) && $_GET['date'] !== '') {
                      $histories = array_filter($histories, function ($a) {
                          return date('Y-m-d', strtotime($a['appointment_date'])) === $_GET['date'];
                      });
                  }

                  // Sorting
                  if (is_array($histories) && count($histories) > 0) {
                      usort($histories, function ($a, $b) {
                          $aDate = strtotime($a['appointment_date']);
                          $bDate = strtotime($b['appointment_date']);
                          return ($_GET['sort'] ?? 'desc') === 'asc' ? $aDate - $bDate : $bDate - $aDate;
                      });
                  }
                  if (count($histories) === 0): ?>
                      <tr>
                          <td colspan="5" class="text-center text-gray-500 py-4">No histories found.</td>
                      </tr>
                  <?php else:
                      foreach ($histories as $appt): ?>
                          <tr class="border-t">
                              <td class="px-4 py-2"><?= htmlspecialchars($appt['id']) ?></td>
                              <td class="px-4 py-2"><?= date('M d, Y', strtotime($appt['appointment_date'])) ?></td>
                              <td class="px-4 py-2"><?= htmlspecialchars($appt['doctor_name']) ?></td>
                              <td class="px-4 py-2"><?= htmlspecialchars($appt['specialty']) ?></td>
                              <td class="px-4 py-2"><?= ucfirst($appt['status']) ?></td>
                              <td class="px-4 py-2">
                                  <a href="appointment_detail.php?id=<?= $appt['id'] ?>" class="text-blue-600 hover:underline mr-2">View</a>
                                  <?php if ($appt['status'] === 'pending'): ?>
                                      <a href="cancel_appointment.php?id=<?= $appt['id'] ?>" class="text-red-500 hover:underline">Cancel</a>
                                  <?php endif; ?>
                              </td>
                          </tr>
                      <?php endforeach;
                  endif; ?>
              </tbody>
          </table>
      </div>
  </div>
</div>
<?php
include_once dirname(__DIR__, 2) . '/includes/footer-auth.php';
?>