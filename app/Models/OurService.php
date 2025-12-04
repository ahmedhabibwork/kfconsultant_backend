<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class OurService extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;
    // public $translatable = ['title', 'description'];
    protected $fillable = [
        'slug',
        'title',
        'description',
        'image'
    ];
    protected static function booted(): void
    {

        static::creating(function (OurService $item) {
            $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
            $originalSlug = $slug;
            $counter = 1;

            while (OurService::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
        });

        static::updating(function (OurService $item) {
            // if ($item->isDirty('title')) {
            $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
            $originalSlug = $slug;
            $counter = 1;

            while (OurService::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
            //  }
        });
    }
}
