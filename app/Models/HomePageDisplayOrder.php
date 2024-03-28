<?php

namespace App\Models;

use App\Cms\HomePageDisplayOrderCms;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;

class HomePageDisplayOrder extends BaseModel
{
    use Activatable;
    use HasFeUsage;

    protected $fillable = [
        'name',
        'order',
        'status',
        'display_on_frontend',
        'hidden_name'
    ];

    public function items()
    {
        return $this->hasMany(HomePageDisplayItem::class, 'group_id', 'id');
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            HomePageDisplayOrderCms::flush();
        });
    }
}
