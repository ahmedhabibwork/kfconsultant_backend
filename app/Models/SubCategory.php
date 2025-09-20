<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class SubCategory extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;
    //public $translatable = ['title', 'description'];
    protected $fillable = [
        'category_id',
        'slug',
        'title',
        'description',
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    protected static function booted(): void
    {

        static::creating(function (SubCategory $item) {
            $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
            $originalSlug = $slug;
            $counter = 1;

            while (SubCategory::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $item->slug = $slug;
        });

        static::updating(function (SubCategory $item) {
            if ($item->isDirty('title')) {
                $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
                $originalSlug = $slug;
                $counter = 1;

                while (SubCategory::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $item->slug = $slug;
            }
        });
    }
}
