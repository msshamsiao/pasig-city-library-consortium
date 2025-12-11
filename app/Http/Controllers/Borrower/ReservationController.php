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
            $reservations = \App\Models\Borrowing::whereNull('id')->paginate(10);
        } else {
            // Get borrowings with pending, reserved, or borrowed status
            $reservations = \App\Models\Borrowing::with('holding')
                ->where('member_id', $member->id)
                ->whereIn('status', ['pending', 'reserved', 'borrowed'])
                ->latest()
                ->paginate(10);
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
            // Log for debugging
            \Log::info('Member not found for user_id: ' . auth()->id() . ', email: ' . auth()->user()->email);
            
            return redirect()->route('borrower.reservations.index')
                ->with('error', 'You must be a registered member to reserve books. Please contact the librarian. (User ID: ' . auth()->id() . ')');
        }

        // Check if the holding is available
        $holding = \App\Models\Holding::findOrFail($validated['holding_id']);
        
        if ($holding->available_copies < 1) {
            return redirect()->route('borrower.reservations.index')
                ->with('error', 'This book is currently not available for reservation.');
        }

        // Create borrowing record with pending status
        $borrowDate = $validated['date_schedule'] . ' ' . $validated['date_time'];
        $dueDate = date('Y-m-d', strtotime($borrowDate . ' + 14 days'));

        \App\Models\Borrowing::create([
            'holding_id' => $validated['holding_id'],
            'member_id' => $member->id,
            'borrowed_date' => $borrowDate,
            'due_date' => $dueDate,
            'status' => 'pending',
            'notes' => 'Reservation request via online system. Scheduled pickup: ' . $borrowDate,
        ]);

        return redirect()->route('borrower.reservations.index')
            ->with('success', 'Reservation request submitted successfully! Please wait for librarian approval.');
    }

    public function destroy($reservation)
    {
        // Book requests functionality has been removed
        return back()->with('error', 'Book requests functionality is no longer available.');
    }
}
