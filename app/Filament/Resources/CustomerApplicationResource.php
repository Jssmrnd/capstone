<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerApplicationResource\Pages;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Summarizers\Average;
use App\Filament\Resources\CustomerApplicationResource\RelationManagers;
use App\Models\CustomerApplication;
use App\Models;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Support\Enums\Alignment;

class CustomerApplicationResource extends Resource
{
    protected static ?string $model = CustomerApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canDelete(Model $record): bool
    {
        return true;
    }

    public static function getUnitToBeFinanced(): Forms\Components\Component
    {
                return Forms\Components\Group::make([
                        Forms\Components\Fieldset::make("Unit to be Financed")
                        ->columns(4)
                        ->columnSpan(2)
                        ->schema([
                                Forms\Components\Select::make('unit_model_id')
                                        ->hint("Ex. Mio soul i")
                                        ->columnSpan(2)
                                        ->label('Unit Model')
                                        ->relationship(
                                                        'unitModel',
                                                        'model_name'
                                                        )
                                        ->searchable(['model_name', 'id'])
                                        ->preload()
                                        ->live()
                                        ->afterStateUpdated(
                                                function(Forms\Get $get, Forms\Set $set){
                                                        $unit_price = Models\UnitModel::find($get("unit_model_id"))->price;
                                                        $set('unit_srp', $unit_price);
                                                }
                                        ),
                                Forms\Components\Group::make()
                                        ->columnSpan(4)
                                        ->columns(2)
                                        ->live()
                                        ->disabled(fn (Forms\Get $get): bool => ! $get('unit_model_id'))
                                        ->schema([
                                                // Forms\Components\Select::make('units_id')
                                                //         ->options(
                                                //             fn (Forms\Get $get): array => Models\Unit::where('customer_application_id', null)
                                                //                     ->where('unit_model_id', $get('unit_model_id'))         
                                                //                     ->limit(20)
                                                //                     ->pluck('chasis_number', 'id')
                                                //                     ->toArray()
                                                //         )
                                                //         ->prefix('#')
                                                //         ->columnSpan(1)
                                                //         ->label('Chasis Number'),

                                                Forms\Components\TextInput::make('unit_srp')
                                                        ->columnSpan(1)
                                                        ->required(true)
                                                        ->label('Selling Retail Price:')
                                                        ->numeric(),
                                                // Forms\Components\TextInput::make('unit_term')
                                                //         ->columnSpan(1)
                                                //         ->minValue(0)
                                                //         ->required(true)
                                                //         ->label('Term:')
                                                //         ->minValue(1)
                                                //         ->numeric()
                                                //         ->live(500)
                                                //         ->afterStateUpdated(
                                                //                 function(Forms\Get $get, Forms\Set $set){
                                                //                 $_term = $get('unit_term');
                                                //                 $_unit_srp = $get('unit_srp');
                                                //                 if($_term > 1){
                                                //                         $quotient = number_format((float)$_unit_srp/$_term, 2, '.', '');
                                                //                         $set('unit_amort_fin', $quotient);
                                                //                         $set('unit_monthly_amort', $quotient);
                                                //                 }
                                                //                 }
                                                //         ),
                                                // Forms\Components\TextInput::make('unit_ttl_dp')
                                                //                 ->required(true)
                                                //                 ->label('Total Downpayment:')
                                                //                 ->numeric()
                                                //                 ->minValue(0)
                                                //                 ->columnSpan(1)
                                                //                 ->live(500)
                                                //                 ->afterStateUpdated(
                                                //                         function(Forms\Get $get, Forms\Set $set){
                                                //                                 $dp = $get('unit_ttl_dp');
                                                //                                 $_term = $get('unit_term');
                                                //                                 $_unit_srp = $get('unit_srp');
                                                //                                 if($_term > 1 || $get('unit_ttl_dp' <= $get('unit_srp'))){
                                                //                                         $quotient = number_format((float)((float)$_unit_srp - (float)$dp)/$_term, 2, '.', '');
                                                //                                         $set('unit_amort_fin', $quotient);
                                                //                                         $set('monthly_amortization', $quotient);
                                                //                                 }
                                                //                         }
                                                //                 ),
                                                // Forms\Components\TextInput::make('unit_monthly_amort')->required(true)
                                                //                 ->label('Monthly Amorthization:')
                                                //                 ->minValue(0)
                                                //                 ->numeric(),
                                                // Forms\Components\Select::make('unit_type')
                                                //                 ->required()
                                                //                 ->options(['New','Repeat',]),
                                                // Forms\Components\TextInput::make('unit_amort_fin')
                                                //                 ->numeric()
                                                //                 ->minValue(0)
                                                //                 ->required(true)
                                                //                 ->label('Amorthization Fin:'),
                                                // Forms\Components\Select::make('unit_mode_of_payment')
                                                //                 ->required(true)
                                                //                 ->label('Mode of Payment:')
                                                //                 ->options(
                                                //                 ['Office','Field','Bank',]
                                                //                 )
                                                //                 ->columnSpan(1),
                                ]),
                ]),
                ]);
    }

    public static function getApplicantInformation(): Forms\Components\Component
    {
                return Forms\Components\Group::make([
                        Forms\Components\Group::make([
                                Forms\Components\TextInput::make('applicant_surname')
                                        ->label('First Name:')
                                        ->columnSpan(2)
                                        ->required(true),
                                Forms\Components\TextInput::make('applicant_middlename')
                                        ->label('Middle Name:')
                                        ->columnSpan(2),
                                Forms\Components\TextInput::make('applicant_lastname')
                                        ->label('Last Name:')
                                        ->columnSpan(2)
                                        ->required(true),
                                Forms\Components\DatePicker::make('applicant_birthday')
                                        ->label('Birthday:')
                                                ->maxDate(now()->subYears(150))
                                                ->maxDate(now())
                                        ->columnSpan(3)
                                        ->required(true),
                                Forms\Components\Select::make('applicant_civil_status')
                                        ->label('Civil Status')
                                        ->live()
                                        ->columnSpan(3)
                                        ->required(true)
                                        ->options(['single'=> 'Single', 'married' => 'Married', 'separated' => 'Separated', 'widow' => 'Widow']),
                        ])
                        ->columnSpan(3)
                        ->columns(6),

                        Forms\Components\Fieldset::make("Contact")
                            ->schema([
                                Forms\Components\TextInput::make('applicant_telephone')
                                        ->columnSpan(3)
                                        ->label('Telephone:'),
                                Forms\Components\TextInput::make('email')
                                        ->columnSpan(3)
                                        ->label('Email:'),
                            ])
                        ->columnSpan(3)
                        ->columns(6),

                        Forms\Components\Group::make([
                                Forms\Components\TextInput::make('applicant_lived_there')
                                        ->columnSpan(3)
                                        ->numeric()
                                        ->suffix('year(s)')
                                        ->inputMode('integer')
                                        ->label('Lived There:'),
                                Forms\Components\Select::make('applicant_house')
                                        ->columnSpan(3)
                                        ->label('House:')
                                        ->options(['owned' => 'Owned', 'rented' => 'Rented', 'w/ parents' => 'W/ parents']),
                                Forms\Components\Textarea::make('applicant_present_address')
                                        ->columnSpan(6)
                                        ->label('Present Address:')
                                        ->required(true),
                                Forms\Components\Textarea::make('applicant_previous_address')
                                        ->columnSpan(6)
                                        ->label('Previous Address:'),
                                Forms\Components\Textarea::make('applicant_provincial_address')
                                        ->columnSpan(6)
                                        ->label('Provincial Address:'),
                        ])
                        ->columnSpan(3)
                        ->columns(6),

                        Forms\Components\Fieldset::make("Requirements")
                        ->schema([
                            Forms\Components\TextInput::make('applicant_valid_id')
                            ->label('Valid ID:')
                            ->required(true)
                            ->columnSpan(3),
                        ])
                        ->columnSpan(3)
                        ->columns(6),

                ])
                ->columns(6);
    }

