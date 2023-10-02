<?php

namespace App\Contracts\Requests\Frontend;

interface BaseFormRequestContract
{
    public function rules(): array;

    public function validated();
}
