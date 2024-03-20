<?php

namespace App\Models;

use App\Enum\ActivationStatusEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasHtmlSEO;
use App\Models\Traits\HasImpactor;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends BaseModel
{
    use Activatable;
    use SoftDeletes;
    use HasImpactor;
    use HasFeUsage;
    use HasHtmlSEO;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'content',
        'post_at',
        'post_category_id',
        'created_by_type',
        'created_by_id',
        'updated_by_type',
        'updated_by_id',
        'order',
        'status',
        'display_on_frontend',
        'allow_frontend_search',
        'meta',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'meta' => 'json'
    ];

    public function getDisplayOnFrontendNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->display_on_frontend);
    }

    public function postCategory()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function htmlSEOProperties()
    {
        return [
            'title'  => $this->meta_title ?? $this->name,
            'desc'   => $this->meta_description ?? ($this->meta_title ?? $this->name),
            'url'    => route('fe.web.posts.index', $this->slug),
            'image'  => $this->image,
        ];
    }
}
