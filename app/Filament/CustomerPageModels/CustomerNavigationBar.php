<?php

namespace App\Filament\CustomerPageModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNavigationBar extends Model
{
    use HasFactory;
    protected $fillable = [
        "company_name",
        "links",
        "login",
        "register"
    ];

    protected $casts = [
        'links'         => 'json',
        'login'         => 'json',
        'register'      => 'json',
    ];

}
