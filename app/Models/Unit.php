<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        //Unit info
        'unit_branch',
        'unit_model',
        'engine_number',
        'frame_number',
        'status',
        'notes',
        'unit_quantity',
        'unit_color',
        'unit_type',
        'unit_srp',
    ];

    public function branch():BelongsTo{
        return $this->belongsTo(Branch::class, 'unit_branch', 'id');
    }

    public function customerApplication(): HasMany{
        return $this->hasMany(CustomerApplication::class);
    }

    public function incomingUnit(): HasMany{
        return $this->hasMany(IncomingUnit::class);
    }

    public function outgoingUnit(): HasMany{
        return $this->hasMany(OutgoingUnit::class);
    }

}
