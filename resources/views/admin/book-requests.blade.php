@extends('layouts.admin')

@section('title', 'Book Requests')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Book Requests</h2>
            <p class="text-gray-600 mt-1">Manage borrowing and return requests</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pending Requests</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1">23</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Approved</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">89</p>
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
                    <p class="text-sm text-gray-600">Due Today</p>
                    <p class="text-3xl font-bold text-red-600 mt-1">7</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Overdue</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">12</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search by member name or book title..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>All Status</option>
                <option>Pending</option>
                <option>Approved</option>
                <option>Rejected</option>
                <option>Returned</option>
                <option>Overdue</option>
            </select>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">REQ-001</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">Juan Dela Cruz</div>
                            <div class="text-sm text-gray-500">MEM-001</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">The Great Gatsby</div>
                            <div class="text-sm text-gray-500">F. Scott Fitzgerald</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">Dec 1, 2025</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Dec 15, 2025</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-orange-800 bg-orange-100 rounded-full">Pending</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <button class="text-green-600 hover:text-green-900">Approve</button>
                                <button class="text-red-600 hover:text-red-900">Reject</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">REQ-002</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">Maria Santos</div>
                            <div class="text-sm text-gray-500">MEM-002</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">To Kill a Mockingbird</div>
                            <div class="text-sm text-gray-500">Harper Lee</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">Nov 28, 2025</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Dec 12, 2025</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Approved</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <button class="text-blue-600 hover:text-blue-900">Mark Returned</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 bg-red-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">REQ-003</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">Pedro Reyes</div>
                            <div class="text-sm text-gray-500">MEM-003</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">1984</div>
                            <div class="text-sm text-gray-500">George Orwell</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">Nov 20, 2025</td>
                        <td class="px-6 py-4 text-sm font-bold text-red-600">Dec 4, 2025</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Overdue</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <button class="text-blue-600 hover:text-blue-900">Send Reminder</button>
                                <button class="text-green-600 hover:text-green-900">Mark Returned</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">131</span> results
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Previous</button>
                <button class="px-3 py-1 bg-blue-600 text-white rounded">1</button>
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">2</button>
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection