<?php

namespace App\Models;

use App\Enum\VideoTypeEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasImpactor;
use App\Models\Traits\HasHtmlSEO;

class Video extends BaseModel
{
    use Activatable;
    use HasImpactor;
    use HasFeUsage;
    use HasHtmlSEO;

    protected $fillable = [
        'name',
        'slug',
        'order',
        'thumbnail',
        'type',
        'status',
        'source_url',
        'description',
        'content',
        'display_on_frontend',
        'created_by_id',
        'created_by_type',
        'updated_by_id',
        'updated_by_type',
        'video_category_id',
        'meta_title',
        'meta_description',
    ];

    public function category()
    {
        return $this->belongsTo(VideoCategory::class, 'video_category_id', 'id');
    }

    public function getTypeNameAttribute()
    {
        return VideoTypeEnum::findConstantLabel($this->type);
    }

    public function htmlSEOProperties()
    {
        return [
            'title'  => $this->meta_title ?? $this->name,
            'desc'   => $this->meta_description ?? ($this->meta_title ?? $this->name),
            'url'    => route('fe.web.videos.index', $this->slug),
            'image'  => $this->thumbnail,
        ];
    }
}
