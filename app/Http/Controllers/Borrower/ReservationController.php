<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = BookRequest::where('user_id', auth()->id())
            ->with('book')
            ->latest()
            ->paginate(20);
        
        return view('borrower.reservations.index', compact('reservations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'request_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        // Check if book is available
        if ($book->available_quantity <= 0) {
            return back()->with('error', 'This book is currently not available.');
        }

        // Check if user already has pending request for this book
        $existingRequest = BookRequest::where('user_id', auth()->id())
            ->where('book_id', $validated['book_id'])
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You already have a pending request for this book.');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        BookRequest::create($validated);

        return redirect()->route('borrower.reservations.index')
            ->with('success', 'Book reservation submitted successfully.');
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

        $reservation->update(['status' => 'cancelled']);

        return back()->with('success', 'Reservation cancelled successfully.');
    }
}
