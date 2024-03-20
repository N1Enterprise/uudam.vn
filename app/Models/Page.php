<?php

namespace App\Models;

use App\Cms\PageCms;
use App\Common\Cache;
use App\Enum\PageDisplayInEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasHtmlSEO;
use App\Models\Traits\HasImpactor;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel
{
    use Activatable;
    use SoftDeletes;
    use HasImpactor;
    use HasFeUsage;
    use HasHtmlSEO;

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
            PageCms::flush();
        });
    }

    public function htmlSEOProperties()
    {
        return [
            'title'  => $this->meta_title ?? $this->title,
            'desc'   => $this->meta_description ?? ($this->meta_title ?? $this->title),
            'url'    => route('fe.web.pages.index', $this->slug),
        ];
    }
}
