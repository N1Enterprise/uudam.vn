<?php

namespace App\Models;

use App\Enum\VideoTypeEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasImpactor;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use Activatable;
    use HasImpactor;
    use HasFeUsage;

    protected $fillable = [
        'name',
        'slug',
        'order',
        'thumbnail',
        'type',
        'status',
        'source_url',
        'short_description',
        'description',
        'display_on_frontend',
        'created_by_id',
        'created_by_type',
        'updated_by_id',
        'updated_by_type',
        'video_category_id'
    ];

    public function category()
    {
        return $this->belongsTo(VideoCategory::class, 'video_category_id', 'id');
    }

    public function getTypeNameAttribute()
    {
        return VideoTypeEnum::findConstantLabel($this->type);
    }
}
