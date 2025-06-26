<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DynamicTable extends Component
{

    public $model;
    public $columns = [];
    public $filter = [];
    public $with = [];
    public $records = [];

    /**
     * Create a new component instance.
     */
    public function __construct($model, $columns = [], $filter = [], $with = [])
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->filter = $filter;
        $this->with = $with;
        $this->loadRecords();
    }

    /**
     * Get the view / contents that represent the component.
     */

    public function loadRecords()
    {
        $query = ($this->model)::query();

        if (!empty($this->with)) {
            $query->with($this->with);
        }

        if (!empty($this->filter)) {
            $query->where($this->filter);
        }

        $this->records = $query->latest()->get();
    }
    public function render(): View|Closure|string
    {
        return view('components.dynamic-table');
    }
}
