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
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $user = $userService->userLogin($email, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        redirect('/user/pages/book-appointment.php');
    } else {
        $message = 'Invalid email or password.';
    }
}

include dirname(__DIR__, 2) . '/includes/header-public.php';
?>

<div class="container mx-auto mt-12 max-w-md py-12">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center text-green-600">Login</h1>

        <?php if ($message): ?>
            <p class="text-red-500 mb-4 text-center"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST">
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
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full sm:w-auto">Login</button>
        </form>
        <p class="mt-4 text-center">Don't have an account? <a href="/user/register"
                class="text-green-600 hover:underline">Register</a></p>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer-public.php'; ?>