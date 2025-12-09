<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        return view('admin.statistics');
    }

    public function export()
    {
        // Export logic
        return response()->download('path/to/file');
    }
}
