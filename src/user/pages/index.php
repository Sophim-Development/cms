<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 1) . '/services/UserService.php';

if (!isset($_SESSION['user_id'])) {
    redirect('/user/login');
}
include dirname(__DIR__) . '/pages/header.php';
?>
                <nav>
                    <ul id="sidebar-menu">
                        <li class="mb-4">
                            <a href="#" class="flex items-center text-gray-700 hover:text-teal-500 active menu-item">
                                <span class="mr-2">🏠</span> Dashboard
                            </a>
                            <ul class="submenu pl-6 mt-2">
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Overview</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Reports</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Statistics</a></li>
                            </ul>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="flex items-center text-gray-700 hover:text-teal-500 menu-item">
                                <span class="mr-2">👥</span> Manage Patients
                            </a>
                            <ul class="submenu pl-6 mt-2">
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Add Patient</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">View Patients</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Edit Patient</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Delete Patient</a></li>
                            </ul>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="flex items-center text-gray-700 hover:text-teal-500 menu-item">
                                <span class="mr-2">📋</span> Patient Request
                            </a>
                            <ul class="submenu pl-6 mt-2">
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Pending</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Approved</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Rejected</a></li>
                            </ul>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="flex items-center text-gray-700 hover:text-teal-500 menu-item">
                                <span class="mr-2">❓</span> Question Library
                            </a>
                            <ul class="submenu pl-6 mt-2">
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Add Question</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">View Questions</a></li>
                            </ul>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="flex items-center text-gray-700 hover:text-teal-500 menu-item">
                                <span class="mr-2">🔔</span> Notifications
                            </a>
                            <ul class="submenu pl-6 mt-2">
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Unread</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Read</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Archive</a></li>
                            </ul>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="flex items-center text-gray-700 hover:text-teal-500 menu-item">
                                <span class="mr-2">⚙️</span> System Settings
                            </a>
                            <ul class="submenu pl-6 mt-2">
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">General</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Users</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Security</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-teal-500 text-sm">Preferences</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-300 rounded-full mr-2"></div>
                <div>
                    <p class="font-semibold">Dr. Francis</p>
                    <a href="/logout" class="text-red-500">Logout</a>
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
            <h2 class="text-2xl font-bold">Dashboard</h2>
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
                        <p class="text-gray-500 text-sm md:text-base">Patient Requests</p>
                        <p class="text-2xl md:text-3xl font-bold">12</p>
                    </div>
                </div>

                <!-- Interventions Needed Card -->
                <div class="card p-4 md:p-6 flex items-center">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-red-500 text-xl md:text-2xl">⚠️</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm md:text-base">Interventions Needed</p>
                        <p class="text-2xl md:text-3xl font-bold">2</p>
                    </div>
                </div>

                <!-- Alerts Card -->
                <div class="card p-4 md:p-6">
                    <p class="text-gray-500 mb-2 text-sm md:text-base">Alerts</p>
                    <div class="flex space-x-4">
                        <div class="text-center">
                            <p class="text-red-500 font-bold text-lg md:text-xl">8</p>
                            <p class="text-gray-500 text-xs md:text-sm">Critical</p>
                        </div>
                        <div class="text-center">
                            <p class="text-orange-500 font-bold text-lg md:text-xl">3</p>
                            <p class="text-gray-500 text-xs md:text-sm">Abnormal</p>
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
                    <h3 class="text-lg font-semibold mb-2 sm:mb-0">Analytics</h3>
                    <select class="border rounded p-1 text-sm">
                        <option>Jun 28 2020 - Jul 4 2020</option>
                    </select>
                </div>
                <canvas id="analyticsChart" height="100"></canvas>
            </div>

            <!-- Upcoming Visits and Unplanned Visits -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mt-4 md:mt-6">
                <!-- Upcoming Visits -->
                <div class="card p-4 md:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Upcoming Visit (32)</h3>
                        <a href="#" class="text-teal-500 text-sm">View All</a>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-500 rounded-full mr-2"></div>
                                <div>
                                    <p class="font-semibold text-sm md:text-base">Patient Name</p>
                                    <p class="text-gray-500 text-xs md:text-sm">Male, Age 42, Zurich</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs md:text-sm">10:15 AM</p>
                                <p class="text-yellow-500 text-xs md:text-sm">Waiting</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-500 rounded-full mr-2"></div>
                                <div>
                                    <p class="font-semibold text-sm md:text-base">Patient Name</p>
                                    <p class="text-gray-500 text-xs md:text-sm">Male, Age 42, Zurich</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs md:text-sm">10:15 AM</p>
                                <p class="text-green-500 text-xs md:text-sm">Visited</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-500 rounded-full mr-2"></div>
                                <div>
                                    <p class="font-semibold text-sm md:text-base">Patient Name</p>
                                    <p class="text-gray-500 text-xs md:text-sm">Male, Age 42, Zurich</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs md:text-sm">10:15 AM</p>
                                <p class="text-yellow-500 text-xs md:text-sm">Waiting</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-500 rounded-full mr-2"></div>
                                <div>
                                    <p class="font-semibold text-sm md:text-base">Patient Name</p>
                                    <p class="text-gray-500 text-xs md:text-sm">Male, Age 42, Zurich</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs md:text-sm">10:15 AM</p>
                                <p class="text-green-500 text-xs md:text-sm">Visited</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Unplanned Visits -->
                <div class="card p-4 md:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Un-planned Visit (7)</h3>
                        <a href="#" class="text-teal-500 text-sm">View All</a>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-500 rounded-full mr-2"></div>
                                <div>
                                    <p class="font-semibold text-sm md:text-base">Patient Name</p>
                                    <p class="text-gray-500 text-xs md:text-sm">Male, Age 42, Zurich</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs md:text-sm">10:15 AM</p>
                                <p class="text-yellow-500 text-xs md:text-sm">Waiting</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-500 rounded-full mr-2"></div>
                                <div>
                                    <p class="font-semibold text-sm md:text-base">Patient Name</p>
                                    <p class="text-gray-500 text-xs md:text-sm">Male, Age 42, Zurich</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs md:text-sm">10:15 AM</p>
                                <p class="text-yellow-500 text-xs md:text-sm">Waiting</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-500 rounded-full mr-2"></div>
                                <div>
                                    <p class="font-semibold text-sm md:text-base">Patient Name</p>
                                    <p class="text-gray-500 text-xs md:text-sm">Male, Age 42, Zurich</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs md:text-sm">10:15 AM</p>
                                <p class="text-yellow-500 text-xs md:text-sm">Waiting</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php 
include dirname(__DIR__) . '/pages/footer.php';
?>