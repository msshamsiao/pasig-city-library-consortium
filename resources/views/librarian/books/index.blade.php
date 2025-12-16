@extends('layouts.librarian')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Books Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage library books collection</p>
            </div>
            <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" type="button" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Upload CSV
            </button>
        </div>

        <!-- Search and Bulk Actions -->
        <div class="mb-6 flex flex-col sm:flex-row gap-4">
            <!-- Search Form -->
            <form method="GET" action="{{ route('librarian.books.index') }}" class="flex-1" id="searchForm">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" 
                        placeholder="Search by title, author, ISBN, category..."
                        class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"
                        autocomplete="off">
                    @if(request('search'))
                    <button type="button" onclick="clearSearch()" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    @endif
                    <div id="searchLoading" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </form>

            <!-- Bulk Actions -->
            <div id="bulkActionsContainer" class="hidden">
                <button onclick="bulkDelete()" class="inline-flex items-center px-4 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete Selected (<span id="selectedCount">0</span>)
                </button>
            </div>
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

        <!-- Import Errors -->
        @if(session('errors') && is_array(session('errors')))
        <div class="mb-6 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg relative" role="alert">
            <p class="font-semibold mb-2">Import completed with {{ count(session('errors')) }} error(s)</p>
            <details class="mt-2">
                <summary class="cursor-pointer text-sm font-medium hover:underline">View error details (first 50 shown)</summary>
                <div class="mt-2 max-h-64 overflow-y-auto bg-white p-3 rounded border border-yellow-300">
                    <ul class="text-xs space-y-1">
                        @foreach(array_slice(session('errors'), 0, 50) as $error)
                        <li class="text-red-700">• {{ $error }}</li>
                        @endforeach
                        @if(count(session('errors')) > 50)
                        <li class="text-gray-600 italic">... and {{ count(session('errors')) - 50 }} more errors</li>
                        @endif
                    </ul>
                </div>
            </details>
        </div>
        @endif

        <!-- Books Table -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 w-8">
                            <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)" 
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">ISBN</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Branch</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Copies</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($books as $book)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2">
                            <input type="checkbox" class="book-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                                value="{{ $book->id }}" onchange="updateBulkActions()">
                        </td>
                        <td class="px-3 py-2">
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($book->title, 40) }}</div>
                            @if($book->description)
                            <div class="text-xs text-gray-500">{{ Str::limit($book->description, 35) }}</div>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-sm text-gray-900">{{ Str::limit($book->author, 25) }}</td>
                        <td class="px-3 py-2 text-xs text-gray-600">{{ $book->isbn }}</td>
                        <td class="px-3 py-2">
                            @if($book->library)
                            <span class="px-2 py-0.5 text-xs font-medium rounded bg-purple-100 text-purple-800">
                                {{ $book->library->acronym }}
                            </span>
                            @else
                            <span class="text-xs text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-0.5 text-xs font-medium rounded bg-blue-100 text-blue-800">
                                {{ $book->category }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-sm">
                            <span class="font-medium text-green-600">{{ $book->available_copies }}</span>/<span class="text-gray-600">{{ $book->total_copies }}</span>
                        </td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-0.5 text-xs font-medium rounded
                                @if($book->status === 'available') bg-green-100 text-green-800
                                @elseif($book->status === 'borrowed') bg-orange-100 text-orange-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($book->status) }}
                            </span>
                        </td>
                        <td class="px-3 py-2">
                            <a href="{{ route('librarian.books.edit', $book) }}" class="p-1.5 text-green-600 hover:bg-green-50 rounded-full transition inline-block" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-3 py-4 text-center text-sm text-gray-500">
                            @if(request('search'))
                                No books found matching "{{ request('search') }}".
                            @else
                                No books found. Add books using the "Upload CSV" button.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            @if($books->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $books->firstItem() ?? 0 }}</span> 
                        to <span class="font-medium">{{ $books->lastItem() ?? 0 }}</span> 
                        of <span class="font-medium">{{ $books->total() }}</span> results
                    </div>
                    <div>
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                <div class="text-sm text-gray-700">
                    Total: <span class="font-medium">{{ $books->total() }}</span> books
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Upload CSV Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Upload Books CSV</h3>
            <button onclick="closeUploadModal()" type="button" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form id="uploadForm" action="{{ route('librarian.books.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Error Display -->
            <div id="uploadError" class="hidden mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg relative" role="alert">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span id="uploadErrorText" class="text-sm"></span>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    CSV/Excel File
                </label>
                <input type="file" name="file" id="fileInput" accept=".csv,.txt,.xlsx,.xls" required
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-2 text-xs text-gray-500">Upload your library holdings spreadsheet (.csv, .xlsx, or .xls file). Supports various column name formats.</p>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <h4 class="text-sm font-medium text-blue-800 mb-2">✅ Library Management System Format (Koha, etc.):</h4>
                <ul class="text-xs text-blue-700 list-disc list-inside space-y-1">
                    <li><strong>title, author</strong> → Required fields</li>
                    <li><strong>isbn</strong> → Auto-generated if blank</li>
                    <li><strong>barcode, itemcallnumber</strong> → Added to description</li>
                    <li><strong>publishercode, publicationyear</strong> → Publisher info</li>
                    <li><strong>copies, available</strong> → Number of copies</li>
                    <li><strong>itype, ccode</strong> → Book category/type</li>
                    <li><strong>holding branch</strong> → Branch location</li>
                </ul>
            </div>
            
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                <h4 class="text-sm font-medium text-green-800 mb-2">Alternative/Legacy Column Names Also Accepted:</h4>
                <ul class="text-xs text-green-700 list-disc list-inside space-y-1">
                    <li><strong>Title:</strong> title, book title, booktitle, book_title</li>
                    <li><strong>Author:</strong> author, authors, author/s, writer</li>
                    <li><strong>ISBN:</strong> isbn, isbn number, isbn_number, isbn no, isbn no.</li>
                    <li><strong>Publisher:</strong> publisher, publishercode, publication</li>
                    <li><strong>Year:</strong> year, publicationyear, publication year</li>
                    <li><strong>Copies:</strong> copies, available, vol, volume, qty, quantity</li>
                    <li><strong>Category:</strong> itype, ccode, type, category, classification</li>
                    <li><strong>Tracking:</strong> barcode, callnumber, itemcallnumber, accession no</li>
                </ul>
                <p class="text-xs text-green-700 mt-2"><strong>Note:</strong> Column names are case-insensitive. ISBN auto-generated if missing. All metadata saved to description field.</p>
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeUploadModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300" id="cancelBtn">
                    Cancel
                </button>
                <button type="submit" id="uploadBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
                    <span id="uploadBtnText">Upload</span>
                    <svg id="uploadSpinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    // Show loading state
    const uploadBtn = document.getElementById('uploadBtn');
    const uploadBtnText = document.getElementById('uploadBtnText');
    const uploadSpinner = document.getElementById('uploadSpinner');
    const cancelBtn = document.getElementById('cancelBtn');
    const fileInput = document.getElementById('fileInput');
    const uploadError = document.getElementById('uploadError');
    
    // Hide any previous errors
    uploadError.classList.add('hidden');
    
    // Validate file
    if (!fileInput.files || !fileInput.files[0]) {
        e.preventDefault();
        document.getElementById('uploadErrorText').textContent = 'Please select a CSV file to upload.';
        uploadError.classList.remove('hidden');
        return;
    }
    
    const file = fileInput.files[0];
    const fileName = file.name.toLowerCase();
    
    // Check file extension
    const validExtensions = ['.csv', '.txt', '.xlsx', '.xls'];
    const hasValidExtension = validExtensions.some(ext => fileName.endsWith(ext));
    
    if (!hasValidExtension) {
        e.preventDefault();
        document.getElementById('uploadErrorText').textContent = 'Please upload a CSV or Excel file (.csv, .xlsx, or .xls).';
        uploadError.classList.remove('hidden');
        return;
    }
    
    // Check file size (max 5MB)
    if (file.size > 5 * 1024 * 1024) {
        e.preventDefault();
        document.getElementById('uploadErrorText').textContent = 'File size must be less than 5MB.';
        uploadError.classList.remove('hidden');
        return;
    }
    
    // Show loading state (don't disable fileInput as it prevents form submission)
    uploadBtnText.textContent = 'Uploading...';
    uploadSpinner.classList.remove('hidden');
    uploadBtn.disabled = true;
    cancelBtn.disabled = true;
    uploadBtn.classList.add('opacity-75', 'cursor-not-allowed');
    
    // Allow form to submit naturally
});

