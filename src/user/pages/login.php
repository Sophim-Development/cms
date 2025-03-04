<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../services/UserService.php';

if (isset($_SESSION['user_id'])) {
    redirect('/src/user/pages/book-appointment.php');
}

$userService = new UserService($con);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $user = $userService->userLogin($email, $password);
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        redirect('/src/user/pages/book-appointment.php');
    } else {
        $message = 'Invalid email or password.';
    }
}

include '../../includes/header-public.php';
?>

<div class="container mx-auto mt-12 max-w-md">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center text-blue-600">Patient Login</h1>
        
        <?php if ($message): ?>
            <p class="text-red-500 mb-4 text-center"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input type="email" id="email" name="email" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <input type="password" id="password" name="password" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">Login</button>
        </form>
        <p class="mt-4 text-center">Don't have an account? <a href="/src/user/pages/register.php" class="text-blue-600 hover:underline">Register</a></p>
    </div>
</div>

<?php include '../../includes/footer-public.php'; ?>