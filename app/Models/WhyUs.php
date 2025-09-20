<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhyUs extends Model
{
      use HasFactory,  SoftDeletes;
    protected $fillable = [
        'title',
        'short_description',
        'description',
        'image',

    ];
    protected $casts = [
        'image' => 'string',
    ];
}
