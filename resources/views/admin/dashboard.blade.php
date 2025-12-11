@extends('layouts.admin')

@section('title', 'Library Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Library Dashboard</h1>
            <p class="text-gray-600 mt-1">Manage your library operations</p>
        </div>

        <!-- Library Dashboard Stats -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-blue-900">Library Members</h4>
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-blue-900">{{ $stats['total_library_members'] ?? 0 }}</div>
                    <p class="text-xs text-blue-700 mt-1">Total librarians</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-green-900">Total Books</h4>
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-green-900">{{ $stats['total_books'] ?? 0 }}</div>
                    <p class="text-xs text-green-700 mt-1">In collection</p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-purple-900">Active Members</h4>
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-purple-900">{{ $stats['total_active_members'] ?? 0 }}</div>
                    <p class="text-xs text-purple-700 mt-1">Registered borrowers</p>
                </div>
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-orange-900">Reservations</h4>
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-orange-900">{{ $stats['book_reservations'] ?? 0 }}</div>
                    <p class="text-xs text-orange-700 mt-1">Pending requests</p>
                </div>
                <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-teal-900">Completed</h4>
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-teal-900">{{ $stats['completed_transactions'] ?? 0 }}</div>
                    <p class="text-xs text-teal-700 mt-1">Total transactions</p>
                </div>
            </div>
        </div>

        <!-- Super Admin Profile & Account Details -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-900">
                    @if(auth()->user()->isSuperAdmin())
                        Super Admin Details
                    @else
                        Account Details
                    @endif
                </h3>
            </div>

            <!-- Profile Section -->
            <div class="flex items-start justify-between mb-6 pb-6 border-b border-gray-200">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name ?? 'Juan Dela Cruz' }}</h2>
                        <p class="text-gray-600">{{ auth()->user()->email ?? 'juan.cruz@email.com' }}</p>
                        <p class="text-gray-600">{{ auth()->user()->phone ?? '09123456789' }}</p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>

            <!-- Account Details Section -->
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Member ID:</span>
                    <span class="font-semibold">{{ auth()->user()->member_id ?? 'user001' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Registration Date:</span>
                    <span class="font-semibold">{{ auth()->user()->created_at?->format('F j, Y') ?? 'January 15, 2024' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Last Login:</span>
                    <span class="font-semibold">{{ now()->format('F j, Y') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Account Status:</span>
                    <span class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        <span class="font-semibold text-green-600">Active</span>
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection