<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LibrarianDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $libraryId = $user->library_id;
        
        // If no library assigned, show all data
        if (!$libraryId) {
            $stats = [
                'total_members' => \App\Models\Member::count(),
                'total_books' => \App\Models\Holding::count(),
                'pending_requests' => \App\Models\Borrowing::where('status', 'pending')->count(),
                'books_borrowed' => \App\Models\Borrowing::whereIn('status', ['reserved', 'borrowed'])->count(),
            ];
        } else {
            // Get library acronym for member filtering
            $library = \App\Models\Library::find($libraryId);
            $libraryAcronym = $library ? $library->acronym : null;
            
            // Get members from this library (by library_branch acronym)
            $memberCount = $libraryAcronym 
                ? \App\Models\Member::where('library_branch', $libraryAcronym)->count()
                : 0;
            
            // Get books from this library (by holding_branch_id)
            $bookCount = \App\Models\Holding::where('holding_branch_id', $libraryId)->count();
            
            // Get pending requests for books in this library
            $pendingCount = \App\Models\Borrowing::where('status', 'pending')
                ->whereHas('holding', function($query) use ($libraryId) {
                    $query->where('holding_branch_id', $libraryId);
                })->count();
            
            // Get borrowed/reserved books from this library
            $borrowedCount = \App\Models\Borrowing::whereIn('status', ['reserved', 'borrowed'])
                ->whereHas('holding', function($query) use ($libraryId) {
                    $query->where('holding_branch_id', $libraryId);
                })->count();
            
            $stats = [
                'total_members' => $memberCount,
                'total_books' => $bookCount,
                'pending_requests' => $pendingCount,
                'books_borrowed' => $borrowedCount,
            ];
        }

        $recentActivities = [];

        return view('librarian.dashboard', compact('stats', 'recentActivities'));
    }
}
