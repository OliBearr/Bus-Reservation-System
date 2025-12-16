<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'valid_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendEmailVerificationNotification()
    {
        $url = $this->verificationUrl();

        BrevoMailService::send(
            $this->email,
            'Verify your email – BusPH',
            "<p>Click the link below to verify your email:</p>
             <a href='{$url}'>Verify Email</a>"
        );
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\BrevoResetPassword($token));
    }
}
