<?php

namespace App\Models;

use App\Models\Traits\Activatable;
use App\Models\Traits\HasImpactor;

class VideoCategory extends BaseModel
{
    use Activatable;
    use HasImpactor;

    protected $fillable = [
        'name',
        'slug',
        'order',
        'status',
        'created_by_id',
        'created_by_type',
        'updated_by_id',
        'updated_by_type',
    ];
}
