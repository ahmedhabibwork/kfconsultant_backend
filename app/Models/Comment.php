<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'comment',
        'image',
        'trip_id',
    ];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
