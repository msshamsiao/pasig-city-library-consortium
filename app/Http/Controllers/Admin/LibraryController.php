<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        return view('admin.libraries');
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
        // Delete logic
        return redirect()->route('admin.libraries.index');
    }
}
