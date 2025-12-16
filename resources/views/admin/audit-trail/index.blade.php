@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Audit Trail</h1>
            <p class="mt-1 text-sm text-gray-600">Track all system activities and changes</p>
        </div>

        <!-- Filters -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <form method="GET" action="{{ route('admin.audit-trail') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Date Range -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- User Filter -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User</label>
                    <select name="user_id" id="user_id" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Filter -->
                <div>
                    <label for="action" class="block text-sm font-medium text-gray-700 mb-1">Action Type</label>
                    <select name="action" id="action" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Buttons -->
                <div class="md:col-span-4 flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.audit-trail') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Audit Log Table -->
        <div class="bg-white shadow-sm rounded-lg">
            <table class="w-full table-fixed divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-[12%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="w-[15%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="w-[8%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Library</th>
                        <th class="w-[10%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        <th class="w-[35%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="w-[12%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP</th>
                        <th class="w-[8%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($auditLogs as $log)
                    <tr>
                        <td class="px-2 py-3">
                            <div class="text-xs text-gray-900">{{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->created_at)->format('h:i A') }}</div>
                        </td>
                        <td class="px-2 py-3">
                            <span class="text-xs font-medium text-gray-900 truncate" title="{{ $log->user_name }}">{{ $log->user_name }}</span>
                        </td>
                        <td class="px-2 py-3">
                            <span class="text-xs font-semibold text-gray-900">
                                {{ $log->library_acronym ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-2 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($log->action === 'created') bg-green-100 text-green-800
                                @elseif($log->action === 'updated') bg-blue-100 text-blue-800
                                @elseif($log->action === 'deleted') bg-red-100 text-red-800
                                @elseif($log->action === 'login') bg-purple-100 text-purple-800
                                @elseif($log->action === 'logout') bg-gray-100 text-gray-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td class="px-2 py-3">
                            <div class="text-xs text-gray-900 truncate" title="@if($log->description){{ $log->description }}@elseif($log->model){{ ucfirst($log->action) }} {{ $log->model }} @if($log->model_id)#{{ $log->model_id }}@endif @else{{ ucfirst($log->action) }} action@endif">
                                @if($log->description)
                                    {{ $log->description }}
                                @elseif($log->model)
                                    {{ ucfirst($log->action) }} {{ $log->model }} 
                                    @if($log->model_id)
                                        #{{ $log->model_id }}
                                    @endif
                                @else
                                    {{ ucfirst($log->action) }} action
                                @endif
                            </div>
                        </td>
                        <td class="px-2 py-3">
                            <div class="text-xs text-gray-900 truncate">{{ $log->ip_address ?? 'N/A' }}</div>
                        </td>
                        <td class="px-2 py-3 text-xs">
                            <button onclick="showDetails({{ $log->id }})" class="text-blue-600 hover:text-blue-900">
                                View
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            No audit logs found. Activity logs will appear here when users perform actions in the system.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <x-pagination :items="$auditLogs" />
        </div>
    </div>
</div>

<!-- Details Modal (Simple implementation) -->
<div id="detailsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Activity Details</h3>
            <button onclick="closeDetails()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="detailsContent" class="text-sm text-gray-600">
            <!-- Details will be loaded here -->
        </div>
    </div>
</div>

<script>
function showDetails(logId) {
    // In a real implementation, you would fetch details via AJAX
    // For now, just show a placeholder
    document.getElementById('detailsContent').innerHTML = `
        <div class="space-y-3">
            <p><strong>Log ID:</strong> ${logId}</p>
            <p><strong>Note:</strong> Detailed change tracking will be implemented when activity logging is integrated throughout the system.</p>
            <p class="text-xs text-gray-500 mt-4">This feature will show old and new values, user agent, and other metadata.</p>
        </div>
    `;
    document.getElementById('detailsModal').classList.remove('hidden');
}

function closeDetails() {
    document.getElementById('detailsModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('detailsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetails();
    }
});
</script>
@endsection
