@extends('layouts.admin')

@section('title', 'Audit Log Details')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Audit Log Details</h1>
                <p class="mt-1 text-sm text-gray-600">Detailed information about this action</p>
            </div>
            <a href="{{ route('admin.audit-logs.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                Back to List
            </a>
        </div>

        <!-- Log Details Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-medium text-gray-900">Action Information</h2>
            </div>
            
            <div class="px-6 py-4 space-y-4">
                <!-- Date & Time -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Date & Time:</div>
                    <div class="col-span-2 text-sm text-gray-900">
                        {{ $auditLog->created_at->format('F d, Y h:i:s A') }}
                        <span class="text-gray-500">({{ $auditLog->created_at->diffForHumans() }})</span>
                    </div>
                </div>

                <!-- User -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">User:</div>
                    <div class="col-span-2">
                        <div class="text-sm text-gray-900">{{ $auditLog->user_name ?? 'System' }}</div>
                        @if($auditLog->user_role)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mt-1
                                @if($auditLog->user_role === 'super_admin') bg-purple-100 text-purple-800
                                @elseif($auditLog->user_role === 'member_librarian') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ str_replace('_', ' ', ucfirst($auditLog->user_role)) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Library -->
                @if($auditLog->library)
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-sm font-medium text-gray-500">Library:</div>
                        <div class="col-span-2 text-sm text-gray-900">{{ $auditLog->library->name }}</div>
                    </div>
                @endif

                <!-- Action -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Action:</div>
                    <div class="col-span-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($auditLog->action === 'create') bg-green-100 text-green-800
                            @elseif($auditLog->action === 'update') bg-blue-100 text-blue-800
                            @elseif($auditLog->action === 'delete') bg-red-100 text-red-800
                            @elseif(in_array($auditLog->action, ['approve', 'borrow'])) bg-green-100 text-green-800
                            @elseif(in_array($auditLog->action, ['reject', 'cancel'])) bg-red-100 text-red-800
                            @elseif($auditLog->action === 'return') bg-indigo-100 text-indigo-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($auditLog->action) }}
                        </span>
                    </div>
                </div>

                <!-- Model Type -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Type:</div>
                    <div class="col-span-2 text-sm text-gray-900">{{ $auditLog->model }}</div>
                </div>

                <!-- Model ID -->
                @if($auditLog->model_id)
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-sm font-medium text-gray-500">Record ID:</div>
                        <div class="col-span-2 text-sm text-gray-900">#{{ $auditLog->model_id }}</div>
                    </div>
                @endif

                <!-- Description -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Description:</div>
                    <div class="col-span-2 text-sm text-gray-900">{{ $auditLog->description }}</div>
                </div>

                <!-- IP Address -->
                @if($auditLog->ip_address)
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-sm font-medium text-gray-500">IP Address:</div>
                        <div class="col-span-2 text-sm text-gray-900 font-mono">{{ $auditLog->ip_address }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Old Values Card -->
        @if($auditLog->old_values && count($auditLog->old_values) > 0)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mt-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-red-50">
                    <h2 class="text-lg font-medium text-red-900">Previous Values</h2>
                </div>
                
                <div class="px-6 py-4">
                    <div class="bg-red-50 rounded-md p-4">
                        <pre class="text-sm text-gray-900 overflow-x-auto">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            </div>
        @endif

        <!-- New Values Card -->
        @if($auditLog->new_values && count($auditLog->new_values) > 0)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mt-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
                    <h2 class="text-lg font-medium text-green-900">New Values</h2>
                </div>
                
                <div class="px-6 py-4">
                    <div class="bg-green-50 rounded-md p-4">
                        <pre class="text-sm text-gray-900 overflow-x-auto">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            </div>
        @endif

        <!-- User Agent Card -->
        @if($auditLog->user_agent)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mt-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-900">Browser Information</h2>
                </div>
                
                <div class="px-6 py-4">
                    <p class="text-sm text-gray-600 break-words">{{ $auditLog->user_agent }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
