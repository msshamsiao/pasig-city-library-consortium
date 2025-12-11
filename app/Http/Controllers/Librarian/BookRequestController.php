<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    public function index()
    {
        // Show all book requests - librarians can view all requests from their library's users
        $bookRequests = BookRequest::whereHas('user', function($query) {
                $query->where('library_id', auth()->user()->library_id);
            })
            ->with('user')
            ->latest()
            ->paginate(20);
        
        return view('librarian.book-requests.index', compact('bookRequests'));
    }

    public function approve(BookRequest $bookRequest)
    {
        // Check if request belongs to user from librarian's library
        if ($bookRequest->user->library_id != auth()->user()->library_id) {
            abort(403);
        }

        $bookRequest->update([
            'status' => 'approved',
            'admin_notes' => 'Approved by ' . auth()->user()->name
        ]);

        return back()->with('success', 'Request approved successfully.');
    }

    public function reject(Request $request, BookRequest $bookRequest)
    {
        // Check if request belongs to user from librarian's library
        if ($bookRequest->user->library_id != auth()->user()->library_id) {
            abort(403);
        }

        $bookRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('reason') ?? 'Request rejected'
        ]);

        return back()->with('success', 'Request rejected.');
    }
}