// Reset form when modal closes
function closeUploadModal() {
    const modal = document.getElementById('uploadModal');
    const uploadForm = document.getElementById('uploadForm');
    const uploadBtn = document.getElementById('uploadBtn');
    const uploadBtnText = document.getElementById('uploadBtnText');
    const uploadSpinner = document.getElementById('uploadSpinner');
    const cancelBtn = document.getElementById('cancelBtn');
    const fileInput = document.getElementById('fileInput');
    const uploadError = document.getElementById('uploadError');
    
    modal.classList.add('hidden');
    uploadForm.reset();
    uploadBtnText.textContent = 'Upload';
    uploadSpinner.classList.add('hidden');
    uploadBtn.disabled = false;
    cancelBtn.disabled = false;
    uploadBtn.classList.remove('opacity-75', 'cursor-not-allowed');
    uploadError.classList.add('hidden');
}

// Auto-search functionality
const searchInput = document.getElementById('searchInput');
const searchForm = document.getElementById('searchForm');
const searchLoading = document.getElementById('searchLoading');
let searchTimeout;

if (searchInput && searchForm) {
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        
        // Show loading indicator
        if (searchLoading && this.value) {
            searchLoading.classList.remove('hidden');
        }
        
        // Debounce search - submit after 300ms of no typing
        searchTimeout = setTimeout(() => {
            searchForm.submit();
        }, 300);
    });
}

// Clear search function
function clearSearch() {
    searchInput.value = '';
    searchForm.submit();
}

// Checkbox selection
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.book-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = checkbox.checked;
    });
    updateBulkActions();
}

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.book-checkbox:checked');
    const bulkActionsContainer = document.getElementById('bulkActionsContainer');
    const selectedCount = document.getElementById('selectedCount');
    const selectAll = document.getElementById('selectAll');
    
    if (checkboxes.length > 0) {
        bulkActionsContainer.classList.remove('hidden');
        selectedCount.textContent = checkboxes.length;
    } else {
        bulkActionsContainer.classList.add('hidden');
    }
    
    // Update select all checkbox state
    const allCheckboxes = document.querySelectorAll('.book-checkbox');
    selectAll.checked = allCheckboxes.length > 0 && checkboxes.length === allCheckboxes.length;
}

// Bulk delete function
function bulkDelete() {
    const checkboxes = document.querySelectorAll('.book-checkbox:checked');
    
    if (checkboxes.length === 0) {
        alert('Please select at least one book to delete.');
        return;
    }
    
    if (!confirm(`Are you sure you want to delete ${checkboxes.length} selected book(s)? This action cannot be undone.`)) {
        return;
    }
    
    const bookIds = Array.from(checkboxes).map(cb => cb.value);
    
    // Create and submit form
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("librarian.books.bulk-delete") }}';
    
    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);
    
    // Add book IDs
    bookIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'book_ids[]';
        input.value = id;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection
