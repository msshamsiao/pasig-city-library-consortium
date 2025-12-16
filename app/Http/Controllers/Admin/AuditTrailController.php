<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditTrailController extends Controller
{
    public function index(Request $request)
    {
        // Get audit logs from database (assuming you have an audit_logs table)
        // If not, you can track actions through activity_log or create one
        
        $query = DB::table('activity_log')
            ->join('users', 'activity_log.user_id', '=', 'users.id')
            ->leftJoin('libraries', 'users.library_id', '=', 'libraries.id')
            ->select(
                'activity_log.*',
                'users.name as user_name',
                'users.email as user_email',
                'libraries.acronym as library_acronym'
            )
            ->orderBy('activity_log.created_at', 'desc');

        // Filter by date range if provided
        if ($request->has('start_date')) {
            $query->where('activity_log.created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->where('activity_log.created_at', '<=', $request->end_date);
        }

        // Filter by user if provided
        if ($request->has('user_id')) {
            $query->where('activity_log.user_id', $request->user_id);
        }

        // Filter by action type if provided
        if ($request->has('action')) {
            $query->where('activity_log.action', $request->action);
        }

        $perPage = $request->input('perPage', 10);
        $auditLogs = $query->paginate($perPage);

        // Get filter options
        $users = DB::table('users')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        $actions = DB::table('activity_log')
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('admin.audit-trail.index', compact('auditLogs', 'users', 'actions'));
    }
}
