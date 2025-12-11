<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AuditLog::with(['user', 'library'])
            ->when($request->filled('user_id'), fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->filled('action'), fn($q) => $q->where('action', $request->action))
            ->when($request->filled('model'), fn($q) => $q->where('model', $request->model))
            ->when($request->filled('library_id'), fn($q) => $q->where('library_id', $request->library_id))
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->latest()
            ->paginate(50);

        // Get unique values for filters
        $users = User::select('id', 'name')->orderBy('name')->get();
        $libraries = Library::select('id', 'name')->orderBy('name')->get();
        $actions = AuditLog::select('action')->distinct()->pluck('action');
        $models = AuditLog::select('model')->distinct()->pluck('model');

        return view('admin.audit-logs.index', compact('logs', 'users', 'libraries', 'actions', 'models'));
    }

    public function show(AuditLog $auditLog)
    {
        $auditLog->load(['user', 'library']);
        return view('admin.audit-logs.show', compact('auditLog'));
    }
}
