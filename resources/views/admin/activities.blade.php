@extends('layouts.admin')

@section('title', 'Activities Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Activities Management</h2>
            <p class="text-gray-600 mt-1">Manage library events and activities</p>
        </div>
        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Activity
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Activities</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalActivities }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Upcoming</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $upcomingActivities }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">This Month</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ $thisMonthActivities }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Participants</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1">{{ number_format($totalParticipants) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search activities by title or description..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>All Status</option>
                <option>Upcoming</option>
                <option>Past</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>All Categories</option>
                <option>Announcement</option>
                <option>Program</option>
                <option>Workshop</option>
                <option>Event</option>
            </select>
        </div>
    </div>

    <!-- Activities Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $colors = [
                ['from' => 'blue-500', 'to' => 'blue-700', 'button' => 'blue-600', 'hover' => 'blue-700'],
                ['from' => 'purple-500', 'to' => 'purple-700', 'button' => 'purple-600', 'hover' => 'purple-700'],
                ['from' => 'green-500', 'to' => 'green-700', 'button' => 'green-600', 'hover' => 'green-700'],
                ['from' => 'orange-500', 'to' => 'orange-700', 'button' => 'orange-600', 'hover' => 'orange-700'],
                ['from' => 'red-500', 'to' => 'red-700', 'button' => 'red-600', 'hover' => 'red-700'],
                ['from' => 'indigo-500', 'to' => 'indigo-700', 'button' => 'indigo-600', 'hover' => 'indigo-700'],
            ];
            
            $categoryColors = [
                'announcement' => ['text' => 'blue-800', 'bg' => 'blue-100'],
                'program' => ['text' => 'green-800', 'bg' => 'green-100'],
                'workshop' => ['text' => 'purple-800', 'bg' => 'purple-100'],
                'event' => ['text' => 'orange-800', 'bg' => 'orange-100'],
            ];
        @endphp

        @forelse($activities as $index => $activity)
            @php
                $color = $colors[$index % count($colors)];
                $categoryColor = $categoryColors[$activity->category] ?? ['text' => 'gray-800', 'bg' => 'gray-100'];
                $isUpcoming = $activity->activity_date >= now();
                $isPast = $activity->activity_date < now();
            @endphp
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                <div class="h-48 bg-gradient-to-br from-{{ $color['from'] }} to-{{ $color['to'] }} flex items-center justify-center">
                    @if($activity->has_image && $activity->image)
                        <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        @if($isUpcoming)
                            <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Upcoming</span>
                        @elseif($isPast)
                            <span class="px-3 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Past</span>
                        @endif
                        <span class="px-3 py-1 text-xs font-semibold text-{{ $categoryColor['text'] }} bg-{{ $categoryColor['bg'] }} rounded-full">{{ ucfirst($activity->category) }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $activity->title }}</h3>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $activity->description }}</p>
                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($activity->activity_date)->format('F d, Y') }}</span>
                        </div>
                        @if($activity->time_start && $activity->time_end)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($activity->time_start)->format('g:i A') }} - {{ \Carbon\Carbon::parse($activity->time_end)->format('g:i A') }}</span>
                        </div>
                        @endif
                        @if($activity->location)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $activity->location }}</span>
                        </div>
                        @endif
                        @if($activity->max_participants)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>{{ $activity->current_participants }} / {{ $activity->max_participants }} slots</span>
                        </div>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <button class="flex-1 bg-{{ $color['button'] }} text-white px-4 py-2 rounded-lg hover:bg-{{ $color['hover'] }} transition text-sm">View Details</button>
                        <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">Edit</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-600">No activities found</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($activities->hasPages())
    <div class="bg-white rounded-lg shadow-sm px-6 py-3">
        {{ $activities->links() }}
    </div>
    @endif
</div>
@endsection
