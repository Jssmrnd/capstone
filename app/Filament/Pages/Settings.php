<?php

namespace App\Filament\Pages;

use App\Models\CustomerApplicationMaintenance;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;

class Settings extends Page implements HasForms
{

    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public ?array $data = []; 
    protected static string $view = 'filament.pages.settings';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

     
    public function mount(): void 
    {
        $this->form->fill(CustomerApplicationMaintenance::all()->toArray()[0]);
    }
 
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('rebate_value')
                    ->required(),
            ])
            ->statePath('data');
    } 

}
