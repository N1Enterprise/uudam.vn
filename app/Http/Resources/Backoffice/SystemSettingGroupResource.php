<?php

namespace App\Http\Resources\Backoffice;

class SystemSettingGroupResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_display' => $this->name_display,
        ];
    }
}
