<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BrevoMailService;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $subject = $request->subject;
        $html = "<p><strong>From:</strong> {$request->name} ({$request->email})</p>
                 <p><strong>Message:</strong><br>{$request->message}</p>";

        if (BrevoMailService::send('busph.help@gmail.com', $subject, $html)) {
            return back()->with('success', 'Thank you! Your message has been sent successfully.');
        } else {
            return back()->with('error', 'Failed to send message. Please try again later.');
        }
    }
}
