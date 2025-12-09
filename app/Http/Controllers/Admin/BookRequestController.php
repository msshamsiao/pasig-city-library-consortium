<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookRequest;

class BookRequestController extends Controller
{
     public function index()
    {
        return view('admin.book-requests');
    }

    public function create()
    {
        return view('admin.book-requests-create');
    }

    public function store(Request $request)
    {
        // Store logic
        return redirect()->route('admin.book-requests.index');
    }

    public function show(BookRequest $bookRequest)
    {
        return view('admin.book-requests-show', compact('bookRequest'));
    }

    public function edit(BookRequest $bookRequest)
    {
        return view('admin.book-requests-edit', compact('bookRequest'));
    }

    public function update(Request $request, BookRequest $bookRequest)
    {
        // Update logic
        return redirect()->route('admin.book-requests.index');
    }

    public function destroy(BookRequest $bookRequest)
    {
        // Delete logic
        return redirect()->route('admin.book-requests.index');
    }

    public function approve(BookRequest $bookRequest)
    {
        // Approve logic
        return redirect()->back()->with('success', 'Book request approved');
    }

    public function reject(BookRequest $bookRequest)
    {
        // Reject logic
        return redirect()->back()->with('success', 'Book request rejected');
    }

    public function complete(BookRequest $bookRequest)
    {
        // Complete logic
        return redirect()->back()->with('success', 'Book request completed');
    }
}
