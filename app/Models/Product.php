<?php

namespace App\Models;

use App\Models\Traits\Activatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use SoftDeletes;
    use Activatable;

    protected $fillable = [
        'name',
        'code',
        'slug',
        'branch',
        'description',
        'min_amount',
        'max_amount',
        'type',
        'status'
    ];
}
