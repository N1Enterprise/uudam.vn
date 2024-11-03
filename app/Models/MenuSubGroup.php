<?php

namespace App\Models;

use App\Cms\MenuCms;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;

class MenuSubGroup extends BaseModel
{
    use Activatable;
    use HasFeUsage;

    public const CACHE_TAG = 'menu';

    protected $fillable = [
        'name',
        'redirect_url',
        'menu_group_id',
        'order',
        'status',
        'params',
        'display_on_frontend'
    ];

    public $casts = [
        'params' => 'json'
    ];

    public function menuGroup()
    {
        return $this->belongsTo(MenuGroup::class, 'menu_group_id');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_sub_group_menus');
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            MenuCms::flush();
        });
    }
}
