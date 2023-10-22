<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateFaqRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\FaqTopic;
use Illuminate\Validation\Rule;

class UpdateFaqRequest extends BaseFormRequest implements UpdateFaqRequestContract
{
    public function rules(): array
    {
        return [
            'question' => ['required', 'max:255'],
            'answer' => ['required'],
            'order' => ['nullable', 'integer'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'faq_topic_id' => ['required', 'integer', Rule::exists(FaqTopic::class, 'id')],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'answer' => $this->answer ? json_decode($this->answer, true) : null
        ]);
    }
}
