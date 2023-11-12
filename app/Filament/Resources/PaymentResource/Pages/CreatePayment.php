<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Enums\ApplicationStatus;
use App\Enums\ReleaseStatus;
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

    protected function afterCreate(): void
    {
        $customer_application = CustomerApplication::query()
                ->where('id', $this->data['customer_application_id'])
                ->first();
        dd("after payment is created.");
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
    
        return $data;
    }

    protected function beforeCreate(): void
    {
        $this->getCreateFormAction()->requiresConfirmation(true);
        //gets the customer application object.
        $customer_application = CustomerApplication::query()
                ->where('id', $this->data['customer_application_id'])
                ->first();
        if($customer_application->application_status == ApplicationStatus::APPROVED_STATUS
                && $customer_application->release_status == ReleaseStatus::RELEASED->value)
        {
            $dp_amount = $this->data['payment_amount'];
            $unit_price = $customer_application->unitModel->price;
            $unit_term = $customer_application->unit_term;
            
            // Calculate the principal amount (unit price - down payment)
            $principal = $unit_price - $dp_amount;
            
            // Get the monthly interest rate (replace with your actual monthly interest rate)
            $monthly_interest_rate = 0.040; // Replace with your actual monthly interest rate
            
            // Calculate the number of payments (term of the installment in months)
            $number_of_payments = $unit_term;
            
            // Calculate the monthly payment using the loan payment formula
            $monthly_payment = ($principal * $monthly_interest_rate) / (1 - pow(1 + $monthly_interest_rate, -$number_of_payments));
            
            // Round the monthly payment to 2 decimal places
            $monthly_payment = round($monthly_payment, 2);

            $customer_application->unit_monthly_amort = $monthly_payment;

            $customer_application->unit_ttl_dp = $dp_amount;

            $customer_application->application_status = ApplicationStatus::ACTIVE_STATUS;

        }
        else if($customer_application->application_status == ApplicationStatus::ACTIVE_STATUS 
                && $customer_application->release_status == ReleaseStatus::RELEASED->value)
        {
            if($customer_application->calculateTotalPayment() < $customer_application->unit_term){
                if($customer_application->calculateTotalPayment()+1 == $customer_application->unit_term){
                    $customer_application->application_status = ApplicationStatus::CLOSED_STATUS;
                }
                $due_date = $customer_application->due_date;
                $carbon_format = Carbon::createFromFormat(config('app.date_format'), $due_date);
                $new_due =  Carbon::parse($carbon_format);
                $new_due = $new_due->addDays(31)->format(config('app.date_format'));
                $customer_application->due_date = $new_due;
            }else if($customer_application->calculateTotalPayment() == $customer_application->unit_term){
                
            }
        }
        $customer_application->save();
    }
}
