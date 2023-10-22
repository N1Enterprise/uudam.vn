<?php

namespace App\Models;

use App\Enum\SubscriberTypeEnum;

class Subscriber extends BaseModel
{
    protected $fillable = [
        'email',
        'type',
        'sent_post'
    ];

    protected $casts = [
        'sent_post' => 'json'
    ];

    public function getTypeNameAttribute()
    {
        return SubscriberTypeEnum::findConstantLabel($this->type);
    }
}
