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
            <div class="flex gap-3">
                <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Upload CSV
                </button>
                <a href="{{ route('librarian.members.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Member
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Members Table -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $member)
                    <tr>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No members found. Add members using the "Add Member" or "Upload CSV" button.
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
                <input type="file" name="file" accept=".csv,.xlsx,.xls" required
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
@endsection
