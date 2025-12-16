@extends('layouts.admin')

@section('title', 'Librarian Dashboard')
@section('page-title', 'Librarian Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Members -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Members</p>
                <p class="text-3xl font-bold text-blue-600">{{ number_format($stats['total_members'] ?? 0) }}</p>
                <p class="text-xs text-gray-500 mt-1">Registered users</p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Books -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Books</p>
                <p class="text-3xl font-bold text-green-600">{{ number_format($stats['total_books'] ?? 0) }}</p>
                <p class="text-xs text-gray-500 mt-1">In collection</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pending Requests -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Pending Requests</p>
                <p class="text-3xl font-bold text-orange-600">{{ number_format($stats['pending_requests'] ?? 0) }}</p>
                <p class="text-xs text-gray-500 mt-1">Awaiting approval</p>
            </div>
            <div class="bg-orange-100 rounded-full p-3">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Books on Reserve -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Books on Reserve</p>
                <p class="text-3xl font-bold text-purple-600">{{ number_format($stats['books_borrowed'] ?? 0) }}</p>
                <p class="text-xs text-gray-500 mt-1">Currently borrowed</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Analysis Section -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4">Library Analysis</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Member Statistics -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Member Statistics
            </h4>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Members:</span>
                    <span class="font-semibold text-gray-900">{{ $stats['total_members'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Active Members:</span>
                    <span class="font-semibold text-green-600">{{ $stats['active_members'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">New This Month:</span>
                    <span class="font-semibold text-blue-600">{{ $stats['new_members'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Book Statistics -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Book Statistics
            </h4>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Books:</span>
                    <span class="font-semibold text-gray-900">{{ $stats['total_books'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Available:</span>
                    <span class="font-semibold text-green-600">{{ $stats['available_books'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">On Reserve:</span>
                    <span class="font-semibold text-purple-600">{{ $stats['books_borrowed'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Request Statistics -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Request Statistics
            </h4>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Pending Requests:</span>
                    <span class="font-semibold text-yellow-600">{{ $stats['pending_requests'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Approved Today:</span>
                    <span class="font-semibold text-green-600">{{ $stats['approved_today'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total This Month:</span>
                    <span class="font-semibold text-blue-600">{{ $stats['requests_this_month'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Activity Statistics -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Recent Activity
            </h4>
            <div class="space-y-2 max-h-24 overflow-y-auto">
                @forelse($recentActivities ?? [] as $activity)
                    <div class="text-xs text-gray-600 border-l-2 border-blue-400 pl-2 py-1">
                        <p class="text-gray-800">{{ Str::limit($activity->description, 50) }}</p>
                        <p class="text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-2">No recent activity</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
