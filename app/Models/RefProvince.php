<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RefProvince extends Model
{
    use HasFactory;

    protected $fillable = [
        'psgcCode',
        'provDesc',
        'regCode',
        'provCode,'
    ];

    public function refRegions():BelongsTo{
        return $this->belongsTo(RefRegion::class, 'regCode', 'regCode');
    }

    public function refMunicipality():HasMany{
        return $this->hasMany(RefMunicipality::class);
    }

}
