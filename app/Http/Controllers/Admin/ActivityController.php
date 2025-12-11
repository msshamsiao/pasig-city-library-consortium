<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        // Get all activities with library information ordered by activity date
        $activities = Activity::with('library')
            ->orderBy('activity_date', 'desc')
            ->paginate(20);

        // Calculate statistics
        $totalActivities = Activity::count();
        $pendingActivities = Activity::where('approval_status', 'pending')->count();
        $approvedActivities = Activity::where('approval_status', 'approved')->count();
        $upcomingActivities = Activity::where('activity_date', '>=', now())
            ->where('approval_status', 'approved')
            ->count();
        
        // Sum all current participants from approved activities
        $totalParticipants = Activity::where('approval_status', 'approved')
            ->sum('current_participants');

        return view('admin.activities', compact('activities', 'totalActivities', 'pendingActivities', 'approvedActivities', 'upcomingActivities', 'totalParticipants'));
    }

    public function approve(Activity $activity)
    {
        $activity->update([
            'approval_status' => 'approved',
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Activity approved successfully');
    }

    public function reject(Request $request, Activity $activity)
    {
        $activity->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Activity rejected');
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
