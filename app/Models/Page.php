<?php

namespace App\Models;

use App\Enum\PageDisplayTypeEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasImpactor;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel
{
    use Activatable;
    use SoftDeletes;
    use HasImpactor;

    protected $fillable = [
        'name',
        'slug',
        'title',
        'display_type',
        'order',
        'status',
        'content',
        'meta_title',
        'meta_description',
        'created_by_type',
        'created_by_id',
        'updated_by_type',
        'updated_by_id',
    ];

    public function getDisplayTypeNameAttribute()
    {
        return PageDisplayTypeEnum::findConstantLabel($this->display_type);
    }

    public function scopeMenu($query)
    {
        return $query->where('display_type', PageDisplayTypeEnum::MENU);
    }
}
