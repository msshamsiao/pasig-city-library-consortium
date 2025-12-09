<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pasig City Library Consortium')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- PUBLIC HEADER (No profile/logout) -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <svg class="w-10 h-10 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                        <rect x="4" y="4" width="4" height="16" rx="1"/>
                        <rect x="10" y="4" width="4" height="16" rx="1"/>
                        <rect x="16" y="4" width="4" height="16" rx="1"/>
                    </svg>
                    <span class="text-xl font-semibold text-blue-600">Pasig City Library Consortium</span>
                </a>

                <!-- Login Button (Only for public pages) -->
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Login to your account
                </a>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center space-x-8">
                    <a href="{{ route('home') }}" class="py-4 px-3 text-gray-700 hover:text-blue-600 border-b-2 {{ request()->routeIs('home') ? 'border-blue-600 text-blue-600' : 'border-transparent' }}">
                        Home
                    </a>
                    <a href="{{ route('about') }}" class="py-4 px-3 text-gray-700 hover:text-blue-600 border-b-2 {{ request()->routeIs('about') ? 'border-blue-600 text-blue-600' : 'border-transparent' }}">
                        About
                    </a>
                    <a href="{{ route('libraries') }}" class="py-4 px-3 text-gray-700 hover:text-blue-600 border-b-2 {{ request()->routeIs('libraries') ? 'border-blue-600 text-blue-600' : 'border-transparent' }}">
                        Libraries
                    </a>
                    <a href="{{ route('activities') }}" class="py-4 px-3 text-gray-700 hover:text-blue-600 border-b-2 {{ request()->routeIs('activities') ? 'border-blue-600 text-blue-600' : 'border-transparent' }}">
                        Activities
                    </a>
                    <a href="{{ route('service') }}" class="py-4 px-3 text-gray-700 hover:text-blue-600 border-b-2 {{ request()->routeIs('service') ? 'border-blue-600 text-blue-600' : 'border-transparent' }}">
                        Service
                    </a>
                    <a href="{{ route('contact') }}" class="py-4 px-3 text-gray-700 hover:text-blue-600 border-b-2 {{ request()->routeIs('contact') ? 'border-blue-600 text-blue-600' : 'border-transparent' }}">
                        Contact Us
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center text-sm">
                <div>Views Today: <span x-data="{ count: 1247 }" x-text="count.toLocaleString()"></span></div>
                <div class="text-center">Copyright @2025 Pasig City MIS, All rights Reserved.</div>
                <div>Total Views: <span x-data="{ count: 28459 }" x-text="count.toLocaleString()"></span></div>
            </div>
        </div>
    </footer>
</body>
</html>