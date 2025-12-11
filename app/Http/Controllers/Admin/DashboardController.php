<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Library;
use App\Models\BookRequest;
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
            'total_books' => Book::count(),
            'total_active_members' => User::where('role', 'borrower')->count(),
            'book_reservations' => BookRequest::where('status', 'pending')->count(),
            'completed_transactions' => BookRequest::where('status', 'completed')->count(),
        ];
        
        // Get library members (member librarians) with their library info
        $libraryMembers = User::where('role', 'member_librarian')
            ->with('library')
            ->latest()
            ->get();
        
        return view('admin.dashboard', compact('user', 'library', 'stats', 'libraryMembers'));
    }
}
