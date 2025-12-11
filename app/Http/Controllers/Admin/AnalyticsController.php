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
        // Get all member libraries with their statistics
        $libraries = Library::active()->get()->map(function($library) {
            return [
                'id' => $library->id,
                'name' => $library->name,
                'address' => $library->address,
                'total_books' => Book::where('library_id', $library->id)->count(),
                'books_borrowed' => BookRequest::where('library_id', $library->id)
                    ->whereIn('status', ['approved', 'borrowed'])
                    ->count(),
                'total_members' => User::where('library_id', $library->id)
                    ->where('role', 'borrower')
                    ->count(),
            ];
        });

        // Overall statistics
        $overallStats = [
            'total_libraries' => Library::active()->count(),
            'total_books' => Book::count(),
            'total_borrowed' => BookRequest::whereIn('status', ['approved', 'borrowed'])->count(),
            'total_members' => User::where('role', 'borrower')->count(),
        ];

        return view('admin.analytics.index', compact('libraries', 'overallStats'));
    }
}
