<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <link href="/public/assets/css/style.css" rel="stylesheet">
    <!-- Remove CDN if using compiled Tailwind -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script src="/src/assets/js/script.js" defer></script>
</head>
<body class="bg-gray-100 font-sans">
    <nav class="bg-blue-600 p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/src/index.php" class="text-2xl font-bold">HMS</a>
            <div class="space-x-6">
                <a href="/src/index.php" class="hover:underline">Home</a>
                <a href="/src/about.php" class="hover:underline">About</a>
                <a href="/src/contact.php" class="hover:underline">Contact</a>
                <a href="/src/user/pages/book-appointment.php" class="hover:underline">Appointment</a>
                <a href="/src/user/pages/login.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-200 transition">Login</a>
            </div>
        </div>
    </nav>