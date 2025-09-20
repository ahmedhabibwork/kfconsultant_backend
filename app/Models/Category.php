<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
  use HasFactory, HasTranslations, SoftDeletes;
  //  public $translatable = ['title', 'description'];
  protected $fillable = [
    'slug',
    'title',
    'description',
    'image'
  ];
  const Hotels        = 1;
  const Transport     = 2;
  const Flights       = 3;
  const  Hajj_Umrah   = 4;
  const Tours          = 5;




  public function subCategories(): HasMany
  {
    return $this->hasMany(SubCategory::class);
  }
  public function trips(): HasMany
  {
    return $this->hasMany(Trip::class);
  }

  public function hasTrips(): bool
  {
    return $this->trips()->exists();
  }



  protected static function booted(): void
  {

    static::creating(function (Category $item) {
      $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
      $originalSlug = $slug;
      $counter = 1;

      while (Category::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $counter;
        $counter++;
      }

      $item->slug = $slug;
    });

    static::updating(function (Category $item) {
      if ($item->isDirty('title')) {
        $slug = str_replace(' ', '-', $item->title); // Keep Arabic letters
        $originalSlug = $slug;
        $counter = 1;

        while (Category::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
          $slug = $originalSlug . '-' . $counter;
          $counter++;
        }

        $item->slug = $slug;
      }
    });
  }
}
