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
        Schema::create('users', function (Blueprint $table) {

            $table->id()->from(1000000);
            $table->string("name");
            $table->string("password");
            $table->timestamp('email_verified_at')->nullable();
            $table->string("email");
            $table->rememberToken();
            $table->timestamps();

            // $table->string("first_name");
            // $table->string("last_name");
            // $table->string("gender");
            // $table->date("birthday");
            // $table->boolean('is_admin')->default(0);
            // $table->foreignIdFor(Branch::class)
            // ->nullable()
            // ->constrained()
            // ->onUpdate('cascade')
            // ->nullOnDelete();
            // $table->string("contact_number");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
