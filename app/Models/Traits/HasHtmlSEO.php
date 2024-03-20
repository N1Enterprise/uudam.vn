<?php

namespace App\Models\Traits;

trait HasHtmlSEO
{
    public function toHtmlSEO()
    {
        return generate_seo_html($this->htmlSEOProperties());
    }
}
