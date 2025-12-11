<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Library;
use App\Models\Holding;

class HomeController extends Controller
{
    /**
     * Display the home page with library statistics.
     */
    public function index()
    {
        // Fetch active libraries from database
        $libraries = Library::active()->orderBy('name')->get();
        
        // Calculate dynamic statistics from database
        $totalBooks = Holding::count();
        $totalReservations = 0; // Removed book requests functionality
        
        $statistics = [
            'total_libraries' => $libraries->count(),
            'total_books' => $totalBooks,
            'total_reservations' => $totalReservations,
        ];

        return view('home', compact('statistics', 'libraries'));
    }

    /**
     * Handle search requests (you can implement this later)
     */
    public function search(Request $request)
    {
        $category = $request->input('category', 'all');
        $library = $request->input('library', 'all');
        $search = $request->input('search', '');

        $query = Holding::with('library');

        // Filter by library branch
        if ($library !== 'all' && !empty($library)) {
            $query->where('holding_branch_id', $library);
        }

        // Filter by search term based on category
        if (!empty($search)) {
            switch ($category) {
                case 'title':
                    $query->where('title', 'like', '%' . $search . '%');
                    break;
                case 'author':
                    $query->where('author', 'like', '%' . $search . '%');
                    break;
                case 'subject':
                    $query->where('description', 'like', '%' . $search . '%');
                    break;
                case 'all':
                default:
                    $query->where(function($q) use ($search) {
                        $q->where('title', 'like', '%' . $search . '%')
                          ->orWhere('author', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%');
                    });
                    break;
            }
        }

        $books = $query->limit(50)->get();

        return response()->json([
            'books' => $books,
            'total' => $books->count()
        ]);
    }
}
