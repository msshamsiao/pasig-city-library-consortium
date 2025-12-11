<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        // Get all activities ordered by activity date
        $activities = Activity::orderBy('activity_date', 'desc')
            ->paginate(15);

        // Calculate statistics
        $totalActivities = Activity::count();
        $upcomingActivities = Activity::where('activity_date', '>=', now())->count();
        $thisMonthActivities = Activity::whereMonth('activity_date', now()->month)
            ->whereYear('activity_date', now()->year)
            ->count();
        
        // Note: participants count would need a participants table/column
        $totalParticipants = 0; // Placeholder until participants table exists

        return view('admin.activities', compact('activities', 'totalActivities', 'upcomingActivities', 'thisMonthActivities', 'totalParticipants'));
    }

    public function create()
    {
        return view('admin.activities-create');
    }

    public function store(Request $request)
    {
        // Store logic
        return redirect()->route('admin.activities.index');
    }

    public function show(Activity $activity)
    {
        return view('admin.activities-show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        return view('admin.activities-edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        // Update logic
        return redirect()->route('admin.activities.index');
    }

    public function destroy(Activity $activity)
    {
        // Delete logic
        return redirect()->route('admin.activities.index');
    }

    public function cancel(Activity $activity)
    {
        // Cancel logic
        return redirect()->back()->with('success', 'Activity cancelled');
    }

    public function addParticipant(Request $request, Activity $activity)
    {
        // Add participant logic
        return redirect()->back()->with('success', 'Participant added');
    }

    public function removeParticipant(Activity $activity, $user)
    {
        // Remove participant logic
        return redirect()->back()->with('success', 'Participant removed');
    }
}
