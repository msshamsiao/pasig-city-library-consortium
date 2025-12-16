@extends('layouts.admin')

@section('title', 'Edit Library')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Edit Library</h1>
            <p class="mt-1 text-sm text-gray-600">Update library branch information</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <form action="{{ route('admin.libraries.update', $library) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-6">
                    <!-- Library Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Library Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $library->name) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Address <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" id="address" rows="3" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror">{{ old('address', $library->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone & Website -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $library->phone) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                                Website
                            </label>
                            <input type="url" name="website" id="website" value="{{ old('website', $library->website) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('website') border-red-500 @enderror"
                                placeholder="https://example.com">
                            @error('website')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Person & Position -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Person <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $library->contact_person) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('contact_person') border-red-500 @enderror">
                            @error('contact_person')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                                Position <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="position" id="position" value="{{ old('position', $library->position) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('position') border-red-500 @enderror"
                                placeholder="e.g. Head Librarian">
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Current Logo -->
                    @if($library->logo)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Current Logo
                        </label>
                        <div class="flex items-center gap-4">
                            <img src="{{ asset($library->logo) }}" alt="{{ $library->name }}" class="h-20 w-20 object-contain rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600">Current library logo</p>
                        </div>
                    </div>
                    @endif

                    <!-- Logo Upload -->
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $library->logo ? 'Update Library Logo' : 'Library Logo' }}
                        </label>
                        <input type="file" name="logo" id="logo" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('logo') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Accepted formats: JPG, PNG, GIF (Max: 2MB). Leave empty to keep current logo.</p>
                        @error('logo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $library->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Active (Library is operational)
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('admin.libraries.index') }}" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Update Library
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
