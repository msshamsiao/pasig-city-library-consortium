<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.messages');
    }

    public function show(ContactMessage $message)
    {
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
        // Mark as read logic
        return redirect()->back()->with('success', 'Message marked as read');
    }
}
