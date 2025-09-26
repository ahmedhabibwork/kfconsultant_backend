<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'question',
        'answer',
        'image',
        'is_published',
        // 'blog_id',
    ];

    // public function blog()
    // {
    //     return $this->belongsTo(Blog::class);
    // }
}
