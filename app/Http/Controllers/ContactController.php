<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        // 1. Validate
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $adminEmail = 'busph.help@gmail.com';

        try {
            // ✅ CHANGED: We now use 'Mail::send' to use the HTML template
            // We pass the validated data to the view using ['data' => $validated]
            Mail::send('emails.contact', ['data' => $validated], function ($message) use ($adminEmail, $validated) {
                $message->to($adminEmail)
                        ->subject('Contact Form: ' . $validated['subject'])
                        ->replyTo($validated['email'], $validated['name']);
            });

            return back()->with('success', 'Thank you! Your message has been sent successfully.');

        } catch (\Exception $e) {
            // Optional: Log error
            // \Log::error('Contact Mail Error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to send message. Please try again later.');
        }
    }
}