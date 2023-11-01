<?php

namespace App\Livewire;

use App\Models\CustomerApplication;
use App\Models\Payment;
use Filament\Forms;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Filament\Support\Exceptions\Halt;

class PaymongoCheckout extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.paymongo-checkout');
    }

    public function getFormActions():array{
        return [
            $this->createAction(),
        ];
    }

    public function form(Form $form): Form{
        return $form->schema([
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

            // Forms\Components\Actions::make([
            //             Forms\Components\Actions\Action::make("create")
            //             ->label("Checkout")
            //             ->action(function(){
            //                 // return redirect()->route("paymongo", ["customerApplicationId" => 1]);
            //                 return 0;
            //             }),
            //         ]),      
        ])->statePath("data")
        ->model(Payment::class);
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            $data = $this->mutateFormDataBeforeSave($data);

            $this->handleRecordUpdate($this->record, $data);

        } catch (Halt $exception) {
            return;
        }

        $this->getSavedNotification()?->send();

        if ($redirectUrl = $this->getRedirectUrl()) {
            $this->redirect($redirectUrl);
        }
    }

    public function createAction(): Action
    {
        return Action::make('save')
            ->label('Paymongo')
            ->submit('save');
    }
}
