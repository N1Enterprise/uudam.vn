<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreMenuRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\MenuTypeEnum;
use App\Models\Inventory;
use App\Models\MenuSubGroup;
use App\Models\Post;
use Illuminate\Validation\Rule;

class StoreMenuRequest extends BaseFormRequest implements StoreMenuRequestContract
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'max:255'],
            'order' => ['nullable', 'integer'],
            'type' => ['required', 'integer', Rule::in(MenuTypeEnum::all())],
            'menu_catalogs' => ['required', 'array'],
            'menu_catalogs.*' => ['required', 'integer', Rule::exists(MenuSubGroup::class, 'id')],
            'is_new' => ['required', Rule::in(ActivationStatusEnum::all())],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'meta' => ['required', 'array']
        ];

        if ($this->type == MenuTypeEnum::NORMAL) {
            $rules = array_merge($rules, [
                'meta.title' => ['required', 'string', 'max:255'],
                'meta.redirect_url' => ['required', 'string', 'max:255'],
                'meta.image' => ['required', 'array'],
                'meta.image.file' => ['nullable', 'file', 'image', 'max:5200'],
                'meta.image.path' => ['nullable', 'string'],
            ]);
        } else if ($this->type == MenuTypeEnum::INVENTORY) {
            $rules = array_merge($rules, [
                'inventory_id' => ['required', 'integer', Rule::exists(Inventory::class, 'id')]
            ]);
        } else if ($this->type == MenuTypeEnum::POST) {
            $rules = array_merge($rules, [
                'post_id' => ['required', 'integer', Rule::exists(Post::class, 'id')]
            ]);
        }

        return $rules;
    }

    public function prepareForValidation()
    {
        $payload = $this->all();

        if (! empty(data_get($payload, 'meta.image'))) {
            $payload['meta']['image'] = empty(array_filter(data_get($this->all(), 'meta.image'))) ? null : array_filter(data_get($this->all(), 'meta.image'));
        }

        $this->merge(array_merge($payload, [
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'is_new' => boolean($this->is_new) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]));
    }
}
