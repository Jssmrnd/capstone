<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RefRegion extends Model
{
    use HasFactory;

    protected $fillable = [
        'psgcCode',
        'regDesc',
        'regCode',
    ];


    public function branches():HasMany
    {
        return $this->hasMany(Branch::class, 'regCode', 'regCode');
    }

    public function RefProvinces():HasMany
    {
        return $this->hasMany(RefProvince::class, 'regCode', 'regCode');
    }

}
