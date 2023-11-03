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
                        $this->getNameComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getPersonalInformationComponent(), 
                    ])
                    ->statePath('data'),
            ),
        ];
    }


    protected function getNameComponent(): Component
    {
        return Forms\Components\Group::make()->schema([
            Forms\Components\TextInput::make('firstname')
                    ->required(),
            Forms\Components\TextInput::make('middlename')
                    ->required(),
            Forms\Components\TextInput::make('lastname')
                    ->required(),
        ]);
    }

    protected function getPersonalInformationComponent(): Component
    {
        return Forms\Components\Group::make()->schema([
            Forms\Components\DatePicker::make('birthday')
                    ->format('Y-m-d'),
            Forms\Components\TextInput::make('contact_number')
                    ->required(),
        ]);
    }
}
