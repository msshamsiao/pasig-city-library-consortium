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
            'book_info' => 'nullable|string',
        ]);

        // Store book information in admin_notes if provided
        if (!empty($validated['book_info'])) {
            $bookInfo = json_decode($validated['book_info'], true);
            if ($bookInfo) {
                $infoText = "Material: " . ($bookInfo['title'] ?? 'N/A');
                if (!empty($bookInfo['author'])) {
                    $infoText .= "\nAuthor: " . $bookInfo['author'];
                }
                if (!empty($bookInfo['isbn'])) {
                    $infoText .= "\nISBN: " . $bookInfo['isbn'];
                }
                $validated['admin_notes'] = $infoText;
            }
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';
        unset($validated['book_info']); // Remove book_info as it's not a database field

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
