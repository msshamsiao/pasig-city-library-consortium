<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Book;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        // Get archived/inactive records from different models
        $archivedLibraries = Library::where('is_active', false)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        $archivedBooks = Book::onlyTrashed()
            ->with('library')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        $archivedActivities = Activity::onlyTrashed()
            ->with('library')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        $archivedUsers = User::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('admin.archive.index', compact(
            'archivedLibraries',
            'archivedBooks',
            'archivedActivities',
            'archivedUsers'
        ));
    }
}
