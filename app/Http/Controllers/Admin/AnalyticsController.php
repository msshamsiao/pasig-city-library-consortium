<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Holding;
use App\Models\User;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Get paginated libraries
        $librariesPaginated = Library::orderBy('name', 'asc')->paginate(10);
        
        // Map statistics for each library
        $libraries = $librariesPaginated->through(function($library) {
            // Count books in this specific library's holdings
            $totalBooks = Holding::where('holding_branch_id', $library->id)->count();
            
            // Count borrowers (members) registered to this library
            $totalMembers = User::where('role', 'borrower')
                ->where('library_id', $library->id)
                ->count();
            
            // Count active requests for books in this library
            $activeRequests = \App\Models\Borrowing::whereIn('status', ['pending', 'reserved'])
                ->whereHas('holding', function($query) use ($library) {
                    $query->where('holding_branch_id', $library->id);
                })->count();

            return [
                'id' => $library->id,
                'name' => $library->name,
                'address' => $library->address,
                'total_books' => $totalBooks,
                'books_borrowed' => $activeRequests,
                'total_members' => $totalMembers,
            ];
        });

        // Overall statistics - dynamically calculated
        $overallStats = [
            'total_libraries' => Library::count(),
            'total_books' => Holding::count(),
            'total_borrowed' => 0, // Removed book requests functionality
            'total_members' => User::where('role', 'borrower')->count(),
        ];

        return view('admin.analytics.index', compact('libraries', 'overallStats'));
    }
}
