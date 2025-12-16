@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">System Settings</h2>
            <p class="text-gray-600 mt-1">Manage system configuration and preferences</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    <!-- General Settings -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">General Settings</h3>
            <p class="text-sm text-gray-600 mt-1">Configure basic system settings</p>
        </div>

        <div class="p-6">
            <!-- General Settings Form -->
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- System Name -->
                    <div>
                        <label for="system_name" class="block text-sm font-medium text-gray-700 mb-2">System Name</label>
                        <input type="text" id="system_name" name="system_name" value="Pasig City Library Consortium" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- System Email -->
                    <div>
                        <label for="system_email" class="block text-sm font-medium text-gray-700 mb-2">System Email</label>
                        <input type="email" id="system_email" name="system_email" value="admin@pasiglibrary.gov.ph" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" value="+63 2 1234 5678" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" id="address" name="address" value="Pasig City Hall Complex" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Operating Hours -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Operating Hours</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="opening_time" class="block text-xs text-gray-600 mb-1">Opening Time</label>
                            <input type="time" id="opening_time" name="opening_time" value="08:00" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="closing_time" class="block text-xs text-gray-600 mb-1">Closing Time</label>
                            <input type="time" id="closing_time" name="closing_time" value="18:00" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Timezone -->
                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                    <select id="timezone" name="timezone" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Asia/Manila" selected>Asia/Manila (PHT)</option>
                        <option value="Asia/Tokyo">Asia/Tokyo (JST)</option>
                        <option value="Asia/Singapore">Asia/Singapore (SGT)</option>
                    </select>
                </div>

                <!-- Date Format -->
                <div>
                    <label for="date_format" class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                    <select id="date_format" name="date_format" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Y-m-d" selected>YYYY-MM-DD (2025-12-11)</option>
                        <option value="m/d/Y">MM/DD/YYYY (12/11/2025)</option>
                        <option value="d/m/Y">DD/MM/YYYY (11/12/2025)</option>
                        <option value="F j, Y">Month DD, YYYY (December 11, 2025)</option>
                    </select>
                </div>

                <!-- Items Per Page -->
                <div>
                    <label for="items_per_page" class="block text-sm font-medium text-gray-700 mb-2">Items Per Page</label>
                    <select id="items_per_page" name="items_per_page" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="10">10</option>
                        <option value="20" selected>20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Super Admins Management -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Super Administrators</h3>
                <p class="text-sm text-gray-600 mt-1">Manage system administrators</p>
            </div>
            <button onclick="openAddAdminModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Super Admin
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($superAdmins as $admin)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                            {{ $admin->name }}
                            @if($admin->id === auth()->id())
                                <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">You</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $admin->email }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $admin->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center gap-2">
                                <!-- Edit button -->
                                <button onclick="openEditAdminModal({{ $admin->id }}, '{{ $admin->name }}', '{{ $admin->email }}')" 
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-full transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <!-- Delete button -->
                                @if($admin->id !== auth()->id())
                                <form action="{{ route('admin.settings.super-admins.destroy', $admin) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this Super Admin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-full transition" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            No super admins found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Member Librarians Management -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Member Librarian Accounts</h3>
                <p class="text-sm text-gray-600 mt-1">Manage library administrator accounts</p>
            </div>
            <button onclick="openAddLibrarianModal()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Member Librarian
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Library Branch</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($librarians as $librarian)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $librarian->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600">{{ $librarian->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($librarian->library)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $librarian->library->acronym }}
                                    </span>
                                    <span class="text-gray-600 ml-1">- {{ $librarian->library->name }}</span>
                                @else
                                    <span class="text-gray-400">No library assigned</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $librarian->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="openEditLibrarianModal({{ $librarian->id }}, '{{ $librarian->name }}', '{{ $librarian->email }}', {{ $librarian->library_id ?? 'null' }})" 
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                Edit
                            </button>
                            <form action="{{ route('admin.settings.librarians.destroy', $librarian->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this librarian account?')" 
                                        class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            No member librarians found. Click "Add Member Librarian" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Super Admin Modal -->
