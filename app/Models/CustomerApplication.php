<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomerApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_status',
        'application_is_new',


        //Unit
        'unit_id',
        'unit_model',
        'unit_term',
        'unit_monthly_amort',
        'unit_ttl_dp',
        'unit_srp',
        'unit_type',
        'unit_amort_fin',
        'unit_mode_of_payment',
        'due_date',

        //Applicant Information
        'applicant_surname',
        'applicant_middlename',
        'applicant_lastname',
        'applicant_birthday',

        'applicant_civil_status',
        'applicant_present_address',
        'applicant_previous_address',
        'applicant_provincial_address',
        'applicant_lived_there',
        'applicant_house',
        'applicant_valid_id',
        'applicant_telephone',


        //Personal & Real Estate Properties
        'properties',

        //Applicant's Income
        'applicants_basic_monthly_salary',
        'applicants_allowance_commission',
        'applicants_deductions',
        'applicants_net_monthly_income',

        //Spouse's Income
        'spouses_basic_monthly_salary',
        'spouse_allowance_commision',
        'spouse_deductions',
        'spouse_net_monthly_income',

        //Other Income
        'other_income',

        //Gross Monthly Income
        'gross_monthly_income',

        //Total Expenses
        'total_expenses',

        //Net Income
        'net_monthly_income',


    ];

    protected $casts = [
        'properties' => 'json',
    ];

    public function payments():HasMany{
        return $this->hasMany(Payment::class);
    }

    public function units():BelongsTo{
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

}
