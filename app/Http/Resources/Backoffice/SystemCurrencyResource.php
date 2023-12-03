<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class SystemCurrencyResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'key' => $this->key,
            'code' => $this->code,
            'name' => $this->name,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'symbol' => $this->symbol,
            'is_default' => $this->is_default,
            'is_base' => $this->is_base,
            'order' => $this->order,
            'decimals' => $this->decimals,
            'usable' => $this->usable,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            $this->mergeWhen($this->whenLoaded('createdBy', true, false), function() {
                return [
                    'created_by' => new CreatedByResource($this->createdBy),
                ];
            }),
            $this->mergeWhen($this->whenLoaded('updatedBy', true, false), function() {
                return [
                    'updated_by' => new UpdatedByResource($this->updatedBy),
                ];
            }),
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $managePermission = $this->getPermissionByAction('manage');

        return array_filter([
            'actions' => array_filter([
                'update' => $managePermission ? Route::findByName('bo.web.system-currencies.edit', ['key' => $this->getKey()]) : null,
                'default' => $managePermission && $this->isActive() && $this->isFiat() && !$this->is_default ? Route::findByName('bo.api.system-currencies.mark-as-default', ['key' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
