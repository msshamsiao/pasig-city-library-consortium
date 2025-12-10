<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BorrowerDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'active_reservations' => 0,
            'books_borrowed' => 0,
            'books_read' => 0,
        ];

        $currentBorrowings = [];
        $activeReservations = [];

        return view('borrower.dashboard', compact('stats', 'currentBorrowings', 'activeReservations'));
    }
}
