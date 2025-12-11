<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holding;
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
            'total_library_members' => User::where('role', 'member_librarian')->count(),
            'total_books' => Holding::count(),
            'total_active_members' => User::where('role', 'borrower')->count(),
            'book_reservations' => 0, // Removed book requests functionality
            'completed_transactions' => 0, // Removed book requests functionality
        ];
        
        return view('admin.dashboard', compact('user', 'library', 'stats'));
    }
}
