<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - Pasig City Library Consortium</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-blue-50">
        <div class="min-h-screen flex">
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-blue-800 p-12 flex-col justify-between relative overflow-hidden">
                <!-- Decorative circles -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full opacity-20 -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-400 rounded-full opacity-20 translate-y-1/2 -translate-x-1/2"></div>
                
                <div class="relative z-10">
                    <a href="{{ route('home') }}" class="flex items-center gap-4 text-white">
                        <img src="{{ asset('images/PCLC_logo.png') }}" alt="PCLC Logo" class="h-16 w-auto drop-shadow-lg">
                        <img src="{{ asset('images/Pasig City Logo.png') }}" alt="Pasig City Logo" class="h-16 w-auto drop-shadow-lg">
                    </a>
                </div>

                <div class="relative z-10 text-white">
                    <h1 class="text-4xl font-bold mb-4">Welcome Back!</h1>
                    <p class="text-blue-100 text-lg leading-relaxed">
                        Access the Pasig City Library Consortium Portal to manage resources, track activities, and connect with our network of libraries.
                    </p>
                </div>

                <div class="relative z-10 text-blue-200 text-sm">
                    © {{ date('Y') }} Pasig City Library Consortium. All rights reserved.
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="flex-1 flex items-center justify-center p-8">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex justify-center items-center gap-3 mb-8">
                        <img src="{{ asset('images/PCLC_logo.png') }}" alt="PCLC Logo" class="h-12 w-auto">
                        <img src="{{ asset('images/Pasig City Logo.png') }}" alt="Pasig City Logo" class="h-12 w-auto">
                    </div>

                    <!-- Login Card -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign In</h2>
                            <p class="text-gray-500">Enter your credentials to access your account</p>
                        </div>

                        {{ $slot }}
                    </div>

                    <!-- Back to Home -->
                    <div class="text-center mt-6">
                        <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-blue-600 transition">
                            ← Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
