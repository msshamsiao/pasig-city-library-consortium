<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Library;

class LibrariesController extends Controller
{
    /**
     * Display all active member libraries from database.
     */
    public function index()
    {
        // Fetch all active libraries from database, ordered by name
        $libraries = Library::active()->orderBy('name', 'asc')->get();

        return view('libraries', compact('libraries'));
    }

    /**
     * Display a specific library's details.
     */
    public function show($id)
    {
        $library = Library::findOrFail($id);
        
        return view('libraries.show', compact('library'));
    }
}
