<?php

namespace App\Models;

use App\Enum\BannerTypeEnum;
use App\Models\Traits\Activatable;

class Banner extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'label',
        'cta_label',
        'redirect_url',
        'order',
        'description',
        'desktop_image',
        'mobile_image',
        'start_at',
        'end_at',
        'status',
        'type',
    ];

    public function getTypeNameAttribute()
    {
        return BannerTypeEnum::findConstantLabel($this->type);
    }
}
