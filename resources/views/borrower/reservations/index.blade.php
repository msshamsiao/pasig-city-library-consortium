@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Reservations</h1>
            <p class="mt-2 text-gray-600">View and manage your material reservation requests</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- New Reservation Button -->
        <div class="mb-6">
            <button onclick="document.getElementById('newReservationModal').classList.remove('hidden')" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Reservation Request
            </button>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button onclick="filterReservations('all')" 
                        class="tab-btn active border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                    All Requests
                </button>
                <button onclick="filterReservations('pending')" 
                        class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Pending
                </button>
                <button onclick="filterReservations('approved')" 
                        class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Approved
                </button>
                <button onclick="filterReservations('rejected')" 
                        class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Rejected
                </button>
                <button onclick="filterReservations('completed')" 
                        class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Completed
                </button>
            </nav>
        </div>

        <!-- Reservations List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($reservations->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No reservations</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new reservation request.</p>
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pickup Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reservations as $reservation)
                            <tr class="reservation-row" data-status="{{ $reservation->status }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($reservation->holding->title, 40) }}</div>
                                            <div class="text-xs text-gray-500">by {{ $reservation->holding->author }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($reservation->borrowed_date)->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($reservation->due_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-orange-100 text-orange-800',
                                            'reserved' => 'bg-yellow-100 text-yellow-800',
                                            'borrowed' => 'bg-blue-100 text-blue-800',
                                            'returned' => 'bg-green-100 text-green-800',
                                            'overdue' => 'bg-red-100 text-red-800',
                                        ];
                                        $color = $statusColors[$reservation->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex gap-1">
                                        @if(in_array($reservation->status, ['pending', 'reserved']))
                                            <form action="{{ route('borrower.reservations.cancel', $reservation) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to cancel this reservation?')" 
                                                        class="p-2 text-red-600 hover:bg-red-50 rounded-full transition inline-block" title="Cancel Reservation">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        @if($reservation->admin_notes)
                                            <button onclick="showNotes(`{{ str_replace('`', '\`', $reservation->admin_notes) }}`)" 
                                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition inline-block" title="View Details">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200">
                    {{ $reservations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- New Reservation Modal -->
<div id="newReservationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">New Reservation Request</h3>
            <button onclick="document.getElementById('newReservationModal').classList.add('hidden')" 
                    class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('borrower.reservations.store') }}" method="POST" id="reservationForm">
            @csrf
            
            <!-- Search Filters -->
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search By</label>
                    <select id="searchCategory" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All (Title, Author, Subject)</option>
                        <option value="title">Title</option>
                        <option value="author">Author</option>
                        <option value="subject">Subject/Category</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Library</label>
                    <select id="searchLibrary" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Libraries</option>
                        @foreach(\App\Models\Library::where('is_active', true)->get() as $lib)
                            <option value="{{ $lib->id }}">{{ $lib->acronym }} - {{ $lib->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Search Section -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Search for Book</label>
                <div class="relative">
                    <input type="text" id="bookSearch" 
                           placeholder="Search by title, author, or subject..."
                           class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Search Results -->
            <div id="searchResults" class="mb-6 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Book</label>
                <div id="booksList" class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg">
                    <!-- Books will be loaded here via JavaScript -->
                </div>
            </div>

            <!-- Selected Book Display -->
            <div id="selectedBookDisplay" class="mb-6 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Selected Book</label>
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium text-gray-900" id="selectedTitle"></h4>
                            <p class="text-sm text-gray-600" id="selectedAuthor"></p>
                            <p class="text-xs text-gray-500" id="selectedISBN"></p>
                        </div>
                        <button type="button" onclick="clearBookSelection()" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <input type="hidden" name="holding_id" id="selectedHoldingId" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Date</label>
                <input type="date" name="date_schedule" required min="{{ date('Y-m-d') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Time</label>
                <input type="time" name="date_time" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="document.getElementById('newReservationModal').classList.add('hidden')"
                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit" id="submitBtn" disabled
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:bg-gray-400 disabled:cursor-not-allowed">
                    Reserve Book
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Details Modal -->
<div id="notesModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Reservation Details</h3>
            <button onclick="document.getElementById('notesModal').classList.add('hidden')" 
                    class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div id="notesContent" class="text-gray-700 whitespace-pre-line"></div>
        <div class="mt-4 flex justify-end">
            <button onclick="document.getElementById('notesModal').classList.add('hidden')" 
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
let searchTimeout;
let selectedBook = null;

// Book Search
document.getElementById('bookSearch')?.addEventListener('input', function(e) {
    const query = e.target.value.trim();
    
    clearTimeout(searchTimeout);
    
    if (query.length < 2) {
        document.getElementById('searchResults').classList.add('hidden');
        return;
    }
    
    searchTimeout = setTimeout(() => {
        searchBooks(query);
    }, 300);
});

function searchBooks(query) {
    fetch(`/api/holdings/search?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            displaySearchResults(data);
        })
        .catch(error => {
            console.error('Search error:', error);
        });
}

function displaySearchResults(books) {
    const resultsDiv = document.getElementById('searchResults');
    const booksList = document.getElementById('booksList');
    
    if (books.length === 0) {
        booksList.innerHTML = '<p class="p-4 text-gray-500 text-sm">No books found</p>';
        resultsDiv.classList.remove('hidden');
        return;
    }
    
    booksList.innerHTML = books.map(book => `
        <div onclick='selectBook(${JSON.stringify(book)})' 
             class="p-3 hover:bg-gray-50 cursor-pointer border-b last:border-b-0">
            <h4 class="font-medium text-gray-900 text-sm">${book.title}</h4>
            <p class="text-xs text-gray-600">by ${book.author}</p>
            <div class="flex justify-between items-center mt-1">
                <span class="text-xs text-gray-500">ISBN: ${book.isbn}</span>
                <span class="text-xs ${book.available_copies > 0 ? 'text-green-600' : 'text-red-600'}">
                    ${book.available_copies} available
                </span>
            </div>
        </div>
    `).join('');
    
    resultsDiv.classList.remove('hidden');
}

function selectBook(book) {
    selectedBook = book;
    
    // Update selected book display
    document.getElementById('selectedTitle').textContent = book.title;
    document.getElementById('selectedAuthor').textContent = `by ${book.author}`;
    document.getElementById('selectedISBN').textContent = `ISBN: ${book.isbn}`;
    document.getElementById('selectedHoldingId').value = book.id;
    
    // Show selected book, hide search results
    document.getElementById('selectedBookDisplay').classList.remove('hidden');
    document.getElementById('searchResults').classList.add('hidden');
    document.getElementById('bookSearch').value = '';
    
    // Enable submit button
    document.getElementById('submitBtn').disabled = false;
}

function clearBookSelection() {
    selectedBook = null;
    document.getElementById('selectedBookDisplay').classList.add('hidden');
    document.getElementById('selectedHoldingId').value = '';
    document.getElementById('submitBtn').disabled = true;
}

function filterReservations(status) {
    const rows = document.querySelectorAll('.reservation-row');
    const tabs = document.querySelectorAll('.tab-btn');
    
    // Update tab styles
    tabs.forEach(tab => {
        tab.classList.remove('border-blue-500', 'text-blue-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    event.target.classList.remove('border-transparent', 'text-gray-500');
    event.target.classList.add('border-blue-500', 'text-blue-600');
    
    // Filter rows
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.classList.remove('hidden');
        } else {
            row.classList.add('hidden');
        }
    });
}

function showNotes(notes) {
    document.getElementById('notesContent').textContent = notes;
    document.getElementById('notesModal').classList.remove('hidden');
}
</script>
@endsection
