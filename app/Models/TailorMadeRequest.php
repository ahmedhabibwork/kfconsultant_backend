<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TailorMadeRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'duration',
        'travel_date',
        'preferred_contact_time',
        'ideal_trip_length',
        'additional_info',
    ];


    protected $casts = [
        'travel_date' => 'date',
    ];
}
