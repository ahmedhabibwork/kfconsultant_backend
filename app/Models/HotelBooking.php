<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\RoomTypeEnum;

class HotelBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hotel_bookings';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'arrival_date',
        'departure_date',
        'people_count',
        'room_type',
        'special_requests',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'arrival_date'   => 'date',
        'departure_date' => 'date',
        'room_type'      => RoomTypeEnum::class, // Laravel 9+ enum casting
    ];
}
