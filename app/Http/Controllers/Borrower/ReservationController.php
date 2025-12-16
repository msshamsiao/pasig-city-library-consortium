<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function index()
    {
        // Get member record
        $member = \App\Models\Member::where('user_id', Auth::id())->first();
        
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
        $member = \App\Models\Member::where('user_id', Auth::id())->first();
        
        if (!$member) {
            // Log for debugging
            Log::info('Member not found for user_id: ' . Auth::id() . ', email: ' . Auth::user()->email);
            
            return redirect()->route('borrower.reservations.index')
                ->with('error', 'You must be a registered member to reserve books. Please contact the librarian. (User ID: ' . Auth::id() . ')');
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

        $borrowing = \App\Models\Borrowing::create([
            'holding_id' => $validated['holding_id'],
            'member_id' => $member->id,
            'borrowed_date' => $borrowDate,
            'due_date' => $dueDate,
            'status' => 'pending',
            'notes' => 'Reservation request via online system. Scheduled pickup: ' . $borrowDate,
        ]);

        AuditLog::log(
            'create',
            'Borrowing',
            "Member " . Auth::user()->name . " requested reservation for book: {$holding->title}",
            $borrowing->id,
            null,
            ['holding_id' => $holding->id, 'book_title' => $holding->title, 'status' => 'pending', 'scheduled_pickup' => $borrowDate]
        );

        // Notify librarian of the book's library about new reservation request
        if ($holding->library_id) {
            NotificationService::notifyLibraryLibrarian(
                $holding->library_id,
                'new_reservation',
                'New Book Reservation',
                Auth::user()->name . " requested to borrow '{$holding->title}'. Scheduled pickup: " . date('M d, Y h:i A', strtotime($borrowDate)),
                route('librarian.reservations.index')
            );
        }

        return redirect()->route('borrower.reservations.index')
            ->with('success', 'Reservation request submitted successfully! Please wait for librarian approval.');
    }

    public function destroy($reservation)
    {
        $borrowing = \App\Models\Borrowing::findOrFail($reservation);
        
        // Get member record
        $member = \App\Models\Member::where('user_id', Auth::id())->first();
        
        // Verify the reservation belongs to the current user
        if (!$member || $borrowing->member_id != $member->id) {
            return back()->with('error', 'You can only cancel your own reservations.');
        }
        
        // Only allow canceling pending reservations
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'You can only cancel pending reservations.');
        }
        
        $holding = $borrowing->holding;
        $bookTitle = $holding->title;
        $libraryId = $holding->library_id;
        
        // Update status to cancelled instead of deleting
        $borrowing->update([
            'status' => 'cancelled',
            'notes' => ($borrowing->notes ?? '') . "\nCancelled by member on " . now()->format('M d, Y h:i A')
        ]);
        
        AuditLog::log(
            'cancel',
            'Borrowing',
            "Member " . Auth::user()->name . " cancelled reservation for book: {$bookTitle}",
            $borrowing->id,
            ['status' => 'pending'],
            ['status' => 'cancelled']
        );
        
        // Notify librarian about cancellation
        if ($libraryId) {
            NotificationService::notifyLibraryLibrarian(
                $libraryId,
                'reservation_cancelled',
                'Reservation Cancelled',
                Auth::user()->name . " cancelled their reservation for '{$bookTitle}'.",
                route('librarian.reservations.index')
            );
        }
        
        return back()->with('success', 'Reservation cancelled successfully.');
    }
}
