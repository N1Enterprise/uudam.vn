<?php

namespace App\Models;

use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;

class HomePageDisplayOrder extends BaseModel
{
    use Activatable;
    use HasFeUsage;

    protected $fillable = [
        'name',
        'order',
        'status',
        'display_on_frontend'
    ];
    
    public function items()
    {
        return $this->hasMany(HomePageDisplayItem::class, 'group_id', 'id');
    }
}
