<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'valid_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function sendEmailVerificationNotification()
    {
        // 1. Generate the secure verification link
        $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            \Carbon\Carbon::now()->addMinutes(60),
            ['id' => $this->getKey(), 'hash' => sha1($this->getEmailForVerification())]
        );

        // 2. Send the email directly to Resend's API
        \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Bearer ' . env('RESEND_KEY'),
            'Content-Type' => 'application/json'
        ])->post('https://api.resend.com/emails', [
            'from' => 'onboarding@resend.dev', // You must use this until you verify a domain
            'to' => $this->email,
            'subject' => 'Verify Your Email Address',
            'html' => '<p>Click the link below to verify your email address:</p>
                       <a href="'.$url.'">'.$url.'</a>'
        ]);
    }
}
