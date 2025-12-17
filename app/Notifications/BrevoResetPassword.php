<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage; // 👈 IMPORTANT: Add this import

class BrevoResetPassword extends Notification
{
    public function __construct(public string $token) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Generate the URL
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ], false));

        // ✅ FIX: Return the MailMessage object
        // Laravel will automatically send this using the 'brevo' mailer you configured.
        return (new MailMessage)
            ->subject('Reset your password – BusPH')
            ->greeting('Hello!')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $url)
            ->line('If you did not request a password reset, no further action is required.');
    }
}