<?php

namespace App\Models;

use App\Enum\DisplayInventoryTypeEnum;
use App\Models\Traits\Activatable;

class DisplayInventory extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'inventory_id',
        'type',
        'order',
        'redirect_url',
        'status',
    ];

    public function getTypeNameAttribute()
    {
        return DisplayInventoryTypeEnum::findConstantLabel($this->type);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
