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
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none"
                            required
                        >
                            <option value="MIS">MIS</option>
                            <option value="circulation">Circulation Department</option>
                            <option value="reference">Reference Department</option>
                            <option value="technical">Technical Services</option>
                            <option value="admin">Administration</option>
                            <option value="digital">Digital Resources</option>
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
                            value="PLCC"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                            placeholder="Your email address"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                            placeholder="Enter your email address"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                            required
                        ></textarea>
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