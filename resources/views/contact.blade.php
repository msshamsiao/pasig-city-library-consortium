@extends('layouts.app')

@section('title', 'Contact Us - Pasig City Library Consortium')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Contact Us</h1>
            <p class="text-gray-600">Send an email inquiry to Pasig City Library Consortium</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg flex items-start">
            <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-lg flex items-start">
            <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-lg">
            <p class="font-semibold mb-2">Please fix the following errors:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Contact Form -->
        <div class="bg-white border border-gray-200 rounded-lg p-8">
            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Department Selection -->
                <div>
                    <label for="department" class="block text-lg font-semibold text-gray-900 mb-2">Select Department:</label>
                    <div class="relative">
                        <select 
                            id="department"
                            name="department"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none @error('department') border-red-500 @enderror"
                            required
                        >
                            <option value="MIS" {{ old('department', 'MIS') == 'MIS' ? 'selected' : '' }}>MIS</option>
                            <option value="circulation" {{ old('department') == 'circulation' ? 'selected' : '' }}>Circulation Department</option>
                            <option value="reference" {{ old('department') == 'reference' ? 'selected' : '' }}>Reference Department</option>
                            <option value="technical" {{ old('department') == 'technical' ? 'selected' : '' }}>Technical Services</option>
                            <option value="admin" {{ old('department') == 'admin' ? 'selected' : '' }}>Administration</option>
                            <option value="digital" {{ old('department') == 'digital' ? 'selected' : '' }}>Digital Resources</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Email Form Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-2xl font-bold text-blue-600 mb-6">Email Form</h2>
                    
                    <!-- To Field -->
                    <div class="mb-6">
                        <label for="to" class="block text-base font-semibold text-gray-900 mb-2">To:</label>
                        <input 
                            type="text" 
                            id="to"
                            name="to"
                            value="Pasig City MIS email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            readonly
                        >
                    </div>

                    <!-- Subject Field -->
                    <div class="mb-6">
                        <label for="subject" class="block text-base font-semibold text-gray-900 mb-2">Subject:</label>
                        <input 
                            type="text" 
                            id="subject"
                            name="subject"
                            value="{{ old('subject', 'PLCC') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('subject') border-red-500 @enderror"
                            required
                        >
                    </div>

                    <!-- From Field -->
                    <div class="mb-6">
                        <label for="from" class="block text-base font-semibold text-gray-900 mb-2">From:</label>
                        <input 
                            type="email" 
                            id="from"
                            name="from"
                            value="{{ old('from') }}"
                            placeholder="Your email address"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('from') border-red-500 @enderror"
                            required
                        >
                    </div>

                    <!-- Email Address Field -->
                    <div class="mb-6">
                        <label for="email" class="block text-base font-semibold text-gray-900 mb-2">Email address:</label>
                        <input 
                            type="email" 
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email address"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                            required
                        >
                    </div>

                    <!-- Message Field -->
                    <div class="mb-6">
                        <label for="message" class="block text-base font-semibold text-gray-900 mb-2">Message:</label>
                        <textarea 
                            id="message"
                            name="message"
                            rows="8"
                            placeholder="Type your question or comments here..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none @error('message') border-red-500 @enderror"
                            required
                        >{{ old('message') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-blue-600 text-white py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-2"
                    >
                        <span>Submit</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection