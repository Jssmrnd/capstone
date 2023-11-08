<?php

namespace App\Models;

use App\Models\Scopes\CustomerApplicationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CustomerApplication extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = 
    [
        'id',
        'application_status',
        'application_is_new',

        //mutate data here
        'branch_id', 
        'author_id',
        'application_type',

        //Unit
        'unit_model_id',
        'units_id',
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

        //Applicant Employment
        'applicant_present_business_employer',
        'applicant_position',
        'applicant_how_long_job_or_business',
        'applicant_business_address',
        'applicant_nature_of_business',
        'applicant_previous_employer',
        'applicant_previous_employer_position',
        'applicant_how_long_prev_job_or_business',

        
        //Spouse Information
        'spouse_firstname',
        'spouse_middlename',
        'spouse_lastname',
        'spouse_birthday',
        'spouse_present_address',
        'spouse_provincial_address',
        'spouse_telephone',

        //Spouse Employer
        'spouse_employer',
        'spouse_position',
        'spouse_how_long_job_business',
        'spouse_business_address',
        'spouse_nature_of_business',

        //Educational Attainment
        'educational_attainment',

        //Dependents
        'dependents',

        //Bank
        'bank_references',
        'credit_references',

        //Financials
        'applicants_basic_monthly_salary',
        'applicants_allowance_commission',
        'applicants_deductions',
        'applicants_net_monthly_income',

        'spouses_basic_monthly_salary',
        'spouse_allowance_commision',
        'spouse_deductions',
        'spouse_net_monthly_income',

        //Personal References
        'personal_references',

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
        'living_expenses',
        'education',
        'transportation',
        'rental',
        'utilities',
        'monthly_amortization',
        'other_expenses',
        'total_expenses',

        //Net Income
        'net_monthly_income',


    ];

    protected $casts = [
        'properties'                => 'json',
        'personal_references'       => 'json',
        'bank_references'           => 'json',
        'credit_references'         => 'json',
        'educational_attainment'    => 'json',
        'dependents'                => 'json',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new CustomerApplicationScope);
    }

    public function approveThisApplication()
    {
        // changes the applications status
        $this->application_status = "active";
        $this->is_application_approved = true;
        $this->is_application_rejected = false;
        // gets the associated unit and marks it as owned.
        // $unit = Unit::query()->where('id', $this->units_id)->first();
        // $unit->customer_application_id = $this->id;
        // $unit->save();
        $this->save();
    }

    public function rejectThisApplication(): void
    {
        // changes the applications status
        $this->application_status = "reject";
        $this->is_application_approved = false;
        $this->is_application_rejected = true;
        $this->unit_term = null;
        $this->due_date = null; // sets the due date to null.
        //gets the associated unit and marks it as owned.
        $unit = Unit::query()->where('id', $this->units_id)->first();
        $unit->customer_application_id = null;
        $this->units_id = null;
        $unit->save();
        $this->save();
    }

    public function release()
    {
        //gets the associated unit and marks it as owned.
        $unit = Unit::query()->where('id', $this->units_id)->first();
        $unit->customer_application_id = $this->id;
        $unit->save();
    }
    
    public function branches():BelongsTo{
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function calculateTotalPayments(): float
    {
        return $this->payments()->sum('payment_amount');
    }

    public function payments():HasMany{
        return $this->hasMany(Payment::class);
    }

    public function unitModel():BelongsTo{
        return $this->belongsTo(UnitModel::class);
    }

    public function units():BelongsTo{
        return $this->belongsTo(Unit::class, 'units_id');
    }

}