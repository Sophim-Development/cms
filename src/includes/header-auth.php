<?php
require_once dirname(__DIR__, 1) . '/includes/config.php';
require_once dirname(__DIR__, 1) . '/includes/functions.php';

// Check if user is logged in
if (!isset($_COOKIE['user_id'])) {
    redirect('/user/login');
}

// Determine the current route
$currentRoute = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js for the analytics graph -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/assets/js/script.js"></script>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center mb-8">
                    <div class="w-14 h-14 bg-teal-500 rounded-full mr-2 p-2">
                      <img src="../../assets/images/logo.jpeg" alt="profile" class="w-full h-full object-cover rounded-full">
                    </div>
                    <h1 class="text-xl font-bold text-teal-500">CMS</h1>
                </div>