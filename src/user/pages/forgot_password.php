<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 2) . '/services/UserService.php';

$userService = new UserService($con);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $user = $userService->getUserByEmail($email);
    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        if ($userService->storePasswordResetToken($user['id'], $token, $expiresAt)) {
            $resetLink = "http://localhost/user/reset-password?token=$token";
            $subject = "Password Reset Request";
            $body = "Hello,\n\nYou requested a password reset. Click the link below to reset your password:\n$resetLink\n\nThis link will expire in 1 hour.\n\nIf you did not request this, please ignore this email.";
            $headers = "From: no-reply@yourdomain.com";

            if (mail($email, $subject, $body, $headers)) {
                $message = "A password reset link has been sent to your email.";
            } else {
                $message = "Failed to send the reset email. Please try again.";
            }
        } else {
            $message = "Failed to generate a reset link. Please try again.";
        }
    } else {
        $message = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-teal-400 to-blue-600 p-4">
    <div class="flex flex-col lg:flex-row max-w-5xl w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="w-full lg:w-1/2 p-8">
            <h1 class="text-3xl font-bold mb-6 text-center text-green-600">Forgot Password</h1>

            <?php if ($message): ?>
                <p class="mb-4 text-center <?php echo strpos($message, 'sent') !== false ? 'text-green-500' : 'text-red-500'; ?>">
                    <?php echo $message; ?>
                </p>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                </div>
                <button type="submit"
                    class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 w-full">Send Reset Link</button>
            </form>
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