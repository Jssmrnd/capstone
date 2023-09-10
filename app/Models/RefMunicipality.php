<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefMunicipality extends Model
{
    use HasFactory;

    protected $fillable = [
        'municipality_name',
        'ref_region_id',
        'ref_province_id',
    ];

    public function region():BelongsTo{
        return $this->belongsTo(RefRegion::class);
    }

    public function province():BelongsTo{
        return $this->belongsTo(RefProvince::class);
    }


}
