<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::where('library_id', auth()->user()->library_id)
            ->latest()
            ->paginate(20);
        
        return view('librarian.activities.index', compact('activities'));
    }

    public function create()
    {
        return view('librarian.activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'activity_date' => 'required|date',
            'activity_time' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $validated['library_id'] = auth()->user()->library_id;
        $validated['created_by'] = auth()->id();
        $validated['status'] = 'pending'; // Needs super admin approval

        Activity::create($validated);

        return redirect()->route('librarian.activities.index')
            ->with('success', 'Activity created and submitted for approval.');
    }

    public function edit(Activity $activity)
    {
        // Check if activity belongs to librarian's library
        if ($activity->library_id != auth()->user()->library_id) {
            abort(403);
        }

        return view('librarian.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        // Check if activity belongs to librarian's library
        if ($activity->library_id != auth()->user()->library_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'activity_date' => 'required|date',
            'activity_time' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $activity->update($validated);

        return redirect()->route('librarian.activities.index')
            ->with('success', 'Activity updated successfully.');
    }
}
