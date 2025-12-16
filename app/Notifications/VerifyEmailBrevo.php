<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use App\Services\BrevoMailService;

class VerifyEmailBrevo extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $verifyUrl = $this->verificationUrl($notifiable);

        app(BrevoMailService::class)->send(
            $notifiable->email,
            'Verify your BusPH account',
            view('emails.verify', ['url' => $verifyUrl])->render()
        );
    }
}
