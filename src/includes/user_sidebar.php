<?php
 // get current user name
$userId = $_COOKIE['user_id'] ?? null;
if ($userId) {
    $userService = new UserService($con);
    $user = $userService->getUserById($userId);
    $userName = $user['full_name'] ?? 'Guest';
} else {
    $userName = 'Guest';
}
$currentRoute = $_SERVER['REQUEST_URI'] ?? '';
?>
<nav>
  <ul id="sidebar-menu">
      <li class="mb-4">
          <a href="/user/dashboard" class="flex items-center text-gray-700 hover:text-teal-500 <?php echo (strpos($currentRoute, '/user/dashboard') !== false) ? 'active' : ''; ?>">
              <span class="mr-2">🏠</span> Dashboard
          </a>
      </li>
      <li class="mb-4">
          <a href="/user/book-appointment" class="flex items-center text-gray-700 hover:text-teal-500 <?php echo (strpos($currentRoute, '/user/book-appointment') !== false) ? 'active' : ''; ?>">
              <span class="mr-2">📅</span> Book Appointment
          </a>
      </li>
      <li class="mb-4">
          <a href="/user/appointment-history" class="flex items-center text-gray-700 hover:text-teal-500 <?php echo (strpos($currentRoute, '/user/appointment-history') !== false) ? 'active' : ''; ?>">
              <span class="mr-2">📜</span> Appointment History
          </a>
      </li>
      <li class="mb-4">
          <a href="/user/medical-history" class="flex items-center text-gray-700 hover:text-teal-500 <?php echo (strpos($currentRoute, '/user/medical-history') !== false) ? 'active' : ''; ?>">
              <span class="mr-2">🩺</span> Medical History
          </a>
      </li>
  </ul>
</nav>
</div>
<div class="flex items-center">
  <div class="w-10 h-10 bg-gray-300 rounded-full mr-2"></div>
      <div>
          <?php echo "<p class='font-semibold'>$userName</p>"; ?>
          <a href="/user/logout" class="text-red-500">Logout</a>
      </div>
  </div>
</div>