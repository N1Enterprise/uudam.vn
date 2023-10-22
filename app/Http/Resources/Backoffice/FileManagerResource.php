<?php

namespace App\Http\Resources\Backoffice;

class FileManagerResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id'   => $this->id,
            'name' => $this->name,
            'ext'  => $this->ext,
            'path' => $this->path,
            'size' => $this->size,
            'disk' => $this->disk,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        return [];
    }
}
