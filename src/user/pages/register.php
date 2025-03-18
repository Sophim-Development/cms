<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 2) . '/services/UserService.php';

if (isset($_SESSION['user_id'])) {
    redirect('/user/pages/book-appointment.php');
}

$userService = new UserService($con);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'fullName' => sanitize($_POST['fullName']),
        'address' => sanitize($_POST['address']),
        'city' => sanitize($_POST['city']),
        'gender' => sanitize($_POST['gender']),
        'email' => sanitize($_POST['email']),
        'password' => md5(sanitize($_POST['password'])) 
    ];

    if ($userService->registerUser($data)) {
        $message = "Registration successful! Please login.";
    } else {
        $message = "Registration failed.";
    }
}

include dirname(__DIR__, 2) . '/includes/header-public.php';
?>

<div class="container mx-auto mt-12 max-w-md py-12">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center text-green-600">Patient Registration</h1>

        <?php if ($message): ?>
            <p
                class="mb-4 text-center <?php echo strpos($message, 'success') !== false ? 'text-green-500' : 'text-red-500'; ?>">
                <?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label for="fullName" class="block text-gray-700 font-medium">Full Name</label>
                <input type="text" id="fullName" name="fullName"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-medium">Address</label>
                <input type="text" id="address" name="address"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <div class="mb-4">
                <label for="city" class="block text-gray-700 font-medium">City</label>
                <input type="text" id="city" name="city"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <div class="mb-4">
                <label for="gender" class="block text-gray-700 font-medium">Gender</label>
                <select id="gender" name="gender"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <button type="submit"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full sm:w-auto">Register</button>
        </form>
        <p class="mt-4 text-center">Already have an account? <a href="/user/login"
                class="text-green-600 hover:underline">Login</a></p>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer-public.php'; ?>