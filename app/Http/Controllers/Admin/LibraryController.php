<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Holding;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        // Get only active libraries (not archived)
        $libraries = Library::orderBy('name', 'asc')->get()->map(function($library) {
            // Count books in this specific library branch
            $totalBooks = Holding::where('holding_branch_id', $library->id)->count();
            
            // Count members from this library (by library_branch acronym in members table)
            $totalMembers = \App\Models\Member::where('library_branch', $library->acronym)->count();

            // Count active requests (pending/reserved) for books in this library
            $activeRequests = \App\Models\Borrowing::whereIn('status', ['pending', 'reserved'])
                ->whereHas('holding', function($query) use ($library) {
                    $query->where('holding_branch_id', $library->id);
                })->count();

            // Add statistics to library object
            $library->total_books = $totalBooks;
            $library->total_members = $totalMembers;
            $library->active_requests = $activeRequests;

            return $library;
        });

        // Calculate overall statistics
        $totalLibraries = Library::count();
        $totalBooks = Holding::count();
        $totalMembers = \App\Models\Member::count();

        return view('admin.libraries', compact('libraries', 'totalLibraries', 'totalBooks', 'totalMembers'));
    }

    public function create()
    {
        return view('admin.libraries-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'website' => 'nullable|url|max:255',
            'contact_person' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $validated['is_active'] = $request->has('is_active');

        $library = Library::create($validated);

        AuditLog::log(
            'create',
            'Library',
            "Created library: {$library->name}",
            $library->id,
            null,
            $validated
        );

        return redirect()->route('admin.libraries.index')
            ->with('success', 'Library created successfully.');
    }

    public function show(Library $library)
    {
        return view('admin.libraries-show', compact('library'));
    }

    public function edit(Library $library)
    {
        return view('admin.libraries-edit', compact('library'));
    }

    public function update(Request $request, Library $library)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'website' => 'nullable|url|max:255',
            'contact_person' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $oldValues = $library->getOriginal();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($library->logo && Storage::disk('public')->exists($library->logo)) {
                Storage::disk('public')->delete($library->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $validated['is_active'] = $request->has('is_active');

        $library->update($validated);

        // Log library update
        AuditLog::log(
            'update',
            'Library',
            "Updated library: {$library->name}",
            $library->id,
            $oldValues,
            $validated
        );

        return redirect()->route('admin.libraries.index')
            ->with('success', 'Library updated successfully!');
    }

    public function destroy(Library $library)
    {
        $libraryName = $library->name;
        $libraryId = $library->id;
        $oldValues = $library->toArray();
        
        $library->delete();
        
        AuditLog::log(
            'delete',
            'Library',
            "Archived library: {$libraryName}",
            $libraryId,
            $oldValues,
            null
        );
        
        return redirect()->route('admin.libraries.index')
            ->with('success', 'Library archived successfully.');
    }
    
    public function restore($id)
    {
        $library = Library::onlyTrashed()->findOrFail($id);
        $library->restore();
        
        AuditLog::log(
            'restore',
            'Library',
            "Restored library: {$library->name}",
            $library->id,
            null,
            $library->toArray()
        );
        
        return redirect()->route('admin.libraries.index')
            ->with('success', 'Library restored successfully.');
    }
}
