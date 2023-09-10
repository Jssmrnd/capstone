<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefBarangay extends Model
{

    protected $table = 'refbrgy';

    use HasFactory;

    protected $fillable = [
        'psgcCode',
        'brgyDesc',
        'regCode',
        'provCode',
        'citymunCode',
    ];

    
    public function region():BelongsTo{
        return $this->belongsTo(RefRegion::class, 'regCode', 'regCode');
    }

    public function province():BelongsTo{
        return $this->belongsTo(RefProvince::class, 'provCode', 'provCode');
    }

    public function municipality():BelongsTo{
        return $this->belongsTo(RefProvince::class, 'citymunCode', 'citymunCode');
    }


}
