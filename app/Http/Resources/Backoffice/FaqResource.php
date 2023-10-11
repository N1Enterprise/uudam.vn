<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class FaqResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
            'order' => $this->order,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'faq_topic_id' => $this->faq_topic_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'faq_topic' => $this->whenLoaded('faqTopic', function() {
                return optional($this->faqTopic)->only(['id', 'name']);
            })
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.faqs.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.faqs.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
