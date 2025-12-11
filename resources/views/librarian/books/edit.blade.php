@extends('layouts.librarian')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Edit Book</h1>
            <p class="mt-1 text-sm text-gray-600">Update book information</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <form action="{{ route('librarian.books.update', $book) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                        Book Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Author -->
                <div class="mb-4">
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-1">
                        Author <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('author') border-red-500 @enderror">
                    @error('author')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ISBN -->
                <div class="mb-4">
                    <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">
                        ISBN <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('isbn') border-red-500 @enderror">
                    @error('isbn')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">International Standard Book Number (must be unique)</p>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category" id="category" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category') border-red-500 @enderror">
                        <option value="">Select a category</option>
                        <option value="Fiction" {{ old('category', $book->category) == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                        <option value="Romance" {{ old('category', $book->category) == 'Romance' ? 'selected' : '' }}>Romance</option>
                        <option value="Dystopian" {{ old('category', $book->category) == 'Dystopian' ? 'selected' : '' }}>Dystopian</option>
                        <option value="Science" {{ old('category', $book->category) == 'Science' ? 'selected' : '' }}>Science</option>
                        <option value="History" {{ old('category', $book->category) == 'History' ? 'selected' : '' }}>History</option>
                        <option value="Biography" {{ old('category', $book->category) == 'Biography' ? 'selected' : '' }}>Biography</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total Copies -->
                <div class="mb-4">
                    <label for="total_copies" class="block text-sm font-medium text-gray-700 mb-1">
                        Total Copies <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="total_copies" id="total_copies" value="{{ old('total_copies', $book->total_copies) }}" min="1" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('total_copies') border-red-500 @enderror">
                    @error('total_copies')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        Current: {{ $book->total_copies }} total, {{ $book->available_copies }} available
                    </p>
                </div>

                <!-- Cover Image URL -->
                <div class="mb-4">
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">
                        Cover Image URL
                    </label>
                    <input type="text" name="cover_image" id="cover_image" value="{{ old('cover_image', $book->cover_image) }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('cover_image') border-red-500 @enderror"
                        placeholder="https://example.com/book-cover.jpg">
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Optional: URL to the book cover image</p>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                        placeholder="Brief description of the book...">{{ old('description', $book->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('librarian.books.index') }}" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
