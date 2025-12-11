@extends('layouts.librarian')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Create New Activity</h1>
            <p class="mt-1 text-sm text-gray-600">Add a new library activity or event (requires super admin approval)</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <form action="{{ route('librarian.activities.store') }}" method="POST">
                @csrf

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                        Activity Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="4" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                        placeholder="Describe the activity...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                        Category
                    </label>
                    <select name="category" id="category"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category') border-red-500 @enderror">
                        <option value="">Select a category</option>
                        <option value="Workshop" {{ old('category') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                        <option value="Seminar" {{ old('category') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                        <option value="Reading Program" {{ old('category') == 'Reading Program' ? 'selected' : '' }}>Reading Program</option>
                        <option value="Book Club" {{ old('category') == 'Book Club' ? 'selected' : '' }}>Book Club</option>
                        <option value="Training" {{ old('category') == 'Training' ? 'selected' : '' }}>Training</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Activity Date -->
                <div class="mb-4">
                    <label for="activity_date" class="block text-sm font-medium text-gray-700 mb-1">
                        Activity Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="activity_date" id="activity_date" value="{{ old('activity_date') }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('activity_date') border-red-500 @enderror">
                    @error('activity_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Start and End -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="time_start" class="block text-sm font-medium text-gray-700 mb-1">
                            Start Time
                        </label>
                        <input type="time" name="time_start" id="time_start" value="{{ old('time_start') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('time_start') border-red-500 @enderror">
                        @error('time_start')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="time_end" class="block text-sm font-medium text-gray-700 mb-1">
                            End Time
                        </label>
                        <input type="time" name="time_end" id="time_end" value="{{ old('time_end') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('time_end') border-red-500 @enderror">
                        @error('time_end')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location -->
                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                        Location
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('location') border-red-500 @enderror"
                        placeholder="e.g., Library Main Hall, Room 201">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Max Participants -->
                <div class="mb-6">
                    <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-1">
                        Maximum Participants
                    </label>
                    <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants') }}" min="1"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('max_participants') border-red-500 @enderror"
                        placeholder="Leave empty for unlimited">
                    @error('max_participants')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Optional: Set a limit for the number of participants</p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('librarian.activities.index') }}" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Submit for Approval
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
