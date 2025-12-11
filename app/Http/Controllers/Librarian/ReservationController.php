<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Holding;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of book reservations/requests
     */
    public function index()
    {
        $libraryId = Auth::user()->library_id;
        
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

        AuditLog::log(
            'approve',
            'Borrowing',
            "Approved book reservation for member {$borrowing->member->user->name} - Book: {$borrowing->holding->title}",
            $borrowing->id,
            ['status' => 'pending'],
            ['status' => 'reserved']
        );

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

        $reason = $request->input('reason', 'No reason provided');
        $borrowing->update([
            'status' => 'rejected',
            'notes' => ($borrowing->notes ?? '') . "\nRejected: " . $reason
        ]);

        AuditLog::log(
            'reject',
            'Borrowing',
            "Rejected book reservation for member {$borrowing->member->user->name} - Book: {$borrowing->holding->title} - Reason: {$reason}",
            $borrowing->id,
            ['status' => 'pending'],
            ['status' => 'rejected', 'reason' => $reason]
        );

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

        AuditLog::log(
            'borrow',
            'Borrowing',
            "Member {$borrowing->member->user->name} borrowed book: {$borrowing->holding->title}",
            $borrowing->id,
            ['status' => 'reserved'],
            ['status' => 'borrowed', 'borrowed_date' => now()->toDateTimeString()]
        );

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

        AuditLog::log(
            'return',
            'Borrowing',
            "Member {$borrowing->member->user->name} returned book: {$borrowing->holding->title}",
            $borrowing->id,
            ['status' => 'borrowed'],
            ['status' => 'returned', 'return_date' => now()->toDateTimeString()]
        );

        return back()->with('success', 'Book marked as returned successfully!');
    }
}
