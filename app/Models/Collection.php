<?php

namespace App\Models;

use App\Enum\ActivationStatusEnum;
use App\Models\Traits\Activatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends BaseModel
{
    use Activatable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'primary_image',
        'cover_image',
        'cta_label',
        'description',
        'featured',
        'status',
        'display_on_frontend',
        'order',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'description' => 'json'
    ];

    public function getFeaturedNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->featured);
    }

    public function getDisplayOnFrontendNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->display_on_frontend);
    }

    public function inventories()
    {
        return $this->belongsToMany(Inventory::class, 'collection_inventories');
    }
}
