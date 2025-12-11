<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivitiesController extends Controller
{
    /**
     * Display active library activities, events, and news.
     * Only shows activities within their start date and end date range.
     */
    public function index()
    {
        $today = Carbon::today();
        
        // Get activities where today is between start_date and end_date
        // Only show published and approved activities
        $activities = Activity::with('library')
            ->where('is_published', true)
            ->where('approval_status', 'approved')
            ->where(function($query) use ($today) {
                $query->whereDate('start_date', '<=', $today)
                      ->whereDate('end_date', '>=', $today);
            })
            ->orderBy('start_date', 'desc')
            ->get();
        
        return view('activities', compact('activities'));
    }
}
