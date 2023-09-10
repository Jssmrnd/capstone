<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RefBarangay extends Model
{

    protected $table = 'refbrgy';

    use HasFactory;

    protected $fillable = [
        'brgyCode',
        'regCode',
        'provCode',
        'citymunCode',
    ];

    public function branches():HasMany
    {
        return $this->hasMany(Branch::class, 'brgyCode', 'brgyCode');
    }
    
    public function refRegion():BelongsTo{
        return $this->belongsTo(RefRegion::class, 'regCode', 'regCode');
    }

    public function refProvince():BelongsTo{
        return $this->belongsTo(RefProvince::class, 'provCode', 'provCode');
    }

    public function refMunicipality():BelongsTo{
        return $this->belongsTo(RefMunicipality::class, 'citymunCode', 'citymunCode');
    }


}
