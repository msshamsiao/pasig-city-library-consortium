<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with library statistics.
     */
    public function index()
    {
        // Library statistics - you can fetch from database later
        $statistics = [
            'total_libraries' => 6,
            'total_books' => 15243,
            'available_books' => 12890,
            'on_loan' => 2353,
        ];

        // Library list for sidebar
        $libraries = [
            ['name' => 'Pasig City Library', 'type' => 'Public'],
            ['name' => 'PLP Library', 'type' => 'University'],
            ['name' => 'PCIST Library', 'type' => 'Technical'],
            ['name' => 'PSHS Library', 'type' => 'High School'],
            ['name' => 'RHS Library', 'type' => 'High School'],
            ['name' => 'City Hall Library', 'type' => 'Government'],
        ];

        return view('home', compact('statistics', 'libraries'));
    }

    /**
     * Handle search requests (you can implement this later)
     */
    public function search(Request $request)
    {
        $category = $request->input('category');
        $library = $request->input('library');
        $search = $request->input('search');

        // TODO: Implement search logic here
        
        return redirect()->back()->with('info', 'Search functionality coming soon!');
    }
}
