<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use App\Models\CustomerApplication;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $get_record = CustomerApplication::query()->where('id', $data["customer_application_id"])->first();
        $unit_srp = $get_record->unit_srp;
        $prev_due = $get_record->due_date;
        $new_due =  Carbon::parse(Carbon::createFromFormat('Y-m-d', $prev_due)->addDays(30));
        $total_payments = $get_record->payments->sum('payment_amount');
        $curr_payment_amount = $data['payment_amount'];

        //checks if amount paid is same with unit's price.
        if($total_payments+$curr_payment_amount == $unit_srp){
            Notifications\Notification::make()
            ->success()
            ->persistent()
            ->title("This account is now complete.")
            ->body("account is now closed!")
            ->send();
            $get_record->application_status = "closed";
            $get_record->save();
        }

        //checks if amount paid is less with the unit's price.
        if($total_payments+$curr_payment_amount > $unit_srp){
            Notifications\Notification::make()
            ->warning()
            ->persistent()
            ->title("Failed to add a payment.")
            ->body('Cannot add more payments to this account.')
            ->send();
            $this->halt();
        }

        $data['due_date'] = $new_due;

        return $data;
    }


    protected function beforeCreate(){
    } 

}