<?php

namespace App\Models;

use App\Enum\ActivationStatusEnum;
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
        'custom_redirect_url',
        'title',
        'order',
        'status',
        'has_contact_form',
        'description',
        'meta_title',
        'meta_description',
        'created_by_type',
        'created_by_id',
        'updated_by_type',
        'updated_by_id',
    ];

    protected $casts = [
        'description' => 'json'
    ];

    public function getHasContactFormNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->has_contact_form);
    }
}