<div id="addAdminModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Add Super Admin</h3>
            <button onclick="closeAddAdminModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.settings.super-admins.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="add_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" id="add_name" name="name" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="add_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="add_email" name="email" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="add_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="add_password" name="password" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="add_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" id="add_password_confirmation" name="password_confirmation" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="closeAddAdminModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Create Admin
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Super Admin Modal -->
<div id="editAdminModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Edit Super Admin</h3>
            <button onclick="closeEditAdminModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="editAdminForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" id="edit_name" name="name" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="edit_email" name="email" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="edit_password" class="block text-sm font-medium text-gray-700 mb-1">New Password (leave blank to keep current)</label>
                <input type="password" id="edit_password" name="password" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="edit_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" id="edit_password_confirmation" name="password_confirmation" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="closeEditAdminModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Update Admin
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Member Librarian Modal -->
<div id="addLibrarianModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Add Member Librarian</h3>
            <button onclick="closeAddLibrarianModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.settings.librarians.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="add_librarian_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" id="add_librarian_name" name="name" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label for="add_librarian_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="add_librarian_email" name="email" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label for="add_librarian_library" class="block text-sm font-medium text-gray-700 mb-1">Library Branch</label>
                <select id="add_librarian_library" name="library_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">Select a library</option>
                    @foreach($libraries as $library)
                        <option value="{{ $library->id }}">{{ $library->acronym }} - {{ $library->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="add_librarian_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="add_librarian_password" name="password" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label for="add_librarian_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" id="add_librarian_password_confirmation" name="password_confirmation" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="closeAddLibrarianModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Create Librarian
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Member Librarian Modal -->
<div id="editLibrarianModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Edit Member Librarian</h3>
            <button onclick="closeEditLibrarianModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="editLibrarianForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="edit_librarian_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" id="edit_librarian_name" name="name" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label for="edit_librarian_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="edit_librarian_email" name="email" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label for="edit_librarian_library" class="block text-sm font-medium text-gray-700 mb-1">Library Branch</label>
                <select id="edit_librarian_library" name="library_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">Select a library</option>
                    @foreach($libraries as $library)
                        <option value="{{ $library->id }}">{{ $library->acronym }} - {{ $library->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="edit_librarian_password" class="block text-sm font-medium text-gray-700 mb-1">New Password (leave blank to keep current)</label>
                <input type="password" id="edit_librarian_password" name="password" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label for="edit_librarian_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" id="edit_librarian_password_confirmation" name="password_confirmation" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="closeEditLibrarianModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Update Librarian
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddAdminModal() {
    document.getElementById('addAdminModal').classList.remove('hidden');
}

function closeAddAdminModal() {
    document.getElementById('addAdminModal').classList.add('hidden');
}

function openEditAdminModal(id, name, email) {
    document.getElementById('editAdminForm').action = `/admin/settings/super-admins/${id}`;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_password').value = '';
    document.getElementById('edit_password_confirmation').value = '';
    document.getElementById('editAdminModal').classList.remove('hidden');
}

function closeEditAdminModal() {
    document.getElementById('editAdminModal').classList.add('hidden');
}

function openAddLibrarianModal() {
    document.getElementById('addLibrarianModal').classList.remove('hidden');
}

function closeAddLibrarianModal() {
    document.getElementById('addLibrarianModal').classList.add('hidden');
}

function openEditLibrarianModal(id, name, email, libraryId) {
    document.getElementById('editLibrarianForm').action = `/admin/settings/librarians/${id}`;
    document.getElementById('edit_librarian_name').value = name;
    document.getElementById('edit_librarian_email').value = email;
    document.getElementById('edit_librarian_library').value = libraryId || '';
    document.getElementById('edit_librarian_password').value = '';
    document.getElementById('edit_librarian_password_confirmation').value = '';
    document.getElementById('editLibrarianModal').classList.remove('hidden');
}

function closeEditLibrarianModal() {
    document.getElementById('editLibrarianModal').classList.add('hidden');
}

// Close modals when clicking outside
window.onclick = function(event) {
    const addModal = document.getElementById('addAdminModal');
    const editModal = document.getElementById('editAdminModal');
    const addLibrarianModal = document.getElementById('addLibrarianModal');
    const editLibrarianModal = document.getElementById('editLibrarianModal');
    
    if (event.target === addModal) {
        closeAddAdminModal();
    }
    if (event.target === editModal) {
        closeEditAdminModal();
    }
    if (event.target === addLibrarianModal) {
        closeAddLibrarianModal();
    }
    if (event.target === editLibrarianModal) {
        closeEditLibrarianModal();
    }
}
</script>
@endsection
