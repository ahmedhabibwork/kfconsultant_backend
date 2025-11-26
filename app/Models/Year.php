<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\LaravelPackageTools\Concerns\Package\HasTranslations;

class Year extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;
    protected $fillable = [
        "id",
        "title",
        "slug"
    ];
    protected static function booted(): void
    {

        static::creating(function (Year $item) {
            $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
            $originalSlug = $slug;
            $counter = 1;

            while (Year::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
        });

        static::updating(function (Year $item) {
            if ($item->isDirty('title')) {
                $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
                $originalSlug = $slug;
                $counter = 1;

                while (Year::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $item->slug = $slug;
            }
        });
    }
}
