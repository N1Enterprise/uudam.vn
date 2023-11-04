<?php

namespace App\Models;

use App\Models\Traits\HasImpactor;

class UserActionLog extends BaseModel
{
    use HasImpactor;

    protected $fillable = [
        'user_id',
        'type',
        'reason',
        'note',
        'created_by_type',
        'created_by_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
