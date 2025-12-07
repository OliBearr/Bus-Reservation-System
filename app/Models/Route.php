<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    // This property tells Laravel which columns are safe to save
    protected $fillable = [
        'origin',
        'destination',
        'price',
    ];
}