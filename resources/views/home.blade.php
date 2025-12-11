@extends('layouts.app')

@section('title', 'Home - Pasig City Library Consortium')

@section('content')
<div class="bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Section -->
        <div class="mb-8" x-data="searchComponent()">
            <h2 class="text-xl font-semibold mb-4">Search By:</h2>
            
            <div class="flex gap-4 items-end">
                <!-- Category Dropdown -->
                <div class="w-36">
                    <select x-model="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Categories</option>
                        <option value="title">Title</option>
                        <option value="author">Author</option>
                        <option value="subject">Subject</option>
                    </select>
                </div>

                <!-- Library Dropdown -->
                <div class="flex-1">
                    <select x-model="library" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Libraries</option>
                        @foreach($libraries as $lib)
                            <option value="{{ $lib->id }}">{{ $lib->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Search Input -->
                <div class="flex-[2]">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input 
                            x-model="search"
                            @keyup.enter="performSearch()"
                            type="text" 
                            placeholder="Enter Title, Author, or Subject..." 
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                </div>

                <!-- Search Button -->
                <button 
                    @click="performSearch()"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition flex items-center justify-center"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>
            
            <!-- Search Results Modal -->
            <div x-show="showModal" 
                 x-cloak
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 @click.self="showModal = false">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="showModal = false"></div>

                    <!-- Modal panel -->
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-2xl font-bold text-gray-900">Search Results</h3>
                                <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Loading State -->
                            <div x-show="isLoading" class="text-center py-8">
                                <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="mt-2 text-gray-600">Searching...</p>
                            </div>

                            <!-- Results -->
                            <div x-show="!isLoading">
                                <div x-show="searchResults.length === 0" class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="mt-2 text-gray-600">No books found</p>
                                </div>

                                <div class="grid grid-cols-1 gap-4 max-h-96 overflow-y-auto">
                                    <template x-for="book in searchResults" :key="book.id">
                                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                            <div class="flex gap-4">
                                                <div x-show="book.cover_image" class="flex-shrink-0">
                                                    <img :src="book.cover_image" :alt="book.title" class="w-20 h-28 object-cover rounded">
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="text-lg font-semibold text-gray-900" x-text="book.title"></h4>
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        <span class="font-medium">Author:</span> <span x-text="book.author"></span>
                                                    </p>
                                                    <p class="text-sm text-gray-600 mt-1" x-show="book.isbn">
                                                        <span class="font-medium">ISBN:</span> <span x-text="book.isbn"></span>
                                                    </p>
                                                    <p class="text-sm text-gray-600 mt-1" x-show="book.category">
                                                        <span class="font-medium">Category:</span> <span x-text="book.category"></span>
                                                    </p>
                                                    <div class="mt-2 flex items-center gap-4">
                                                        <span class="text-sm" :class="book.status === 'available' ? 'text-green-600' : 'text-red-600'">
                                                            <span class="font-medium">Status:</span> 
                                                            <span x-text="book.status === 'available' ? 'Available' : 'On Loan'"></span>
                                                        </span>
                                                        <span class="text-sm text-gray-600" x-show="book.available_copies !== undefined">
                                                            <span class="font-medium">Available:</span> 
                                                            <span x-text="book.available_copies + ' / ' + book.total_copies"></span>
                                                        </span>
                                                    </div>
                                                    <p class="text-sm text-gray-500 mt-2" x-show="book.description" x-text="book.description"></p>
                                                    
                                                    @auth
                                                        @if(auth()->user()->isBorrower())
                                                            <button 
                                                                @click="openReservationModal(book)"
                                                                class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition"
                                                            >
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                                </svg>
                                                                Request Material
                                                            </button>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('login') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                                            Login to Request
                                                        </a>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button @click="showModal = false" type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Sidebar - Libraries List -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-center mb-6">Libraries</h3>
                    
                    <div class="space-y-4">
                        @foreach($libraries as $library)
                            <div>
                                @if($library->website)
                                    <a href="{{ $library->website }}" target="_blank" class="font-semibold text-blue-600 hover:underline">{{ $library->name }}</a>
                                @else
                                    <h4 class="font-semibold text-gray-900">{{ $library->name }}</h4>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Survey Banner -->
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSe4EKCT3DEPlMlDX7K3DHAhxpWbf3qJA748cf-HNiDjrv4IRA/viewform" target="_blank" class="block bg-gradient-to-r from-blue-600 to-blue-700 border border-blue-700 rounded-lg p-6 hover:from-blue-700 hover:to-blue-800 transition transform hover:scale-[1.02] shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="bg-white/20 rounded-full p-3">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">Help Us Improve!</h3>
                                <p class="text-blue-100">Take our quick survey and share your feedback</p>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Welcome Message -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">Welcome</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Welcome to the Community Library Consortium Portal. Use the search bar above to explore titles, authors, and subjects across all participating libraries in our network. 
                        This platform helps you quickly locate materials, check availability, and access shared resources from member libraries.
                    </p>
                </div>

                <!-- Statistics Cards -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- Total Libraries -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                            <div class="text-4xl font-bold text-blue-600 mb-2">{{ $statistics['total_libraries'] }}</div>
                            <div class="text-sm text-gray-600">Total Libraries</div>
                        </div>

                        <!-- Total Books -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                            <div class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($statistics['total_books']) }}</div>
                            <div class="text-sm text-gray-600">Total Books</div>
                        </div>

                        <!-- Total Reservations -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                            <div class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($statistics['total_reservations']) }}</div>
                            <div class="text-sm text-gray-600">Total Reservations</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reservation Request Modal -->
