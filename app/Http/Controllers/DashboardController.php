<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current user (librarian)
        $user = auth()->user();
        
        // Get library information (from first library for now)
        $library = Library::first();
        
        // Dashboard statistics
        $stats = [
            'books_available' => Book::available()->count(),
            'members' => User::where('status', 'active')->count(),
            'books_borrowed' => Book::borrowed()->count(),
            'pending_returns' => Book::where('due_date', '<', now())->count(),
        ];
        
        return view('admin.dashboard', compact('user', 'library', 'stats'));
    }
}
