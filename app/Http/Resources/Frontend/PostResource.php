<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Frontend\BaseJsonResource;

class PostResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'description' => $this->description,
            'post_at' => format_datetime($this->post_at),
            'code' => $this->code,
            'view_count' => $this->view_count ?? 0,
            'author' => $this->author
        ];
    }
}
