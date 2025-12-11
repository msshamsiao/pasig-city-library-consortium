@extends('layouts.admin')

@section('title', 'Libraries Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Libraries Management</h2>
            <p class="text-gray-600 mt-1">Manage library branches and locations</p>
        </div>
        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Library
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Libraries</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalLibraries }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Books</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ number_format($totalBooks) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Members</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ number_format($totalMembers) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Libraries Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $colors = [
                ['from' => 'blue-500', 'to' => 'blue-600', 'button' => 'blue-600', 'hover' => 'blue-700'],
                ['from' => 'green-500', 'to' => 'green-600', 'button' => 'green-600', 'hover' => 'green-700'],
                ['from' => 'purple-500', 'to' => 'purple-600', 'button' => 'purple-600', 'hover' => 'purple-700'],
                ['from' => 'orange-500', 'to' => 'orange-600', 'button' => 'orange-600', 'hover' => 'orange-700'],
                ['from' => 'pink-500', 'to' => 'pink-600', 'button' => 'pink-600', 'hover' => 'pink-700'],
                ['from' => 'indigo-500', 'to' => 'indigo-600', 'button' => 'indigo-600', 'hover' => 'indigo-700'],
            ];
        @endphp

        @forelse($libraries as $index => $library)
            @php
                $color = $colors[$index % count($colors)];
            @endphp
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                <div class="h-32 bg-gradient-to-r from-{{ $color['from'] }} to-{{ $color['to'] }}"></div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $library->name }}</h3>
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $library->address ?? 'No address' }}
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            {{ $library->type ?? 'Library' }}
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-blue-600">{{ number_format($library->total_books) }}</div>
                            <div class="text-xs text-gray-600">Books</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-green-600">{{ number_format($library->total_members) }}</div>
                            <div class="text-xs text-gray-600">Members</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-orange-600">{{ number_format($library->active_requests) }}</div>
                            <div class="text-xs text-gray-600">Active</div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="flex-1 px-4 py-2 bg-{{ $color['button'] }} text-white rounded-lg hover:bg-{{ $color['hover'] }} transition text-sm">View Details</button>
                        <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">Edit</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <p class="text-gray-600">No libraries found</p>
            </div>
        @endforelse
    </div>
</div>
@endsection