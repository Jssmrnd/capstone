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
                $customer_application->due_date = $new_due;
                $customer_application->save();
            }

    }
}

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $get_record = CustomerApplication::query()->where('id', $data["customer_application_id"])->first();
    //     $unit_srp = $get_record->unit_srp;
    //     $prev_due = $get_record->due_date;
    //     $new_due =  Carbon::parse(Carbon::createFromFormat('Y-m-d', $prev_due)->addDays(30));
    //     $total_payments = $get_record->payments->sum('payment_amount');
    //     $curr_payment_amount = $data['payment_amount'];

    //     //checks if amount paid is same with unit's price.
    //     if($total_payments+$curr_payment_amount == $unit_srp){
    //         Notifications\Notification::make()
    //         ->success()
    //         ->persistent()
    //         ->title("This account is now complete.")
    //         ->body("account is now closed!")
    //         ->send();
    //         $get_record->application_status = "closed";
    //         $get_record->save();
    //     }

    //     //checks if amount paid is less with the unit's price.
    //     if($total_payments+$curr_payment_amount > $unit_srp){
    //         Notifications\Notification::make()
    //         ->warning()
    //         ->persistent()
    //         ->title("Failed to add a payment.")
    //         ->body('Cannot add more payments to this account.')
    //         ->send();
    //         $this->halt();
    //     }

    //     $data['due_date'] = $new_due;

    //     return $data;
    // }


// }