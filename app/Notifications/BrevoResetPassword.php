<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Services\BrevoMailService;

class BrevoResetPassword extends Notification
{
    public function __construct(public string $token) {}

    public function via($notifiable)
    {
        return ['mail']; // channel required, but we override send
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ], false));

        BrevoMailService::send(
            $notifiable->email,
            'Reset your password – BusPH',
            "<p>Reset your password:</p>
             <a href='{$url}'>Reset Password</a>"
        );
    }
}
