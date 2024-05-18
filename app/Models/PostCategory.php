<?php

namespace App\Models;

use App\Enum\ActivationStatusEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasHtmlSEO;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends BaseModel
{
    use Activatable;
    use SoftDeletes;
    use HasFeUsage;
    use HasHtmlSEO;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'order',
        'status',
        'display_on_frontend',
        'linked_inventories',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'linked_inventories'
    ];

    public function getDisplayOnFrontendNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->display_on_frontend);
    }

    public function scopeDisplayOnFE($query)
    {
        return $query->where('display_on_frontend', ActivationStatusEnum::ACTIVE);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function htmlSEOProperties()
    {
        return [
            'title'  => $this->meta_title ?? $this->name,
            'desc'   => $this->meta_description ?? ($this->meta_title ?? $this->name),
            'url'    => route('fe.web.news.show-post-categories', $this->slug),
            'image'  => $this->image,
        ];
    }
}
