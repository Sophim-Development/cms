<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS - Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link href="/assets/css/style.css" rel="stylesheet">
    <script src="/assets/js/script.js" defer></script>
</head>

<body class="font-sans">
 <nav class="bg-white shadow-md fixed w-full top-0 z-10">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold"><a href="/" class="cursor-pointer">CMS</a></div>
            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-6">
                <a href="/" class="hover:text-blue-500">Home</a>
                <a href="#services" class="hover:text-blue-500">Services</a>
                <a href="#about-us" class="hover:text-blue-500">About Us</a>
                <a href="#gallery" class="hover:text-blue-500">Gallery</a>
                <a href="#contact-us" class="hover:text-blue-500">Contact Us</a>
            </div>
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <a href="/user/book-appointment" class="hidden md:block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Book an Appointment</a>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white shadow-md">
            <div class="flex flex-col space-y-4 py-4 px-4">
                <a href="/" class="hover:text-blue-500">Home</a>
                <a href="#services" class="hover:text-blue-500">Services</a>
                <a href="#about-us" class="hover:text-blue-500">About Us</a>
                <a href="#gallery" class="hover:text-blue-500">Gallery</a>
                <a href="#contact-us" class="hover:text-blue-500">Contact Us</a>
                <a href="/user/book-appointment" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-center">Book an Appointment</a>
            </div>
        </div>
    </nav>