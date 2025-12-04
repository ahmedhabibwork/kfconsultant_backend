<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\LaravelPackageTools\Concerns\Package\HasTranslations;

class Project extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;
    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
    ];
    protected $fillable = [
        "id",
        "slug",
        "title",
        "introduction",
        "description",
        "category_id",
        "scope_id",
        'year_id',
        'category_id',
        "scale_id",
        "owner",
        "location",
        "map_link",
        "status_id",
        "is_active",
        'short_description',
        'cover_image',
        'images',
        "sort_order",
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    protected static function booted(): void
    {
        static::creating(function (Project $item) {
            // If slug is empty, generate from title
            if (empty($item->slug)) {
                $slug = str_replace(' ', '-', $item->title); // keep Arabic letters
            } else {
                $slug = str_replace(' ', '-', $item->slug);
            }

            $originalSlug = $slug;
            $counter = 1;

            while (Project::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
        });

        static::updating(function (Project $item) {
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

            while (Project::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
        });
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    public function scale()
    {
        return $this->belongsTo(Scale::class, 'scale_id', 'id');
    }
    public function scope()
    {
        return $this->belongsTo(Scope::class, 'scope_id', 'id');
    }
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
