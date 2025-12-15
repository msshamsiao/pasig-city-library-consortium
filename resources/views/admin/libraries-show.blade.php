@extends('layouts.admin')

@section('title', 'Library Details')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $library->name }}</h1>
                <p class="mt-1 text-sm text-gray-600">Library branch details and information</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.libraries.edit', $library) }}" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Library
                </a>
                <a href="{{ route('admin.libraries.index') }}" 
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information Card -->
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Library Name</label>
                            <p class="text-base text-gray-900">{{ $library->name }}</p>
                        </div>

                        @if($library->acronym)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Acronym</label>
                            <p class="text-base text-gray-900">{{ $library->acronym }}</p>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                            <p class="text-base text-gray-900">{{ $library->address }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                                <p class="text-base text-gray-900">{{ $library->phone }}</p>
                            </div>

                            @if($library->website)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Website</label>
                                <a href="{{ $library->website }}" target="_blank" class="text-base text-blue-600 hover:text-blue-700 underline">
                                    {{ $library->website }}
                                </a>
                            </div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $library->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <span class="w-2 h-2 rounded-full {{ $library->is_active ? 'bg-green-500' : 'bg-red-500' }} mr-2"></span>
                                {{ $library->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Contact Person</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                                <p class="text-base text-gray-900">{{ $library->contact_person }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Position</label>
                                <p class="text-base text-gray-900">{{ $library->position }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Statistics</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Books</p>
                                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($library->holdings()->count()) }}</p>
                                    </div>
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Available</p>
                                        <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($library->holdings()->where('status', 'available')->count()) }}</p>
                                    </div>
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Logo Card -->
                @if($library->logo)
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Library Logo</h3>
                    </div>
                    <div class="p-6 flex justify-center">
                        <img src="{{ asset('storage/' . $library->logo) }}" alt="{{ $library->name }}" class="max-h-48 object-contain rounded-lg">
                    </div>
                </div>
                @endif

                <!-- Metadata Card -->
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Metadata</h3>
                    </div>
                    <div class="p-6 space-y-3 text-sm">
                        <div>
                            <label class="block text-gray-500 mb-1">Created</label>
                            <p class="text-gray-900">{{ $library->created_at->format('M d, Y h:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-500 mb-1">Last Updated</label>
                            <p class="text-gray-900">{{ $library->updated_at->format('M d, Y h:i A') }}</p>
                        </div>

                        @if($library->deleted_at)
                        <div>
                            <label class="block text-gray-500 mb-1">Deleted At</label>
                            <p class="text-red-600">{{ $library->deleted_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Actions</h3>
                    </div>
                    <div class="p-6 space-y-2">
                        <a href="{{ route('admin.libraries.edit', $library) }}" 
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Library
                        </a>

                        @if($library->trashed())
                        <form action="{{ route('admin.libraries.restore', $library) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Restore Library
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.libraries.destroy', $library) }}" method="POST" 
                            onsubmit="return confirm('Are you sure you want to delete this library? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Library
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
