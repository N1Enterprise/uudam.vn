<?php

namespace App\View\Components\Backoffice;

use Illuminate\View\Component;

class SearchUsernameInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $id;
    public $label;
    public $placeholder;

    public function __construct($name = 'username', $id = 'username', $label = '', $placeholder = '')
    {
        $this->name        = $name;
        $this->id          = $id;
        $this->label       = $label;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.backoffice.search-username-input', [
            'name'        => $this->name,
            'id'          => $this->id,
            'label'       => $this->label,
            'placeholder' => $this->placeholder,
        ]);
    }
}
