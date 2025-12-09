<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display the service/booking page with user's previous requests.
     */
    public function index()
    {
        // TODO: Fetch user's previous requests from database when implemented
        // $requests = BookRequest::where('user_id', auth()->id())->latest()->get();
        
        $requests = []; // Placeholder - empty array for now
        
        return view('service', compact('requests'));
    }

    /**
     * Store a new book/resource request with full validation.
     */
    public function store(Request $request)
    {
        // Validate the incoming request with custom error messages
        $validator = Validator::make($request->all(), [
            'material_type' => 'required|string|in:book,journal,cd,ebook',
            'date_schedule' => 'required|date|after_or_equal:today',
            'date_time' => 'required|string',
        ], [
            'material_type.required' => 'Please select a material type.',
            'material_type.in' => 'Invalid material type selected.',
            'date_schedule.required' => 'Please provide a schedule date.',
            'date_schedule.date' => 'Please provide a valid date.',
            'date_schedule.after_or_equal' => 'Schedule date must be today or a future date.',
            'date_time.required' => 'Please provide a time.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // TODO: Save to database when implemented
        // Example:
        // BookRequest::create([
        //     'user_id' => auth()->id(),
        //     'material_type' => $validated['material_type'],
        //     'date_schedule' => $validated['date_schedule'],
        //     'date_time' => $validated['date_time'],
        //     'status' => 'pending',
        //     'created_at' => now(),
        // ]);

        // Redirect back with success message
        return redirect()->route('service')
            ->with('success', 'Your request has been submitted successfully! We will contact you soon.');
    }

    /**
     * Display list of user's requests (for LIST tab).
     */
    public function list()
    {
        // TODO: Fetch user's requests from database when implemented
        // $requests = BookRequest::where('user_id', auth()->id())
        //     ->latest()
        //     ->paginate(10);
        
        $requests = []; // Placeholder
        
        return view('service', compact('requests'));
    }

    /**
     * Cancel a specific request.
     */
    public function cancel($id)
    {
        // TODO: Update request status in database when implemented
        // $request = BookRequest::findOrFail($id);
        // 
        // // Check if user owns this request
        // if ($request->user_id !== auth()->id()) {
        //     abort(403, 'Unauthorized action.');
        // }
        // 
        // $request->update(['status' => 'cancelled']);

        return redirect()->route('service')
            ->with('success', 'Request cancelled successfully.');
    }

    /**
     * Update a specific request.
     */
    public function update(Request $request, $id)
    {
        // TODO: Implement when you have database
        // $bookRequest = BookRequest::findOrFail($id);
        // 
        // // Check if user owns this request
        // if ($bookRequest->user_id !== auth()->id()) {
        //     abort(403, 'Unauthorized action.');
        // }
        //
        // $validated = $request->validate([
        //     'material_type' => 'required|string|in:book,journal,cd,ebook',
        //     'date_schedule' => 'required|date|after_or_equal:today',
        //     'date_time' => 'required|string',
        // ]);
        //
        // $bookRequest->update($validated);

        return redirect()->route('service')
            ->with('success', 'Request updated successfully.');
    }
}
