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
            $table->string("name");
            $table->string("password");
            $table->timestamp('email_verified_at')->nullable();
            $table->string("email")->unique();
            $table->rememberToken();
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
