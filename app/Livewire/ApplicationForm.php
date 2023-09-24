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
                    Forms\Components\Fieldset::make("Unit to be Financed")
                            ->disabledOn('edit')
                            ->columns(4)
                            ->columnSpan(2)
                            ->schema([
                                    Forms\Components\Select::make('unit_id')
                                            ->hint("Ex. Mio soul i")
                                            ->columnSpan(2)
                                            ->label('Unit Model')
                                            ->relationship("unitModel", "model_name")
                                            ->searchable()
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
                                                    
                                                    Forms\Components\TextInput::make('unit_engine_number')
                                                            ->prefix('#')
                                                            ->columnSpan(1)
                                                            ->label('Engine Number')
                                                            ->numeric(),

                                                    Forms\Components\TextInput::make('unit_srp')
                                                            ->columnSpan(1)
                                                            ->required(true)
                                                            ->label('Selling Retail Price:')
                                                            ->numeric(),
                                                    Forms\Components\TextInput::make('unit_term')
                                                            ->columnSpan(1)
                                                            ->minValue(0)
                                                            ->required(true)
                                                            ->label('Term:')
                                                            ->minValue(1)
                                                            ->numeric()
                                                            ->live(500)
                                                            ->afterStateUpdated(
                                                                    function(Forms\Get $get, Forms\Set $set){
                                                                    $_term = $get('unit_term');
                                                                    $_unit_srp = $get('unit_srp');
                                                                    if($_term > 1){
                                                                            $quotient = number_format((float)$_unit_srp/$_term, 2, '.', '');
                                                                            $set('unit_amort_fin', $quotient);
                                                                            $set('unit_monthly_amort', $quotient);
                                                                    }
                                                                }
                                                            ),
                                                    Forms\Components\TextInput::make('unit_ttl_dp')
                                                                ->required(true)
                                                                ->label('Total Downpayment:')
                                                                ->numeric()
																->minValue(0)
                                                                ->columnSpan(1)
                                                                ->live(500)
                                                                ->afterStateUpdated(
                                                                        function(Forms\Get $get, Forms\Set $set){
                                                                                $dp = $get('unit_ttl_dp');
                                                                                $_term = $get('unit_term');
                                                                                $_unit_srp = $get('unit_srp');
                                                                                if($_term > 1 || $get('unit_ttl_dp' <= $get('unit_srp'))){
                                                                                        $quotient = number_format((float)((float)$_unit_srp - (float)$dp)/$_term, 2, '.', '');
                                                                                        $set('unit_amort_fin', $quotient);
                                                                                        $set('monthly_amortization', $quotient);
                                                                                }
                                                                        }
                                                                ),
                                                    Forms\Components\TextInput::make('unit_monthly_amort')->required(true)
                                                                ->label('Monthly Amorthization:')
																->minValue(0)
                                                                ->numeric(),
                                                    Forms\Components\Select::make('unit_type')
                                                                ->required()
                                                                ->options(['New','Repeat',]),
                                                    Forms\Components\TextInput::make('unit_amort_fin')
                                                                ->numeric()
																->minValue(0)
                                                                ->required(true)
                                                                ->label('Amorthization Fin:'),
                                                    Forms\Components\Select::make('unit_mode_of_payment')
                                                                ->required(true)
                                                                ->label('Mode of Payment:')
                                                                ->options(
                                                                    ['Office','Field','Bank',]
                                                                )
                                                                ->columnSpan(1),
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
