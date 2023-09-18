<?php

namespace App\Http\Resources\Backoffice;

class UpdatedByResource extends BaseJsonResource
{
    public function toArray($request)
    {
        $type = class_basename($this->resource);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'type' => class_basename($this->resource),
            'display' => $this->name,
        ];
    }
}
