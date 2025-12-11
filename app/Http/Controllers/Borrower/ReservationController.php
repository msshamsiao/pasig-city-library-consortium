<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = BookRequest::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);
        
        return view('borrower.reservations.index', compact('reservations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_type' => 'required|in:book,journal,cd,ebook',
            'date_schedule' => 'required|date|after_or_equal:today',
            'date_time' => 'required',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        BookRequest::create($validated);

        return redirect()->route('borrower.reservations.index')
            ->with('success', 'Reservation request submitted successfully. Please wait for librarian approval.');
    }

    public function destroy(BookRequest $reservation)
    {
        // Check if reservation belongs to current user
        if ($reservation->user_id != auth()->id()) {
            abort(403);
        }

        // Only allow cancelling pending requests
        if ($reservation->status != 'pending') {
            return back()->with('error', 'You can only cancel pending reservations.');
        }

        $reservation->delete();

        return back()->with('success', 'Reservation cancelled successfully.');
    }
}
