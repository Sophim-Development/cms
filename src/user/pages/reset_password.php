<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 1) . '/services/UserService.php';

$userService = new UserService($con);
$message = '';
$token = isset($_GET['token']) ? sanitize($_GET['token']) : '';

if (!$token) {
    $message = "Invalid or missing token.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $token) {
    $newPassword = sanitize($_POST['new_password']);
    $confirmPassword = sanitize($_POST['confirm_password']);

    if ($newPassword !== $confirmPassword) {
        $message = "Passwords do not match.";
    } else {
        $resetData = $userService->verifyPasswordResetToken($token);
        if ($resetData && strtotime($resetData['expires_at']) > time()) {
            if ($userService->updatePassword($resetData['user_id'], md5($newPassword))) {
                $userService->deletePasswordResetToken($token);
                $message = "Password reset successful! Redirecting to login...";
                header("Refresh: 2; url=/user/login");
            } else {
                $message = "Failed to reset password. Please try again.";
            }
        } else {
            $message = "Invalid or expired token.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-teal-400 to-blue-600 p-4">
    <div class="flex flex-col lg:flex-row max-w-5xl w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="w-full lg:w-1/2 p-8">
            <h1 class="text-3xl font-bold mb-6 text-center text-green-600">Reset Password</h1>

            <?php if ($message): ?>
                <p class="mb-4 text-center <?php echo strpos($message, 'successful') !== false ? 'text-green-500' : 'text-red-500'; ?>">
                    <?php echo $message; ?>
                </p>
            <?php endif; ?>

            <?php if (!$message || strpos($message, 'successful') === false): ?>
                <form method="POST">
                    <div class="mb-4">
                        <label for="new_password" class="block text-gray-700 font-medium mb-2">New Password</label>
                        <input type="password" id="new_password" name="new_password"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                    <div class="mb-6">
                        <label for="confirm_password" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                    <button type="submit"
                        class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 w-full">Reset Password</button>
                </form>
            <?php endif; ?>
            <p class="mt-4 text-center">
                <a href="/user/login" class="text-green-600 hover:underline">Back to Login</a>
            </p>
        </div>

        <div class="hidden lg:block w-full lg:w-1/2 relative">
            <img src="https://images.unsplash.com/photo-1585435557343-3b092031a831?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80"
                alt="Doctor with tablet" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-blue-500 opacity-20"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-white text-center">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-lg">Reset your password</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>