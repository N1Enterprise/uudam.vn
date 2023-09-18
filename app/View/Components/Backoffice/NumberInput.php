<?php

namespace App\View\Components\Backoffice;

use Illuminate\View\Component;

class NumberInput extends Component
{
    public $name;
    public $id;
    public $class;
    public $icon;
    public $placeholder;
    public $value = 0;
    public $digits;
    public $key;
    public $allowMinus;
    public $disabled;
    public $readonly;

    public function __construct(
        $key,
        $name = null,
        $id = null,
        $class = null,
        $icon = null,
        $placeholder = null,
        $value = null,
        $digits = null,
        $allowMinus = true,
        $disabled = false,
        $readonly = false
    ) {
        $this->key = $key;
        $this->name = $name;
        $this->id = $id;
        $this->class = $class ?? 'form-control';
        $this->icon = $icon;
        $this->placeholder = $placeholder;
        $this->value = is_numeric($value) ? (float) $value : null;
        $this->digits = $digits ?? 2;
        $this->disabled = boolean($disabled);
        $this->readonly = boolean($readonly);
        $this->allowMinus = boolean(empty($allowMinus) ? true : $allowMinus);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // return inline blade template (performance issue when return a view inside a large loop)
        return <<<'blade'
            <input type="text"
                data-digits="{{ $digits }}"
                data-type="inputmask_numeric"
                data-allow-minus="{{ $allowMinus == true ? 'true'  : 'false'}}"
                class="{{ $class }}"
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($value !== null) value="{{ $value }}" @endif
                data-key="{{ $key }}"
                {{ $disabled === true ? 'disabled' : '' }}
                {{ $readonly === true ? 'readonly' : '' }}
                {{ $attributes }}>

            <input type="hidden"
                data-type="inputmask_numeric_unmasked"
                name="{{ $name }}"
                data-key="{{ $key }}"
                @if($id) id="{{ $id }}" @endif
                @if($value !== null) value="{{ $value }}" @endif
                {{ $disabled === true ? 'disabled' : '' }}
                {{ $attributes }}>
        blade;
    }
}
