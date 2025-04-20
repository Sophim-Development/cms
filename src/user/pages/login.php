<?php
// Start session to ensure session-related functions work
session_start();

require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 2) . '/services/UserService.php';

error_log("Session started, ID: " . session_id());
error_log("Cookies at start: " . print_r($_COOKIE, true));

if (isset($_COOKIE['user_id'])) {
    $userService = new UserService($con);
    $user = $userService->getUserById($_COOKIE['user_id']);
    if ($user) {
        if ($user['role'] === 'doctor') {
            redirect('/doctor/dashboard');
        } else {
            redirect('/user/dashboard');
        }
    } else {
        setcookie('user_id', '', time() - 3600, '/');
        setcookie('role', '', time() - 3600, '/');
        session_unset();
        session_destroy();
        redirect('/user/login');
    }
}

$userService = new UserService($con);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("POST request received");
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    error_log("Email after sanitize: $email, Password length: " . strlen($password));

    $user = $userService->userLogin($email, $password);
    error_log("userLogin result: " . ($user ? "User found, ID: " . $user['id'] : "No user found or invalid password"));

    if ($user) {
        setcookie('user_id', $user['id'], [
            'expires' => time() + (86400 * 30),
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        setcookie('role', $user['role'], [
            'expires' => time() + (86400 * 30),
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        error_log("Cookies set - User ID: " . $user['id'] . ", Role: " . $user['role']);
        error_log("Cookies after set: " . print_r($_COOKIE, true));

        if ($user['role'] === 'doctor') {
            error_log("Redirecting to doctor dashboard");
            redirect('/doctor/dashboard');
        } else {
            error_log("Redirecting to user dashboard");
            redirect('/user/dashboard');
        }
    } else {
        $message = "Invalid email or password.";
        error_log("Login failed: Invalid email or password");
    }
} else {
    error_log("Not a POST request, REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-teal-400 to-blue-600 p-4">
    <div class="flex flex-col lg:flex-row max-w-5xl w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Left Side: Form -->
        <div class="w-full lg:w-1/2 p-8">
            <h1 class="text-3xl font-bold mb-6 text-center text-green-600">Login</h1>

            <?php if ($message): ?>
                <p class="mb-4 text-center text-red-500"><?php echo $message; ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email"
                           class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" id="password" name="password"
                           class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                <button type="submit"
                        class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 w-full">Login</button>
            </form>
            <p class="mt-4 text-center">
                <a href="/user/forgot-password" class="text-green-600 hover:underline">Forgot Password?</a>
            </p>
            <p class="mt-2 text-center">
                Don't have an account? <a href="/user/register" class="text-green-600 hover:underline">Register here</a>
            </p>
        </div>

        <!-- Right Side: Image -->
        <div class="hidden lg:block w-full lg:w-1/2 relative">
            <img src="https://images.unsplash.com/photo-1585435557343-3b092031a831?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80"
                 alt="Doctor with tablet" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-green-500 opacity-20"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-white text-center">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-lg">Access your health services</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>