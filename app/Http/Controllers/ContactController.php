<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactQuery;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact'); // Ensure your view file is named 'contact.blade.php'
    }

    public function send(Request $request)
    {
        // 1. Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        // 2. Prepare data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => 'BusPH Inquiry', // You can add a subject field if you want
            'message' => $request->message
        ];

        // 3. Send Email to Admin (busph.help@gmail.com)
        // We use try-catch to prevent crashing if internet is slow/smtp fails
        try {
            Mail::to('busph.help@gmail.com')->send(new ContactQuery($data));
            return back()->with('success', 'Thank you! Your message has been sent successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Message could not be sent. Please try again later.');
        }
    }
}