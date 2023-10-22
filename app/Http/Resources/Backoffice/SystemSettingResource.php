<?php

namespace App\Http\Resources\Backoffice;

class SystemSettingResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
            'value_type' => $this->value_type,
            'label' => $this->label,
            'order' => $this->order,
            'group' => $this->systemSettingGroup,
        ];
    }
}
