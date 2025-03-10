<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System - Dashboard</title>
    <link href="/assets/css/style.css" rel="stylesheet">
    <script src="/assets/js/script.js" defer></script>
</head>

<body class="bg-gray-100 font-sans">
    <nav class="bg-blue-600 p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">HMS</a>
            <div class="space-x-6">
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <a href="/admin/dashboard" class="hover:underline">Dashboard</a>
                    <a href="/admin/manage-doctors" class="hover:underline">Manage Doctors</a>
                <?php elseif (isset($_SESSION['doctor_id'])): ?>
                    <a href="/doctor/pages/dashboard" class="hover:underline">Dashboard</a>
                    <a href="/doctor/appointments" class="hover:underline">Appointments</a>
                <?php elseif (isset($_SESSION['user_id'])): ?>
                    <a href="/user/book-appointment" class="hover:underline">Book Appointment</a>
                <?php endif; ?>
                <a href="/logout" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-200 transition">Logout</a>
            </div>
        </div>
    </nav>