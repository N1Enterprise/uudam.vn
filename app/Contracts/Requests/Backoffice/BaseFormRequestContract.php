<?php

namespace App\Contracts\Requests\Backoffice;

interface BaseFormRequestContract
{
    public function rules(): array;

    public function validated();
}
