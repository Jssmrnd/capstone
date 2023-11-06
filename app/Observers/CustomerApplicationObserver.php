<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\CustomerApplication;

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

        AuditLog::query()->create([
            "user_id" => auth()->id(),
            "operation" => "update",
            "model" => class_basename($customerApplication),
            "new_details" => $changes,
            "old_details" => $changedValuesInOldArray,
            "record_id" => $customerApplication->id,
    ]);
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