    public static function getEducationalAttainment(): Forms\Components\Component
    {
                return Forms\Components\Group::make([
                                Forms\Components\Repeater::make("educational_attainment")
                                        ->schema([
                                                Forms\Components\TextInput::make("course")
                                                        ->columnSpan(2),
                                                Forms\Components\TextInput::make("no_years")
                                                        ->columnSpan(1)
                                                        ->numeric()
                                                        ->suffix("year(s)"),
                                                Forms\Components\TextInput::make("school")
                                                        ->columnSpan(2),
                                                Forms\Components\DatePicker::make("year_grad")
                                                        ->columnSpan(1),
                                        ])
                                        ->columns(3)
                                        ->columnSpan(3),
                                Forms\Components\Repeater::make("dependents")
                                        ->schema([
                                            Forms\Components\TextInput::make("dependent_name")
                                                    ->columnSpan(2)
                                                    ->label("Name"),
                                            Forms\Components\DatePicker::make("dependent_birthdate")
                                                    ->columnSpan(1)
                                                    ->label("Birthdate"),
                                            Forms\Components\TextInput::make("dependent_school")
                                                    ->columnSpan(2)
                                                    ->label("School"),
                                            Forms\Components\TextInput::make("dependent_monthly_tuition")
                                                    ->columnSpan(1)
                                                    ->numeric()
                                                    ->label("Tuition"),
                                        ])
                                        ->columns(3)
                                        ->columnSpan(3),


                ])
                ->columnSpan(6)
                ->columns(6);
    }

