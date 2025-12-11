<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::where('library_id', Auth::user()->library_id);
        
        // Filter by library if provided
        if ($request->filled('library')) {
            $query->where('library_id', $request->library);
        }
        
        $activities = $query->latest()->paginate(20);
        
        // Get libraries for filter dropdown
        $libraries = \App\Models\Library::orderBy('name')->get();
        
        return view('librarian.activities.index', compact('activities', 'libraries'));
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

        $validated['library_id'] = Auth::user()->library_id;
        $validated['created_by'] = Auth::id();
        $validated['status'] = 'pending'; // Needs super admin approval

        $activity = Activity::create($validated);

        AuditLog::log(
            'create',
            'Activity',
            "Created activity: {$activity->title} (Date: {$activity->activity_date})",
            $activity->id,
            null,
            ['title' => $activity->title, 'activity_date' => $activity->activity_date, 'status' => 'pending']
        );

        return redirect()->route('librarian.activities.index')
            ->with('success', 'Activity created and submitted for approval.');
    }

    public function edit(Activity $activity)
    {
        // Check if activity belongs to librarian's library
        if ($activity->library_id != Auth::user()->library_id) {
            abort(403);
        }

        return view('librarian.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        // Check if activity belongs to librarian's library
        if ($activity->library_id != Auth::user()->library_id) {
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

        $oldValues = $activity->only(['title', 'activity_date', 'activity_time']);
        $activity->update($validated);

        AuditLog::log(
            'update',
            'Activity',
            "Updated activity: {$activity->title}",
            $activity->id,
            $oldValues,
            $validated
        );

        return redirect()->route('librarian.activities.index')
            ->with('success', 'Activity updated successfully.');
    }
}
