<?php

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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string("customer_firstname")->nullable();
            $table->string("customer_middlename")->nullable();
            $table->string("customer_lastname")->nullable();

            $table->string("customer_email");
            $table->string("password");
            
            $table->string("customer_phonenumber")->nullable();
            $table->string("customer_region")->nullable();

            $table->string("customer_province")->nullable();
            $table->string("customer_municipality")->nullable();
            $table->string("customer_barangay")->nullable();

            $table->timestamps();
        });
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
