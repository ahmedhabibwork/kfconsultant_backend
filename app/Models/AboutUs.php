<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AboutUs extends Model
{
    use HasFactory,  SoftDeletes;
    protected $fillable = [
        'title',
        'short_description',
        'description',
        'experience_years',
        'experts',
        'clients',
        'projects',
        'mission',
        'vision',
        'our_founder',
        'our_founder_image',
        'mission_image',
        'vision_image',

    ];
    protected $casts = [
        'our_founder_image' => 'string',
        'mission_image' => 'string',
        'vision_image' => 'string',
    ];
}
