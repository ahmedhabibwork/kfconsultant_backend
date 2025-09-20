<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'adults',
        'children',
        'infants',
        'preferred_travel_date',
        'message',
        'trip_id',
    ];


    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
