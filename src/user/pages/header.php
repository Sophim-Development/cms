<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar {
            background-color: #f7fafc;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 16rem; 
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
        }
        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .active {
            background-color: #e6fffa;
            color: #38b2ac;
            border-radius: 8px;
            padding: 8px;
        }
        .header {
            position: fixed;
            top: 0;
            left: 16rem; 
            right: 0;
            z-index: 40;
            background-color: #f7fafc;
        }
        .main-content {
            margin-top: 4rem; 
            margin-left: 16rem; 
            height: calc(100vh - 4rem);
            overflow-y: auto;
            width: calc(100vw - 16rem);
        }
        .submenu {
            max-height: 0;
            overflow-y: auto;
            transition: max-height 0.3s ease-in-out;
        }
        .submenu.open {
            max-height: 12rem;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 50;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .header {
                left: 0;
            }
            .main-content {
                margin-left: 0;
                width: 100vw;
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">
        <div class="sidebar p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center mb-8">
                    <div class="w-14 h-14 bg-teal-500 rounded-full mr-2 p-2">
                      <img src="../../assets/images/logo.jpeg" alt="profile" class="w-full h-full object-cover rounded-full">
                    </div>
                    <h1 class="text-xl font-bold text-teal-500">CMS</h1>
                </div>