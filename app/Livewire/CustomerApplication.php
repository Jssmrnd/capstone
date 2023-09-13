<?php

namespace App\Livewire;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class CustomerApplication extends Component implements HasForms
{

    use InteractsWithForms;

    public $n = 0;

    protected function getFormSchema(): array 
    {
        return [
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\MarkdownEditor::make('content'),
            // ...
        ];
    } 

    public function increment(){
        $this->n++;
    }

    public function render()
    {
        return view('livewire.customer-application');
    }
}
