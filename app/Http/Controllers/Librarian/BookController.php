<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Holding;
use App\Models\Library;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BookController extends Controller
{
    public function index()
    {
        // Show all books since they are centralized across all libraries
        $books = Holding::with('library')
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

            Holding::create($validated);

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

        $book->update($validated);

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
            $errors = [];
            $batchSize = 100;
            $holdingsToInsert = [];
            
            // Log columns found for debugging
            \Log::info('CSV Upload - Columns found: ' . $headersList);
            \Log::info('CSV Upload - Total rows to process: ' . count($csv));
            
            // Get existing ISBNs from database to avoid duplicates
            $existingIsbns = Holding::pluck('isbn')->toArray();
            
            // Cache library lookups
            $libraryCache = Library::pluck('id', 'acronym')->toArray();
            
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
                if (in_array($isbn, $existingIsbns)) {
                    $errors[] = "Row " . ($index + 2) . ": ISBN '{$isbn}' already exists (Title: {$title})";
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
                if ($holdingBranch) {
                    $acronymKey = strtoupper(trim($holdingBranch));
                    $libraryId = $libraryCache[$acronymKey] ?? null;
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
