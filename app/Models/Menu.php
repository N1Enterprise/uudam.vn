<?php

namespace App\Models;

use App\Enum\MenuTypeEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use Illuminate\Support\Facades\Artisan;

class Menu extends BaseModel
{
    use Activatable;
    use HasFeUsage;

    public const CACHE_TAG = 'menu';

    protected $fillable = [
        'name',
        'label',
        'is_new',
        'type',
        'collection_id',
        'inventory_id',
        'post_id',
        'order',
        'meta',
        'status',
        'display_on_frontend'
    ];

    protected $casts = [
        'meta' => 'json'
    ];

    public function getTypeNameAttribute()
    {
        return MenuTypeEnum::findConstantLabel($this->type);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id');
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

    protected static function booted()
    {
        static::saved(function ($model) {
            SystemSetting::flush(self::CACHE_TAG);
            Artisan::call('cache:clear');
        });
    }
}
