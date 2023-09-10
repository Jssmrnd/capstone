<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RefMunicipality extends Model
{
    use HasFactory;

    protected $fillable = [
        'psgcCode',
        'citymunDesc',
        'regDesc',
        'provCode',
        'citymunCode',
    ];

    public function region():BelongsTo{
        return $this->belongsTo(RefRegion::class);
    }

    public function province():BelongsTo{
        return $this->belongsTo(RefProvince::class, 'provCode', 'provCode');
    }

    public function barangay():HasMany{
        return $this->hasMany(RefBarangay::class, 'citymunCode', 'citymunCode');
    }

}
