@extends('layouts.librarian')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Members Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage library members and borrowers</p>
            </div>
            <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Upload CSV
            </button>
        </div>

        <!-- Search and Bulk Actions -->
        <div class="mb-6 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
            <!-- Search Form -->
            <form method="GET" action="{{ route('librarian.members.index') }}" class="flex-1 max-w-md">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search by name, email, ID, or phone..." 
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                </div>
            </form>

            <!-- Bulk Actions (shown when items are selected) -->
            <div id="bulkActions" class="hidden">
                <button type="button" onclick="bulkDelete()" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <p class="font-semibold mb-2">Import Errors:</p>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach(session('errors') as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Members Table -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                            <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $member)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <input type="checkbox" name="selected_members[]" value="{{ $member->id }}" 
                                class="member-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                onchange="updateBulkActions()">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-medium text-sm">{{ strtoupper(substr($member->name, 0, 2)) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $member->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $member->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $member->phone ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ Str::limit($member->address ?? 'N/A', 30) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $member->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('librarian.members.edit', $member) }}" class="p-2 text-green-600 hover:bg-green-50 rounded-full transition inline-block" title="Update">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                            @if(request('search'))
                                No members found matching "{{ request('search') }}". 
                                <a href="{{ route('librarian.members.index') }}" class="text-blue-600 hover:text-blue-800">Clear search</a>
                            @else
                                No members found. Add members using the "Upload CSV" button.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            @if($members->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $members->firstItem() ?? 0 }}</span> 
                        to <span class="font-medium">{{ $members->lastItem() ?? 0 }}</span> 
                        of <span class="font-medium">{{ $members->total() }}</span> results
                    </div>
                    <div>
                        {{ $members->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                <div class="text-sm text-gray-700">
                    Total: <span class="font-medium">{{ $members->total() }}</span> members
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
            <h3 class="text-lg font-medium text-gray-900">Upload Members CSV</h3>
            <button onclick="document.getElementById('uploadModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form action="{{ route('librarian.members.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    CSV File
                </label>
                <input type="file" name="file" accept=".csv" required
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-2 text-xs text-gray-500">Upload a CSV file with columns: name, email, password, phone, address</p>
            </div>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <h4 class="text-sm font-medium text-yellow-800 mb-2">CSV Format Requirements:</h4>
                <ul class="text-xs text-yellow-700 list-disc list-inside space-y-1">
                    <li>Headers: name, email, password, phone (optional), address (optional)</li>
                    <li>Each row represents one member</li>
                    <li>Email must be unique</li>
                    <li>Password will be encrypted automatically</li>
                </ul>
                <div class="mt-3 p-3 bg-white rounded border border-yellow-300">
                    <p class="text-xs font-medium text-yellow-800 mb-1">Sample CSV format:</p>
                    <code class="text-xs text-gray-700 block">
                        name,email,password,phone,address<br>
                        John Doe,john@example.com,Pass1234,09123456789,123 Main St<br>
                        Jane Smith,jane@example.com,Pass5678,,456 Oak Ave
                    </code>
                </div>
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle select all checkboxes
    function toggleSelectAll(checkbox) {
        const checkboxes = document.querySelectorAll('.member-checkbox');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
        updateBulkActions();
    }

    // Update bulk actions visibility and count
    function updateBulkActions() {
        const checkboxes = document.querySelectorAll('.member-checkbox:checked');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');
        const selectAll = document.getElementById('selectAll');
        
        selectedCount.textContent = checkboxes.length;
        
        if (checkboxes.length > 0) {
            bulkActions.classList.remove('hidden');
        } else {
            bulkActions.classList.add('hidden');
        }

        // Update select all checkbox state
        const allCheckboxes = document.querySelectorAll('.member-checkbox');
        selectAll.checked = allCheckboxes.length > 0 && checkboxes.length === allCheckboxes.length;
        selectAll.indeterminate = checkboxes.length > 0 && checkboxes.length < allCheckboxes.length;
    }

    // Bulk delete function
    function bulkDelete() {
        const checkboxes = document.querySelectorAll('.member-checkbox:checked');
        const selectedIds = Array.from(checkboxes).map(cb => cb.value);
        
        if (selectedIds.length === 0) {
            alert('Please select at least one member to delete.');
            return;
        }

        if (confirm(`Are you sure you want to delete ${selectedIds.length} member(s)? This action cannot be undone.`)) {
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("librarian.members.bulk-delete") }}';
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            // Add selected IDs
            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'member_ids[]';
                input.value = id;
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Auto-submit search on input
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    }
</script>
@endsection
