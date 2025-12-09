<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        // Delete logic
        return redirect()->route('admin.messages.index');
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
