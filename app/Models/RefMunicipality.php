<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RefMunicipality extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = [
        'psgcCode',
        'citymunDesc',
        'regDesc',
        'provCode',
        'citymunCode',
    ];

    public function branches():HasMany
    {
        return $this->hasMany(Branch::class, 'citymunCode', 'citymunCode');
    }

    public function refRegion():BelongsTo{
        return $this->belongsTo(RefRegion::class);
    }

    public function refProvince():BelongsTo{
        return $this->belongsTo(RefProvince::class, 'provCode', 'provCode');
    }

    public function refBarangay():HasMany{
        return $this->hasMany(RefBarangay::class, 'citymunCode', 'citymunCode');
    }

}
