<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 2) . '/services/UserService.php';
require_once dirname(__DIR__, 2) . '/services/SpecializationService.php';
require_once dirname(__DIR__, 2) . '/services/AppointmentService.php';
require_once dirname(__DIR__, 2) . '/services/DoctorService.php';

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

// Get all appointments for this user
$appointmentService = new AppointmentService($con);
$appointments = $appointmentService->getUserAppointments($user['id']);
if (!$appointments) {
    $appointments = [];
}

// Get all doctors
$doctorService = new DoctorService($con);
$doctors = $doctorService->getAllDoctors();
if (!$doctors) {
    $doctors = [];
}
// Get all specializations
$specService = new SpecializationService($con);
$specializations = $specService->getAllSpecializations();
if (!$specializations) {
    $specializations = [];
}

// Handle form submission for booking a new appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['specialization'])) {
    $data = [
        'user_id' => $_COOKIE['user_id'],
        'specialization_id' => sanitize($_POST['specialization']),
        'doctor_id' => sanitize($_POST['doctorId']),
        'appointment_date' => sanitize($_POST['date']),
        'appointment_time' => sanitize($_POST['time']),
        'fees' => sanitize($_POST['fees'] ?? '0.00'),
        'status' => 'pending'
    ];

    if ($appointmentService->createAppointment($data)) {
        $message = "Appointment booked successfully!";
        // Refresh the appointment list
        $appointments = $userService->getAppointmentsByUserId($user['id']);
    } else {
        $message = "Failed to book appointment. Please try again.";
    }
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
    <h2 class="text-2xl font-bold">Appointment History</h2>
    <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
</div>

<!-- Main Content -->
  <div class="main-content p-4 md:p-6">
  <div class="p-4">
      <button id="book-new-appointment" class="mb-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
        Book New Appointment
      </button>
      <div class="bg-white p-4 rounded shadow">
          <div class="mb-4 flex justify-between items-center">
              <form method="get" class="flex items-center gap-2">
                  <label for="filter-date" class="text-gray-600">Filter by date:</label>
                  <input type="date" name="date" id="filter-date" value="<?= $_GET['date'] ?? '' ?>" class="border rounded px-2 py-1">
                  <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Filter</button>
                  <button class="bg-red-500 text-white px-3 py-1 rounded">
                    <a href="/user/appointment-history">Clear</a>
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
                      $appointments = array_filter($appointments, function ($a) {
                          return date('Y-m-d', strtotime($a['appointment_date'])) === $_GET['date'];
                      });
                  }

                  // Sorting
                  if (is_array($appointments) && count($appointments) > 0) {
                      usort($appointments, function ($a, $b) {
                          $aDate = strtotime($a['appointment_date']);
                          $bDate = strtotime($b['appointment_date']);
                          return ($_GET['sort'] ?? 'desc') === 'asc' ? $aDate - $bDate : $bDate - $aDate;
                      });
                  }
                  if (count($appointments) === 0): ?>
                      <tr>
                          <td colspan="5" class="text-center text-gray-500 py-4">No appointments found.</td>
                      </tr>
                  <?php else:
                      foreach ($appointments as $appt): ?>
                          <tr class="border-t">
                              <td class="px-4 py-2"><?= htmlspecialchars($appt['id']) ?></td>
                              <td class="px-4 py-2"><?= date('M d, Y', strtotime($appt['appointment_date'])) ?></td>
                              <td class="px-4 py-2"><?= htmlspecialchars($appt['doctor_name']) ?></td>
                              <td class="px-4 py-2"><?= htmlspecialchars($appt['specialization']) ?></td>
                              <td class="px-4 py-2"><?= ucfirst($appt['status']) ?></td>
                              <td class="px-4 py-2">
                                  <a href="appointment_detail?id=<?= $appt['id'] ?>" class="text-blue-600 hover:underline mr-2">View</a>
                                  <?php if ($appt['status'] === 'pending'): ?>
                                      <a href="cancel_appointment?id=<?= $appt['id'] ?>" class="text-red-500 hover:underline">Cancel</a>
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
                        class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                      <?php foreach ($doctors as $doc): ?>
                        <option value="<?php echo $doc['id']; ?>"><?php echo htmlspecialchars($doc['name']); ?></option>
                    <?php endforeach; ?>
                      </select>
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
            <div class="mb-6">
                <label for="time" class="block text-gray-700 font-medium">Fees($)</label>
                <input name="fees" id="fees" hidden disabled
                       class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">
                Book Appointment
            </button>
        </form>
    </div>
</div>
<?php
include_once dirname(__DIR__, 2) . '/includes/footer-auth.php';
?>
<script>
    document.getElementById('book-new-appointment').addEventListener('click', function () {
        document.getElementById('booking-modal').classList.remove('hidden');
    });

    document.getElementById('close-booking-modal').addEventListener('click', function () {
        document.getElementById('booking-modal').classList.add('hidden');
    });

    // Optional: Close modal when clicking outside the form
    document.getElementById('booking-modal').addEventListener('click', function (e) {
        if (e.target.id === 'booking-modal') {
            document.getElementById('booking-modal').classList.add('hidden');
        }
    });
</script>