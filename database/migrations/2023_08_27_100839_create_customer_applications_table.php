<?php

use App\Models\Unit;
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
            $table->string('application_status')->default('pending');
            $table->boolean('application_is_new')->default(true);
            $table->boolean('is_application_approved')->default(false);
            $table->boolean('is_application_rejected')->default(false);

            // Unit Information
            $table->foreignIdFor(Unit::class)->nullable();
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


            $table->double('applicants_basic_monthly_salary')->nullable();
            $table->double('applicants_allowance_commission')->nullable();
            $table->double('applicants_deductions')->nullable();
            $table->double('applicants_net_monthly_income')->nullable();

            $table->double('spouses_basic_monthly_salary')->nullable();
            $table->double('spouse_allowance_commision')->nullable();
            $table->double('spouse_deductions')->nullable();
            $table->double('spouse_net_monthly_income')->nullable();

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
