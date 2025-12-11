<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Holding;
use App\Models\Library;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current user (librarian)
        $user = Auth::user();
        
        // Get library information (from first library for now)
        $library = Library::first();
        
        // Dashboard statistics
        $stats = [
            'books_available' => Holding::available()->count(),
            'members' => User::where('status', 'active')->count(),
            'books_borrowed' => Holding::borrowed()->count(),
            'pending_returns' => Holding::where('due_date', '<', now())->count(),
        ];
        
        return view('admin.dashboard', compact('user', 'library', 'stats'));
    }
}
