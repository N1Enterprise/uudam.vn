<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class HomePageDisplayOrder extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'order',
        'status'
    ];
}
