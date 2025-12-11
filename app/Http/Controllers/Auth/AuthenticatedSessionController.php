<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Log successful login
        $user = Auth::user();
        AuditLog::log(
            'login', 
            'User', 
            "User logged in: {$user->name} ({$user->email})", 
            $user->id, 
            null, 
            ['email' => $user->email, 'role' => $user->role]
        );

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Capture user info before logout
        $user = Auth::user();
        $userName = $user?->name;
        $userEmail = $user?->email;
        $userId = $user?->id;

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Log logout action
        if ($userName) {
            AuditLog::create([
                'user_id' => $userId,
                'user_name' => $userName,
                'user_role' => $user->role,
                'library_id' => $user->library_id,
                'action' => 'logout',
                'model' => 'User',
                'model_id' => $userId,
                'description' => "User logged out: {$userName} ({$userEmail})",
                'old_values' => null,
                'new_values' => null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return redirect('/');
    }
}
