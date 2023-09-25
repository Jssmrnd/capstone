<?php

namespace App\Filament\TestPanel\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Register as AuthRegister;
use Filament\Forms;

class Register extends AuthRegister
{
    protected function getForms():array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getPersonalInformationComponent(), 
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getPersonalInformationComponent(): Component
    {
        return Forms\Components\Group::make()->schema([
            Forms\Components\Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->required(),
            Forms\Components\TextInput::make('contact_number')
                    ->required(),
        ]);
    }
}
