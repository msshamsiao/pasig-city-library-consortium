<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Library;
use App\Models\Book;

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
        $totalBooks = Book::count();
        $availableBooks = Book::where('status', 'available')->count();
        $onLoan = Book::where('status', 'borrowed')->count();
        
        $statistics = [
            'total_libraries' => $libraries->count(),
            'total_books' => $totalBooks,
            'available_books' => $availableBooks,
            'on_loan' => $onLoan,
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

        $query = Book::query();

        // Filter by search term based on category
        if (!empty($search)) {
            switch ($category) {
                case 'book':
                case 'title':
                    $query->where('title', 'like', '%' . $search . '%');
                    break;
                case 'author':
                    $query->where('author', 'like', '%' . $search . '%');
                    break;
                case 'subject':
                    $query->where('category', 'like', '%' . $search . '%');
                    break;
                case 'all':
                default:
                    $query->where(function($q) use ($search) {
                        $q->where('title', 'like', '%' . $search . '%')
                          ->orWhere('author', 'like', '%' . $search . '%')
                          ->orWhere('isbn', 'like', '%' . $search . '%')
                          ->orWhere('category', 'like', '%' . $search . '%');
                    });
                    break;
            }
        }

        // Note: Library filter not implemented yet - needs library_id in books table

        $books = $query->limit(50)->get();

        return response()->json([
            'books' => $books,
            'total' => $books->count()
        ]);
    }
}
