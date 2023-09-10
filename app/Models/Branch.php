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
        'regCode',
        'provCode',
        'citymunCode',
        'brgyDesc',
        'branch_street',
        'branch_building_number',
    ];

    public function region():BelongsTo{
        return $this->belongsTo(RefRegion::class, 'regCode', 'regCode');
    }

    public function province():BelongsTo{
        return $this->belongsTo(RefProvince::class, 'provCode', 'provCode');
    }

    public function municipality():BelongsTo{
        return $this->belongsTo(RefMunicipality::class, 'citymunCode', 'citymunCode');
    }

    public function barangay():BelongsTo{
        return $this->belongsTo(RefBarangay::class, 'brgyCode', 'brgyCode');
    }

    public function users(): HasMany{
        return $this->hasMany(User::class);
    }

}
