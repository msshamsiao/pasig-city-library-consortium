<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\AuditLog;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        // Get all activities with library information
        $query = Activity::with('library');
        
        // Filter by library if provided
        if ($request->filled('library')) {
            $query->where('library_id', $request->library);
        }
        
        $perPage = $request->input('perPage', 10);
        $activities = $query->orderBy('activity_date', 'desc')->paginate($perPage);

        // Calculate statistics
        $totalActivities = Activity::count();
        $pendingActivities = Activity::where('approval_status', 'pending')->count();
        $approvedActivities = Activity::where('approval_status', 'approved')->count();
        $upcomingActivities = Activity::where('activity_date', '>=', now())
            ->where('approval_status', 'approved')
            ->count();
        
        // Get libraries for filter dropdown
        $libraries = \App\Models\Library::orderBy('name')->get();

        return view('admin.activities', compact('activities', 'totalActivities', 'pendingActivities', 'approvedActivities', 'upcomingActivities', 'libraries'));
    }

    public function approve(Activity $activity)
    {
        $activity->update([
            'approval_status' => 'approved',
            'rejection_reason' => null,
        ]);

        // Notify the librarian who created the activity
        NotificationService::notifyLibraryLibrarian(
            $activity->library_id,
            'activity_approved',
            'Activity Approved',
            "Your activity '{$activity->title}' has been approved and is now live!",
            route('librarian.activities.index')
        );

        return redirect()->back()->with('success', 'Activity approved successfully');
    }

    public function reject(Request $request, Activity $activity)
    {
        $reason = $request->rejection_reason ?? 'No reason provided';
        
        $activity->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $reason,
        ]);

        // Notify the librarian who created the activity
        NotificationService::notifyLibraryLibrarian(
            $activity->library_id,
            'activity_rejected',
            'Activity Rejected',
            "Your activity '{$activity->title}' was rejected. Reason: {$reason}",
            route('librarian.activities.index')
        );

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
        $oldValues = $activity->toArray();
        
        $activity->delete();

        // Log activity deletion
        AuditLog::log(
            'delete',
            'Activity',
            "Deleted activity: {$oldValues['title']} at {$activity->library->name}",
            $activity->id,
            $oldValues,
            null
        );
        
        return redirect()->route('admin.activities.index')->with('success', 'Activity deleted successfully');
    }

    public function cancel(Activity $activity)
    {
        $oldValues = $activity->only(['approval_status', 'rejection_reason']);
        
        $activity->update([
            'approval_status' => 'cancelled',
            'rejection_reason' => 'Cancelled by administrator',
        ]);

        // Log activity cancellation
        AuditLog::log(
            'cancel',
            'Activity',
            "Cancelled activity: {$activity->title} at {$activity->library->name}",
            $activity->id,
            $oldValues,
            ['approval_status' => 'cancelled']
        );
        
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
