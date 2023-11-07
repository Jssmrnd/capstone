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
            $table->id()->from(2000000);
            $table->string("firstname");
            $table->string("lastname");
            $table->string("middlename")->nullable();
            $table->string("gender")->nullable();

            $table->string("regCode")->nullable();
            $table->string("provCode")->nullable();
            $table->string("citymunCode")->nullable();
            $table->string("brgyCode")->nullable();

            $table->date("birthday")->nullable();
            $table->string("password");
            $table->timestamp('email_verified_at')->nullable();
            $table->string("email");
            $table->rememberToken();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
