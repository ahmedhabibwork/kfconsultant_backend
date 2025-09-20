<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactInfo extends Model
{
    use HasFactory,  SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'address',
        'phone1',
        'phone2',
        'email',
        'facebook_link',
        'instagram_link',
        'map_link',
        'whatsapp_number',
    ];
}
