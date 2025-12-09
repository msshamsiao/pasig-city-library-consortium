<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Library;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current user (librarian/admin)
        $user = auth()->user();
        
        // Get library information (from first library for now)
        $library = Library::first();
        
        // Dashboard statistics
        $stats = [
            'books_available' => Book::where('status', 'available')->count(),
            'members' => User::where('status', 'active')->count(),
            'books_borrowed' => Book::where('status', 'borrowed')->count(),
            'pending_returns' => Book::where('due_date', '<', now())->count(),
        ];
        
        return view('admin.dashboard', compact('user', 'library', 'stats'));
    }
}
