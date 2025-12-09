@extends('layouts.admin')

@section('title', 'Import Books')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.books.index') }}" class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Import Books</h2>
            <p class="text-gray-600 mt-1">Upload a spreadsheet file to import multiple books</p>
        </div>
    </div>

    <!-- Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Import Instructions</h3>
                <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                    <li>Upload an Excel (.xlsx, .xls) or CSV (.csv) file</li>
                    <li>File must contain columns: Title, Author, ISBN, Publisher, Publication Year, Category, Language, Total Copies, Available Copies</li>
                    <li>Optional columns: Shelf Location, Call Number, Condition, Subject</li>
                    <li>First row should be the header row</li>
                    <li>Maximum file size: 5MB</li>
                </ul>
                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium mt-3 inline-block">
                    Download Sample Template →
                </a>
            </div>
        </div>
    </div>

    <!-- Upload Form -->
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- File Upload Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Upload Spreadsheet File
            </h3>

            <div class="space-y-4">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center hover:border-blue-400 transition">
                    <input type="file" name="book_file" accept=".xlsx,.xls,.csv" id="book_file" required class="hidden" onchange="displayFileName(event)">
                    <label for="book_file" class="cursor-pointer">
                        <div class="mb-4">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-lg text-gray-700 font-medium mb-2">Click to upload spreadsheet file</p>
                        <p class="text-sm text-gray-500 mb-2">or drag and drop</p>
                        <p class="text-xs text-gray-500">Excel (.xlsx, .xls) or CSV (.csv) up to 5MB</p>
                        <div id="file-name" class="mt-4 text-sm font-medium text-blue-600"></div>
                    </label>
                </div>

                <!-- File Details Preview -->
                <div id="file-details" class="hidden bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900" id="selected-file-name"></p>
                                <p class="text-xs text-gray-500" id="selected-file-size"></p>
                            </div>
                        </div>
                        <button type="button" onclick="clearFile()" class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Import Options -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Import Options
            </h3>

            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="skip_duplicates" id="skip_duplicates" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="skip_duplicates" class="text-sm font-medium text-gray-700">Skip duplicate ISBN entries</label>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="update_existing" id="update_existing" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="update_existing" class="text-sm font-medium text-gray-700">Update existing books with matching ISBN</label>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="validate_data" id="validate_data" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="validate_data" class="text-sm font-medium text-gray-700">Validate data before import (recommended)</label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.books.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Import Books
            </button>
        </div>
    </form>
</div>

<script>
function displayFileName(event) {
    const file = event.target.files[0];
    const fileDetails = document.getElementById('file-details');
    const fileName = document.getElementById('selected-file-name');
    const fileSize = document.getElementById('selected-file-size');
    
    if (file) {
        fileName.textContent = file.name;
        fileSize.textContent = `${(file.size / 1024 / 1024).toFixed(2)} MB`;
        fileDetails.classList.remove('hidden');
        document.getElementById('file-name').textContent = `Selected: ${file.name}`;
    }
}

function clearFile() {
    document.getElementById('book_file').value = '';
    document.getElementById('file-details').classList.add('hidden');
    document.getElementById('file-name').textContent = '';
}
</script>
@endsection