<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoMailService
{
    public static function send(string $to, string $subject, string $html): bool
    {
        try {
            $response = Http::timeout(10)  // max 10 seconds
                ->retry(2, 1000)          // retry twice, 1s apart
                ->withHeaders([
                    'api-key' => config('services.brevo.key'),
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
                Log::error('Brevo send failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('Brevo exception', [
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
