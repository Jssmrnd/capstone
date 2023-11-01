<?php

namespace App\Filament\TestPanel\Resources\PaymentResource\Pages;

use App\Filament\TestPanel\Resources\PaymentResource;
use App\Models\Payment;
use Filament\Actions\Action;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Resources\Pages\Page;
use Filament\Forms;
use Carbon\Carbon;
use App\Models\CustomerApplication;
use App\Models\CustomerApplicationMaintenance;
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
 
    public function form(Form $form): Form
    {
        return $form
            ->live()        
            ->schema([

                
                Forms\Components\Select::make('customer_application_id')
                ->relationship(
                name: 'customerApplication',
                titleAttribute: 'applicant_lastname',
                modifyQueryUsing: fn (Builder $query) => $query->where("application_status", "active"),
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

                        $due_date = $application->due_date;
                        $today = Carbon::parse(Carbon::today()->format('Y-m-d'));
                        $amort_fin = $application->unit_amort_fin;
                        $set('due_date', $due_date);
                        $set('payment_amount', $amort_fin);

                        //Y-m-d

                        $delinquent = Carbon::parse(Carbon::createFromFormat('Y-m-d', $due_date)->addDays(30));

                        $is_advance = $today->lessThan($due_date);
                        $is_current = $today->equalTo($due_date);
                        $is_overdue = $today->greaterThan($due_date) && $today->lessThan($delinquent);
                        $is_delinquent = $today->greaterThan($delinquent);

                        if($today->lessThan($due_date)){
                            $set('payment_status', 'advance');
                        }
                        elseif($today->equalTo($due_date)){
                            $set('payment_status', 'current');
                        }
                        elseif($today->greaterThan($due_date) && $today->lessThan($delinquent)){
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
            $this->createAction(),
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

