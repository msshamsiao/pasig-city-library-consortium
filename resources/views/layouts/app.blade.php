<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pasig City Library Consortium')</title>
    
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
            <div class="flex justify-between items-center py-4">
                <!-- Logos and Title -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/PCLC_logo.png') }}" alt="PCLC Logo" class="h-14 w-auto">
                    <span class="text-xl font-bold text-blue-900">Pasig City Library Consortium</span>
                    <img src="{{ asset('images/Pasig City Logo.png') }}" alt="Pasig City Logo" class="h-14 w-auto">
                </a>

                <!-- Date/Time and Login Button -->
                <div class="flex items-center gap-6">
                    <div class="text-sm text-gray-600" x-data="{ 
                        datetime: '',
                        updateDateTime() {
                            const now = new Date();
                            const options = { 
                                year: 'numeric', 
                                month: 'long', 
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            };
                            this.datetime = now.toLocaleString('en-US', options);
                        }
                    }" x-init="updateDateTime(); setInterval(() => updateDateTime(), 1000)">
                        <span x-text="datetime"></span>
                    </div>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
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