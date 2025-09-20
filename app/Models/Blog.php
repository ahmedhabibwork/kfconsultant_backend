<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Blog extends Model
{
    use HasFactory,  SoftDeletes;
    protected $casts = [
        'images' => 'array',
    ];
    protected $fillable = [
        'title',
        'category_id',
        'short_description',
        'meta_title',
        'meta_description',
        'description',
        'is_published',
        'images',
        'slug',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    protected static function booted(): void
    {

        static::creating(function (Blog $item) {
            $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
            $originalSlug = $slug;
            $counter = 1;

            while (Blog::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
        });

        static::updating(function (Blog $item) {
            if ($item->isDirty('title')) {
                $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
                $originalSlug = $slug;
                $counter = 1;

                while (Blog::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $item->slug = $slug;
            }
        });
    }
}
