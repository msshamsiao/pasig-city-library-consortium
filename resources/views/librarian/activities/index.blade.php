@extends('layouts.librarian')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Activities</h1>
                <p class="mt-1 text-sm text-gray-600">Manage library activities and events</p>
            </div>
            <a href="{{ route('librarian.activities.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Activity
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <!-- Dashboard Statistics -->
        <div class="mb-6 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Activities Overview</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Activity Status Statistics -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Activity Status
                    </h4>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Activities:</span>
                            <span class="font-semibold text-gray-900">{{ $stats['total'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pending:</span>
                            <span class="font-semibold text-yellow-600">{{ $stats['pending'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Approved:</span>
                            <span class="font-semibold text-green-600">{{ $stats['approved'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Rejected:</span>
                            <span class="font-semibold text-red-600">{{ $stats['rejected'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Activity Timeline Statistics -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Activity Timeline
                    </h4>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Upcoming Events:</span>
                            <span class="font-semibold text-purple-600">{{ $stats['upcoming'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">This Month:</span>
                            <span class="font-semibold text-indigo-600">{{ $stats['this_month'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Last Updated:</span>
                            <span class="font-semibold text-gray-900 text-xs">{{ now()->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" id="searchInput" 
                    placeholder="Search by activity title or description..."
                    class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"
                    autocomplete="off">
                <button type="button" id="clearSearch" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Activities Table -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Activity</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Start</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">End</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Posting Date</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activities as $activity)
                    <tr>
                        <td class="px-3 py-2">
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($activity->title, 35) }}</div>
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap">
                            <div class="text-xs text-gray-900">
                                {{ $activity->start_date ? \Carbon\Carbon::parse($activity->start_date)->format('M d, Y') : ($activity->activity_date->format('M d, Y')) }}
                            </div>
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap">
                            <div class="text-xs text-gray-900">
                                {{ $activity->end_date ? \Carbon\Carbon::parse($activity->end_date)->format('M d, Y') : 'N/A' }}
                            </div>
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap">
                            <div class="text-xs text-gray-700">
                                @if($activity->time_start && $activity->time_end)
                                    {{ $activity->time_start }} - {{ $activity->time_end }}
                                @else
                                    N/A
                                @endif
                            </div>
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap">
                            <div class="text-xs text-gray-700">
                                {{ $activity->created_at->format('M d, Y') }}
                                @if($activity->created_at->format('Y-m-d') !== $activity->updated_at->format('Y-m-d'))
                                    <br><span class="text-gray-500">to {{ $activity->updated_at->format('M d, Y') }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded
                                @if($activity->approval_status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($activity->approval_status === 'approved') bg-green-100 text-green-800
                                @elseif($activity->approval_status === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($activity->approval_status ?? 'pending') }}
                            </span>
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap">
                            @if($activity->approval_status === 'pending')
                                <a href="{{ route('librarian.activities.edit', $activity->id) }}" class="p-2 text-green-600 hover:bg-green-50 rounded-full transition inline-block" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            @elseif($activity->approval_status === 'approved')
                                <form action="{{ route('librarian.activities.destroy', $activity->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this activity?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-full transition inline-block" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @if($activity->rejection_reason)
                    <tr class="bg-red-50">
                        <td colspan="7" class="px-6 py-2">
                            <div class="text-xs text-red-600">
                                <span class="font-medium">Rejection Reason:</span> {{ $activity->rejection_reason }}
                            </div>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            @if(request('search'))
                                No activities found matching "{{ request('search') }}".
                            @else
                                No activities found. Click "Add Activity" to create one.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>

            <!-- Pagination -->
            <x-pagination :items="$activities" />
        </div>
    </div>
</div>

<script>
// Real-time search functionality
const searchInput = document.getElementById('searchInput');
const clearSearchBtn = document.getElementById('clearSearch');
const activitiesTableBody = document.querySelector('tbody');
let allActivities = [];

// Store all activity rows on page load
window.addEventListener('DOMContentLoaded', function() {
    const rows = activitiesTableBody.querySelectorAll('tr');
    rows.forEach(row => {
        if (row.querySelector('td[colspan]')) return; // Skip empty/rejection rows
        allActivities.push({
            element: row.cloneNode(true),
            text: row.textContent.toLowerCase(),
            nextRow: row.nextElementSibling?.querySelector('td[colspan]') ? row.nextElementSibling.cloneNode(true) : null
        });
    });
});

// Real-time search
searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    
    // Show/hide clear button
    if (searchTerm) {
        clearSearchBtn.classList.remove('hidden');
    } else {
        clearSearchBtn.classList.add('hidden');
    }
    
    // Filter activities
    if (searchTerm === '') {
        // Show all activities
        activitiesTableBody.innerHTML = '';
        allActivities.forEach(activity => {
            activitiesTableBody.appendChild(activity.element.cloneNode(true));
            if (activity.nextRow) {
                activitiesTableBody.appendChild(activity.nextRow.cloneNode(true));
            }
        });
    } else {
        // Filter and show matching activities
        const filtered = allActivities.filter(activity => activity.text.includes(searchTerm));
        
        if (filtered.length > 0) {
            activitiesTableBody.innerHTML = '';
            filtered.forEach(activity => {
                activitiesTableBody.appendChild(activity.element.cloneNode(true));
                if (activity.nextRow) {
                    activitiesTableBody.appendChild(activity.nextRow.cloneNode(true));
                }
            });
        } else {
            activitiesTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                        No activities found matching "${searchInput.value}".
                    </td>
                </tr>
            `;
        }
    }
});

// Clear search
clearSearchBtn.addEventListener('click', function() {
    searchInput.value = '';
    searchInput.dispatchEvent(new Event('input'));
    searchInput.focus();
});
</script>
@endsection
