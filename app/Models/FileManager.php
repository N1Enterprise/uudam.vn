<?php

namespace App\Models;

use App\Models\Traits\HasImpactor;

class FileManager extends BaseModel
{
    use HasImpactor;

    public $fillable = [
        'id',
        'name',
        'ext',
        'path',
        'size',
        'disk',
        'type',
        'created_by_id',
        'created_by_type',
        'updated_by_id',
        'updated_by_type',
    ];
}
