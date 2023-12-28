<?php

namespace App\Models;

use App\Common\Cache;
use App\Enum\PageDisplayInEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasImpactor;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Artisan;

class Page extends BaseModel
{
    use Activatable;
    use SoftDeletes;
    use HasImpactor;
    use HasFeUsage;

    public const CACHE_TAG = 'page';

    protected $fillable = [
        'name',
        'slug',
        'title',
        'display_in',
        'order',
        'status',
        'content',
        'meta_title',
        'meta_description',
        'created_by_type',
        'created_by_id',
        'updated_by_type',
        'updated_by_id',
        'display_on_frontend',
    ];

    public static function allFromCache($displayIn)
    {
        $cacheKey = 'page:'.$displayIn;

        return Cache::tags([self::CACHE_TAG])->rememberForever($cacheKey, function() use ($displayIn) {
            return self::whereJsonContains('display_in', $displayIn)
                ->orderBy('order')
                ->get(['name', 'slug', 'status', 'title', 'content', 'display_on_frontend']);
        });
    }

    protected $casts = [
        'display_in' => 'json'
    ];

    public function scopeDisplayInFooter($query)
    {
        return $query->whereJsonContains('display_in', PageDisplayInEnum::FOOTER);
    }

    public function scopeDisplayInCheckout($query)
    {
        return $query->whereJsonContains('display_in', PageDisplayInEnum::CHECKOUT);
    }

    public static function flush($tags = [])
    {
        Cache::tags($tags)->flush();
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            SystemSetting::flush(self::CACHE_TAG);
        });
    }
}
