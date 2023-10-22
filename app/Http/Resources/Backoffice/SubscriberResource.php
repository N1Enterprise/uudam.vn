<?php

namespace App\Http\Resources\Backoffice;

class SubscriberResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'email' => $this->email,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'sent_post' => $this->sent_post,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $managePermission = $this->getPermissionByAction('manage');

        return array_filter([
            'actions' => array_filter([
            ]),
        ]);
    }
}
