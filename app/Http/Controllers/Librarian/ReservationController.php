<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Holding;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of book reservations/requests
     */
    public function index()
    {
        $libraryId = auth()->user()->library_id;
        
        $reservations = Borrowing::with(['holding.library', 'member.user'])
            ->whereIn('status', ['pending', 'reserved', 'borrowed'])
            ->when($libraryId, function($q) use ($libraryId) {
                return $q->whereHas('holding', function($query) use ($libraryId) {
                    $query->where('holding_branch_id', $libraryId);
                });
            })
            ->latest()
            ->paginate(20);

        return view('librarian.reservations.index', compact('reservations'));
    }

    /**
     * Approve a reservation request
     */
    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Only pending reservations can be approved.');
        }

        $borrowing->update(['status' => 'reserved']);

        return back()->with('success', 'Reservation approved successfully!');
    }

    /**
     * Reject a reservation request
     */
    public function reject(Request $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Only pending reservations can be rejected.');
        }

        $borrowing->update([
            'status' => 'rejected',
            'notes' => ($borrowing->notes ?? '') . "\nRejected: " . $request->input('reason', 'No reason provided')
        ]);

        return back()->with('success', 'Reservation rejected.');
    }

    /**
     * Mark as borrowed (book picked up)
     */
    public function borrowed($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        
        if ($borrowing->status !== 'reserved') {
            return back()->with('error', 'Only reserved books can be marked as borrowed.');
        }

        $borrowing->update([
            'status' => 'borrowed',
            'borrowed_date' => now()
        ]);

        // Update available copies
        $holding = $borrowing->holding;
        if ($holding && $holding->available_copies > 0) {
            $holding->decrement('available_copies');
        }

        return back()->with('success', 'Book marked as borrowed successfully!');
    }

    /**
     * Mark as returned
     */
    public function returned($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        
        if ($borrowing->status !== 'borrowed') {
            return back()->with('error', 'Only borrowed books can be marked as returned.');
        }

        $borrowing->update([
            'status' => 'returned',
            'return_date' => now()
        ]);

        // Update available copies
        $holding = $borrowing->holding;
        if ($holding) {
            $holding->increment('available_copies');
        }

        return back()->with('success', 'Book marked as returned successfully!');
    }
}
