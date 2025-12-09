@extends('layouts.app')

@section('title', 'Home - Pasig City Library Consortium')

@section('content')
<div class="bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Search By:</h2>
            
            <div class="flex gap-4 items-end" x-data="{ category: 'all', library: 'all', search: '' }">
                <!-- Category Dropdown -->
                <div class="flex-1">
                    <select x-model="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Categories</option>
                        <option value="fiction">Fiction</option>
                        <option value="non-fiction">Non-Fiction</option>
                        <option value="reference">Reference</option>
                        <option value="academic">Academic</option>
                    </select>
                </div>

                <!-- Library Dropdown -->
                <div class="flex-1">
                    <select x-model="library" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Libraries</option>
                        <option value="pasig-city">Pasig City Library</option>
                        <option value="plp">PLP Library</option>
                        <option value="pcist">PCIST Library</option>
                        <option value="pshs">PSHS Library</option>
                        <option value="rhs">RHS Library</option>
                        <option value="city-hall">City Hall Library</option>
                    </select>
                </div>

                <!-- Search Input -->
                <div class="flex-1">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input 
                            x-model="search"
                            type="text" 
                            placeholder="Search books, authors, or titles..." 
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                </div>

                <!-- Search Button -->
                <button 
                    @click="console.log('Search:', { category, library, search })"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition flex items-center justify-center"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Sidebar - Libraries List -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-center mb-6">Libraries</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900">Pasig City Library</h4>
                            <p class="text-sm text-gray-500">Public</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">PLP Library</h4>
                            <p class="text-sm text-gray-500">University</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">PCIST Library</h4>
                            <p class="text-sm text-gray-500">Technical</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">PSHS Library</h4>
                            <p class="text-sm text-gray-500">High School</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">RHS Library</h4>
                            <p class="text-sm text-gray-500">High School</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">City Hall Library</h4>
                            <p class="text-sm text-gray-500">Government</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Process/Routes Info -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">Process / Routes</h3>
                    <p class="text-gray-700">
                        Welcome to the Pasig City Library Consortium portal. Use the search functionality above to find books, authors, subjects, or ISBN numbers across all participating libraries in our network.
                    </p>
                </div>

                <!-- Statistics Cards -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-2xl font-bold text-blue-600 text-center mb-6">HOME (Demographics + Statistics)</h3>
                    
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Total Libraries -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                            <div class="text-4xl font-bold text-blue-600 mb-2">6</div>
                            <div class="text-sm text-gray-600">Total Libraries</div>
                        </div>

                        <!-- Total Books -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                            <div class="text-4xl font-bold text-blue-600 mb-2">15,243</div>
                            <div class="text-sm text-gray-600">Total Books</div>
                        </div>

                        <!-- Available Books -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                            <div class="text-4xl font-bold text-blue-600 mb-2">12,890</div>
                            <div class="text-sm text-gray-600">Available Books</div>
                        </div>

                        <!-- On Loan -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                            <div class="text-4xl font-bold text-blue-600 mb-2">2,353</div>
                            <div class="text-sm text-gray-600">On Loan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection