<?php

namespace App\Models;

use App\Elements\BaseElement;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;

class SystemSetting extends BaseModel
{
    protected $fillable = [
        'group_id',
        'label',
        'key',
        'value',
        'value_type',
        'order'
    ];

    protected $appends = [
        'label_display'
    ];

    protected $casts = [
        'value' => 'array'
    ];

    public const CACHE_TAG = 'system_settings';

    /**
     * @param mixed $key
     *
     * @return BaseElement
     * @throws BadMethodCallException
     */
    public static function from($key)
    {
        $cacheKey = 'system_settings_element:'.$key;

        $cacheElement = Cache::tags([self::CACHE_TAG])->rememberForever($cacheKey, function() use ($key) {
            return new BaseElement(self::where('key', $key)->first());
        });

        return $cacheElement;
    }

    public function getLabelDisplayAttribute()
    {
        return ! empty($this->label) ? $this->label : str_replace('_',' ', $this->key);
    }

    public function systemSettingGroup()
    {
        return $this->hasOne(SystemSettingGroup::class, 'id', 'group_id');
    }

    public static function flush($tags = [])
    {
        Cache::tags($tags)->flush();
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
