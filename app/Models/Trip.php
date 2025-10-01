<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Trip extends Model
{

    use HasFactory, SoftDeletes;
    protected $casts = [
        'images' => 'array',
        'is_popular' => 'boolean',
        'is_best_offer' => 'boolean',
        'departure_time' => 'datetime',
    ];
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'sub_category_id',
        'destination',
        'duration',
        'overview',
        'highlights',
        'itinerary',
        'city_id',
        'accommodation',
        'inclusions',
        'price',
        'images',
        'currency',
        'description',
        'image',
        'map_link',
        'rating',
        'type',
        'is_popular',
        'is_best_offer',
        'is_best_seller',
        'cover_image',
        'meta_title',
        'meta_description',
        'max_people',
        'departure_time',
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_trips');
    }
    public function scopePopular($query)
    {
        return $query->where('is_popular', 1);
    }
    public function scopeActivity($query)
    {
        return $query->where('type', 'activity');
    }
    public function scopeNileCruise($query)
    {
        return $query->where('type', 'nile_cruise');
    }

    public function scopeBestSaller($query)
    {
        return $query->where('is_best_seller', 1);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    protected static function booted(): void
    {
        static::creating(function (Trip $item) {
            // If slug is empty, generate from title
            if (empty($item->slug)) {
                $slug = str_replace(' ', '-', $item->title); // keep Arabic letters
            } else {
                $slug = str_replace(' ', '-', $item->slug);
            }

            $originalSlug = $slug;
            $counter = 1;

            while (Trip::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
        });

        static::updating(function (Trip $item) {
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

            while (Trip::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
        });
    }
}
