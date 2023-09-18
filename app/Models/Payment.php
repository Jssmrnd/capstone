<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_application_id',  //
        'payment_status',           //p 
        'payment_type',             //
        'payment_amount',           // 2000.00
    ];


    public function customerApplication():BelongsTo{
        return $this->belongsTo(CustomerApplication::class);
    }
}
