<?php

namespace App\Models;

use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasImpactor;

class VideoCategory extends BaseModel
{
    use Activatable;
    use HasImpactor;
    use HasFeUsage;

    protected $fillable = [
        'name',
        'slug',
        'order',
        'status',
        'created_by_id',
        'created_by_type',
        'updated_by_id',
        'updated_by_type',
        'display_on_frontend'
    ];

    public function videos()
    {
        return $this->hasMany(Video::class, 'video_category_id', 'id');
    }
}
