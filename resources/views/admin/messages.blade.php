@extends('layouts.admin')

@section('title', 'Messages Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Messages Management</h2>
            <p class="text-gray-600 mt-1">View and respond to contact messages</p>
        </div>
        <div class="flex gap-2">
            <button class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
                </svg>
                Mark All as Read
            </button>
            <button class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete Selected
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Messages</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">156</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Unread</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1">23</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Replied</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">98</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">This Month</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">35</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search messages by name, email, or subject..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>All Status</option>
                <option>Unread</option>
                <option>Read</option>
                <option>Replied</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>All Time</option>
                <option>Today</option>
                <option>This Week</option>
                <option>This Month</option>
            </select>
        </div>
    </div>

    <!-- Messages List -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="divide-y divide-gray-200">
            <!-- Message Item 1 - Unread -->
            <div class="p-6 hover:bg-gray-50 cursor-pointer transition">
                <div class="flex items-start gap-4">
                    <input type="checkbox" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                        JD
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-bold text-gray-900">Juan Dela Cruz</h3>
                                <span class="px-3 py-1 text-xs font-semibold text-orange-800 bg-orange-100 rounded-full">Unread</span>
                            </div>
                            <span class="text-sm text-gray-500">2 hours ago</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-1">juan.delacruz@email.com</p>
                        <p class="font-semibold text-gray-900 mb-2">Book Reservation Inquiry</p>
                        <p class="text-gray-700 line-clamp-2">Hello, I would like to inquire about reserving "The Great Gatsby" for next week. Is it possible to reserve books in advance? Looking forward to your response...</p>
                        <div class="flex gap-3 mt-4">
                            <button class="text-blue-600 hover:text-blue-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                Reply
                            </button>
                            <button class="text-green-600 hover:text-green-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Mark as Read
                            </button>
                            <button class="text-red-600 hover:text-red-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Item 2 - Read -->
            <div class="p-6 hover:bg-gray-50 cursor-pointer transition bg-gray-50">
                <div class="flex items-start gap-4">
                    <input type="checkbox" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                        MS
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-semibold text-gray-700">Maria Santos</h3>
                                <span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded-full">Read</span>
                            </div>
                            <span class="text-sm text-gray-500">5 hours ago</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-1">maria.santos@email.com</p>
                        <p class="font-medium text-gray-700 mb-2">Library Hours Question</p>
                        <p class="text-gray-600 line-clamp-2">Good day! I would like to know if the library is open on Sundays and what are the operating hours? Thank you!</p>
                        <div class="flex gap-3 mt-4">
                            <button class="text-blue-600 hover:text-blue-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                Reply
                            </button>
                            <button class="text-red-600 hover:text-red-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Item 3 - Replied -->
            <div class="p-6 hover:bg-gray-50 cursor-pointer transition">
                <div class="flex items-start gap-4">
                    <input type="checkbox" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                        PR
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-semibold text-gray-700">Pedro Reyes</h3>
                                <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Replied</span>
                            </div>
                            <span class="text-sm text-gray-500">1 day ago</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-1">pedro.reyes@email.com</p>
                        <p class="font-medium text-gray-700 mb-2">Membership Application</p>
                        <p class="text-gray-600 line-clamp-2">Hi, I'm interested in applying for library membership. What are the requirements and fees? Can I apply online?</p>
                        <div class="flex gap-3 mt-4">
                            <button class="text-blue-600 hover:text-blue-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Reply
                            </button>
                            <button class="text-red-600 hover:text-red-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Item 4 - Unread -->
            <div class="p-6 hover:bg-gray-50 cursor-pointer transition">
                <div class="flex items-start gap-4">
                    <input type="checkbox" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                        AG
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-bold text-gray-900">Ana Garcia</h3>
                                <span class="px-3 py-1 text-xs font-semibold text-orange-800 bg-orange-100 rounded-full">Unread</span>
                            </div>
                            <span class="text-sm text-gray-500">3 hours ago</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-1">ana.garcia@email.com</p>
                        <p class="font-semibold text-gray-900 mb-2">Event Registration</p>
                        <p class="text-gray-700 line-clamp-2">I would like to register for the upcoming Digital Literacy Workshop on December 15. How can I sign up? Is there a registration fee?</p>
                        <div class="flex gap-3 mt-4">
                            <button class="text-blue-600 hover:text-blue-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                Reply
                            </button>
                            <button class="text-green-600 hover:text-green-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Mark as Read
                            </button>
                            <button class="text-red-600 hover:text-red-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Item 5 - Read -->
            <div class="p-6 hover:bg-gray-50 cursor-pointer transition bg-gray-50">
                <div class="flex items-start gap-4">
                    <input type="checkbox" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                        LT
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-semibold text-gray-700">Luis Torres</h3>
                                <span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded-full">Read</span>
                            </div>
                            <span class="text-sm text-gray-500">2 days ago</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-1">luis.torres@email.com</p>
                        <p class="font-medium text-gray-700 mb-2">Overdue Book Notice</p>
                        <p class="text-gray-600 line-clamp-2">I received a notice about an overdue book. I believe I already returned it last week. Can you please check your records?</p>
                        <div class="flex gap-3 mt-4">
                            <button class="text-blue-600 hover:text-blue-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                Reply
                            </button>
                            <button class="text-red-600 hover:text-red-900 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">156</span> messages
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