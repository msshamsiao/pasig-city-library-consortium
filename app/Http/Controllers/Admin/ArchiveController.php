<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Holding;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        
        // Get archived/inactive records from different models
        $archivedLibraries = Library::where('is_active', false)
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);

        $archivedBooks = Holding::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        $archivedActivities = Activity::onlyTrashed()
            ->with('library')
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        $archivedUsers = User::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        return view('admin.archive.index', compact(
            'archivedLibraries',
            'archivedBooks',
            'archivedActivities',
            'archivedUsers'
        ));
    }
}
