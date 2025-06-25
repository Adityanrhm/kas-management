<?php

namespace App\Livewire;

use Livewire\Component;

class DynamicTable extends Component
{
    public $model;
    public $columns = [];
    public $filter = [];
    public $with = [];
    public $records = [];

    public function mount($model, $columns = [], $filter = [], $with = [])
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->filter = $filter;
        $this->with = $with;
        $this->loadRecords();
    }

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

    public function render()
    {
        return view('livewire.dynamic-table');
    }
}