@auth
@if(auth()->user()->isBorrower())
<div id="reservationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Request Material</h3>
            <button onclick="closeReservationModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Book Info Display -->
        <div id="selectedBookInfo" class="mb-4 p-3 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-600"><span class="font-medium">Material:</span> <span id="bookInfoTitle"></span></p>
            <p class="text-sm text-gray-600"><span class="font-medium">Author:</span> <span id="bookInfoAuthor"></span></p>
        </div>

        <form action="{{ route('borrower.reservations.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="book_info" id="bookInfoHidden">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Material Type</label>
                <select name="material_type" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select material type</option>
                    <option value="book" selected>Book</option>
                    <option value="journal">Journal</option>
                    <option value="cd">CD/DVD</option>
                    <option value="ebook">E-Book</option>
                </select>
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
                <button type="button" onclick="closeReservationModal()"
                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endauth

<script>
function searchComponent() {
    return {
        category: 'all',
        library: 'all',
        search: '',
        showModal: false,
        searchResults: [],
        isLoading: false,
        
        init() {
            // Watch for Enter key on search input
            this.$watch('search', () => {
                if (event && event.keyCode === 13) {
                    this.performSearch();
                }
            });
        },
        
        performSearch() {
            console.log('Search params:', {
                category: this.category,
                library: this.library,
                search: this.search
            });
            
            if (!this.search.trim()) {
                alert('Please enter a search term');
                return;
            }
            
            this.isLoading = true;
            this.showModal = true;
            
            fetch('{{ route("home.search") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    category: this.category,
                    library: this.library,
                    search: this.search
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Search results:', data);
                this.searchResults = data.books || [];
                this.isLoading = false;
            })
            .catch(error => {
                console.error('Search error:', error);
                alert('An error occurred while searching');
                this.isLoading = false;
            });
        },
        
        openReservationModal(book) {
            console.log('Opening reservation for:', book);
            document.getElementById('bookInfoTitle').textContent = book.title;
            document.getElementById('bookInfoAuthor').textContent = book.author;
            document.getElementById('bookInfoHidden').value = JSON.stringify({
                title: book.title,
                author: book.author,
                isbn: book.isbn
            });
            document.getElementById('reservationModal').classList.remove('hidden');
        }
    }
}

function closeReservationModal() {
    document.getElementById('reservationModal').classList.add('hidden');
}
</script>
@endsection