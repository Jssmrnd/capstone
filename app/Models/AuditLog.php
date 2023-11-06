<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id", "operation", "model", "new_details", "old_details", "record_id"
    ];

    protected $casts = [
        "new_details" => "json",
        "old_details" => "json"
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    // public function getChangedValues(array $newValues): array
    // {
    //     $changes = [];
    //     foreach ($newValues as $key => $value) {
    //         if (!array_key_exists($key, $newValues) || $newValues[$key] !== $value) {
    //             $changes[$key] = $value;
    //         }
    //     }
    //     return $changes;
    // }

    // public function getChangedValuesInOldRecordInArray(array $changes): array
    // {
    //     $changedValuesInOldArray = [];
    //     $details = $this->getAttributes();
    //     foreach ($changes as $key => $value) {
    //         if (array_key_exists($key, $details)) {
    //             $changedValuesInOldArray[$key] = $details[$key];
    //         }
    //     }
    //     return $changedValuesInOldArray;
    // }

}