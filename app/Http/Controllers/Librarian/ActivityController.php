<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\AuditLog;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $libraryId = Auth::user()->library_id;
        $query = Activity::where('library_id', $libraryId);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        $perPage = $request->input('perPage', 10);
        $activities = $query->latest()->paginate($perPage)->appends(['search' => $request->search]);
        
        // Calculate statistics
        $stats = [
            'total' => Activity::where('library_id', $libraryId)->count(),
            'pending' => Activity::where('library_id', $libraryId)->where('approval_status', 'pending')->count(),
            'approved' => Activity::where('library_id', $libraryId)->where('approval_status', 'approved')->count(),
            'rejected' => Activity::where('library_id', $libraryId)->where('approval_status', 'rejected')->count(),
            'upcoming' => Activity::where('library_id', $libraryId)
                ->where('approval_status', 'approved')
                ->where(function($q) {
                    $q->where('start_date', '>=', now())
                      ->orWhere(function($q2) {
                          $q2->whereNull('start_date')
                             ->where('activity_date', '>=', now());
                      });
                })->count(),
            'this_month' => Activity::where('library_id', $libraryId)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
        
        return view('librarian.activities.index', compact('activities', 'stats'));
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

        // Notify all super admins about new activity submission
        NotificationService::notifyAdmins(
            'activity_submission',
            'New Activity Submitted',
            "New activity '{$activity->title}' has been submitted for approval.",
            route('admin.activities.index')
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

        // Only allow editing pending activities
        if ($activity->approval_status !== 'pending') {
            return redirect()->route('librarian.activities.index')
                ->with('error', 'Only pending activities can be edited.');
        }

        return view('librarian.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        // Check if activity belongs to librarian's library
        if ($activity->library_id != Auth::user()->library_id) {
            abort(403);
        }

        // Only allow updating pending activities
        if ($activity->approval_status !== 'pending') {
            return redirect()->route('librarian.activities.index')
                ->with('error', 'Only pending activities can be updated.');
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
