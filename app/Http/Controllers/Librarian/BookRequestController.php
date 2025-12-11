<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    public function index(Request $request)
    {
        // Show all book requests - librarians can view all requests from their library's users
        $query = BookRequest::whereHas('user', function($q) {
                $q->where('library_id', auth()->user()->library_id);
            })
            ->with('user');
        
        // Filter by status
        $status = $request->get('status', 'pending');
        if ($status) {
            $query->where('status', $status);
        }
        
        // Filter by date range (for completed and lapsed)
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
        
        $bookRequests = $query->latest()->paginate(20);
        
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
