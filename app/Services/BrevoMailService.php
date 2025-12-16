<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoMailService
{
    /**
     * Send email via Brevo SMTP API
     */
    public static function send(string $to, string $subject, string $html): bool
    {
        try {
            $response = Http::timeout(10)
                ->retry(3, 1000)
                ->withHeaders([
                    'api-key' => config('services.brevo.api_key'),
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.brevo.com/v3/smtp/email', [
                    'sender' => [
                        'email' => config('services.brevo.sender_email'),
                        'name'  => config('services.brevo.sender_name'),
                    ],
                    'to' => [
                        ['email' => $to],
                    ],
                    'subject' => $subject,
                    'htmlContent' => $html,
                ]);

            if (! $response->successful()) {
                Log::error('Brevo email failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                    'to'     => $to,
                    'subject'=> $subject,
                ]);
            }

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('Brevo exception', [
                'message' => $e->getMessage(),
                'to'      => $to,
                'subject' => $subject,
            ]);
            return false;
        }
    }
}
