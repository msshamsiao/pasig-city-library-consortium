<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Holding;
use App\Models\Library;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $libraryId = Auth::user()->library_id;
        $search = $request->input('search');
        
        // Build query - always filter by librarian's library
        $query = Holding::with('library')
            ->where('holding_branch_id', $libraryId);
        
        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $books = $query->latest()->paginate(20)->appends(['search' => $search]);
        
        return view('librarian.books.index', compact('books'));
    }

    public function create()
    {
        return view('librarian.books.create');
    }

    public function store(Request $request)
    {
        try {
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

            $book = Holding::create($validated);

            AuditLog::log(
                'create',
                'Holding',
                "Added new book: {$book->title} by {$book->author} (ISBN: {$book->isbn})",
                $book->id,
                null,
                $validated
            );

            return redirect()->route('librarian.books.index')
                ->with('success', 'Book added successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to add book: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Holding $book)
    {
        return view('librarian.books.edit', compact('book'));
    }

    public function update(Request $request, Holding $book)
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

        $oldValues = $book->getOriginal();
        $book->update($validated);

        AuditLog::log(
            'update',
            'Holding',
            "Updated book: {$book->title} (ISBN: {$book->isbn})",
            $book->id,
            $oldValues,
            $validated
        );

        return redirect()->route('librarian.books.index')
            ->with('success', 'Book updated successfully.');
    }

    public function upload(Request $request)
    {
        // Increase execution time and memory for large uploads
        set_time_limit(300); // 5 minutes
        ini_set('memory_limit', '512M');
        
        try {
            $request->validate([
                'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', 'Validation failed: ' . implode(', ', $e->errors()['file'] ?? ['Unknown validation error']));
        }

        try {
            $file = $request->file('file');
            
            if (!$file) {
                return back()->with('error', 'No file was uploaded.');
            }
            
            $path = $file->getRealPath();
            $extension = strtolower($file->getClientOriginalExtension());
            
            // Read file based on type
            if (in_array($extension, ['xlsx', 'xls'])) {
                // Read Excel file using PhpSpreadsheet
                $spreadsheet = IOFactory::load($path);
                $worksheet = $spreadsheet->getActiveSheet();
                $csv = $worksheet->toArray();
            } else {
                // Read CSV file
                $csv = array_map('str_getcsv', file($path));
            }
            
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
            $updated = 0;
            $errors = [];
            $batchSize = 100;
            $holdingsToInsert = [];
            
            // Log columns found for debugging
            Log::info('CSV Upload - Columns found: ' . $headersList);
            Log::info('CSV Upload - Total rows to process: ' . count($csv));
            
            // Get existing ISBNs from database to avoid duplicates
            $existingIsbns = Holding::pluck('isbn')->toArray();
            
            // Cache library lookups with uppercase acronym keys for case-insensitive matching
            $libraryCache = Library::all()->pluck('id', 'acronym')->mapWithKeys(function($id, $acronym) {
                return [strtoupper($acronym) => $id];
            })->toArray();
            
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
                $title = $data['title'] ?? $data['book title'] ?? $data['booktitle'] ?? $data['book_title'] ?? '';
                
                // Get author - check multiple possible column names
                $author = $data['author'] ?? $data['authors'] ?? $data['author/s'] ?? $data['writer'] ?? '';
                
                // Get ISBN - check multiple possible column names
                $isbn = $data['isbn'] ?? $data['isbn number'] ?? $data['isbn_number'] ?? $data['isbn no'] ?? $data['isbn no.'] ?? '';
                
                // Get accession number (can be used for tracking)
                $accessionNo = $data['accession no'] ?? $data['accession_no'] ?? $data['accession'] ?? '';
                
                // If ISBN is empty, try to use accession number or generate unique one
                if (empty($isbn)) {
                    if (!empty($accessionNo)) {
                        $isbn = 'ACC-' . preg_replace('/[^a-zA-Z0-9]/', '', $accessionNo);
                    } else {
                        $isbn = 'GEN-' . substr(md5($title . time() . $index), 0, 10);
                    }
                }
                
                // Validate required fields
                if (empty($title)) {
                    // Show first few column values for debugging
                    $sampleData = implode(', ', array_slice($row, 0, 3));
                    $errors[] = "Row " . ($index + 2) . ": Missing title (Sample data: {$sampleData})";
                    continue;
                }
                
                // If author is missing, use "Unknown Author" as default
                if (empty($author)) {
                    $author = 'Unknown Author';
                }
                
                // Check if ISBN already exists in database or in current batch
                $existingBook = Holding::where('isbn', $isbn)
                    ->where('holding_branch_id', $libraryId ?? Auth::user()->library_id)
                    ->first();
                
                if ($existingBook) {
                    // Update existing book by incrementing copies
                    $existingBook->total_copies += $copies;
                    $existingBook->available_copies += $copies;
                    $existingBook->save();
                    $updated++;
                    continue;
                }
                
                // Check if already in current batch
                if (in_array($isbn, $existingIsbns)) {
                    // Find in batch and increment copies
                    foreach ($holdingsToInsert as &$holding) {
                        if ($holding['isbn'] === $isbn) {
                            $holding['total_copies'] += $copies;
                            $holding['available_copies'] += $copies;
                            break;
                        }
                    }
                    continue;
                }
                
                // Add to existing ISBNs to check future duplicates in this batch
                $existingIsbns[] = $isbn;
                
                // Get copies - check multiple column names (accession count, volume count, qty, etc.)
                $copies = $data['vol'] ?? $data['volume'] ?? $data['copies'] ?? $data['total_copies'] ?? 
                         $data['qty'] ?? $data['quantity'] ?? $data['no. of copies'] ?? 
                         $data['no of copies'] ?? $data['count'] ?? $data['available'] ?? 1;
                if (!is_numeric($copies) || $copies < 1) {
                    $copies = 1; // Default to 1 if invalid
                }
                
                // Get category/classification - check multiple possible column names
                // Map common library classifications to our categories
                $typeMapping = [
                    'FIL' => 'Fiction',
                    'FILI' => 'Fiction',
                    'BOOK' => 'Fiction',
                    'POST' => 'Fiction',
                    'PLNP' => 'Fiction',
                    'PCSLB' => 'Fiction',
                    'PCSHS' => 'Fiction',
                    'FICTION' => 'Fiction',
                    'FILIPINIANA' => 'Fiction',
                    'ROM' => 'Romance',
                    'ROMANCE' => 'Romance',
                    'SCI' => 'Science',
                    'SCIENCE' => 'Science',
                    'HIST' => 'History',
                    'HISTORY' => 'History',
                    'BIO' => 'Biography',
                    'BIOGRAPHY' => 'Biography',
                    'DYS' => 'Dystopian',
                    'DYSTOPIAN' => 'Dystopian',
                    'CON' => 'Fiction',
                ];
                
                $rawType = $data['type'] ?? $data['itype'] ?? $data['category'] ?? $data['classification'] ?? 
                          $data['class'] ?? $data['genre'] ?? $data['ccode'] ?? 'BOOK';
                $category = $typeMapping[strtoupper(trim($rawType))] ?? 'Fiction';
                
                // Get optional fields from various possible column names
                $publisher = $data['publisher'] ?? $data['publishers'] ?? $data['publication'] ?? 
                            $data['publishercode'] ?? null;
                
                // Get publication year
                $year = $data['year'] ?? $data['publication year'] ?? $data['pub year'] ?? 
                       $data['publicationyear'] ?? null;
                
                // Get place of publication
                $placeOfPub = $data['place of pub'] ?? $data['place_of_pub'] ?? $data['place'] ?? null;
                
                // Get imprint information
                $imprint = $data['imprint'] ?? null;
                
                // Get additional library system fields
                $barcode = $data['barcode'] ?? null;
                $callNumber = $data['itemcallnumber'] ?? $data['call number'] ?? $data['callnumber'] ?? null;
                $holdingBranch = $data['holding branch'] ?? $data['holdingbranch'] ?? $data['branch'] ?? 
                                $data['library'] ?? $data['acronym'] ?? null;
                $ccode = $data['ccode'] ?? null;
                $itype = $data['itype'] ?? null;
                
                // Find library by acronym using cached data
                $libraryId = null;
                if ($holdingBranch && strtoupper(trim($holdingBranch)) !== 'N/A') {
                    $acronymKey = strtoupper(trim($holdingBranch));
                    $libraryId = $libraryCache[$acronymKey] ?? null;
                }
                
                // If no library found from CSV, use the logged-in librarian's library
                if (!$libraryId) {
                    $libraryId = Auth::user()->library_id;
                }
                
                // Build description from available fields
                $descriptionParts = [];
                if ($imprint) $descriptionParts[] = "Imprint: " . $imprint;
                if ($placeOfPub) $descriptionParts[] = "Place: " . $placeOfPub;
                if ($year) $descriptionParts[] = "Year: " . $year;
                if ($publisher) $descriptionParts[] = "Publisher: " . $publisher;
                if ($holdingBranch) $descriptionParts[] = "Branch: " . $holdingBranch;
                if ($callNumber) $descriptionParts[] = "Call#: " . $callNumber;
                if ($barcode) $descriptionParts[] = "Barcode: " . $barcode;
                if ($accessionNo) $descriptionParts[] = "Accession No: " . $accessionNo;
                
                $description = !empty($descriptionParts) ? implode(" | ", $descriptionParts) : null;
                
                // Also check for explicit description field
                if (isset($data['description']) || isset($data['desc']) || isset($data['summary']) || isset($data['notes'])) {
                    $explicitDesc = $data['description'] ?? $data['desc'] ?? $data['summary'] ?? $data['notes'] ?? '';
                    if (!empty($explicitDesc)) {
                        $description = $explicitDesc . ($description ? " | " . $description : '');
                    }
                }
                
                // Add to batch
                $holdingsToInsert[] = [
                    'holding_branch_id' => $libraryId,
                    'title' => $title,
                    'author' => $author,
                    'isbn' => $isbn,
                    'category' => $category,
                    'total_copies' => (int)$copies,
                    'available_copies' => (int)$copies,
                    'description' => $description,
                    'cover_image' => $data['cover_image'] ?? null,
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // Insert batch when it reaches the batch size
                if (count($holdingsToInsert) >= $batchSize) {
                    try {
                        Holding::insert($holdingsToInsert);
                        $imported += count($holdingsToInsert);
                        $holdingsToInsert = [];
                    } catch (\Exception $e) {
                        $errors[] = "Batch insert error: " . $e->getMessage();
                        $holdingsToInsert = [];
                    }
                }
            }
            
            // Insert remaining holdings
            if (!empty($holdingsToInsert)) {
                try {
                    Holding::insert($holdingsToInsert);
                    $imported += count($holdingsToInsert);
                } catch (\Exception $e) {
                    $errors[] = "Final batch insert error: " . $e->getMessage();
                }
            }
            
            // Prepare response message
            if ($imported > 0 || $updated > 0) {
                $message = "Successfully imported {$imported} book(s)";
                if ($updated > 0) {
                    $message .= " and updated {$updated} existing book(s) with additional copies";
                }
                $message .= ".";
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

    public function bulkDelete(Request $request)
    {
        try {
            $bookIds = $request->input('book_ids', []);
            
            if (empty($bookIds)) {
                return redirect()->back()->with('error', 'No books selected for deletion.');
            }
            
            $libraryId = Auth::user()->library_id;
            $deletedCount = 0;
            
            foreach ($bookIds as $bookId) {
                $book = Holding::find($bookId);
                
                if (!$book) {
                    continue;
                }
                
                // Authorization check - only delete books from librarian's branch
                if ($libraryId && $book->holding_branch_id != $libraryId) {
                    continue;
                }
                
                // Store book details before deletion for audit log
                $bookTitle = $book->title;
                $bookAuthor = $book->author;
                $bookIsbn = $book->isbn;
                
                // Delete the book
                $book->delete();
                $deletedCount++;
                
                // Log the deletion
                AuditLog::log(
                    'delete',
                    'Holding',
                    "Deleted book: {$bookTitle} by {$bookAuthor} (ISBN: {$bookIsbn})",
                    $bookId,
                    [
                        'title' => $bookTitle,
                        'author' => $bookAuthor,
                        'isbn' => $bookIsbn,
                        'holding_branch_id' => $book->holding_branch_id,
                    ],
                    null
                );
            }
            
            if ($deletedCount > 0) {
                return redirect()->back()->with('success', "Successfully deleted {$deletedCount} book(s).");
            } else {
                return redirect()->back()->with('error', 'No books were deleted. You can only delete books from your library branch.');
            }
            
        } catch (\Exception $e) {
            Log::error('Bulk delete books error', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while deleting books: ' . $e->getMessage());
        }
    }
}
