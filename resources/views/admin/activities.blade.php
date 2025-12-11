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
    <div class="bg-white rounded-lg shadow-sm px-6 py-4 flex items-center justify-between">
        <div class="text-sm text-gray-700">
            Showing <span class="font-medium">{{ $activities->firstItem() ?? 0 }}</span> 
            to <span class="font-medium">{{ $activities->lastItem() ?? 0 }}</span> 
            of <span class="font-medium">{{ $activities->total() }}</span> activities
        </div>
        <div>
            {{ $activities->links() }}
        </div>
    </div>
</div>

<script>
function viewActivity(id) {
    // Implement view modal functionality
    alert('View activity details for ID: ' + id);
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
