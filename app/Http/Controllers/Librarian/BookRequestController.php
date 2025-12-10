<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    public function index()
    {
        $bookRequests = BookRequest::whereHas('book', function($query) {
                $query->where('library_id', auth()->user()->library_id);
            })
            ->with(['user', 'book'])
            ->latest()
            ->paginate(20);
        
        return view('librarian.book-requests.index', compact('bookRequests'));
    }

    public function approve(BookRequest $bookRequest)
    {
        // Check if request belongs to librarian's library
        if ($bookRequest->book->library_id != auth()->user()->library_id) {
            abort(403);
        }

        $bookRequest->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id()
        ]);

        return back()->with('success', 'Book request approved successfully.');
    }

    public function reject(Request $request, BookRequest $bookRequest)
    {
        // Check if request belongs to librarian's library
        if ($bookRequest->book->library_id != auth()->user()->library_id) {
            abort(403);
        }

        $bookRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('reason')
        ]);

        return back()->with('success', 'Book request rejected.');
    }
}
