<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Book;
use App\Models\User;
use App\Models\BookRequest;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        // Get libraries based on filter (active or archived)
        $filter = $request->get('filter', 'active');
        
        $librariesQuery = $filter === 'archived' 
            ? Library::onlyTrashed() 
            : Library::query();
            
        // Get all libraries with their statistics
        $libraries = $librariesQuery->orderBy('name', 'asc')->get()->map(function($library) {
            // Count members for this library
            $totalMembers = User::where('library_id', $library->id)
                ->where('role', 'borrower')
                ->count();

            // Get user IDs from this library
            $userIds = User::where('library_id', $library->id)->pluck('id');

            // Count active book requests from users of this library
            $activeRequests = BookRequest::whereIn('user_id', $userIds)
                ->whereIn('status', ['approved', 'borrowed'])
                ->count();

            // Add statistics to library object
            $library->total_books = Book::count(); // Shared consortium books
            $library->total_members = $totalMembers;
            $library->active_requests = $activeRequests;

            return $library;
        });

        // Calculate overall statistics
        $totalLibraries = Library::count();
        $totalBooks = Book::count();
        $totalMembers = User::where('role', 'borrower')->count();

        return view('admin.libraries', compact('libraries', 'totalLibraries', 'totalBooks', 'totalMembers'));
    }

    public function create()
    {
        return view('admin.libraries-create');
    }

    public function store(Request $request)
    {
        // Store logic
        return redirect()->route('admin.libraries.index');
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
        // Update logic
        return redirect()->route('admin.libraries.index');
    }

    public function destroy(Library $library)
    {
        $library->delete();
        return redirect()->route('admin.libraries.index')
            ->with('success', 'Library archived successfully.');
    }
    
    public function restore($id)
    {
        $library = Library::onlyTrashed()->findOrFail($id);
        $library->restore();
        return redirect()->route('admin.libraries.index')
            ->with('success', 'Library restored successfully.');
    }
}
