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
            // Count members associated with this library
            $memberCount = User::where('library_id', $library->id)
                ->where('role', 'borrower')
                ->count();

            // Count borrowed books from users of this library
            $userIds = User::where('library_id', $library->id)->pluck('id');
            $borrowedCount = 0; // Removed book requests functionality

            return [
                'id' => $library->id,
                'name' => $library->name,
                'address' => $library->address,
                'total_books' => Holding::count(), // Shared consortium books
                'books_borrowed' => $borrowedCount,
                'total_members' => $memberCount,
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
