<?php

namespace App\Models;

use App\Enum\PageDisplayInEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasImpactor;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel
{
    use Activatable;
    use SoftDeletes;
    use HasImpactor;
    use HasFeUsage;

    protected $fillable = [
        'name',
        'slug',
        'title',
        'display_in',
        'order',
        'status',
        'content',
        'meta_title',
        'meta_description',
        'created_by_type',
        'created_by_id',
        'updated_by_type',
        'updated_by_id',
        'display_on_frontend',
    ];

    protected $casts = [
        'display_in' => 'json'
    ];

    public function scopeDisplayInFooter($query)
    {
        return $query->whereJsonContains('display_in', PageDisplayInEnum::FOOTER);
    }

    public function scopeDisplayInCheckout($query)
    {
        return $query->whereJsonContains('display_in', PageDisplayInEnum::CHECKOUT);
    }
}
