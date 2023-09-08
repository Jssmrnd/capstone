<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutgoingUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'outgoing_quantity'
    ];

    public function unit():BelongsTo{
        return $this->belongsTo(Unit::class);
    }

}
