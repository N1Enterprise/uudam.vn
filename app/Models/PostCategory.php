<?php

namespace App\Models;

use App\Enum\ActivationStatusEnum;
use App\Models\Traits\Activatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends BaseModel
{
    use Activatable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'order',
        'status',
        'featured',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'description' => 'json',
    ];

    public function getFeaturedNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->featured);
    }
}
