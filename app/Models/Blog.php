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
        'published_date' => 'datetime',
    ];
    protected $fillable = [
        'title',
        'category_id',
        'short_description',
        'meta_title',
        'meta_description',
        'description',
        'is_published',
        'is_popular',
        'images',
        'slug',
        'published_date',
    ];
    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Blog $item) {
            // If slug is empty, generate from title
            if (empty($item->slug)) {
                $slug = str_replace(' ', '-', $item->title); // keep Arabic letters
            } else {
                $slug = str_replace(' ', '-', $item->slug);
            }

            $originalSlug = $slug;
            $counter = 1;

            while (Blog::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
        });

        static::updating(function (Blog $item) {
            // If slug is empty, regenerate from title
            if (empty($item->slug)) {
                $slug = str_replace(' ', '-', $item->title);
            } elseif ($item->isDirty('slug')) {
                // If slug manually updated
                $slug = str_replace(' ', '-', $item->slug);
            } elseif ($item->isDirty('title')) {
                // If title changed but slug was never manually set
                $slug = str_replace(' ', '-', $item->title);
            } else {
                return; // no change needed
            }

            $originalSlug = $slug;
            $counter = 1;

            while (Blog::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
        });
    }
}
