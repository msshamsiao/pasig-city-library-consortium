<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
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
        $oldValues = $member->toArray();
        
        $member->delete();

        // Log member deletion
        AuditLog::log(
            'delete',
            'User',
            "Deleted member: {$oldValues['name']} ({$oldValues['email']}) - Member ID: {$oldValues['member_id']}",
            $member->id,
            $oldValues,
            null
        );
        
        return redirect()->route('admin.members.index')
            ->with('success', 'Member deleted successfully!');
    }

    public function suspend(User $member)
    {
        $oldStatus = $member->status;
        $member->update(['status' => 'suspended']);

        // Log member suspension
        AuditLog::log(
            'suspend',
            'User',
            "Suspended member: {$member->name} ({$member->email})",
            $member->id,
            ['status' => $oldStatus],
            ['status' => 'suspended']
        );
        
        return redirect()->back()->with('success', 'Member suspended successfully!');
    }

    public function activate(User $member)
    {
        $oldStatus = $member->status;
        $member->update(['status' => 'active']);

        // Log member activation
        AuditLog::log(
            'activate',
            'User',
            "Activated member: {$member->name} ({$member->email})",
            $member->id,
            ['status' => $oldStatus],
            ['status' => 'active']
        );
        
        return redirect()->back()->with('success', 'Member activated successfully!');
    }
}
