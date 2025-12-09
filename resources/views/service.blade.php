@extends('layouts.app')

@section('title', 'Service - Pasig City Library Consortium')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Service</h1>
            <p class="text-gray-600">Book and Resource Request System</p>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-white border border-gray-200 rounded-t-lg" x-data="{ activeTab: 'new' }">
            <div class="grid grid-cols-2">
                <button 
                    @click="activeTab = 'new'"
                    :class="activeTab === 'new' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                    class="py-4 text-lg font-semibold transition"
                >
                    NEW
                </button>
                <button 
                    @click="activeTab = 'list'"
                    :class="activeTab === 'list' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                    class="py-4 text-lg font-semibold transition"
                >
                    LIST
                </button>
            </div>

            <!-- New Request Form -->
            <div x-show="activeTab === 'new'" class="p-8 space-y-6">
                <form action="{{ route('service.store') }}" method="POST">
                    @csrf
                    
                    <!-- Material Type Selection -->
                    <div>
                        <label class="block text-lg font-semibold text-gray-900 mb-3">Material</label>
                        <div class="flex gap-3" x-data="{ material: 'book' }">
                            <button 
                                type="button"
                                @click="material = 'book'"
                                :class="material === 'book' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300'"
                                class="px-6 py-2 rounded-lg font-medium transition hover:shadow-md"
                            >
                                Book
                            </button>
                            <button 
                                type="button"
                                @click="material = 'journal'"
                                :class="material === 'journal' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300'"
                                class="px-6 py-2 rounded-lg font-medium transition hover:shadow-md"
                            >
                                Journal
                            </button>
                            <button 
                                type="button"
                                @click="material = 'cd'"
                                :class="material === 'cd' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300'"
                                class="px-6 py-2 rounded-lg font-medium transition hover:shadow-md"
                            >
                                CD
                            </button>
                            <button 
                                type="button"
                                @click="material = 'ebook'"
                                :class="material === 'ebook' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300'"
                                class="px-6 py-2 rounded-lg font-medium transition hover:shadow-md"
                            >
                                e-book
                            </button>
                            <input type="hidden" name="material_type" x-model="material">
                        </div>
                    </div>

                    <!-- Date Schedule -->
                    <div>
                        <label for="date_schedule" class="block text-lg font-semibold text-gray-900 mb-2">DATE SCHEDULE</label>
                        <input 
                            type="text" 
                            id="date_schedule"
                            name="date_schedule"
                            placeholder="YYYY-MM-DD"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                    </div>

                    <!-- Date Time -->
                    <div>
                        <label for="date_time" class="block text-lg font-semibold text-gray-900 mb-2">DATE TIME</label>
                        <input 
                            type="text" 
                            id="date_time"
                            name="date_time"
                            placeholder="HH:MM AM/PM"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-blue-600 text-white py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transition"
                    >
                        SUBMIT
                    </button>
                </form>
            </div>

            <!-- List View -->
            <div x-show="activeTab === 'list'" class="p-8">
                <div class="text-center text-gray-500 py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-lg">No requests yet</p>
                    <p class="text-sm mt-2">Your submitted requests will appear here</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection