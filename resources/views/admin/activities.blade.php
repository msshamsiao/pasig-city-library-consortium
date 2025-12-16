@extends('layouts.admin')

@section('title', 'Activities Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Activities Management</h2>
            <p class="text-gray-600 mt-1">Review and approve library activities</p>
        </div>
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
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $pendingActivities }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Approved</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $approvedActivities }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Upcoming</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ $upcomingActivities }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search activities..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>All Status</option>
                <option>Pending</option>
                <option>Approved</option>
                <option>Rejected</option>
            </select>
            <form method="GET" action="{{ route('admin.activities.index') }}" class="flex">
                <select name="library" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                    <option value="">All Libraries</option>
                    @foreach($libraries as $library)
                        <option value="{{ $library->id }}" {{ request('library') == $library->id ? 'selected' : '' }}>
                            {{ $library->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <!-- Activities Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Activity</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Library</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Start</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">End</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($activities as $activity)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2">
                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($activity->title, 30) }}</div>
                    </td>
                    <td class="px-3 py-2">
                        <div class="text-xs text-gray-700">{{ Str::limit($activity->library->name ?? 'N/A', 25) }}</div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <div class="text-xs text-gray-900">
                            {{ $activity->start_date ? \Carbon\Carbon::parse($activity->start_date)->format('M d, Y') : \Carbon\Carbon::parse($activity->activity_date)->format('M d, Y') }}
                        </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <div class="text-xs text-gray-900">
                            {{ $activity->end_date ? \Carbon\Carbon::parse($activity->end_date)->format('M d, Y') : 'N/A' }}
                        </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        @php
                            $categoryColors = [
                                'announcement' => 'blue',
                                'program' => 'green',
                                'workshop' => 'purple',
                                'event' => 'orange',
                            ];
                            $color = $categoryColors[$activity->category] ?? 'gray';
                        @endphp
                        <span class="px-2 py-1 text-xs font-medium rounded bg-{{ $color }}-100 text-{{ $color }}-800">
                            {{ ucfirst($activity->category) }}
                        </span>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        @if($activity->approval_status === 'pending')
                            <span class="px-2 py-1 text-xs font-medium rounded bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @elseif($activity->approval_status === 'approved')
                            <span class="px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-800">
                                Approved
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-800">
                                Rejected
                            </span>
                        @endif
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <div class="flex items-center gap-1">
                            <button onclick="viewActivity({{ $activity->id }})" class="text-blue-600 hover:text-blue-900 p-1" title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            @if($activity->approval_status === 'pending')
                                <form action="{{ route('admin.activities.approve', $activity) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:text-green-900 p-1" title="Approve">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </form>
                                <button onclick="rejectActivity({{ $activity->id }})" class="text-red-600 hover:text-red-900 p-1" title="Reject">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-600">No activities found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <!-- Pagination -->
    <x-pagination :items="$activities" />
</div>

<!-- View Activity Modal -->
<div id="viewActivityModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4 pb-3 border-b">
            <h3 class="text-xl font-semibold text-gray-900">Activity Details</h3>
            <button onclick="closeActivityModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div id="activityModalContent" class="mt-4">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<script>
const activities = @json($activities->items());

function viewActivity(id) {
    const activity = activities.find(a => a.id === id);
    if (!activity) {
        alert('Activity not found');
        return;
    }
    
    const statusColors = {
        'pending': 'yellow',
        'approved': 'green',
        'rejected': 'red'
    };
    
    const categoryColors = {
        'workshop': 'blue',
        'reading_program': 'green',
        'event': 'orange'
    };
    
    const statusColor = statusColors[activity.approval_status] || 'gray';
    const categoryColor = categoryColors[activity.category] || 'gray';
    
    const content = `
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-100">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h4 class="text-2xl font-bold text-gray-900 mb-2">${activity.title}</h4>
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-${categoryColor}-100 text-${categoryColor}-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                ${activity.category.replace('_', ' ').charAt(0).toUpperCase() + activity.category.replace('_', ' ').slice(1)}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-${statusColor}-100 text-${statusColor}-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                ${activity.approval_status.charAt(0).toUpperCase() + activity.approval_status.slice(1)}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    <h5 class="font-semibold text-gray-900">Description</h5>
                </div>
                <p class="text-gray-700 leading-relaxed">${activity.description || 'No description provided'}</p>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Library -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-500">Library</span>
                    </div>
                    <p class="text-gray-900 font-semibold">${activity.library ? activity.library.name : 'N/A'}</p>
                </div>

                <!-- Activity Date -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-500">Activity Date</span>
                    </div>
                    <p class="text-gray-900 font-semibold">${new Date(activity.activity_date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                </div>

                ${activity.location ? `
                <!-- Location -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-500">Location</span>
                    </div>
                    <p class="text-gray-900 font-semibold">${activity.location}</p>
                </div>
                ` : ''}

                ${activity.max_participants ? `
                <!-- Max Participants -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-500">Max Participants</span>
                    </div>
                    <p class="text-gray-900 font-semibold">${activity.max_participants} people</p>
                </div>
                ` : ''}

                ${activity.registration_deadline ? `
                <!-- Registration Deadline -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-500">Registration Deadline</span>
                    </div>
                    <p class="text-gray-900 font-semibold">${new Date(activity.registration_deadline).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                </div>
                ` : ''}
            </div>

            ${activity.approval_status === 'rejected' && activity.rejection_reason ? `
            <!-- Rejection Reason -->
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-5">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div class="flex-1">
                        <h5 class="font-semibold text-red-900 mb-1">Rejection Reason</h5>
                        <p class="text-red-800">${activity.rejection_reason}</p>
                    </div>
                </div>
            </div>
            ` : ''}

            <!-- Timestamps -->
            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <div>
                        <span class="text-gray-500">Created:</span>
                        <span class="text-gray-900 font-medium ml-1">${new Date(activity.created_at).toLocaleString()}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <div>
                        <span class="text-gray-500">Updated:</span>
                        <span class="text-gray-900 font-medium ml-1">${new Date(activity.updated_at).toLocaleString()}</span>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('activityModalContent').innerHTML = content;
    document.getElementById('viewActivityModal').classList.remove('hidden');
}

function closeActivityModal() {
    document.getElementById('viewActivityModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('viewActivityModal');
    if (event.target === modal) {
        closeActivityModal();
    }
}

function rejectActivity(id) {
    const reason = prompt('Enter rejection reason:');
    if (reason) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/activities/${id}/reject`;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PATCH';
        
        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'rejection_reason';
        reasonInput.value = reason;
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        form.appendChild(reasonInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
