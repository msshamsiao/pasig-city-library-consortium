<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LibrarianDashboardController extends Controller
{
    public function index()
    {
        $libraryId = auth()->user()->library_id;
        
        $stats = [
            'total_members' => User::where('role', 'borrower')->where('library_id', $libraryId)->count(),
            'total_books' => 0,
            'pending_requests' => 0,
            'books_borrowed' => 0,
        ];

        $recentActivities = [];

        return view('librarian.dashboard', compact('stats', 'recentActivities'));
    }
}
