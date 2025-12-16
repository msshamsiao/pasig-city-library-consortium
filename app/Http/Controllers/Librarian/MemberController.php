<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $libraryId = Auth::user()->library_id;
        $search = $request->input('search');
        
        // Filter borrowers by librarian's library - always filter by library_id
        $members = User::with('library')
            ->where('role', 'borrower')
            ->where('library_id', $libraryId)
            ->when($search, function($q) use ($search) {
                return $q->where(function($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('member_id', 'like', "%{$search}%")
                          ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->appends(['search' => $search]);
        
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
        $validated['library_id'] = Auth::user()->library_id;
        $validated['password'] = bcrypt($validated['password']);

        $member = User::create($validated);

        AuditLog::log(
            'create',
            'User',
            "Created new member: {$member->name} ({$member->email})",
            $member->id,
            null,
            ['name' => $member->name, 'email' => $member->email, 'role' => 'borrower']
        );

        return redirect()->route('librarian.members.index')
            ->with('success', 'Member created successfully.');
    }

    public function edit(User $member)
    {
        // Ensure the member belongs to the same library
        $libraryId = Auth::user()->library_id;
        $library = \App\Models\Library::find($libraryId);
        $libraryAcronym = $library ? $library->acronym : null;
        
        // Check if member belongs to this library through the members table
        $memberRecord = \App\Models\Member::where('member_id', $member->member_id)
            ->where('library_branch', $libraryAcronym)
            ->first();
            
        if (!$memberRecord) {
            abort(403, 'Unauthorized action. This member does not belong to your library.');
        }

        return view('librarian.members.edit', compact('member'));
    }

    public function update(Request $request, User $member)
    {
        // Ensure the member belongs to the same library
        $libraryId = Auth::user()->library_id;
        $library = \App\Models\Library::find($libraryId);
        $libraryAcronym = $library ? $library->acronym : null;
        
        // Check if member belongs to this library through the members table
        $memberRecord = \App\Models\Member::where('member_id', $member->member_id)
            ->where('library_branch', $libraryAcronym)
            ->first();
            
        if (!$memberRecord) {
            abort(403, 'Unauthorized action. This member does not belong to your library.');
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

        $oldValues = $member->only(['name', 'email', 'phone', 'address']);
        $member->update($validated);

        AuditLog::log(
            'update',
            'User',
            "Updated member: {$member->name} ({$member->email})",
            $member->id,
            $oldValues,
            $member->only(['name', 'email', 'phone', 'address'])
        );

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
                        'library_id' => Auth::user()->library_id,
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
            
            // Notify admins about bulk member import
            if ($imported > 0) {
                NotificationService::notifyAdmins(
                    'member_import',
                    'Members Imported',
                    Auth::user()->name . " imported {$imported} new member(s) to their library.",
                    route('admin.members.index')
                );
            }
            
            return back()->with('success', $message)
                        ->with('errors', $errors);
                        
        } catch (\Exception $e) {
            return back()->with('error', 'Error processing CSV file: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $memberIds = $request->input('member_ids', []);
        
        if (empty($memberIds)) {
            return back()->with('error', 'No members selected for deletion.');
        }

        $libraryId = Auth::user()->library_id;
        $library = \App\Models\Library::find($libraryId);
        $libraryAcronym = $library ? $library->acronym : null;
        
        $deleted = 0;
        $errors = [];
        
        foreach ($memberIds as $memberId) {
            $member = User::find($memberId);
            
            if (!$member) {
                $errors[] = "Member ID {$memberId} not found";
                continue;
            }
            
            // Check if member belongs to this library
            $memberRecord = \App\Models\Member::where('member_id', $member->member_id)
                ->where('library_branch', $libraryAcronym)
                ->first();
                
            if (!$memberRecord) {
                $errors[] = "Member {$member->name} does not belong to your library";
                continue;
            }
            
            try {
                $memberName = $member->name;
                $memberEmail = $member->email;
                
                $member->delete();
                
                // Log deletion
                AuditLog::log(
                    'delete',
                    'User',
                    "Deleted member: {$memberName} ({$memberEmail})",
                    $memberId,
                    ['name' => $memberName, 'email' => $memberEmail],
                    null
                );
                
                $deleted++;
            } catch (\Exception $e) {
                $errors[] = "Error deleting {$member->name}: " . $e->getMessage();
            }
        }
        
        $message = "Successfully deleted {$deleted} member(s).";
        if (!empty($errors)) {
            $message .= " " . count($errors) . " error(s) occurred.";
        }
        
        return back()->with('success', $message)
                    ->with('errors', $errors);
    }
}
