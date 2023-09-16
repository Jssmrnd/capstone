<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        //persnal information
        'customer_firstname',
        'customer_middlename',
        'customer_lastname',
        'customer_birthday',
        'password',
        //contact
        'customer_email',
        'customer_phonenumber',
        'customer_region',
        //address
        'customer_province',
        'customer_municipality',
        'customer_barangay',
    ];


}
