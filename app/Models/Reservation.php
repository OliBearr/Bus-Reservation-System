<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_id',
        'seat_number',
        'status',
        'cancellation_status',
        'cancellation_reason',
        'transaction_id',
        'payment_method',
    ];

    // Relationship: A reservation belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: A reservation belongs to a Schedule
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}