<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Pagination extends Component
{
    public $route;
    public $label;

    public function __construct($route, $label = 'item')
    {
        $this->route = $route;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.pagination');
    }
}
