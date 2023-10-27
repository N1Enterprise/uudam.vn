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
        'display_on_frontend',
        'linked_inventories',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'linked_inventories'
    ];

    public function getDisplayOnFrontendNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->display_on_frontend);
    }

    public function scopeDisplayOnFE($query)
    {
        return $query->where('display_on_frontend', ActivationStatusEnum::ACTIVE);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
