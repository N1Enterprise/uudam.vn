<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class Post extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'image',
        'description',
        'post_at',
        'viewer_count',
        'post_category_id',
        'created_by_type',
        'created_by_id',
        'updated_by_type',
        'updated_by_id',
    ];

    protected $casts = [
        'description' => 'json'
    ];
}
