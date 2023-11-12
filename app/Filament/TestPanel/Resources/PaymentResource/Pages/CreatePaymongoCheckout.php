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

                Forms\Components\Select::make('customer_application_id')
                ->relationship(
                name: 'customerApplication',
                titleAttribute: 'applicant_lastname',
                modifyQueryUsing: fn (Builder $query) => $query->where("application_status", Enums\ApplicationStatus::APPROVED_STATUS)
                                                                            ->where("release_status", Enums\ReleaseStatus::RELEASED->value)
                )
                ->label('For Applicant:')
                ->preload()
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(
                    function($state, Forms\Set $set){
                        $application = CustomerApplication::query()
                                ->where("id", $state)
                                ->first();
                        if($application != null){
                            if($application->application_status == Enums\ApplicationStatus::APPROVED_STATUS 
                                    && $application->release_status == Enums\ReleaseStatus::UN_RELEASED->value)
                    {
                                // dd("Down Payment");
                            }else if($application->application_status == Enums\ApplicationStatus::ACTIVE_STATUS){
                                // dd("Amort. Payment");
                            }
                        }
                        $due_date = $application->due_date;
                        $carbon_format = Carbon::createFromFormat(config('app.date_format'), $due_date);
                        $new_due =  Carbon::parse($carbon_format);
                        $new_due = $new_due->addDays(31)->format(config('app.date_format'));



                        $today = Carbon::parse(Carbon::createFromFormat(config('app.date_format'), Carbon::today()->format(config('app.date_format'))));
                        $amort_fin = $application->unit_monthly_amort;
                        $set('due_date', $due_date);
                        $set('payment_amount', $amort_fin);

                        $delinquent = Carbon::parse(Carbon::createFromFormat(config('app.date_format'), $due_date)->addDays(30));

                        $parsed_date = Carbon::parse(Carbon::createFromFormat(config('app.date_format'), $due_date));

                        $is_advance = $today->lessThan($parsed_date);
                        $is_current = $today->equalTo($parsed_date);
                        $is_overdue = $today->greaterThan($parsed_date) && $today->lessThan($delinquent);
                        $is_delinquent = $today->greaterThan($delinquent);

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
                ),

            Forms\Components\TextInput::make('due_date')
                    ->hidden(function(string $operation){
                        if($operation == "edit"){
                            return true;
                        }
                    }),
            Forms\Components\TextInput::make('payment_amount'),
            Forms\Components\Select::make('payment_status')
                    ->live()
                    ->options([
                        'advance' => 'Advance',
                        'current' => 'Current',
                        'overdue' => 'Overdue',
                        'diligent' => 'Diligent',
                    ])
                    ->required(),


            Forms\Components\Select::make('payment_type')->label('Payment Type:')
                    ->options([
                        "field" => "Field",
                        "office" => "Office",
                        "bank" => "Bank",
                    ])
                    ->columnSpan(1)
                    ->required(true),
            ])
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
        return redirect()->route("paymongo");
    }

    public function createAction(): Action
    {
        return Action::make('save')
            ->label('Checkout')
            ->submit('save');
    }
}

