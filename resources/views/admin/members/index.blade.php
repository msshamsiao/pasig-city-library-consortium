@extends('layouts.admin')

@section('title', 'Members Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Members Management</h2>
            <p class="text-gray-600 mt-1">Manage library members and their accounts</p>
        </div>
        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Member
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Members</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">342</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active Members</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">328</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">New This Month</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">28</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pending Approval</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1">14</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search members by name, email, or member ID..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>All Status</option>
                <option>Active</option>
                <option>Inactive</option>
                <option>Suspended</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>All Types</option>
                <option>Standard</option>
                <option>Premium</option>
                <option>Student</option>
            </select>
        </div>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Join Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                    JD
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Juan Dela Cruz</div>
                                    <div class="text-sm text-gray-500">Standard Member</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">MEM-001</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">juan.dela.cruz@email.com</div>
                            <div class="text-sm text-gray-500">09123456789</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">Jan 15, 2024</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                                <button class="text-green-600 hover:text-green-900">Edit</button>
                                <button class="text-red-600 hover:text-red-900">Suspend</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                    MS
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Maria Santos</div>
                                    <div class="text-sm text-gray-500">Premium Member</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">MEM-002</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">maria.santos@email.com</div>
                            <div class="text-sm text-gray-500">09234567890</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">Feb 20, 2024</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                                <button class="text-green-600 hover:text-green-900">Edit</button>
                                <button class="text-red-600 hover:text-red-900">Suspend</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                    PR
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Pedro Reyes</div>
                                    <div class="text-sm text-gray-500">Student Member</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">MEM-003</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">pedro.reyes@email.com</div>
                            <div class="text-sm text-gray-500">09345678901</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">Mar 10, 2024</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                                <button class="text-green-600 hover:text-green-900">Edit</button>
                                <button class="text-red-600 hover:text-red-900">Suspend</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">342</span> results
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Previous</button>
                <button class="px-3 py-1 bg-blue-600 text-white rounded">1</button>
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">2</button>
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">3</button>
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection