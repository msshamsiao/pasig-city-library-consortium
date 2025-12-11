@extends('layouts.app')

@section('title', 'About Us - Pasig City Library Consortium')

@section('content')
<div class="bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">About Us</h1>
            <p class="text-gray-600">Learn more about the Pasig City Library Consortium</p>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Mission -->
                <div class="bg-white border border-gray-200 rounded-lg p-8">
                    <h2 class="text-3xl font-bold text-blue-600 mb-4">Mission</h2>
                    <p class="text-gray-700 leading-relaxed">
                        The Pasig City Library Consortium is committed to providing equitable access to information, education, and cultural resources for all residents of Pasig City. We strive to foster a love of learning, support academic achievement, and promote intellectual freedom through our collaborative network of libraries. Our mission is to bridge educational gaps, enhance digital literacy, and create inclusive spaces where knowledge thrives and communities grow stronger through shared learning experiences.
                    </p>
                </div>

                <!-- Vision -->
                <div class="bg-white border border-gray-200 rounded-lg p-8">
                    <h2 class="text-3xl font-bold text-blue-600 mb-4">Vision</h2>
                    <p class="text-gray-700 leading-relaxed">
                        To be the premier library consortium in Metro Manila, recognized for excellence in information services, innovative educational programs, and community engagement. We envision a future where every citizen of Pasig City has seamless access to world-class library resources, advanced technology, and lifelong learning opportunities. Through our integrated network, we aim to transform lives, empower minds, and build a knowledge-based society that drives sustainable development and social progress.
                    </p>
                </div>

                <!-- Logo Section -->
                <div class="bg-white border border-gray-200 rounded-lg p-8">
                    <h2 class="text-3xl font-bold text-blue-600 mb-6">Logo</h2>
                    
                    <div class="flex items-start gap-8">
                        <!-- Logo Image -->
                        <div class="flex-shrink-0">
                            <div class="border border-gray-200 rounded-lg p-8 bg-white">
                                <img src="{{ asset('images/PCLC_logo.png') }}" alt="PCLC Official Logo" class="w-48 h-auto">
                                <p class="text-center text-sm text-gray-600 mt-4 font-medium">PCLC Official Logo</p>
                            </div>
                        </div>

                        <!-- Logo Description -->
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Description of Logo</h3>
                            <p class="text-gray-700 leading-relaxed">
                                The Pasig City Library Consortium logo features a stylized library building symbolizing knowledge, learning, and community. The blue color represents trust, wisdom, and stability, reflecting our commitment to reliable information services. The interconnected design elements signify collaboration between our member libraries, while the open book motif emphasizes our dedication to accessible education. The circular arrangement represents unity and the continuous cycle of learning that we foster within our community.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Process/Rules -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-lg p-6 sticky top-4">
                    <h3 class="text-2xl font-bold text-blue-600 text-center mb-6">Process / Rules</h3>
                    
                    <div class="space-y-6">
                        <!-- Library Membership -->
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Library Membership</h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Valid ID required for registration</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Free membership for Pasig City residents</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Annual renewal required</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Guest access available for visitors</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Borrowing Guidelines -->
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Borrowing Guidelines</h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Maximum 5 books per member</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>14-day loan period</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>2 renewal extensions allowed</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Late fees apply after due date</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Digital Resources -->
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Digital Resources</h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>24/7 online access with library card</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Download limits per month</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Device compatibility requirements</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Technical support available</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Facility Usage -->
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Facility Usage</h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Quiet zones enforced</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Food and drinks restricted</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Computer use by reservation</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Study rooms available for booking</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Code of Conduct -->
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Code of Conduct</h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Respectful behavior required</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>No disruptive activities</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Proper care of materials</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Compliance with staff instructions</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection