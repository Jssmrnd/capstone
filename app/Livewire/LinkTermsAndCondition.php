<?php

namespace App\Livewire;

use Filament\Pages\Concerns\InteractsWithFormActions;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists;
use Filament\Forms;

class LinkTermsAndCondition extends Component implements HasForms, HasActions
{

    use InteractsWithActions;
    use InteractsWithForms;


    public function render()
    {
        return view('livewire.link-terms-and-condition');        
    }

    public function createLink():Action{
        return Action::make('terms_and_conditions')
        ->submit("action")
        ->label('Terms and Conditions');
    }

}
