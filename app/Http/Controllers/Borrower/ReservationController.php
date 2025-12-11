<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        // Get member record
        $member = \App\Models\Member::where('user_id', auth()->id())->first();
        
        if (!$member) {
            $reservations = collect();
        } else {
            // Get borrowings with reserved status
            $reservations = \App\Models\Borrowing::with('holding')
                ->where('member_id', $member->id)
                ->whereIn('status', ['reserved', 'borrowed'])
                ->latest()
                ->get();
        }
        
        return view('borrower.reservations.index', compact('reservations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'holding_id' => 'required|exists:holdings,id',
            'date_schedule' => 'required|date|after_or_equal:today',
            'date_time' => 'required',
        ]);

        // Check if user has a member record
        $member = \App\Models\Member::where('user_id', auth()->id())->first();
        
        if (!$member) {
            return redirect()->route('borrower.reservations.index')
                ->with('error', 'You must be a registered member to reserve books. Please contact the librarian.');
        }

        // Check if the holding is available
        $holding = \App\Models\Holding::findOrFail($validated['holding_id']);
        
        if ($holding->available_copies < 1) {
            return redirect()->route('borrower.reservations.index')
                ->with('error', 'This book is currently not available for reservation.');
        }

        // Create borrowing record with reserved status
        $borrowDate = $validated['date_schedule'] . ' ' . $validated['date_time'];
        $dueDate = date('Y-m-d', strtotime($borrowDate . ' + 14 days'));

        \App\Models\Borrowing::create([
            'holding_id' => $validated['holding_id'],
            'member_id' => $member->id,
            'borrowed_date' => $borrowDate,
            'due_date' => $dueDate,
            'status' => 'reserved',
            'notes' => 'Reserved via online system. Scheduled pickup: ' . $borrowDate,
        ]);

        return redirect()->route('borrower.reservations.index')
            ->with('success', 'Book reserved successfully! Please pick it up on your scheduled date and time.');
    }

    public function destroy($reservation)
    {
        // Book requests functionality has been removed
        return back()->with('error', 'Book requests functionality is no longer available.');
    }
}
