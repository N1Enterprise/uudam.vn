<?php

namespace App\Models;

use App\Enum\MenuTypeEnum;
use App\Models\Traits\Activatable;

class Menu extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'slug',
        'is_new',
        'type',
        'inventory_id',
        'post_id',
        'order',
        'meta',
        'status',
    ];

    protected $casts = [
        'meta' => 'json'
    ];

    public function getTypeNameAttribute()
    {
        return MenuTypeEnum::findConstantLabel($this->type);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function menuCatalogs()
    {
        return $this->belongsToMany(MenuSubGroup::class, 'menu_sub_group_menus');
    }
}
