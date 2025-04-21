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
include_once dirname(__DIR__, 2) . '/includes/header-auth.php';
include_once dirname(__DIR__, 2) . '/includes/user_sidebar.php';
?>
<!-- Header -->
<div class="header p-4 flex justify-between items-center">
    <div class="md:hidden">
        <button id="menu-toggle" class="text-teal-500 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>
    <h2 class="text-2xl font-bold">User Dashboard</h2>
    <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
</div>

<!-- Main Content -->
<div class="main-content p-4 md:p-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        <!-- Patient Requests Card -->
        <div class="card p-4 md:p-6 flex items-center">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                <span class="text-orange-500 text-xl md:text-2xl">👥</span>
            </div>
            <div>
                <p class="text-gray-500 text-sm md:text-base">Upcoming Appointments</p>
                <p class="text-2xl md:text-3xl font-bold">3</p>
            </div>
        </div>

        <!-- Interventions Needed Card -->
        <div class="card p-4 md:p-6 flex items-center">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                <span class="text-red-500 text-xl md:text-2xl">⚠️</span>
            </div>
            <div>
                <p class="text-gray-500 text-sm md:text-base">Pending Actions</p>
                <p class="text-2xl md:text-3xl font-bold">1</p>
            </div>
        </div>

        <!-- Alerts Card -->
        <div class="card p-4 md:p-6">
            <p class="text-gray-500 mb-2 text-sm md:text-base">Health Alerts</p>
            <div class="flex space-x-4">
                <div class="text-center">
                    <p class="text-red-500 font-bold text-lg md:text-xl">2</p>
                    <p class="text-gray-500 text-xs md:text-sm">Critical</p>
                </div>
                <div class="text-center">
                    <p class="text-orange-500 font-bold text-lg md:text-xl">1</p>
                    <p class="text-gray-500 text-xs md:text-sm">Warning</p>
                </div>
                <div class="text-center">
                    <p class="text-green-500 font-bold text-lg md:text-xl">5</p>
                    <p class="text-gray-500 text-xs md:text-sm">Normal</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Graph -->
    <div class="card p-4 md:p-6 mt-4 md:mt-6">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <h3 class="text-lg font-semibold mb-2 sm:mb-0">Health Trends</h3>
            <select class="border rounded p-1 text-sm">
                <option>Mar 31 2025 - Apr 6 2025</option>
            </select>
        </div>
        <canvas id="analyticsChart" height="100"></canvas>
    </div>

    <!-- Upcoming Appointments -->
    <div class="card p-4 md:p-6 mt-4 md:mt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Upcoming Appointments</h3>
            <a href="/user/appointment-history" class="text-teal-500 text-sm">View All</a>
        </div>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-500 rounded-full mr-2"></div>
                    <div>
                        <p class="font-semibold text-sm md:text-base">Dr. Smith</p>
                        <p class="text-gray-500 text-xs md:text-sm">Cardiology, Apr 2 2025</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs md:text-sm">10:00 AM</p>
                    <p class="text-yellow-500 text-xs md:text-sm">Pending</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once dirname(__DIR__, 2) . '/includes/footer-auth.php';
?>