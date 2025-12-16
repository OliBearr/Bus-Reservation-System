<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactQuery;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact'); // Ensure resources/views/contact.blade.php exists
    }

    public function send(Request $request)
    {
        // 1. Validate the form data
        // Added 'subject' so users can tell you WHAT the issue is about
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255', 
            'message' => 'required|string|min:10',
        ]);

        // 2. Prepare data for the Mailable
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject, // Dynamic subject from form
            'message' => $request->message
        ];

        // 3. Send Email via Brevo (SMTP)
        try {
            // Recipient: Ensure this is the email you want to receive alerts at
            Mail::to('busph.help@gmail.com')->send(new ContactQuery($data));
            
            return back()->with('success', 'Thank you! Your message has been sent successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging if needed: \Log::error($e->getMessage());
            return back()->with('error', 'Network error: Message could not be sent. Please try again later.');
        }
    }
}