<?php

namespace App\View\Components\Backoffice;

use Illuminate\View\Component;

class ContentEditor extends Component
{
    public $id;
    public $name;
    public $label;
    public $cols;
    public $rows;
    public $placeholder;
    public $class;
    public $config;
    public $disk;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = '', $name, $label = '', $cols = '30', $rows = '10', $class = '', $config = [], $placeholder = '', $disk = 'file_manager', $value = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->cols = $cols;
        $this->rows = $rows;
        $this->class = $class;
        $this->config = $config;
        $this->placeholder = $placeholder;
        $this->disk = $disk;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backoffice.content-editor', [
            'id'          => $this->id,
            'name'        => $this->name,
            'cols'        => $this->cols,
            'rows'        => $this->rows,
            'class'       => $this->class,
            'config'       => $this->config,
            'placeholder' => $this->placeholder,
            'disk'        => $this->disk,
            'value'       => $this->value,
        ]);
    }
}
