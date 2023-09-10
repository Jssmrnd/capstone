<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{

    use HasFactory;

    public $fillable = [
        'ref_region_id',
        'branch_address',
    ];

    public function regions():BelongsTo{
        return $this->belongsTo(RefRegion::class);
    }

    public function users(): HasMany{
        return $this->hasMany(User::class);
    }

}
