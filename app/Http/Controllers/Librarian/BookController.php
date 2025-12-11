<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // Show all books since they are centralized across all libraries
        $books = Book::latest()
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
            'isbn' => 'required|string|max:20|unique:books,isbn',
            'category' => 'required|string|max:100',
            'total_copies' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string|max:255',
        ]);

        $validated['available_copies'] = $validated['total_copies'];
        $validated['status'] = 'available';

        Book::create($validated);

        return redirect()->route('librarian.books.index')
            ->with('success', 'Book added successfully.');
    }

    public function edit(Book $book)
    {
        return view('librarian.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'category' => 'required|string|max:100',
            'total_copies' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string|max:255',
        ]);

        // Adjust available copies if total copies changed
        $copyDifference = $validated['total_copies'] - $book->total_copies;
        $validated['available_copies'] = $book->available_copies + $copyDifference;
        
        // Ensure available copies doesn't go negative
        if ($validated['available_copies'] < 0) {
            $validated['available_copies'] = 0;
        }

        $book->update($validated);

        return redirect()->route('librarian.books.index')
            ->with('success', 'Book updated successfully.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        try {
            $file = $request->file('file');
            $path = $file->getRealPath();
            
            // Read CSV file
            $csv = array_map('str_getcsv', file($path));
            
            // Check if file has data
            if (empty($csv) || count($csv) < 2) {
                return back()->with('error', 'CSV file is empty or has no data rows.');
            }
            
            // Get headers from first row
            $headers = array_map('strtolower', array_map('trim', $csv[0]));
            
            // Debug: Store headers for error message if needed
            $headersList = implode(', ', $headers);
            
            // Remove header row
            array_shift($csv);
            
            $imported = 0;
            $errors = [];
            
            foreach ($csv as $index => $row) {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }
                
                // Ensure row has same number of elements as headers
                if (count($row) < count($headers)) {
                    $row = array_pad($row, count($headers), '');
                } elseif (count($row) > count($headers)) {
                    $row = array_slice($row, 0, count($headers));
                }
                
                // Map row data to headers
                $data = array_combine($headers, $row);
                
                // Trim all values
                $data = array_map('trim', $data);
                
                // Get title - check multiple possible column names
                $title = $data['title'] ?? $data['book title'] ?? $data['booktitle'] ?? '';
                
                // Get author
                $author = $data['author'] ?? $data['authors'] ?? '';
                
                // Get ISBN
                $isbn = $data['isbn'] ?? $data['isbn number'] ?? '';
                
                // Validate required fields
                if (empty($title)) {
                    $errors[] = "Row " . ($index + 2) . ": Missing title";
                    continue;
                }
                
                if (empty($author)) {
                    $errors[] = "Row " . ($index + 2) . ": Missing author";
                    continue;
                }
                
                if (empty($isbn)) {
                    $errors[] = "Row " . ($index + 2) . ": Missing ISBN";
                    continue;
                }
                
                // Check if ISBN already exists
                if (Book::where('isbn', $isbn)->exists()) {
                    $errors[] = "Row " . ($index + 2) . ": ISBN '{$isbn}' already exists";
                    continue;
                }
                
                // Get copies - check multiple column names
                $copies = $data['copies'] ?? $data['total_copies'] ?? $data['qty'] ?? $data['quantity'] ?? 1;
                if (!is_numeric($copies) || $copies < 1) {
                    $copies = 1; // Default to 1 if invalid
                }
                
                // Get category from 'type' column (FIL, BOOK, POST, etc.) or 'category' column
                // Map common types to our categories
                $typeMapping = [
                    'FIL' => 'Fiction',
                    'BOOK' => 'Fiction',
                    'POST' => 'Fiction',
                    'PLNP' => 'Fiction',
                    'PCSLB' => 'Fiction',
                    'PCSHS' => 'Fiction',
                ];
                
                $rawType = $data['type'] ?? $data['category'] ?? 'BOOK';
                $category = $typeMapping[strtoupper($rawType)] ?? 'Fiction';
                
                // Get optional fields
                $publisher = $data['publisher'] ?? $data['publishers'] ?? null;
                $description = $data['description'] ?? $data['desc'] ?? null;
                
                // Create book
                try {
                    Book::create([
                        'title' => $title,
                        'author' => $author,
                        'isbn' => $isbn,
                        'category' => $category,
                        'total_copies' => (int)$copies,
                        'available_copies' => (int)$copies,
                        'description' => $description,
                        'cover_image' => $data['cover_image'] ?? null,
                        'status' => 'available',
                    ]);
                    
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }
            
            // Prepare response message
            if ($imported > 0) {
                $message = "Successfully imported {$imported} book(s).";
                if (!empty($errors)) {
                    $message .= " " . count($errors) . " row(s) had errors.";
                }
                return back()->with('success', $message)
                            ->with('errors', $errors);
            } else {
                // No books imported - show detailed error
                if (!empty($errors)) {
                    return back()->with('error', 'No books were imported. Please check the errors below.')
                                ->with('errors', $errors);
                } else {
                    return back()->with('error', "No books were imported. CSV columns found: {$headersList}. Required columns: title, author, isbn");
                }
            }
                        
        } catch (\Exception $e) {
            return back()->with('error', 'Error processing CSV file: ' . $e->getMessage());
        }
    }
}
