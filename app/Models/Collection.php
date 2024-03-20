<?php

namespace App\Models;

use App\Enum\ActivationStatusEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasHtmlSEO;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends BaseModel
{
    use Activatable;
    use SoftDeletes;
    use HasFeUsage;
    use HasHtmlSEO;

    protected $fillable = [
        'name',
        'slug',
        'primary_image',
        'cover_image',
        'cta_label',
        'description',
        'status',
        'linked_inventories',
        'linked_featured_inventories',
        'display_on_frontend',
        'allow_frontend_search',
        'order',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'linked_inventories' => 'json',
        'linked_featured_inventories' => 'json',
    ];

    public function getDisplayOnFrontendNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->display_on_frontend);
    }

    public function htmlSEOProperties()
    {
        return [
            'title'  => $this->meta_title ?? $this->name,
            'desc'   => $this->meta_description ?? ($this->meta_title ?? $this->name),
            'url'    => route('fe.web.collections.index', $this->slug),
            'image'  => $this->primary_image,
        ];
    }
}
