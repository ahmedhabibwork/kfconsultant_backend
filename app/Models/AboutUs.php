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
        'image',
        'experience_years',
        'experts',
        'clients',
        'projects',
        'phone',

    ];
    protected $casts = [
        'image' => 'string',
    ];
}
