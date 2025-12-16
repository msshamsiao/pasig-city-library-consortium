<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibrarianDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $libraryId = $user->library_id;
        
        // If no library assigned, show all data
        if (!$libraryId) {
            $stats = [
                'total_members' => \App\Models\Member::count(),
                'active_members' => \App\Models\Member::where('status', 'active')->count(),
                'new_members' => \App\Models\Member::whereMonth('created_at', now()->month)->count(),
                'total_books' => \App\Models\Holding::count(),
                'available_books' => \App\Models\Holding::where('status', 'available')->count(),
                'pending_requests' => \App\Models\Borrowing::where('status', 'pending')->count(),
                'books_borrowed' => \App\Models\Borrowing::whereIn('status', ['reserved', 'borrowed'])->count(),
                'approved_today' => \App\Models\Borrowing::where('status', 'reserved')
                    ->whereDate('updated_at', now()->toDateString())->count(),
                'requests_this_month' => \App\Models\Borrowing::whereMonth('created_at', now()->month)->count(),
            ];
        } else {
            // Get library acronym for member filtering
            $library = \App\Models\Library::find($libraryId);
            $libraryAcronym = $library ? $library->acronym : null;
            
            // Get members from this library (by library_branch acronym)
            $memberCount = $libraryAcronym 
                ? \App\Models\Member::where('library_branch', $libraryAcronym)->count()
                : 0;
            
            $activeMemberCount = $libraryAcronym 
                ? \App\Models\Member::where('library_branch', $libraryAcronym)
                    ->where('status', 'active')->count()
                : 0;
            
            $newMemberCount = $libraryAcronym 
                ? \App\Models\Member::where('library_branch', $libraryAcronym)
                    ->whereMonth('created_at', now()->month)->count()
                : 0;
            
            // Get books from this library (by holding_branch_id)
            $bookCount = \App\Models\Holding::where('holding_branch_id', $libraryId)->count();
            $availableBookCount = \App\Models\Holding::where('holding_branch_id', $libraryId)
                ->where('status', 'available')->count();
            
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
            
            // Get approved requests today
            $approvedToday = \App\Models\Borrowing::where('status', 'reserved')
                ->whereDate('updated_at', now()->toDateString())
                ->whereHas('holding', function($query) use ($libraryId) {
                    $query->where('holding_branch_id', $libraryId);
                })->count();
            
            // Get total requests this month
            $requestsThisMonth = \App\Models\Borrowing::whereMonth('created_at', now()->month)
                ->whereHas('holding', function($query) use ($libraryId) {
                    $query->where('holding_branch_id', $libraryId);
                })->count();
            
            $stats = [
                'total_members' => $memberCount,
                'active_members' => $activeMemberCount,
                'new_members' => $newMemberCount,
                'total_books' => $bookCount,
                'available_books' => $availableBookCount,
                'pending_requests' => $pendingCount,
                'books_borrowed' => $borrowedCount,
                'approved_today' => $approvedToday,
                'requests_this_month' => $requestsThisMonth,
            ];
        }

        // Get recent activities (audit logs for this library)
        $recentActivities = \App\Models\AuditLog::where('library_id', $libraryId)
            ->latest()
            ->take(5)
            ->get();

        return view('librarian.dashboard', compact('stats', 'recentActivities'));
    }
}
