<?php

namespace App\Observers;

use App\Mail\CustomerApplicationMail;
use App\Models\AuditLog;
use App\Models\CustomerApplication;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class CustomerApplicationObserver
{
    /**
     * Handle the CustomerApplication "created" event.
     */
    public function created(CustomerApplication $customerApplication): void
    {
        //
        AuditLog::query()->create([
                "user_id" => auth()->id(),
                "operation" => "create",
                "model" => class_basename($customerApplication),
                "new_details" => "",
                "old_details" => "",
                "record_id" => $customerApplication->id,
        ]);

        Mail::to('antugaevasco@gmail.com')->send(new CustomerApplicationMail("Application Has been created"));
    }

    /**
     * Handle the CustomerApplication "updating" event.
     */
    public function updating(CustomerApplication $customerApplication): void
    {

        $old = CustomerApplication::query()->find($customerApplication->id)->first();
        $details = [
           "old" => $old->getAttributes(),
           "new" => $customerApplication->getAttributes(),
        ];

        $changes = [];
   
        foreach ($details["new"] as $key => $value) {
            if (!array_key_exists($key, $details["old"]) || $details["old"][$key] !== $value) {
                $changes[$key] = $value;
            }
        }
        
        $changedValuesInOldArray = [];
        
        foreach ($changes as $key => $value) {
            if (array_key_exists($key, $details["old"])) {
                $changedValuesInOldArray[$key] = $details["old"][$key];
            }
        }

        $to_email = "antugaevasco@gmail.com";
        $to_name = "Carlo";

        Mail::to('antugaevasco@gmail.com')->send(new CustomerApplicationMail("Application Has been Been reviewed"));
    }

    /**
     * Handle the CustomerApplication "deleted" event.
     */
    public function deleted(CustomerApplication $customerApplication): void
    {
        //
        AuditLog::query()->create([
            "user_id" => auth()->id(),
            "operation" => "deleted",
            "model" => class_basename($customerApplication),
            "new_details" => "",
            "old_details" => "",
            "record_id" => $customerApplication->id,
    ]);

    // $to_email = "antugaevasco@gmail.com";
    // $to_name = "Carlo";

    // Mail::send('customer-application-email', ['name' => "Dealership", 'body' => "Test mail" ], function($message) use ($to_name, $to_email) {
    //     $message->to($to_email, $to_name)->subject("Application deleted.")
    //     ->subject("Laravel Test Mail")
    //     ->cc("hello")
    //     ->bcc("");
    //     $message->from("antugaevasco@gmail.com", 'Test Mail');

    // });
        // Mail::to(auth()->user()->email)->send(
        //     new MailMessage()
        //         ->greeting('Hello!')
        //         ->line('One of your invoices has been paid!')
        //         ->lineIf($this->amount > 0, "Amount paid: {$this->amount}")
        //         ->action('View Invoice', $url)
        //         ->line('Thank you for using our application!');
        // );

    }

    /**
     * Handle the CustomerApplication "restored" event.
     */
    public function restored(CustomerApplication $customerApplication): void
    {
        //
        AuditLog::query()->create([
            "user_id" => auth()->id(),
            "operation" => "restored",
            "model" => class_basename($customerApplication),
            "new_details" => "",
            "old_details" => "",
            "record_id" => $customerApplication->id,
        ]);
    }

    /**
     * Handle the CustomerApplication "force deleted" event.
     */
    public function forceDeleted(CustomerApplication $customerApplication): void
    {
        //
        AuditLog::query()->create([
            "user_id" => auth()->id(),
            "operation" => "deleted",
            "model" => class_basename($customerApplication),
            "new_details" => "",
            "old_details" => "",
            "record_id" => $customerApplication->id,
        ]);
    }
}
