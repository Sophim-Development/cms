<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 2) . '/services/UserService.php';
require_once dirname(__DIR__, 2) . '/services/AppointmentService.php';

// Check if user is logged in
if (!isset($_COOKIE['user_id'])) {
    redirect('/user/login');
}

// Check user role
if (!isset($_COOKIE['role']) || $_COOKIE['role'] !== 'doctor') {
    if ($_COOKIE['role'] === 'patient') {
        redirect('/user/pages/dashboard.php');
    } else {
        session_unset();
        session_destroy();
        redirect('/user/login');
    }
}

$userService = new UserService($con);
$appointmentService = new AppointmentService($con);
$user = $userService->getUserById($_COOKIE['user_id']);
if (!$user) {
    session_unset();
    session_destroy();
    redirect('/user/login');
}

// Fetch doctor's appointments
$doctorAppointments = $appointmentService->getDoctorAppointments($user['id']);

// Determine the current route
$currentRoute = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js for the analytics graph -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center mb-8">
                    <div class="w-8 h-8 bg-teal-500 rounded-full mr-2"></div>
                    <h1 class="text-xl font-bold text-teal-500">Clinic Name</h1>
                </div>
                <nav>
                    <ul id="sidebar-menu">
                        <li class="mb-4">
                            <a href="/doctor/dashboard" class="flex items-center text-gray-700 hover:text-teal-500 <?php echo (strpos($currentRoute, '/doctor/dashboard') !== false) ? 'active' : ''; ?>">
                                <span class="mr-2">🏠</span> Dashboard
                            </a>
                        </li>
                        <li class="mb-4">
                            <a href="/doctor/appointments" class="flex items-center text-gray-700 hover:text-teal-500 <?php echo (strpos($currentRoute, '/doctor/appointments') !== false) ? 'active' : ''; ?>">
                                <span class="mr-2">📅</span> My Appointments
                            </a>
                        </li>
                        <li class="mb-4">
                            <a href="/doctor/patients" class="flex items-center text-gray-700 hover:text-teal-500 <?php echo (strpos($currentRoute, '/doctor/patients') !== false) ? 'active' : ''; ?>">
                                <span class="mr-2">👥</span> My Patients
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-300 rounded-full mr-2"></div>
                <div>
                    <p class="font-semibold"><?php echo htmlspecialchars($user['full_name']); ?></p>
                    <a href="/user/logout" class="text-red-500">Logout</a>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="header p-4 flex justify-between items-center">
            <div class="md:hidden">
                <button id="menu-toggle" class="text-teal-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
            <h2 class="text-2xl font-bold">Doctor Dashboard</h2>
            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
        </div>

        <!-- Main Content -->
        <div class="main-content p-4 md:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <!-- Today's Appointments -->
                <div class="card p-4 md:p-6 flex items-center">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-blue-500 text-xl md:text-2xl">📅</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm md:text-base">Today's Appointments</p>
                        <p class="text-2xl md:text-3xl font-bold"><?php echo count(array_filter($doctorAppointments, fn($appt) => date('Y-m-d', strtotime($appt['appointment_date'])) === date('Y-m-d'))); ?></p>
                    </div>
                </div>

                <!-- Total Patients -->
                <div class="card p-4 md:p-6 flex items-center">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-green-500 text-xl md:text-2xl">👥</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm md:text-base">Total Patients</p>
                        <p class="text-2xl md:text-3xl font-bold"><?php echo count(array_unique(array_column($doctorAppointments, 'user_id'))); ?></p>
                    </div>
                </div>

                <!-- Pending Actions -->
                <div class="card p-4 md:p-6 flex items-center">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-yellow-500 text-xl md:text-2xl">⚠️</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm md:text-base">Pending Actions</p>
                        <p class="text-2xl md:text-3xl font-bold"><?php echo count(array_filter($doctorAppointments, fn($appt) => $appt['status'] === 'pending')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Today's Appointments List -->
            <div class="card p-4 md:p-6 mt-4 md:mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Today's Appointments</h3>
                    <a href="/doctor/appointments" class="text-teal-500 text-sm">View All</a>
                </div>
                <div class="space-y-4">
                    <?php
                    $todayAppointments = array_filter($doctorAppointments, fn($appt) => date('Y-m-d', strtotime($appt['appointment_date'])) === date('Y-m-d'));
                    if (empty($todayAppointments)):
                    ?>
                        <p class="text-gray-500">No appointments today.</p>
                    <?php else: ?>
                        <?php foreach ($todayAppointments as $appointment): ?>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-500 rounded-full mr-2"></div>
                                    <div>
                                        <p class="font-semibold text-sm md:text-base"><?php echo htmlspecialchars($appointment['patient_name']); ?></p>
                                        <p class="text-gray-500 text-xs md:text-sm"><?php echo htmlspecialchars($appointment['specialization']); ?></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs md:text-sm"><?php echo htmlspecialchars($appointment['appointment_time']); ?></p>
                                    <p class="text-<?php echo $appointment['status'] === 'confirmed' ? 'green' : ($appointment['status'] === 'cancelled' ? 'red' : 'yellow'); ?>-500 text-xs md:text-sm">
                                        <?php echo ucfirst(htmlspecialchars($appointment['status'])); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Link to external JavaScript -->
    <script src="/assets/js/main.js"></script>
</body>
</html>