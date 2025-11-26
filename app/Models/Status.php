<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $fillable = [
        "id",
        "title",
        "slug"
    ];
    protected static function booted(): void
    {

        static::creating(function (Status $item) {
            $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
            $originalSlug = $slug;
            $counter = 1;

            while (Status::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
        });

        static::updating(function (Status $item) {
            if ($item->isDirty('title')) {
                $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
                $originalSlug = $slug;
                $counter = 1;

                while (Status::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $item->slug = $slug;
            }
        });
    }
}
