<?php

namespace App\Livewire;

use App\Models\UnitModel;
use Livewire\Component;

class Search extends Component
{
    public $search;
    protected $queryString = ['search'];

    public function save(){
        
    }

    public function render()
    {
        return view('livewire.search', [
            'unit_models' => UnitModel::query()->where('model_name', 'like', "%".$this->search."%")->get(),
        ]);
    }
}
