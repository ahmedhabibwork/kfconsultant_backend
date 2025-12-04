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
            $slug = Str::slug($item->title);
            $originalSlug = $slug;
            $counter = 1;
            // Check if the slug already exists in the database
            while (Blog::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            // Assign the unique slug
            $item->slug = $slug;
        });

        static::updating(function (Blog $item) {

            if ($item->isDirty('title')) { // Check if title is being updated
                $slug = Str::slug($item->title);
                $originalSlug = $slug;
                $counter = 1;
                // Check if the slug already exists, but ignore the current record
                while (Blog::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                // Assign the unique slug
                $item->slug = $slug;
            }
        });
    }
}
