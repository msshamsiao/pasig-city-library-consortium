@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Notification System Test</h1>
        
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
        @endif

        @auth
        <div class="space-y-6">
            <div class="border-b pb-4">
                <h2 class="text-xl font-semibold mb-2">Your Account</h2>
                <p class="text-gray-600">Name: <strong>{{ auth()->user()->name }}</strong></p>
                <p class="text-gray-600">Email: <strong>{{ auth()->user()->email }}</strong></p>
                <p class="text-gray-600">Role: <strong class="capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</strong></p>
                <p class="text-gray-600">Unread Notifications: <strong>{{ auth()->user()->unreadNotificationsCount() }}</strong></p>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-4">Test Actions</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Create Test Notification -->
                    <form action="{{ route('test.notification') }}" method="GET" class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h3 class="font-semibold text-blue-900 mb-2">Create Test Notification</h3>
                        <p class="text-sm text-blue-700 mb-3">Creates a test notification for your account</p>
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            Create Notification
                        </button>
                    </form>

                    <!-- View Dashboard -->
                    <a href="{{ route('dashboard') }}" class="bg-green-50 p-4 rounded-lg border border-green-200 block">
                        <h3 class="font-semibold text-green-900 mb-2">Go to Dashboard</h3>
                        <p class="text-sm text-green-700 mb-3">View the notification bell in your dashboard</p>
                        <button class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                            Open Dashboard
                        </button>
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="font-semibold text-gray-900 mb-2">How to Test:</h3>
                <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                    <li>Click "Create Notification" button above to create a test notification</li>
                    <li>Go to your dashboard and look for the bell icon in the top right</li>
                    <li>You should see a red dot indicator on the bell icon</li>
                    <li>Click the bell icon to see your notifications</li>
                    <li>Click on a notification to mark it as read</li>
                    <li>Use "Mark all read" to mark all notifications as read</li>
                </ol>
            </div>

            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                <h3 class="font-semibold text-yellow-900 mb-2">📋 API Endpoints:</h3>
                <div class="space-y-1 text-sm text-yellow-800 font-mono">
                    @if(auth()->user()->isSuperAdmin())
                    <p>GET /admin/notifications - List notifications</p>
                    <p>GET /admin/notifications/unread-count - Get unread count</p>
                    <p>POST /admin/notifications/{id}/read - Mark as read</p>
                    <p>POST /admin/notifications/read-all - Mark all as read</p>
                    @elseif(auth()->user()->isMemberLibrarian())
                    <p>GET /librarian/notifications - List notifications</p>
                    <p>GET /librarian/notifications/unread-count - Get unread count</p>
                    <p>POST /librarian/notifications/{id}/read - Mark as read</p>
                    <p>POST /librarian/notifications/read-all - Mark all as read</p>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-8">
            <p class="text-gray-600 mb-4">Please login to test notifications</p>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition inline-block">
                Login
            </a>
        </div>
        @endauth
    </div>
</div>
@endsection
