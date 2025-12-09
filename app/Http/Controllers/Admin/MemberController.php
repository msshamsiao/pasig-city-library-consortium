<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::latest()->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'member_type' => 'required|string',
        ]);

        $validated['password'] = bcrypt('password');
        $validated['member_id'] = 'user' . str_pad(User::count() + 1, 3, '0', STR_PAD_LEFT);
        $validated['status'] = 'active';
        $validated['membership_date'] = now();

        User::create($validated);

        return redirect()->route('admin.members.index')
            ->with('success', 'Member added successfully!');
    }

    public function edit(User $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, User $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $member->id,
            'phone' => 'required|string',
            'member_type' => 'required|string',
        ]);

        $member->update($validated);

        return redirect()->route('admin.members.index')
            ->with('success', 'Member updated successfully!');
    }

    public function destroy(User $member)
    {
        $member->delete();
        return redirect()->route('admin.members.index')
            ->with('success', 'Member deleted successfully!');
    }

    public function suspend(User $member)
    {
        $member->update(['status' => 'suspended']);
        return redirect()->back()->with('success', 'Member suspended successfully!');
    }

    public function activate(User $member)
    {
        $member->update(['status' => 'active']);
        return redirect()->back()->with('success', 'Member activated successfully!');
    }
}
