<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LibrarianDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_members' => 0,
            'total_books' => 0,
            'pending_requests' => 0,
            'books_borrowed' => 0,
        ];

        $recentActivities = [];

        return view('librarian.dashboard', compact('stats', 'recentActivities'));
    }
}
