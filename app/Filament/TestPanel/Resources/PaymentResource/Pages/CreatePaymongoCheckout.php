<?php

namespace App\Filament\TestPanel\Resources\PaymentResource\Pages;

use App\Filament\TestPanel\Resources\PaymentResource;
use App\Models\Payment;
use App\Enums;
use Filament\Actions\Action;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Resources\Pages\Page;
use Filament\Forms;
use Carbon\Carbon;
use Filament\Notifications;
use App\Models\CustomerApplication;
use App\Models\CustomerApplicationMaintenance;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CreatePaymongoCheckout extends Page
{
    use InteractsWithFormActions;
    protected static string $resource = PaymentResource::class;

    protected static string $view = 'filament.test-panel.resources.payment-resource.pages.create-paymongo-checkout';
    public ?array $data = [];

    public function mount(): void 
    {
        $this->form->fill(CustomerApplicationMaintenance::all()->toArray());
    }

    public static function getApplicationInformation(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\Section::make("Customer Application Information")
                    ->schema([
                        Forms\Components\TextInput::make('application_firstname')
                                ->columnSpan(3)
                                ->disabled()
                                ->label('First name'),
                        Forms\Components\TextInput::make('application_lastname')
                                ->columnSpan(3)
                                ->disabled()
                                ->label('Last name'),
                        Forms\Components\TextInput::make('application_unit')
                                ->columnSpan(6)
                                ->disabled()
                                ->label('Unit'),
                        Forms\Components\TextInput::make('application_unit_price')
                                ->columnSpan(6)
                                ->disabled()
                                ->label('Price'),
                    ])
                    ->columns(6)
        ]);
    }

    public static function getPaymentDetails(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
                Forms\Components\TextInput::make('due_date')
                        ->columnSpan(6)
                        ->readOnly()
                        ->hidden(function(string $operation){
                            if($operation == "edit"){
                                return true;
                            }
                        }),
                Forms\Components\TextInput::make('payment_amount')
                        ->live()
                        ->columnSpan(2)
                        ->required()
                        ->readOnly(function (Forms\Get $get):bool{
                            $dp = CustomerApplication::query()
                                ->where('id', $get('customer_application_id'))
                                ->first();
                            if($dp != null){
                                return true;
                            }
                            return false;
                        }),
                Forms\Components\Select::make('payment_status')
                        ->live()
                        ->options([
                            'advance' => 'Advance',
                            'current' => 'Current',
                            'overdue' => 'Overdue',
                            'diligent' => 'Diligent',
                        ])
                        ->columnSpan(2)
                        ->required(),
                Forms\Components\Select::make('payment_type')->label('Payment Type:')
                        ->options([
                            "field" => "Field",
                            "office" => "Office",
                            "bank" => "Bank",
                        ])
                        ->columnSpan(6)
                        ->required(true),
        ])
        ->columns(6);
    }

    public static function getApplicationDetails(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
                Forms\Components\Select::make('customer_application_id')
                ->relationship(
                        name: 'customerApplication',
                        titleAttribute: 'applicant_lastname',
                        modifyQueryUsing: fn (Builder $query) => $query->where("application_status", "Active")
                                                                    ->orwhere("application_status", "Approved"),
                )
                ->label('For Applicant:')
                ->preload()
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(
                    function($state, Forms\Set $set, ?Model $record){
                        $application = CustomerApplication::query()
                                ->where("id", $state)
                                ->first();
                        $set('due_date', "");
                        $set('payment_amount', "");
                        $set('application_firstname',  "");
                        $set('customer_application_group',  "");
                        $set('application_unit',  "");
                        $set('application_unit',  "");
                        $set('application_unit_price',  "");
                        if($application != null){
                            if($application->application_status == Enums\ApplicationStatus::APPROVED_STATUS ->value
                                    && $application->release_status == Enums\ReleaseStatus::UN_RELEASED->value)
                            {
                                dd("Down Payment");
                            }else if($application->application_status == Enums\ApplicationStatus::ACTIVE_STATUS->value){
                                // dd("Amort. Payment");
                                $state->payment_amount = $application->unit_monthly_amort;
                                dd($record->payment_amount);
                            }
                            $due_date = $application->due_date;
                            $today = Carbon::today();
                            
                            $amort_fin = $application->unit_monthly_amort;
                            $set('due_date', $due_date);
                            $set('payment_amount', $amort_fin);
                            $set('application_firstname', $application->applicant_firstname);
                            $set('application_lastname', $application->applicant_lastname);
                            $set('application_unit', $application->unitModel->model_name);
                            $set('application_unit_price', $application->unitModel->price);
                            
                            $delinquent = $today->copy()->addDays(30);
                            
                            $parsed_date = Carbon::createFromFormat(config('app.date_format'), $due_date);
                            
                            $is_advance = $today->lt($parsed_date);
                            $is_current = $today->eq($parsed_date);
                            $is_overdue = $today->gt($parsed_date) && $today->lt($delinquent);
                            $is_delinquent = $today->gt($delinquent);
    
                            if($today->lessThan($parsed_date)){
                                $set('payment_status', 'advance');
                            }
                            elseif($today->equalTo($parsed_date)){
                                $set('payment_status', 'current');
                            }
                            elseif($today->greaterThan($parsed_date) && $today->lessThan($delinquent)){
                                $set('payment_status', 'overdue');
                            }
                            elseif($today->greaterThan($delinquent)){
                                $set('payment_status', 'delinquent');
                            }
                        }
                    }
                ),
        ]);
    }

    protected function beforeCreate(): void
    {
        //gets the customer application object.
        $customer_application = CustomerApplication::query()
                                                        ->where('id', $this->data['customer_application_id'])
                                                        ->first();
        $this_payment = $this->data; //a dictionary
        $prev_due = $customer_application->due_date;
        $new_due =  Carbon::parse(Carbon::createFromFormat('Y-m-d', $prev_due)
                    ->addDays(30))->toDateString(); //calculates the due to a month forward.

            //calculate the sum with the payment amount, make a notif when greater then or eq to unit srp
            if(($customer_application->calculateTotalPayments() + $this_payment["payment_amount"]) >= $customer_application->unit_srp
                && $customer_application->application_status == "active")
            {
                Notifications\Notification::make()
                        ->title("This account is complete!")
                        ->body("This Account is now closed.")
                        ->warning()
                        ->persistent()
                        ->send();
                $customer_application->application_status = 'closed';
                $customer_application->due_date = null;
                $customer_application->save();
            }

            if($customer_application->application_status == "active")
            {
                $this->paymongo($customer_application);
            }

    }
 
    public function form(Form $form): Form
    {
        return $form
            ->live()        
            ->schema([
                    Forms\Components\Group::make([
                        PaymentResource::getApplicationDetails()
                                ->columnSpan(3),
                        PaymentResource::getApplicationInformation()
                                ->columnSpan(3),  
                    ])
                    ->columns(3)
                    ->columnSpan(3),
                    PaymentResource::getPaymentDetails()
                            ->columnSpan(3),
            ])
            ->columns(6)
            ->statePath('data')
            ->model(Payment::class);
    }

    public function getFormActions():array{
        return [
            $this->createAction()->requiresConfirmation(),
        ];
    }

    public function save(){
        $data = $this->form->getState();
        return redirect()->route("paymongo", ["customerApplicationId" => $data['customer_application_id']]);
    }

    public function createAction(): Action
    {
        return Action::make('save')
            ->label('Checkout')
            ->submit('save');
    }
}

