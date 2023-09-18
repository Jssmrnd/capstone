<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use App\Models\CustomerApplication;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(
                    function(){
                        $this_payment = $this->getRecord();
                        $customer_application = $this_payment->customerApplication;
                        $total_payments = $customer_application->calculateTotalPayments();

                        //checks the sum with the new payment if greater than unit_srp 
                        if(($total_payments + $this_payment->payment_amount) < $customer_application->unit_srp){
                            $customer_application->application_status = "active";
                        }
                        elseif(($total_payments + $this_payment->payment_amount) >= $customer_application->unit_srp){
                            $customer_application->application_status = "closed";
                        }
                        $customer_application->save();
                    }
                ),
        ];
    }
}
