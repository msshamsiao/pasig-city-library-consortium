@extends('layouts.librarian')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Book Requests</h1>
            <p class="mt-1 text-sm text-gray-600">Review and manage book material requests from library members</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Filter Tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <a href="?status=pending" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status') == 'pending' || !request('status') ? 'border-blue-500 text-blue-600' : '' }}">
                        Pending
                        <span class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                            {{ $bookRequests->where('status', 'pending')->count() }}
                        </span>
                    </a>
                    <a href="?status=approved" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status') == 'approved' ? 'border-blue-500 text-blue-600' : '' }}">
                        Approved
                    </a>
                    <a href="?status=rejected" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status') == 'rejected' ? 'border-blue-500 text-blue-600' : '' }}">
                        Rejected
                    </a>
                    <a href="?status=completed" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status') == 'completed' ? 'border-blue-500 text-blue-600' : '' }}">
                        Completed
                    </a>
                </nav>
            </div>
        </div>

        <!-- Requests Table -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookRequests as $request)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-medium text-sm">{{ strtoupper(substr($request->user->name ?? 'U', 0, 2)) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $request->user->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">{{ $request->user->email ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($request->material_type === 'book') bg-blue-100 text-blue-800
                                @elseif($request->material_type === 'journal') bg-purple-100 text-purple-800
                                @elseif($request->material_type === 'cd') bg-green-100 text-green-800
                                @elseif($request->material_type === 'ebook') bg-indigo-100 text-indigo-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($request->material_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $request->date_schedule->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $request->date_time }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($request->status === 'approved') bg-green-100 text-green-800
                                @elseif($request->status === 'rejected') bg-red-100 text-red-800
                                @elseif($request->status === 'completed') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($request->status === 'pending')
                                <div class="flex gap-2">
                                    <form action="{{ route('librarian.book-requests.approve', $request->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                    </form>
                                    <button onclick="showRejectModal({{ $request->id }})" class="text-red-600 hover:text-red-900">Reject</button>
                                </div>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                    </tr>
                    @if($request->admin_notes)
                    <tr class="bg-gray-50">
                        <td colspan="6" class="px-6 py-2">
                            <div class="text-xs text-gray-600">
                                <span class="font-medium">Notes:</span> {{ $request->admin_notes }}
                            </div>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No book requests found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            @if($bookRequests->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $bookRequests->firstItem() ?? 0 }}</span> 
                        to <span class="font-medium">{{ $bookRequests->lastItem() ?? 0 }}</span> 
                        of <span class="font-medium">{{ $bookRequests->total() }}</span> results
                    </div>
                    <div>
                        {{ $bookRequests->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                <div class="text-sm text-gray-700">
                    Total: <span class="font-medium">{{ $bookRequests->total() }}</span> requests
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Reject Request</h3>
            <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Reason for Rejection <span class="text-red-500">*</span>
                </label>
                <textarea name="reason" rows="4" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Please provide a reason for rejecting this request..."></textarea>
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeRejectModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Reject Request
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal(requestId) {
    const form = document.getElementById('rejectForm');
    form.action = `/librarian/book-requests/${requestId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectForm').reset();
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>
@endsection
