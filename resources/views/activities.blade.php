@extends('layouts.app')

@section('title', 'Activities - Pasig City Library Consortium')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Activities</h1>
            <p class="text-gray-600">Library events, programs, and announcements</p>
        </div>

        <!-- Activities Timeline -->
        <div class="space-y-6">
            @forelse($activities as $activity)
            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                <div class="text-sm text-blue-600 font-semibold mb-2">{{ $activity['date'] }}</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $activity['title'] }}</h2>
                <p class="text-gray-700 mb-4">{{ $activity['description'] }}</p>
                
                @if($activity['has_image'])
                <!-- Image Placeholder -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 bg-gray-50">
                    @if($activity['image'])
                        <img src="{{ asset('storage/' . $activity['image']) }}" alt="{{ $activity['title'] }}" class="w-full h-auto rounded">
                    @else
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">News Article with Pictures</span>
                        </div>
                    @endif
                </div>
                @endif
            </div>
            @empty
            <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
                <p class="text-gray-500">No activities found.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection