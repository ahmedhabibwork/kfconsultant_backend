<?php

namespace App\Models;

use App\Enums\ClassTypeEnum;
use App\Enums\TicketTypeEnum;
use Illuminate\Database\Eloquent\Model;

class FlightBooking extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'ticket_type',
        'origin',
        'destination',
        'class_type',
        'adults',
        'children',
        'infants',
        'departure_date',
        'return_date',
    ];

    protected $casts = [
        'ticket_type' => TicketTypeEnum::class,
        'class_type' => ClassTypeEnum::class,
        'departure_date' => 'date',
        'return_date' => 'date',
    ];
}
