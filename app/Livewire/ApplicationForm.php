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
            Forms\Components\Select::make('unit_id')
                    ->hint("Ex. Mio soul i")
                    ->columnSpan(2)
                    ->label('Unit Model')
                    ->relationship('unitModel', 'model_name')
                    ->searchable(['unit_model', 'id'])
                    ->preload()
                    ->live()
                    ->afterStateUpdated(
                            function(Forms\Get $get, Forms\Set $set){
                                $unit_price = UnitModel::find($get("unit_id"))->price;
                                $set('unit_srp', $unit_price);
                            }
            ),

            Forms\Components\Group::make()
                    ->columnSpan(4)
                    ->columns(2)
                    ->live()
                    ->disabled(fn (Forms\Get $get): bool => ! $get('unit_id'))
                    ->schema([
                            Forms\Components\Select::make('unit_term')
                                    ->columnSpan(1)
                                    ->required(true)
                                    ->label('Term:')
                                    ->options([
                                        12 => 12,
                                        24 => 24,
                                        36 => 36,
                                    ]),
                            Forms\Components\Fieldset::make("Applicant Information")
                            ->columns(3)
                            ->columnSpan(2)
                            ->schema([
                                    Forms\Components\TextInput::make('applicant_surname')
                                            ->label('First Name:')
                                            ->columnSpan(1)
                                            ->required(true),
                                    Forms\Components\TextInput::make('applicant_middlename')
                                            ->label('Middle Name:')
                                            ->columnSpan(1),
                                    Forms\Components\TextInput::make('applicant_lastname')
                                            ->label('Last Name:')
                                            ->columnSpan(1)
                                            ->required(true),
                                    Forms\Components\DatePicker::make('applicant_birthday')
                                            ->label('Birthday:')
                                            ->maxDate(now()->subYears(150))
                                            ->maxDate(now())
                                            ->columnSpan(1)
                                            ->required(true),
                                    Forms\Components\TextInput::make('applicant_telephone')
                                            ->label('Telephone:'),
                                    Forms\Components\TextInput::make('applicant_valid_id')
                                            ->label('Valid ID:')
                                            ->required(true),
                                    Forms\Components\Select::make('applicant_civil_status')
                                            ->label('Civil Status')
                                            ->live()
                                            ->columnSpan(3)
                                            ->required(true)
                                            ->options(['single'=> 'Single', 'married' => 'Married', 'separated' => 'Separated', 'widow' => 'Widow']),
                                    Forms\Components\Textarea::make('applicant_present_address')
                                            ->label('Present Address:')
                                            ->columnSpan(1)->required(true),
                                    Forms\Components\Textarea::make('applicant_previous_address')
                                            ->label('Previous Address:')
                                            ->columnSpan(1),
                                    Forms\Components\Textarea::make('applicant_provincial_address')
                                            ->label('Provincial Address:')->columnSpan(1),
                                    Forms\Components\TextInput::make('applicant_lived_there')
                                            ->numeric()
                                            ->suffix('year(s)')
                                            ->inputMode('integer')
                                            ->label('Lived There:'),
                                    Forms\Components\Select::make('applicant_house')
                                            ->label('House:')
                                            ->options(['owned' => 'Owned', 'rented' => 'Rented', 'w/ parents' => 'W/ parents']),

                                    Forms\Components\Fieldset::make("Present Employer")
                                            ->columns(2)
                                            ->columnSpan(2)
                                            ->schema([
                                                    Forms\Components\TextArea::make('applicant_present_business_employer')
                                                            ->label('Business Employer:')
                                                            ->columnSpan(2),
                                                    Forms\Components\TextInput::make('applicant_position')
                                                            ->label('Position:')
                                                            ->columnSpan(1),
                                                    Forms\Components\TextInput::make('applicant_how_long_job_or_business')
                                                            ->label('How long:')
                                                            ->columnSpan(1),
                                            ]),
    
                                    Forms\Components\Fieldset::make("Applicant's Business")
                                            ->columnSpan(1)
                                            ->columns(1)
                                            ->schema([
                                                    Forms\Components\TextArea::make('applicant_business_address')
                                                            ->label('Address:')
                                                            ->columnSpan(1),
                                                    Forms\Components\TextInput::make('applicant_nature_of_business')
                                                            ->label('Nature of Business:'),
                                            ]),
    
                                    
                                    Forms\Components\Fieldset::make("Previous Employer")
                                                                                        ->columns(3)
                                            ->columnSpan(3)
                                            ->schema([
                                                Forms\Components\TextArea::make('applicant_previous_employer')
                                                        ->label('Employer:')
                                                        ->columnSpan(1),
                                                Forms\Components\TextArea::make('applicant_previous_employer_position')
                                                        ->label('Position:')
                                                        ->columnSpan(1),
                                                Forms\Components\TextArea::make('applicant_how_long_prev_job_or_business')
                                                        ->label('How Long:')
                                                        ->columnSpan(1),
                                            ]),
                            ]),
        ]),
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
