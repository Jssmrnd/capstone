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
        
        //Foreign keys
        'branch_id',
        'unit_model_id',

        'engine_number',
        'frame_number',

        'unit_quantity',
        'status',
        'notes',
    ];

    public function unitModel():BelongsTo{
        return $this->belongsTo(UnitModel::class);
    }

    public function branch():BelongsTo{
        return $this->belongsTo(Branch::class);
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
