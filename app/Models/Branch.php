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
        'brgyCode',
        'regCode',
        'provCode',
        'citymunCode',
        'branch_street',
        'branch_building_number',
    ];

    public function refRegions():BelongsTo{
        return $this->belongsTo(RefRegion::class, 'regCode', 'regCode');
    }

    public function refProvinces():BelongsTo{
        return $this->belongsTo(RefProvince::class, 'provCode', 'provCode');
    }

    public function refMunicipalities():BelongsTo{
        return $this->belongsTo(RefMunicipality::class, 'citymunCode', 'citymunCode');
    }

    public function refBarangays():BelongsTo{
        return $this->belongsTo(RefBarangay::class, 'brgyCode', 'brgyCode');
    }

    public function users(): HasMany{
        return $this->hasMany(User::class);
    }

}
