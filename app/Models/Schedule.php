<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'route_id',
        'departure_time',
        'arrival_time',
        'available',
    ];

    // Relationship: A Schedule belongs to one Bus
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    // Relationship: A Schedule belongs to one Route
    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}