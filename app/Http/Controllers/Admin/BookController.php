<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holding;

class BookController extends Controller
{
    public function index()
    {
        $books = Holding::latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books',
            'category' => 'required|string',
            'total_copies' => 'required|integer|min:1',
        ]);

        $validated['available_copies'] = $validated['total_copies'];
        $validated['status'] = 'available';

        Holding::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book added successfully!');
    }

    public function edit(Holding $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Holding $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'category' => 'required|string',
            'total_copies' => 'required|integer|min:1',
        ]);

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book updated successfully!');
    }

    public function destroy(Holding $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully!');
    }

    public function borrow(Holding $book)
    {
        // TODO: Implement borrow logic
        return redirect()->back()->with('success', 'Book borrowed successfully!');
    }

    public function return(Holding $book)
    {
        // TODO: Implement return logic
        return redirect()->back()->with('success', 'Book returned successfully!');
    }
}
