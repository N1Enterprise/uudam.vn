<?php

namespace App\Models;

use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use Spatie\ResponseCache\Facades\ResponseCache;
use Illuminate\Support\Facades\Artisan;

class MenuGroup extends BaseModel
{
    use Activatable;
    use HasFeUsage;

    protected $fillable = [
        'name',
        'redirect_url',
        'order',
        'status',
        'params',
        'display_on_frontend'
    ];

    public const CACHE_TAG = 'menu';

    protected $casts = [
        'params' => 'json',
    ];

    public function menuSubGroups()
    {
        return $this->hasMany(MenuSubGroup::class);
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            SystemSetting::flush(self::CACHE_TAG);
            Artisan::call('cache:clear');
            ResponseCache::clear(['setting']);
        });
    }
}
