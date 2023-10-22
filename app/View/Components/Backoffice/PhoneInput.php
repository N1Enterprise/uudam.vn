<?php

namespace App\View\Components\Backoffice;

use Illuminate\View\Component;

class PhoneInput extends Component
{
    public $phonePrefixName;
    public $class;
    public $value = 0;
    public $required;
    public $phone;
    public $requiredPrefix;
    public $phoneInputName;
    public $phoneBeautifyName;
    public $placeholder;

    public function __construct(
        $phonePrefixName    = 'calling_code',
        $phoneInputName    = 'contact_number',
        $phoneBeautifyName = 'phone_number',
        $placeholder       = 'Phone number',
        $class             = 'form-control',
        $value             = null,
        $required          = false,
        $requiredPrefix     = false,
        $phone             = ''
    ) {
        $this->phonePrefixName    = $phonePrefixName;
        $this->phoneInputName    = $phoneInputName;
        $this->placeholder       = $placeholder;
        $this->phoneBeautifyName = $phoneBeautifyName;
        $this->phone             = $phone;
        $this->class             = $class ?? 'form-control';
        $this->value             = $value;
        $this->required          = boolean($required);
        $this->requiredPrefix     = boolean($requiredPrefix);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backoffice.phone-input', [
            'class'             => $this->class,
            'value'             => $this->value,
            'required'          => $this->required,
            'requiredPrefix'     => $this->requiredPrefix,
            'phoneInputName'    => $this->phoneInputName,
            'phoneBeautifyName' => $this->phoneBeautifyName,
            'phonePrefixName'    => $this->phonePrefixName,
        ]);
    }
}
