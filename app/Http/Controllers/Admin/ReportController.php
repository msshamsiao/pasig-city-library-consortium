<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // TODO: Add report statistics
        return view('admin.reports.index');
    }

    public function export()
    {
        // TODO: Implement export functionality
        return redirect()->back()->with('success', 'Report exported successfully!');
    }
}
