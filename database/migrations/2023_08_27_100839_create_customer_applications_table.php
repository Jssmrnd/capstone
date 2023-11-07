<?php

use App\Models\Branch;
use App\Models\Unit;
use App\Models\UnitModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_applications', function (Blueprint $table) {

            $table->id();
            $table->string("due_date")->nullable();
            $table->string('application_status')->default('pending');
            $table->boolean('application_is_new')->default(true);
            $table->boolean('is_application_approved')->default(false);
            $table->boolean('is_application_rejected')->default(false);

            $table->foreignIdFor(Branch::class)->nullable()->onDelete('set null');
            $table->string('author_id')->nullable();
            $table->enum('application_type',['online', 'walk-in']);


            // Unit Information
            $table->foreignIdFor(UnitModel::class)->onDelete('set null');
            $table->foreignId('units_id')->onDelete('set null')->nullable();
            $table->string('unit_term')->nullable();
            $table->decimal('unit_monthly_amort', 10, 2)->nullable();
            $table->decimal('unit_ttl_dp')->nullable();
            $table->decimal('unit_srp', 10, 2)->nullable();
            $table->string('unit_type')->nullable();
            $table->decimal('unit_amort_fin', 10, 2)->nullable();
            $table->string('unit_mode_of_payment')->nullable();

            //Applicant Information
            $table->string('applicant_surname')->nullable();
            $table->string('applicant_middlename')->nullable();
            $table->string('applicant_lastname')->nullable();
            $table->string('applicant_birthday')->nullable();
            $table->string('applicant_civil_status')->nullable();
            $table->string('applicant_present_address')->nullable();
            $table->string('applicant_previous_address')->nullable();
            $table->string('applicant_provincial_address')->nullable();
            $table->string('applicant_lived_there')->nullable();
            $table->string('applicant_house')->nullable();
            $table->string('applicant_valid_id')->nullable();
            $table->string('applicant_telephone')->nullable();

            //Applcant Employment
            $table->string('applicant_present_business_employer')->nullable();
            $table->string('applicant_position')->nullable();
            $table->string('applicant_how_long_job_or_business')->nullable();
            $table->text('applicant_business_address')->nullable();
            $table->string('applicant_nature_of_business')->nullable();
            $table->string('applicant_previous_employer')->nullable();
            $table->string('applicant_previous_employer_position')->nullable();
            $table->string('applicant_how_long_prev_job_or_business')->nullable();

            //Educational Attainment
            $table->json('educational_attainment')->nullable();

            //Dependents
            $table->json('dependents')->nullable();

            //Spouse Information
            $table->string('spouse_firstname')->nullable();
            $table->string('spouse_middlename')->nullable();
            $table->string('spouse_lastname')->nullable();
            $table->date('spouse_birthday')->nullable();
            $table->text('spouse_present_address')->nullable();
            $table->text('spouse_provincial_address')->nullable();

            //Spouse Employer
            $table->string('spouse_employer')->nullable();
            $table->string('spouse_position')->nullable();
            $table->string('spouse_how_long_job_business')->nullable();
            $table->string('spouse_business_address')->nullable();
            $table->string('spouse_nature_of_business')->nullable();

            //Educational Attainment
            $table->string('applicant_course')->nullable();
            $table->integer('applicant_course_number_of_yrs')->nullable();
            $table->string('applicant_school')->nullable();
            $table->integer('applicant_school_year_graduated')->nullable();

            //Bank
            $table->json('bank_references')->nullable();
            $table->json('credit_references')->nullable();

            //Financials
            $table->double('applicants_basic_monthly_salary')->nullable();
            $table->double('applicants_allowance_commission')->nullable();
            $table->double('applicants_deductions')->nullable();
            $table->double('applicants_net_monthly_income')->nullable();

            //Expenses
            $table->double('living_expenses')->nullable();
            $table->double('education')->nullable();
            $table->double('transportation')->nullable();
            $table->double('rental')->nullable();
            $table->double('utilities')->nullable();
            $table->double('monthly_amortization')->nullable();
            $table->double('other_expenses')->nullable();

            $table->double('spouses_basic_monthly_salary')->nullable();
            $table->double('spouse_allowance_commision')->nullable();
            $table->double('spouse_deductions')->nullable();
            $table->double('spouse_net_monthly_income')->nullable();

            // Personal References
            $table->json('personal_references')->nullable();

            $table->json('properties')->nullable();
            $table->double('other_income')->nullable();
            $table->double('total_expenses')->nullable();
            $table->double('gross_monthly_income')->nullable();

            $table->double('net_monthly_income')->nullable();

            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_applications');
    }
};
