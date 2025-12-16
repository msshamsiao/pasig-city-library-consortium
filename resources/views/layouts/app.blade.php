<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pasig City Library Consortium')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PCLC_logo.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- PUBLIC HEADER (No profile/logout) -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <!-- Left Logo -->
                <div class="flex items-center">
                    <img src="{{ asset('images/PCLC_logo.png') }}" alt="PCLC Logo" class="h-16 w-auto">
                </div>

                <!-- Center Title and Date/Time -->
                <div class="flex flex-col items-center gap-2">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-900 hover:text-blue-700 transition">
                        Pasig City Library Consortium
                    </a>
                    <div class="flex items-center gap-2 text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-lg border border-gray-200" 
                         x-data="{ 
                            datetime: '',
                            updateDateTime() {
                                const now = new Date();
                                const options = { 
                                    weekday: 'long',
                                    year: 'numeric', 
                                    month: 'long', 
                                    day: 'numeric'
                                };
                                const dateStr = now.toLocaleString('en-US', options);
                                const timeStr = now.toLocaleTimeString('en-US', { 
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                });
                                this.datetime = dateStr + ' | ' + timeStr;
                            }
                        }" 
                        x-init="updateDateTime(); setInterval(() => updateDateTime(), 1000)">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span x-text="datetime" class="font-medium"></span>
                    </div>
                </div>

                <!-- Right Side: Logo and Login -->
                <div class="flex items-center gap-6">
                    <img src="{{ asset('images/Pasig City Logo.png') }}" alt="Pasig City Logo" class="h-16 w-auto">
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
                        Login to your account
                    </a>
                </div>
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