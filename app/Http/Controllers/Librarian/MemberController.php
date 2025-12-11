<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'borrower')
            ->where('library_id', auth()->user()->library_id)
            ->latest()
            ->paginate(20);
        
        return view('librarian.members.index', compact('members'));
    }

    public function create()
    {
        return view('librarian.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $validated['role'] = 'borrower';
        $validated['library_id'] = auth()->user()->library_id;
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('librarian.members.index')
            ->with('success', 'Member created successfully.');
    }

    public function edit(User $member)
    {
        // Ensure the member belongs to the same library
        if ($member->library_id !== auth()->user()->library_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('librarian.members.edit', compact('member'));
    }

    public function update(Request $request, User $member)
    {
        // Ensure the member belongs to the same library
        if ($member->library_id !== auth()->user()->library_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $member->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $member->update($validated);

        return redirect()->route('librarian.members.index')
            ->with('success', 'Member updated successfully.');
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
            
            // Get headers from first row
            $headers = array_map('strtolower', array_map('trim', $csv[0]));
            
            // Remove header row
            array_shift($csv);
            
            $imported = 0;
            $errors = [];
            
            foreach ($csv as $index => $row) {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }
                
                // Map row data to headers
                $data = array_combine($headers, $row);
                
                // Validate required fields
                if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
                    $errors[] = "Row " . ($index + 2) . ": Missing required fields (name, email, or password)";
                    continue;
                }
                
                // Check if email already exists
                if (User::where('email', $data['email'])->exists()) {
                    $errors[] = "Row " . ($index + 2) . ": Email '{$data['email']}' already exists";
                    continue;
                }
                
                // Create member
                try {
                    User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => bcrypt($data['password']),
                        'phone' => $data['phone'] ?? null,
                        'address' => $data['address'] ?? null,
                        'role' => 'borrower',
                        'library_id' => auth()->user()->library_id,
                    ]);
                    
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }
            
            // Prepare success message
            $message = "Successfully imported {$imported} member(s).";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " row(s) had errors.";
            }
            
            return back()->with('success', $message)
                        ->with('errors', $errors);
                        
        } catch (\Exception $e) {
            return back()->with('error', 'Error processing CSV file: ' . $e->getMessage());
        }
    }
}
