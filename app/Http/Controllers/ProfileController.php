<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $oldValues = $user->getOriginal();
        
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Log profile update
        AuditLog::log(
            'update',
            'User',
            "User updated profile: {$user->name}",
            $user->id,
            $oldValues,
            $user->only(['name', 'email', 'phone', 'address'])
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $userName = $user->name;
        $userEmail = $user->email;
        $userId = $user->id;
        $userRole = $user->role;
        $libraryId = $user->library_id;

        Auth::logout();

        $user->delete();

        // Log account deletion
        AuditLog::create([
            'user_id' => $userId,
            'user_name' => $userName,
            'user_role' => $userRole,
            'library_id' => $libraryId,
            'action' => 'delete',
            'model' => 'User',
            'model_id' => $userId,
            'description' => "User deleted their account: {$userName} ({$userEmail})",
            'old_values' => ['name' => $userName, 'email' => $userEmail, 'role' => $userRole],
            'new_values' => null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
