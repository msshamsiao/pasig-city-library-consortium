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

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:2048'
        ]);

        // TODO: Implement CSV/Excel upload functionality
        
        return back()->with('success', 'Members uploaded successfully.');
    }
}
