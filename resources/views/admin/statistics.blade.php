@extends('layouts.admin')

@section('title', 'Statistics & Analytics')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Statistics & Analytics</h2>
            <p class="text-gray-600 mt-1">Library performance metrics and insights</p>
        </div>
        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export Report
        </button>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" value="2025-01-01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date" value="2025-12-08" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Apply Filter
            </button>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold bg-white bg-opacity-30 px-3 py-1 rounded-full">+12%</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Books</p>
            <p class="text-3xl font-bold">1,247</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold bg-white bg-opacity-30 px-3 py-1 rounded-full">+8%</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Active Members</p>
            <p class="text-3xl font-bold">342</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold bg-white bg-opacity-30 px-3 py-1 rounded-full">+15%</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Books Borrowed</p>
            <p class="text-3xl font-bold">89</p>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-700 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold bg-white bg-opacity-30 px-3 py-1 rounded-full">+22%</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Events Held</p>
            <p class="text-3xl font-bold">48</p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Borrowing Trends -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Borrowing Trends</h3>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="text-sm">Line Chart: Monthly borrowing statistics</p>
                </div>
            </div>
        </div>

        <!-- Category Distribution -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Book Category Distribution</h3>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                    <p class="text-sm">Pie Chart: Books by category</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Most Borrowed Books -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Most Borrowed Books</h3>
            </div>
            <div class="divide-y divide-gray-200">
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">1</div>
                        <div>
                            <p class="font-medium text-gray-900">The Great Gatsby</p>
                            <p class="text-sm text-gray-500">F. Scott Fitzgerald</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-blue-600">45 borrows</span>
                </div>
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">2</div>
                        <div>
                            <p class="font-medium text-gray-900">To Kill a Mockingbird</p>
                            <p class="text-sm text-gray-500">Harper Lee</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-purple-600">38 borrows</span>
                </div>
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-sm">3</div>
                        <div>
                            <p class="font-medium text-gray-900">1984</p>
                            <p class="text-sm text-gray-500">George Orwell</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-green-600">35 borrows</span>
                </div>
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold text-sm">4</div>
                        <div>
                            <p class="font-medium text-gray-900">Pride and Prejudice</p>
                            <p class="text-sm text-gray-500">Jane Austen</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-orange-600">32 borrows</span>
                </div>
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center font-bold text-sm">5</div>
                        <div>
                            <p class="font-medium text-gray-900">The Catcher in the Rye</p>
                            <p class="text-sm text-gray-500">J.D. Salinger</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-red-600">28 borrows</span>
                </div>
            </div>
        </div>

        <!-- Most Active Members -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Most Active Members</h3>
            </div>
            <div class="divide-y divide-gray-200">
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">JD</div>
                        <div>
                            <p class="font-medium text-gray-900">Juan Dela Cruz</p>
                            <p class="text-sm text-gray-500">MEM-001</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-blue-600">23 books</span>
                </div>
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">MS</div>
                        <div>
                            <p class="font-medium text-gray-900">Maria Santos</p>
                            <p class="text-sm text-gray-500">MEM-002</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-purple-600">19 books</span>
                </div>
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-sm">PR</div>
                        <div>
                            <p class="font-medium text-gray-900">Pedro Reyes</p>
                            <p class="text-sm text-gray-500">MEM-003</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-green-600">17 books</span>
                </div>
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold text-sm">AG</div>
                        <div>
                            <p class="font-medium text-gray-900">Ana Garcia</p>
                            <p class="text-sm text-gray-500">MEM-004</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-orange-600">15 books</span>
                </div>
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center font-bold text-sm">LT</div>
                        <div>
                            <p class="font-medium text-gray-900">Luis Torres</p>
                            <p class="text-sm text-gray-500">MEM-005</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-red-600">14 books</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Library Usage Statistics -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Library Usage by Day</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Monday</span>
                    <span class="text-sm font-semibold text-blue-600">245 visits</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Tuesday</span>
                    <span class="text-sm font-semibold text-purple-600">210 visits</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-purple-600 h-2 rounded-full" style="width: 72%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Wednesday</span>
                    <span class="text-sm font-semibold text-green-600">268 visits</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 92%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Thursday</span>
                    <span class="text-sm font-semibold text-orange-600">232 visits</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-orange-600 h-2 rounded-full" style="width: 80%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Friday</span>
                    <span class="text-sm font-semibold text-red-600">290 visits</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-600 h-2 rounded-full" style="width: 100%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Saturday</span>
                    <span class="text-sm font-semibold text-indigo-600">198 visits</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: 68%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Sunday</span>
                    <span class="text-sm font-semibold text-pink-600">156 visits</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-pink-600 h-2 rounded-full" style="width: 54%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection