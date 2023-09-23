<?php

namespace App\Livewire;

use App\Models\CustomerApplication;
use App\Models\UnitModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use Livewire\Component;


class ApplicationForm extends Component implements HasForms
{

    use InteractsWithForms;

    public ?array $data = [];
    public $unit_model;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
                ->schema([
                    Forms\Components\Select::make("unit_id")
                        ->relationship("unitModel", "model_name")
                        ->searchable()
                ])
                ->statePath('data')
                ->model(CustomerApplication::class);
    }

    public function create(): void
    {
        dd($this->form->getState());
    }
    

    public function render()
    {
        return view('livewire.application-form');
    }
}
