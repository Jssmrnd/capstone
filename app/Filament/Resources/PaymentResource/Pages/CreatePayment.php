<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use App\Models\CustomerApplication;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Carbon;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;


    protected function beforeCreate(): void
    {
        dd("Here");
        $this->getCreateFormAction()->requiresConfirmation(true);
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
