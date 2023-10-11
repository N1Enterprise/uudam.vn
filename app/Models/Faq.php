<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class Faq extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'question',
        'answer',
        'order',
        'status',
        'faq_topic_id'
    ];

    protected $casts = [
        'answer' => 'json'
    ];

    public function faqTopic()
    {
        return $this->belongsTo(FaqTopic::class, 'faq_topic_id');
    }
}
