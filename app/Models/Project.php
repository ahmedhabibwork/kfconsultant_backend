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
