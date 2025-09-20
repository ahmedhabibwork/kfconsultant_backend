<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportBooking extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'destination',
        'trip_date',
        'trip_time',
        'people_count',
        'car_type',
        'special_requests',
    ];


    protected $casts = [
        'trip_date' => 'date',
        'trip_time' => 'datetime:H:i',
    ];
}
