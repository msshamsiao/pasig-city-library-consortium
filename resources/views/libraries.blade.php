@extends('layouts.app')

@section('title', 'Libraries - Pasig City Library Consortium')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Libraries</h1>
            <p class="text-gray-600">Member libraries of the Pasig City Library Consortium</p>
        </div>

        <!-- Library Cards Grid -->
        <div class="space-y-6">
            @forelse($libraries as $library)
            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-blue-600 mb-4">{{ $library->name }}</h2>
                        
                        <div class="space-y-2 text-gray-700">
                            <div class="flex">
                                <span class="font-semibold w-40">Address:</span>
                                <span>{{ $library->address }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold w-40">Phone:</span>
                                <span>{{ $library->phone }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold w-40">Web Link:</span>
                                <a href="http://{{ $library->website }}" class="text-blue-600 hover:underline" target="_blank">{{ $library->website }}</a>
                            </div>
                            <div class="flex">
                                <span class="font-semibold w-40">Contact Person:</span>
                                <span>{{ $library->contact_person }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold w-40">Position:</span>
                                <span>{{ $library->position }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Logo -->
                    <div class="ml-6 flex-shrink-0">
                        <div class="border border-gray-200 rounded-lg p-3 bg-white">
                            @if($library->logo)
                                <img src="{{ asset('storage/' . $library->logo) }}" alt="{{ $library->name }} Logo" class="w-16 h-16 object-contain">
                            @else
                                <img src="{{ asset('images/PCLC_logo.png') }}" alt="PCLC Logo" class="w-16 h-16 object-contain">
                            @endif
                            <p class="text-center text-xs text-gray-500 mt-1">Logo</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
                <p class="text-gray-500">No libraries found.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection