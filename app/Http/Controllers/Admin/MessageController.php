<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('from_email', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }
        
        $perPage = $request->input('perPage', 10);
        $messages = $query->latest()->paginate($perPage)->appends($request->except('page'));
        
        // Statistics
        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::where('status', 'unread')->count(),
            'read' => ContactMessage::where('status', 'read')->count(),
        ];
        
        return view('admin.messages', compact('messages', 'stats'));
    }

    public function show(ContactMessage $message)
    {
        // Automatically mark as read when viewing
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }
        
        return view('admin.messages-show', compact('message'));
    }

    public function destroy(ContactMessage $message)
    {
        $oldValues = $message->toArray();
        
        $message->delete();

        // Log message deletion
        AuditLog::log(
            'delete',
            'ContactMessage',
            "Deleted contact message from: {$oldValues['name']} ({$oldValues['email']}) - Subject: {$oldValues['subject']}",
            $message->id,
            $oldValues,
            null
        );
        
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted successfully');
    }

    public function reply(Request $request, ContactMessage $message)
    {
        // Reply logic
        return redirect()->back()->with('success', 'Reply sent');
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->update(['status' => 'read']);
        
        AuditLog::log(
            'update',
            'ContactMessage',
            "Marked message as read from: {$message->from_email}",
            $message->id,
            ['status' => 'unread'],
            ['status' => 'read']
        );
        
        return redirect()->back()->with('success', 'Message marked as read');
    }
}
