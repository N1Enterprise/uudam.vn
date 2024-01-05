<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class BannerResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'cta_label' => $this->cta_label,
            'description' => $this->description,
            'redirect_url' => $this->redirect_url,
            'order' => $this->order,
            'desktop_image' => $this->desktop_image,
            'mobile_image' => $this->mobile_image,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'type' => $this->type,
            'color' => $this->color,
            'type_name' => $this->type_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.banners.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.banners.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
