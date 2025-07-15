<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Livewire Tailwind App</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="flex flex-col min-h-screen font-sans bg-gray-100">

    @auth
        <nav class="bg-gray-800 p-4 shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                <a href="#" class="text-white text-2xl font-bold rounded-md px-3 py-2 hover:bg-gray-700 transition-colors duration-200">Your App Name</a>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-300 hover:text-white rounded-md px-3 py-2 transition-colors duration-200">Dashboard</a>
                    <a href="#" class="text-gray-300 hover:text-white rounded-md px-3 py-2 transition-colors duration-200">Settings</a>
                    <a href="#" class="text-gray-300 hover:text-white rounded-md px-3 py-2 transition-colors duration-200">Profile</a>
                </div>
            </div>
        </nav>
    @endauth

    <div class="flex flex-1">
        @auth
            <!-- Include Sidebar Component -->
            <aside class="w-64 bg-gray-700 p-6 shadow-lg flex-shrink-0">
                <nav>
                    <ul>
                        <li class="mb-4">
                            <a href="#" class="block text-gray-300 hover:text-white hover:bg-gray-600 rounded-md px-4 py-2 transition-colors duration-200">
                                <i class="fas fa-home mr-2"></i> Home
                            </a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="block text-gray-300 hover:text-white hover:bg-gray-600 rounded-md px-4 py-2 transition-colors duration-200">
                                <i class="fas fa-users mr-2"></i> Users
                            </a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="block text-gray-300 hover:text-white hover:bg-gray-600 rounded-md px-4 py-2 transition-colors duration-200">
                                <i class="fas fa-cog mr-2"></i> Services
                            </a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="block text-gray-300 hover:text-white hover:bg-gray-600 rounded-md px-4 py-2 transition-colors duration-200">
                                <i class="fas fa-chart-line mr-2"></i> Reports
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>
        @endauth

        <!-- Page Content -->
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>
    </div>

    @auth
        <!-- Include Footer Component -->
        <footer class="bg-gray-800 p-4 text-center text-gray-400 text-sm shadow-inner mt-auto">
            <div class="container mx-auto">
                &copy; {{ date('Y') }} Your App Name. All rights reserved.
            </div>
        </footer>
    @endauth

    <!-- Font Awesome for icons (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    
    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
