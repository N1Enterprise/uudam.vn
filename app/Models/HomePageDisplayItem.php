<?php

namespace App\Models;

use App\Enum\HomePageDisplayType;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;

class HomePageDisplayItem extends BaseModel
{
    use Activatable;
    use HasFeUsage;

    protected $fillable = [
        'name',
        'group_id',
        'order',
        'type',
        'linked_items',
        'status',
        'display_on_frontend'
    ];

    protected $casts = [
        'linked_items' => 'json'
    ];

    public function getTypeNameAttribute()
    {
        return HomePageDisplayType::findConstantLabel($this->type);
    }

    public function group()
    {
        return $this->belongsTo(HomePageDisplayOrder::class, 'group_id', 'id');
    }
}
