<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SettingsController extends Controller
{
    public function index()
    {
        $superAdmins = User::where('role', 'super_admin')->orderBy('name')->get();
        
        return view('admin.settings.index', compact('superAdmins'));
    }

    public function update(Request $request)
    {
        // Handle settings update logic here
        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function storeSuperAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Super Admin created successfully.');
    }

    public function updateSuperAdmin(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Super Admin updated successfully.');
    }

    public function destroySuperAdmin(User $user)
    {
        // Prevent deleting if it's the only super admin
        $superAdminCount = User::where('role', 'super_admin')->count();
        
        if ($superAdminCount <= 1) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Cannot delete the last Super Admin.');
        }

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Super Admin deleted successfully.');
    }
}
