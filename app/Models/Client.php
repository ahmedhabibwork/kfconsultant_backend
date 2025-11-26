<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Str;

class Client extends Model
{
    use HasFactory, HasTranslations,  SoftDeletes;
    public $translatable = ['title'];
    protected $fillable = [
        'title',
        'image',
        'slug'
    ];
    protected static function booted(): void
    {
        static::creating(function (Client $item) {
            $slug = Str::slug($item->title);
            $originalSlug = $slug;
            $counter = 1;
            // Check if the slug already exists in the database
            while (Client::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            // Assign the unique slug
            $item->slug = $slug;
        });

        static::updating(function (Client $item) {

            if ($item->isDirty('title')) { // Check if title is being updated
                $slug = Str::slug($item->title);
                $originalSlug = $slug;
                $counter = 1;
                // Check if the slug already exists, but ignore the current record
                while (Client::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                // Assign the unique slug
                $item->slug = $slug;
            }
        });
    }
}
