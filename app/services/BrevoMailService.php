<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BrevoMailService
{
    public function send($to, $subject, $html)
    {
        return Http::withHeaders([
            'api-key' => config('services.brevo.key'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => config('mail.from.name'),
                'email' => config('mail.from.address'),
            ],
            'to' => [
                ['email' => $to],
            ],
            'subject' => $subject,
            'htmlContent' => $html,
        ]);
    }
}
