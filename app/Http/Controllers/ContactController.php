<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        $departments = [
            'MIS' => 'Management Information Systems',
            'circulation' => 'Circulation Department',
            'reference' => 'Reference Department',
            'technical' => 'Technical Services',
            'admin' => 'Administration',
            'digital' => 'Digital Resources'
        ];

        return view('contact', compact('departments'));
    }

    /**
     * Submit contact form and save to database.
     */
    public function submit(Request $request)
    {
        // Validate the form
        $validator = Validator::make($request->all(), [
            'department' => 'required|string',
            'subject' => 'required|string|max:255',
            'from' => 'required|email',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ], [
            'department.required' => 'Please select a department.',
            'subject.required' => 'Please provide a subject.',
            'from.required' => 'Please provide your email address.',
            'from.email' => 'Please provide a valid email address.',
            'email.required' => 'Please provide your email address.',
            'email.email' => 'Please provide a valid email address.',
            'message.required' => 'Please write your message.',
            'message.min' => 'Message must be at least 10 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // Save message to database
        ContactMessage::create([
            'department' => $validated['department'],
            'subject' => $validated['subject'],
            'from_email' => $validated['from'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'status' => 'unread',
        ]);

        // TODO: Send email notification
        // Mail::to($this->getDepartmentEmail($validated['department']))
        //     ->send(new ContactMail($validated));

        return redirect()->route('contact')
            ->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }

    /**
     * Get department email address.
     */
    private function getDepartmentEmail($department)
    {
        $emails = [
            'MIS' => 'mis@pasigcity.gov.ph',
            'circulation' => 'circulation@pasigcity.gov.ph',
            'reference' => 'reference@pasigcity.gov.ph',
            'technical' => 'technical@pasigcity.gov.ph',
            'admin' => 'admin@pasigcity.gov.ph',
            'digital' => 'digital@pasigcity.gov.ph',
        ];

        return $emails[$department] ?? 'info@pasigcity.gov.ph';
    }
}
