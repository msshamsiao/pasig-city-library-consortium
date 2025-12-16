@extends('layouts.admin')

@section('title', 'Audit Trail')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Audit Trail</h1>
            <p class="mt-1 text-sm text-gray-600">View all system activities and user actions</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                    <select name="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 min-w-[120px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Action</label>
                    <select name="action" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 min-w-[120px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="model" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Types</option>
                        @foreach($models as $model)
                            <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>{{ $model }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Library</label>
                    <select name="library_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Libraries</option>
                        @foreach($libraries as $library)
                            <option value="{{ $library->id }}" {{ request('library_id') == $library->id ? 'selected' : '' }}>{{ $library->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 min-w-[140px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex-1 min-w-[140px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Apply Filters</button>
                    <a href="{{ route('admin.audit-logs.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">Clear</a>
                </div>
            </form>
        </div>

        <!-- Audit Logs Table -->
        <div class="bg-white rounded-lg shadow-sm">
                <table class="w-full table-fixed divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="w-[12%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date/Time</th>
                            <th class="w-[15%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="w-[10%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                            <th class="w-[10%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="w-[30%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                            <th class="w-[10%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Library</th>
                            <th class="w-[8%] px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-2 py-3 text-xs text-gray-900">
                                    {{ $log->created_at->format('M d, Y') }}<br>
                                    <span class="text-gray-500">{{ $log->created_at->format('h:i A') }}</span>
                                </td>
                                <td class="px-2 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                        @if($log->user_role === 'super_admin') bg-purple-100 text-purple-800
                                        @elseif($log->user_role === 'member_librarian') bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800
                                        @endif">
                                        {{ $log->user_name ?? 'System' }}
                                    </span>
                                </td>
                                <td class="px-2 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($log->action === 'create') bg-green-100 text-green-800
                                        @elseif($log->action === 'update') bg-blue-100 text-blue-800
                                        @elseif($log->action === 'delete') bg-red-100 text-red-800
                                        @elseif(in_array($log->action, ['approve', 'borrow'])) bg-green-100 text-green-800
                                        @elseif(in_array($log->action, ['reject', 'cancel'])) bg-red-100 text-red-800
                                        @elseif($log->action === 'return') bg-indigo-100 text-indigo-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td class="px-2 py-3 text-xs text-gray-900 truncate">
                                    {{ $log->model }}
                                </td>
                                <td class="px-2 py-3 text-xs text-gray-900 truncate" title="{{ $log->description }}">
                                    {{ Str::limit($log->description, 60) }}
                                </td>
                                <td class="px-2 py-3 text-xs font-semibold text-gray-900">
                                    {{ $log->library?->acronym ?? 'N/A' }}
                                </td>
                                <td class="px-2 py-3 text-xs font-medium">
                                    <a href="{{ route('admin.audit-logs.show', $log) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="mt-2">No audit logs found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            <!-- Pagination -->
            <x-pagination :items="$logs" />
        </div>
    </div>
</div>
@endsection
