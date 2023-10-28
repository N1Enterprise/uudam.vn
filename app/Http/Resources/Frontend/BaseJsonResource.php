<?php

namespace App\Http\Resources\Frontend;

use App\Common\RequestHelper;
use App\Http\Resources\BaseJsonResource as CoreBaseJsonResource;

abstract class BaseJsonResource extends CoreBaseJsonResource
{
    public function getLang()
    {
        return $this->lang ?? RequestHelper::getLanguage(request(), request()->get('lang', 'en'));
    }
}
