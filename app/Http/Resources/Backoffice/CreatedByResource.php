<?php

namespace App\Http\Resources\Backoffice;

class CreatedByResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'name' => $this->name,
            'display' => $this->name,
            'email' => $this->email,
            'type' => class_basename($this->resource),
        ];
    }
}
