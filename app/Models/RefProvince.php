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
        'province_name',
        'ref_region_id',
    ];

    public function refRegions():BelongsTo{
        return $this->belongsTo(RefRegion::class);
    }

    public function refMunicipality():HasMany{
        return $this->hasMany(RefMunicipality::class);
    }

}
