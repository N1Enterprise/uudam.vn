<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class FaqTopic extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'order',
        'status',
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }
}
