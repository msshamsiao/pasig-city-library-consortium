<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::where('library_id', auth()->user()->library_id)
            ->latest()
            ->paginate(20);
        
        return view('librarian.books.index', compact('books'));
    }

    public function create()
    {
        return view('librarian.books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books,isbn',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'category' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $validated['library_id'] = auth()->user()->library_id;
        $validated['available_quantity'] = $validated['quantity'];
        $validated['status'] = 'available';

        Book::create($validated);

        return redirect()->route('librarian.books.index')
            ->with('success', 'Book added successfully.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:2048'
        ]);

        // TODO: Implement CSV/Excel upload functionality
        
        return back()->with('success', 'Books uploaded successfully.');
    }
}
