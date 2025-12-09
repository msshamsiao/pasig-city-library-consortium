<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $library = Library::first();
        return view('admin.settings.index', compact('library'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        $library = Library::first();
        if ($library) {
            $library->update($validated);
        }

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully!');
    }
}
