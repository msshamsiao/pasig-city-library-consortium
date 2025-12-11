@extends('layouts.admin')

@section('title', 'Book Requests Management')
@section('page-title', 'Book Requests')

@section('content')
<div class="mb-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pickup Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($reservations as $reservation)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $reservation->member->first_name }} {{ $reservation->member->last_name }}
                            </div>
                            <div class="text-sm text-gray-500">{{ $reservation->member->member_id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $reservation->holding->title }}</div>
                            <div class="text-sm text-gray-500">by {{ $reservation->holding->author }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($reservation->borrowed_date)->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-orange-100 text-orange-800',
                                    'reserved' => 'bg-yellow-100 text-yellow-800',
                                    'borrowed' => 'bg-blue-100 text-blue-800',
                                    'returned' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                ];
                                $color = $statusColors[$reservation->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex gap-1">
                                @if($reservation->status === 'pending')
                                    <form action="{{ route('librarian.reservations.approve', $reservation->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-full transition inline-block" title="Approve">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <button onclick="showRejectModal({{ $reservation->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-full transition inline-block" title="Reject">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                @endif

                                @if($reservation->status === 'reserved')
                                    <form action="{{ route('librarian.reservations.borrowed', $reservation->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition inline-block" title="Mark as Borrowed">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                @if($reservation->status === 'borrowed')
                                    <form action="{{ route('librarian.reservations.returned', $reservation->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-full transition inline-block" title="Mark as Returned">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                @if($reservation->notes)
                                    <button onclick="showNotes('{{ str_replace("'", "\\'", $reservation->notes) }}')" class="p-2 text-gray-600 hover:bg-gray-50 rounded-full transition inline-block" title="View Notes">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No reservations found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white px-4 py-3 border-t border-gray-200">
        {{ $reservations->links() }}
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Reservation</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection</label>
                <textarea name="reason" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Reject</button>
            </div>
        </form>
    </div>
</div>

<!-- Notes Modal -->
<div id="notesModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
        <div id="notesContent" class="text-sm text-gray-700 whitespace-pre-wrap"></div>
        <div class="mt-4 flex justify-end">
            <button onclick="document.getElementById('notesModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Close</button>
        </div>
    </div>
</div>

<script>
function showRejectModal(id) {
    const form = document.getElementById('rejectForm');
    form.action = `/librarian/reservations/${id}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function showNotes(notes) {
    document.getElementById('notesContent').textContent = notes;
    document.getElementById('notesModal').classList.remove('hidden');
}
</script>
@endsection