    public static function getReferences(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
                Forms\Components\Fieldset::make('Financial References')
                ->columns(2)
                ->schema([

                        //Applicant's Bank References
                        Forms\Components\Repeater::make('bank_references')
                        ->label('Bank References')
                        ->columnSpan(1)
                        ->columns(2)
                        ->collapsible(true)
                        ->schema([
                                Forms\Components\Select::make('bank_acc_type')
                                ->columnSpan(1)
                                ->options([
                                    'time_deposit' => 'Time Deposit',
                                    'savings' => 'Savings',
                                ]),
                                Forms\Components\TextInput::make('account_number')->numeric()
                                        ->minLength(12)
                                        ->maxLength(12)
                                        ->columnSpan(1),
                                Forms\Components\TextInput::make('bank_or_branch')
                                        ->columnSpan(2),
                                Forms\Components\DatePicker::make('date_openned')
                                        ->minDate(now()->subYears(150))
                                        ->maxDate(now()),
                                Forms\Components\TextInput::make('average_monthly_balance')
                                        ->numeric(),
                        ]),

                        Forms\Components\Repeater::make('credit_references')
                                    ->columnSpan(1)
                                    ->columns(3)
                                    ->label('Applicant\'s Credit References')
                                    ->collapsible(true)
                                    ->schema([
                                            Forms\Components\Select::make('credit_type')
                                            ->columnSpan(3)
                                            ->options([
                                                    'creditor' => 'Creditor',
                                                    'credit_card' => 'Credit Card',
                                            ])
                                            ->live()
                                            ->afterStateUpdated(fn (Forms\Components\Select $component)
                                            => $component
                                                    ->getContainer()
                                                    ->getComponent('creditCardDynamicTypeFields')
                                                    ->getChildComponentContainer()
                                                    ->fill()
                                            ),
            
        
                        Forms\Components\Grid::make(4)
                                ->columnSpan(4)
                                ->columns(4)
                                ->key('creditCardDynamicTypeFields')
                                ->schema(fn (Forms\Get $get): array => match ($get('credit_type')) {
                                        'creditor' => [
                                                Forms\Components\TextInput::make('creditor')
                                                ->columnSpan(4),
                                                Forms\Components\TextInput::make('term')
                                                ->columnSpan(2),
                                                Forms\Components\TextInput::make('present_balance')
                                                ->columnSpan(2)
                                                ->numeric(),
                                                Forms\Components\TextInput::make('principal')
                                                ->columnSpan(2),
                                                Forms\Components\TextInput::make('monthly_amorthization')
                                                ->columnSpan(2)
                                                ->numeric(),
                                        ],
                                        'credit_card' => [
                                                Forms\Components\TextInput::make('credit_card_company'),
                                                Forms\Components\TextInput::make('card_number'),
                                                Forms\Components\DatePicker::make('date_issued')
                                                ->minDate(now()->subYears(150))
                                                ->maxDate(now())    ,
                                                Forms\Components\TextInput::make('credit_limit'),
                                                Forms\Components\TextInput::make('outstanding_balance'),
                                        ],
                                        default => [],
                                })
                            ]),
                ]),

                Forms\Components\Repeater::make('personal_references')
                        ->columnSpanFull()
                        ->columns(4)
                        ->label('Applicant\'s Personal References')
                        ->collapsible(true)
                        ->schema([
                                Forms\Components\TextInput::make('name'),
                                Forms\Components\TextInput::make('address'),
                                Forms\Components\TextInput::make('relationship')
                                        ->autocomplete(true)
                                        ->datalist([
                                                'Mother',
                                                'Father',
                                                'Spouse',
                                                'Husband',
                                        ]),
                                Forms\Components\TextInput::make('telephone')->numeric(),
                ]),
        ]);
    }

    public static function getEmployment(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\Fieldset::make("Present Employer")
        //     ->columns(2)
        //     ->columnSpan(2)
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

        ]);
    }

    public static function getProperties(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\Repeater::make("properties")
                    ->live()
                    ->schema([
                            Forms\Components\Select::make('type_of_property')
                                    ->live()
                                    ->columnSpan(2)
                                    ->label("Type of properties:")
                                    ->options([
                                            'vehicle' => 'Vehicle',
                                            'house' => 'House',
                                            'lot' => 'Lot',
                                            'appliance' => 'Appliance',
                                    ])
                                    ->afterStateUpdated(
                                            fn (Forms\Components\Select $component) => $component
                                                ->getContainer()
                                                ->getComponent('dynamicFields')
                                                ->getChildComponentContainer()
                                                ->fill()
                                    ),

                            Forms\Components\Grid::make(2)
                                    ->key('dynamicFields')
                                    ->schema(
                                            fn (Forms\Get $get): array => match ($get('type_of_property')){
                                                'vehicle' => [],
                                                'house' => [
                                                    Forms\Components\TextInput::make('clean'),
                                                    Forms\Components\TextInput::make('mortgage'),
                                                    Forms\Components\TextInput::make('to_whom'),
                                                    Forms\Components\TextInput::make('market_value'),
                                                ],
                                                'lot' => [
                                                    Forms\Components\TextInput::make('clean'),
                                                    Forms\Components\TextInput::make('mortgage'),
                                                    Forms\Components\TextInput::make('to_whom'),
                                                    Forms\Components\TextInput::make('market_value'),
                                                ],
                                                'appliance' => [
                                                    Forms\Components\TextInput::make('name'),
                                                ],
                                                default => [],
                                            }
                                    ),
                    ])->columns(2),

        ]);
    }

    public static function getIncome(): Forms\Components\Component
    {
        return new Forms\Components\Group([
                
                Forms\Components\Group::make([
                        Forms\Components\Fieldset::make("Applicant's Income")
                        ->columns(4)
                        ->columnSpan(2)
                        ->schema([
                                Forms\Components\TextInput::make("applicants_basic_monthly_salary")
                                        ->label("Basic Monthly Salary:")
                                        ->minLength(4)
                                        ->maxLength(7)
                                        ->required()
                                        ->default(0)
                                        ->numeric()
                                        ->columnSpan(1),
                                Forms\Components\TextInput::make("applicants_allowance_commission")
                                        ->label("Allowance Commision:")
                                        ->required()
                                        ->default(0)
                                        ->numeric()
                                        ->columnSpan(1),
                                Forms\Components\TextInput::make("applicants_deductions")
                                        ->label("Deductions:")
                                        ->required()
                                        ->default(0)
                                        ->numeric()
                                        ->columnSpan(1),
                                Forms\Components\TextInput::make("applicants_net_monthly_income")
                                        ->label("Net Monthly Income:")
                                        ->default(0)
                                        ->numeric()
                                        ->columnSpan(1),
                        ]),


                        Forms\Components\Fieldset::make("Spouse's Monthly Salary")
                                ->columns(4)
                                ->columnSpan(2)
                                ->disabled(fn (Forms\Get $get): bool => $get('applicant_civil_status') != "married")
                                ->schema([
                                        Forms\Components\TextInput::make("spouses_basic_monthly_salary")->label("Basic Monthly Salary:")
                                                ->columnSpan(1)
                                                ->default(0)
                                                ->numeric(),
                                        Forms\Components\TextInput::make("spouse_allowance_commision")->label("Allowance Commision:")->numeric()
                                                ->columnSpan(1)
                                                ->default(0)
                                                ->numeric(),
                                        Forms\Components\TextInput::make("spouse_deductions")->label("Deductions:")->numeric()
                                                ->columnSpan(1)
                                                ->default(0)
                                                ->numeric(),
                                        Forms\Components\TextInput::make("spouse_net_monthly_income")->label("Net Monthly Income:")->numeric()
                                                ->columnSpan(1)
                                                ->default(0)
                                                ->numeric(),
                                ]),
                ])
                ->columns(2),

                Forms\Components\TextInput::make("other_income")->label("Other Income:")->numeric()
                        ->columnSpan(1)
                        ->default(0)
                        ->default(0),

                Forms\Components\TextInput::make("gross_monthly_income")->label("Gross Monthly Income:")->numeric()->columnSpan(1)
                        ->numeric()
                        ->columnSpan(1)
                        ->default(0)
                        ->prefix('Total:'),

                Forms\Components\Actions::make([
                        Forms\Components\Actions\Action::make('Calculate Income')
                                ->icon('heroicon-m-calculator')
                                ->action(function (Forms\Set $set, Forms\Get $get){

                                    //Net Monthly income (Applicant) = Basic Monthly Salary + Allowance commission - Deduction
                                    $applicants_net_monthly_income = (double)$get('applicants_basic_monthly_salary') 
                                                                    + (double)$get('applicants_allowance_commission') - 
                                                                    (double)$get('applicants_deductions');

                                    //Net Monthly income (Spouse) = Basic Monthly Salary (Spouse) + Allowance commission (Spouse) - Deduction (Spouse)
                                    $spouses_net_monthly_income = (double)$get('spouses_basic_monthly_salary') 
                                                                + (double)$get('spouse_allowance_commision') 
                                                                - (double)$get('spouse_deductions');

                                    $other_income = (float)$get('other_income');

                                    $gross_monthly_income = $applicants_net_monthly_income + $spouses_net_monthly_income + $other_income;

                                    $set('spouse_net_monthly_income', $spouses_net_monthly_income);
                                    $set('applicants_net_monthly_income', $applicants_net_monthly_income);
                                    $set('gross_monthly_income', $gross_monthly_income);

                    }),
                        ])
                        ->alignment(Alignment::Center)
                        ->columnSpan(1),
        ]);
    }

    public static function getExpenses(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
                Forms\Components\Section::make("Expenses")
                ->columns(2)
                ->schema([

                        Forms\Components\TextInput::make("living_expenses")
                                ->label("Living Expenses:")
                                ->numeric()
                                ->default(0)
                                ->columnSpan(1),
                        Forms\Components\TextInput::make("education")
                                ->label("Education:")
                                ->numeric()
                                ->default(0)
                                ->columnSpan(1),
                        Forms\Components\TextInput::make("transportation")
                                ->label("Transportation:")
                                ->numeric()
                                ->numeric()
                                ->default(0)
                                ->columnSpan(1),
                        Forms\Components\TextInput::make("rental")
                                ->label("Rental:")
                                ->numeric()
                                ->numeric()
                                ->default(0)
                                ->columnSpan(1),
                        Forms\Components\TextInput::make("utilities")->label("Utilities:")->numeric()
                                ->numeric()
                                ->default(0)
                                ->columnSpan(1),
                        Forms\Components\TextInput::make("monthly_amortization")->label("Monthly Amortization:")->numeric()
                                ->numeric()
                                ->default(0)
                                ->columnSpan(1),
                        Forms\Components\TextInput::make("other_expenses")->label("Other Expenses:")->numeric()
                                ->numeric()
                                ->default(0)
                                ->columnSpan(1),
                        Forms\Components\TextInput::make("total_expenses")->label("Total Expenses:")->numeric()->columnSpan(1)
                                ->numeric()
                                ->required()
                                ->default(0)
                                ->prefix('Total:')
                                ->columnSpan(1),

                        Forms\Components\Actions::make([
                                Forms\Components\Actions\Action::make('Calculate Expenses')
                                ->icon('heroicon-m-calculator')
                                ->action(function (Forms\Set $set, Forms\Get $get){
        
                                    $total_expenses = (double)$get('living_expenses') + (double)$get('education') 
                                                    + (double)$get('transportation') + (double)$get('rental')
                                                    + (double)$get('utilities') + (double)$get('monthly_amortization')
                                                    + (double)$get('other_expenses');
        
                                    $set('total_expenses', $total_expenses);
        
                                }),
                        ])->columnSpan(2),
                ]),
        ]);
    }

    public static function getNetIncome(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\Section::make("Net Monthly Income:")
            ->schema([
                    Forms\Components\TextInput::make("net_monthly_income")->label("Net Monthly Income:")
                            ->numeric()
                            ->required()
                            ->prefix('Total:'),

                    Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('Calculate Net Monthly Income')
                            ->icon('heroicon-m-calculator')
                            ->action(
                                    function (Forms\Set $set, Forms\Get $get){
                                            $net_monthly_income = (double)$get('gross_monthly_income') - (double)$get('total_expenses');
                                            $set('net_monthly_income', $net_monthly_income);
        
                            }),
                        ])->alignment(Alignment::Center),

            ]),
        ]);
    }

    public static function getStatementOfMonthlyIncome(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            CustomerApplicationResource::getIncome()->columnSpan(2),
            CustomerApplicationResource::getExpenses()->columnSpan(1),
            CustomerApplicationResource::getNetIncome()->columnSpan(3),
        ])
        ->columns(3);

    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
                Forms\Components\Select::make("branch_id")
                ->options([
                    Models\Branch::query()->where("id", auth()->user()->branch_id)->first()->id => 
                    Models\Branch::query()->where("id", auth()->user()->branch_id)->first()->full_address,
                ])
                ->preload(),
                Forms\Components\Wizard::make([
                                Forms\Components\Wizard\Step::make('Unit')
                                        ->schema([
                                                CustomerApplicationResource::getUnitToBeFinanced()
                                                        ->disabled(
                                                                function(string $operation){
                                                                    if($operation == "edit"){
                                                                        return true;
                                                        }}),
                                        ]),
                                Forms\Components\Wizard\Step::make('Applicant Information')
                                        ->schema([
                                                CustomerApplicationResource::getApplicantInformation()
                                        ]),
                                Forms\Components\Wizard\Step::make('Educational Attainment')
                                        ->schema([
                                                CustomerApplicationResource::getEducationalAttainment()
                                        ]),
                                Forms\Components\Wizard\Step::make('References')
                                        ->schema([
                                                CustomerApplicationResource::getReferences()
                                        ]),
                                Forms\Components\Wizard\Step::make('Employment')
                                        ->schema([
                                                CustomerApplicationResource::getEmployment()
                                        ]),
                                Forms\Components\Wizard\Step::make('Statement of Month. income')
                                        ->schema([
                                                // CustomerApplicationResource::getProperties(),
                                                CustomerApplicationResource::getStatementOfMonthlyIncome()
                                        ]),
                        ])->columnSpan(6),
                    Forms\Components\Fieldset::make("Spouse Information")
							->hidden(fn (Forms\Get $get): bool => $get('applicant_civil_status') != "married")
							->columns(3)
							->columnSpan(2)
							->schema([
									Forms\Components\TextInput::make('spouse_firstname')->label('Surname:')
											->columnSpan(1)->required(true),
                                    Forms\Components\TextInput::make('spouse_middlename')
                                            ->label('Middle Name:')
                                            ->columnSpan(1),
                                    Forms\Components\TextInput::make('spouse_lastname')
                                            ->label('Last Name:')
                                            ->columnSpan(1)
                                            ->required(true),
                                    Forms\Components\DatePicker::make('spouse_birthday')
                                            ->label('Birthday:')
                                            ->columnSpan(1)
                                            ->required(true),
                                    Forms\Components\TextInput::make('spouse_present_address')
                                            ->label('Present Address:')
                                            ->required(true),
                                    Forms\Components\Textarea::make('spouse_provincial_address')
                                            ->label('Provincial Address:')
                                            ->columnSpan(1),
                                    Forms\Components\Textarea::make('spouse_telephone')
                                            ->label('Telephone:')
                                            ->columnSpan(1),
                                    Forms\Components\Fieldset::make("Present Employer")
                                            ->columns(2)
                                            ->columnSpan(2)
                                            ->schema([
                                                    Forms\Components\TextArea::make('spouse_employer')
                                                            ->label('Business Employer:')
                                                            ->columnSpan(2),
                                                    Forms\Components\TextInput::make('spouse_position')
                                                            ->label('Position:')
                                                            ->columnSpan(1),
                                                    Forms\Components\TextInput::make('spouse_how_long_job_business')
                                                            ->label('How long:')
                                                            ->columnSpan(1),
                                            ]),
                                    Forms\Components\Fieldset::make("Business")
                                            ->columnSpan(1)
                                            ->columns(1)
                                            ->schema([
                                                    Forms\Components\TextArea::make('spouse_business_address')->label('Address:')->columnSpan(1),
                                                    Forms\Components\TextInput::make('spouse_nature_of_business')->label('Nature of Business:'),
                                            ]),
                ]),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoLists\Components\Section::make('Customer Application')->schema([

                        InfoLists\Components\FieldSet::make('Applicant Information')
                                ->schema([
                                        InfoLists\Components\TextEntry::make('application_status')
                                                ->label('Application Status')
                                                ->badge(),
                                        InfoLists\Components\TextEntry::make('payment_method')
                                                ->hidden(fn(?Model $record): bool => $record->payment_method == null)
                                                ->label('Payment method')
                                                ->badge(),
                                        InfoLists\Components\TextEntry::make('created_at')
                                                ->dateTime('M d Y')
                                                ->label('Date Created')
                                                ->badge(),
                                        InfoLists\Components\TextEntry::make('due_date')
                                                ->hidden(fn(?Model $record): bool => $record->due_date == null)
                                                ->dateTime('M d Y')
                                                ->label('Upcoming Due')
                                                ->badge()
                                                ->color('danger'),
                                ]),

                        InfoLists\Components\FieldSet::make('Unit Information')
                                ->columns(4)
                                ->columnSpan(2)
                                ->schema([
                                        InfoLists\Components\TextEntry::make('unitModel.model_name')
                                                ->label('Unit Model')
                                                ->hidden(fn(?Model $record): bool => $record->unit_model_id == null),
                                        InfoLists\Components\TextEntry::make('units.chasis_number')
                                                ->label('Chasis number')
                                                ->hidden(fn(?Model $record): bool => $record->units_id == null)
                                                ->badge(),
                                        InfoLists\Components\TextEntry::make('unit_term')
                                                ->label('Unit Term')
                                                ->hidden(fn(?Model $record): bool => $record->unit_term == 0),
                                        InfoLists\Components\TextEntry::make('unit_ttl_dp')  
                                                ->label('Down Payment')
                                                ->money('php')
                                                ->hidden(fn(?Model $record): bool => $record->unit_ttl_dp == 0),
                                        InfoLists\Components\TextEntry::make('unit_amort_fin')
                                                ->hidden(fn(?Model $record): bool => $record->unit_amort_fin == 0)
                                                ->label('Monthly Amortization')
                                                ->money('php'),                     
                                        InfoLists\Components\TextEntry::make('unit_srp')
                                                ->label('Unit Price')
                                                ->money('php'),
                        ]),

                    InfoLists\Components\FieldSet::make('Applicant Information')
                            ->columns(6)
                            ->columnSpan(4)
                            ->schema([
                                InfoLists\Components\TextEntry::make('applicant_surname')->label('First Name:'),
                                InfoLists\Components\TextEntry::make('applicant_lastname')->label('Last Name:'),
                                InfoLists\Components\TextEntry::make('applicant_valid_id')->label('Provided ID:'),
                                InfoLists\Components\TextEntry::make('applicant_house')->label('House:'),  
                                InfoLists\Components\TextEntry::make('applicant_present_address')->label('Present Address:'),
                                InfoLists\Components\TextEntry::make('applicant_telephone')->label('Contacts:'),       
                    ]),

                    InfoLists\Components\FieldSet::make("Applicant's Income")->schema([
                            InfoLists\Components\TextEntry::make('gross_monthly_income')
                                    ->label("Gross Monthly Income:")
                                    ->color('success')
                                    ->money('php'),
                            InfoLists\Components\TextEntry::make('total_expenses')
                                    ->label("Total Expenses:")
                                    ->color('danger')
                                    ->money('php'),
                            InfoLists\Components\TextEntry::make('net_monthly_income')
                                    ->label("Net Monthly Income:")
                                    ->color('success')
                                    ->money('php'),
                    ])->columns(3)->columnSpan(4),

                ]),

                Infolists\Components\Actions::make([
                        Infolists\Components\Actions\Action::make("export_pdf")
                                ->label('Export PDF'),
                ]),

            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                        ->label("Application ID:")
                        ->searchable(),
                Tables\Columns\TextColumn::make('application_type')
                        ->label("Type:")
                        ->badge()
                        ->searchable(),
                Tables\Columns\TextColumn::make('application_status')
                        ->label("Status:")
                        ->badge(),
                Tables\Columns\TextColumn::make('units.chasis_number')
                        ->label("unit chasis:")
                        ->badge(),
                Tables\Columns\TextColumn::make('applicant_surname')
                        ->label("First Name:")
                        ->searchable(),
                Tables\Columns\TextColumn::make('applicant_lastname')
                        ->label("Last Name:")
                        ->searchable(),
                Tables\Columns\TextColumn::make('unitModel.model_name')
                        ->label("Unit Model:"),
                Tables\Columns\TextColumn::make('unit_srp')->label("Price:")
                        ->summarize(Average::make())->money('php'),
                Tables\Columns\TextColumn::make('created_at')
                        ->label("Date Created:")
                        ->dateTime('d-M-Y'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false)
            ->filters([
                Tables\Filters\SelectFilter::make('application_status')
                        ->options([
                            'pending' => 'Pending',
                            'active' => 'Active',
                            'reject' => 'Reject'
                        ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PaymentsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerApplications::route('/'),
            'create' => Pages\CreateCustomerApplication::route('/create'),
            'view' => Pages\ViewCustomerApplication::route('/{record}'),
            'edit' => Pages\EditCustomerApplication::route('/{record}/edit'),
        ];
    }    
}
