<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Book;
use App\Models\BookRequest;
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
            // Count members associated with this library
            $memberCount = User::where('library_id', $library->id)
                ->where('role', 'borrower')
                ->count();

            // Count book requests from users of this library
            $userIds = User::where('library_id', $library->id)->pluck('id');
            $borrowedCount = BookRequest::whereIn('user_id', $userIds)
                ->whereIn('status', ['approved', 'borrowed'])
                ->count();

            return [
                'id' => $library->id,
                'name' => $library->name,
                'address' => $library->address,
                'total_books' => Book::count(), // Shared consortium books
                'books_borrowed' => $borrowedCount,
                'total_members' => $memberCount,
            ];
        });

        // Overall statistics - dynamically calculated
        $overallStats = [
            'total_libraries' => Library::count(),
            'total_books' => Book::count(),
            'total_borrowed' => BookRequest::whereIn('status', ['approved', 'borrowed'])->count(),
            'total_members' => User::where('role', 'borrower')->count(),
        ];

        return view('admin.analytics.index', compact('libraries', 'overallStats'));
    }
}
